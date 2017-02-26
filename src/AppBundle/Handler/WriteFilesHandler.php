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
     */
    public function write(\stdClass $translations)
    {
        foreach ($translations as $fileLocation => $domains) {
            foreach ($domains as $domain => $locales) {
                foreach ($locales as $locale => $translationSet) {
                    $this->fileBuilders['xlf']->build($fileLocation, $domain, $locale, $translationSet);
                }
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
