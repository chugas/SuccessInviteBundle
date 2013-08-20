<?php

namespace Success\InviteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {

  /**
   * {@inheritDoc}
   */
  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('success_invite');

    $rootNode
        ->addDefaultsIfNotSet()
        ->children()
          ->scalarNode('referer_class')->isRequired()->end()            
          ->scalarNode('referer_relation_class')->isRequired()->end()
          ->scalarNode('field')->defaultValue('ref')->end()
          ->scalarNode('session_key')->defaultValue('success_referer')->end()
        ->end()
    ;

    return $treeBuilder;
  }

}
