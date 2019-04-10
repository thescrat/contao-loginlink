<?php

/*
 * LoginLink extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2019
 * @author     Michael Fleischmann
 * @license    MIT
 * @link       http://github.com/thescrat/contao-loginlink
 */

namespace thescrat\LoginLinkBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use thescrat\LoginLinkBundle\thescratLoginLinkBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(thescratLoginLinkBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['loginlink']),
        ];
    }
}
