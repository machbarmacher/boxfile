<?php

namespace derhasi\boxfile\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BoxfileConfiguration implements ConfigurationInterface {

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('boxfile');

        $children = $rootNode->children();

        $children->floatNode('version')->min(1)->max(2)->end();
        $children->arrayNode('shared_folders')->prototype('scalar')->end();
        $children->arrayNode('env_specific_files')
          // https://github.com/symfony/symfony/issues/7405
          // http://symfony.com/doc/current/components/config/definition.html#array-node-options
          ->normalizeKeys(false)
          ->useAttributeAsKey('target')
          ->prototype('array')
            ->normalizeKeys(false)
            ->useAttributeAsKey('environment')->prototype('scalar')->end()
          ->end()
        ;
        $children->end();

        return $treeBuilder;
    }
}
