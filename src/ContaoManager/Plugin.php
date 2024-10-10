<?php

namespace Thescrat\LoginLinkBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Thescrat\LoginLinkBundle\ThescratLoginLinkBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ThescratLoginLinkBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['loginlink']),
        ];
    }
}
