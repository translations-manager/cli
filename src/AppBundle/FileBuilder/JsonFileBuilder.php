<?php

namespace AppBundle\FileBuilder;

use Symfony\Component\Yaml\Yaml;

class JsonFileBuilder extends AbstractFileBuilder
{
    /**
     * {@inheritdoc}
     */
    public function build($location, $domain, $locale, array $translations)
    {
        if (!is_dir($location)) {
            mkdir($location, 0777, true);
        }

        $formatted = [
            $domain => []
        ];
        foreach ($translations as $translation) {
            $explodedPath = explode('.', $translation->key);
            $formatted[$domain] = array_merge_recursive(
                $formatted[$domain],
                $this->buildPath($explodedPath, $translation->translation)
            );
        }

        return $formatted;
    }

    public function buildPath(array $keys, $value) {
        $out = [];
        if (count($keys) > 1) {
            $key = $keys[0];
            array_shift($keys);
            $out[$key] = $this->buildPath($keys, $value);

            return $out;
        }

        $out[$keys[0]] = $value;
        return $out;
    }
}
