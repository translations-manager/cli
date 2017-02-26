<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FileBuildersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc]
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.handler.write_files')) {
            return;
        }
        $definition = $container->findDefinition('app.handler.write_files');

        $taggedServices = $container->findTaggedServiceIds('app.file_builder');
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addFileBuilder', [
                    $attributes['alias'],
                    new Reference($id)
                ]);
            }
        }
    }
}
