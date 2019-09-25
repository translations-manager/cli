<?php

namespace AppBundle\Handler;

use AppBundle\FileBuilder\FileBuilderInterface;

class WriteFilesHandler
{
    /**
     * @var FileBuilderInterface[]
     */
    private $fileBuilders = [];

    /**
     * @param \stdClass $translations
     * @param string $format
     */
    public function write(\stdClass $translations, $format)
    {
        $formatted = [];
        $location = '.';

        foreach ($translations as $fileLocation => $domains) {
            foreach ($domains as $domain => $locales) {
                foreach ($locales as $locale => $translationSet) {
                    $location = $fileLocation;

                    if ($format === 'json') {
                        if (!isset($formatted[$locale])) {
                            $formatted[$locale] = [];
                        }
                        $formatted[$locale] = array_merge(
                            $formatted[$locale],
                            $this->fileBuilders[$format]->build($fileLocation, $domain, $locale, $translationSet)
                        );
                    } else {
                        $this->fileBuilders[$format]->build($fileLocation, $domain, $locale, $translationSet);
                    }
                }
            }
        }

        if ($format === 'json') {
            if (!is_dir($location)) {
                mkdir($location, 0777, true);
            }
            foreach ($formatted as $locale => $trans) {
                file_put_contents(
                    sprintf('%s/%s.json', $location, $locale),
                    json_encode($trans, JSON_PRETTY_PRINT)
                );
            }
        }
    }

    /**
     * @param string $alias
     * @param FileBuilderInterface $fileBuilder
     */
    public function addFileBuilder($alias, FileBuilderInterface $fileBuilder)
    {
        $this->fileBuilders[$alias] = $fileBuilder;
    }
}
