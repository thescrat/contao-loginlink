<?php

/*
 * LoginLink extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2019
 * @author     Michael Fleischmann
 * @license    MIT
 * @link       http://github.com/thescrat/contao-loginlink
 */

namespace thescrat\LoginLinkBundle\EventListener;

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\CoreBundle\Security\Authentication\Token\TokenChecker;
use Contao\FrontendUser;
use Contao\MemberModel;
use Contao\Input;
use Contao\Controller;
use Contao\PageModel;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class GeneratePageListener
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var AuthenticationSuccessHandlerInterface
     */
    private $authenticationSuccessHandler;

    /**
     * @var TokenChecker
     */
    private $tokenChecker;

    public $loginKey;

    /**
     * RegistrationListener constructor.
     *
     * @param UserProviderInterface                 $userProvider
     * @param TokenStorageInterface                 $tokenStorage
     * @param Connection                            $connection
     * @param LoggerInterface                       $logger
     * @param EventDispatcherInterface              $eventDispatcher
     * @param RequestStack                          $requestStack
     * @param UserCheckerInterface                  $userChecker
     * @param AuthenticationSuccessHandlerInterface $authenticationSuccessHandler
     */
    public function __construct(UserProviderInterface $userProvider, TokenStorageInterface $tokenStorage, Connection $connection, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher, RequestStack $requestStack, UserCheckerInterface $userChecker, AuthenticationSuccessHandlerInterface $authenticationSuccessHandler, TokenChecker $tokenChecker)
    {
        $this->userProvider = $userProvider;
        $this->tokenStorage = $tokenStorage;
        $this->connection = $connection;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
        $this->requestStack = $requestStack;
        $this->userChecker = $userChecker;
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;
        $this->tokenChecker = $tokenChecker;
    }


    public function onGeneratePage($pageModel, $layoutModel)
    {
        global $objPage;

        $pageModel = PageModel::findById($objPage->rootId);

        if (null === $pageModel || !$pageModel->loginlink) {
            return;
        }

        if(NULL === $this->loginKey = Input::get('key'))
            return;

        if(!$this->tokenChecker->hasFrontendUser()) {

            $objMember = MemberModel::findBy('loginLink',$this->loginKey);

            if(NULL === $objMember) {
                return;
            }

            $this->loginUser($objMember->username);

            if(Input::get('redirect')) {
                $objRedirectPage = PageModel::findOneByAlias(Input::get('redirect'));
                Controller::redirect($objRedirectPage->getAbsoluteUrl());
            }

            if($pageModel->loginlink_jumpTo) {
                $objRedirectPage = PageModel::findOneById($pageModel->loginlink_jumpTo);
                Controller::redirect($objRedirectPage->getAbsoluteUrl());
            }

            // default redirect without key parameter
            Controller::redirect(Controller::addToUrl('',false,['key']));
        }
    }

    /**
     * Within the registration process, log in the user if needed.
     *
     * @param int   $userId The user id
     * @param array $data   The user data of the registration module
     */
    public function onCreateNewUser(int $userId, array $data): void
    {
        global $objPage;

        $pageModel = PageModel::findById($objPage->rootId);

        if (null === $pageModel) {
            return;
        }

        $strLoginLink = substr(uniqid(mt_rand()).uniqid(mt_rand()),0,$pageModel->loginlink_length);

        $this->connection->createQueryBuilder()
            ->update('tl_member')
            ->set('loginLink', ':loginLink')
            ->where('id=:id')
            ->setParameter('id', $userId)
            ->setParameter(':loginLink', $strLoginLink)
            ->execute();
    }


    /**
     * Actually log in the user by given username.
     *
     * @param string $username
     */
    private function loginUser(string $username)
    {
        try {
            $user = $this->userProvider->loadUserByUsername($username);
        } catch (UsernameNotFoundException $exception) {
            return;
        }

        if (!$user instanceof FrontendUser) {
            return;
        }

        try {
            $this->userChecker->checkPreAuth($user);
            $this->userChecker->checkPostAuth($user);
        } catch (AccountStatusException $e) {
            return;
        }

        $usernamePasswordToken = new UsernamePasswordToken($user, null, 'frontend', $user->getRoles());
        $this->tokenStorage->setToken($usernamePasswordToken);


        $event = new InteractiveLoginEvent($this->requestStack->getCurrentRequest(), $usernamePasswordToken);
        $this->eventDispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $event);

        $this->logger->log(
            LogLevel::INFO,
            'User "'.$username.'" was logged in by LoginLink',
            ['contao' => new ContaoContext(__METHOD__, TL_ACCESS)]
        );

        /*$this->authenticationSuccessHandler->onAuthenticationSuccess(
            $this->requestStack->getCurrentRequest(),
            $usernamePasswordToken
        );*/

        return;
    }
}
