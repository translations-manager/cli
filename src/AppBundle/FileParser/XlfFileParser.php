<?php

namespace AppBundle\FileParser;

class XlfFileParser extends AbstractFileParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileInfo $file)
    {
        $this->output->writeln(sprintf('<info>Reading file %s', $file->getPathname()));

        $translations = [];
        $data = new \SimpleXMLElement(file_get_contents($file->getPathname()));
        foreach ($data->file->body->{'trans-unit'} as $unit) {
            $translations[] = [
                'key' => $unit->source->__toString(),
                'translation' => $unit->target->__toString()
            ];
        }

        return $translations;
    }
}
