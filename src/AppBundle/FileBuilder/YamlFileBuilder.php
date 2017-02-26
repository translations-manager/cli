<?php

namespace AppBundle\FileBuilder;

use Symfony\Component\Yaml\Yaml;

class YamlFileBuilder implements FileBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function build($location, $domain, $locale, array $translations)
    {
        if (!is_dir($location)) {
            mkdir($location, 0777, true);
        }

        $formatted = [];
        foreach ($translations as $translation) {
            $formatted[$translation->key] = $translation->translation;
        }

        file_put_contents(
            sprintf('%s/%s.%s.yml', $location, $domain, $locale),
            Yaml::dump($formatted)
        );
    }
}
