<?php

namespace Success\InviteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SuccessInviteExtension extends Extension {

  /**
   * {@inheritDoc}
   */
  public function load(array $configs, ContainerBuilder $container) {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $container->setParameter('success_invite.referer_class', $config['referer_class']);
    $container->setParameter('success_invite.referer_relation_class', $config['referer_relation_class']);
    $container->setParameter('success_invite.field', $config['field']);
    $container->setParameter('success_invite.session_key', $config['session_key']);
    
    $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yml');
    
    $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');
  }

}
