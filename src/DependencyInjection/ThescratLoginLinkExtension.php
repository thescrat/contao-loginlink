<?php

/*
 * LoginLink extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2019
 * @author     Michael Fleischmann
 * @license    MIT
 * @link       http://github.com/thescrat/contao-loginlink
 */

namespace Thescrat\LoginLinkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ThescratLoginLinkExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('listeners.yml');
    }
}
