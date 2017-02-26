<?php

namespace AppBundle\FileParser;

interface FileParserInterface
{
    /**
     * @param \SplFileInfo $file
     *
     * @return array
     */
    public function parse(\SplFileInfo $file);
}
