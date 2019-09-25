<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class ConfigurationExtension extends Extension
{
    const CONFIGURATION_FILE = '.translations_manager.yml';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $filename = sprintf('%s/%s', getcwd(), self::CONFIGURATION_FILE);

        if (!file_exists($filename)) {
            echo sprintf("No %s file :(\n", self::CONFIGURATION_FILE);
            die;
        }

        $content = file_get_contents(sprintf('%s/%s', getcwd(), self::CONFIGURATION_FILE));

        if (!$content) {
            throw new FileNotFoundException;
        }

        $config = Yaml::parse($content);

        $container->setParameter('server', $config['server']);
        $container->setParameter('project_id', $config['project_id']);
        $container->setParameter('format', isset($config['format']) ? $config['format'] : 'xlf');
    }
}
