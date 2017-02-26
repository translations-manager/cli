<?php

namespace AppBundle\FileBuilder;

interface FileBuilderInterface
{
    /**
     * @param string $location
     * @param string $domain
     * @param string $locale
     * @param array $translations
     */
    public function build($location, $domain, $locale, array $translations);
}
