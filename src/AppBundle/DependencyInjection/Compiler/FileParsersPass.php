<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FileParsersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc]
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.handler.read_files')) {
            return;
        }
        $definition = $container->findDefinition('app.handler.read_files');

        $taggedServices = $container->findTaggedServiceIds('app.file_parser');
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addFileParser', [
                    $attributes['alias'],
                    new Reference($id)
                ]);
            }
        }
    }
}
