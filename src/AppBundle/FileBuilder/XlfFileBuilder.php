<?php

namespace AppBundle\FileBuilder;

class XlfFileBuilder extends AbstractFileBuilder
{
    /**
     * {@inheritdoc}
     */
    public function build($location, $domain, $locale, array $translations)
    {
        $outputFile = sprintf('%s/%s.%s.xlf', $location, $domain, $locale);
        $this->output->writeln(sprintf('<info>Writing file %s</info>', $outputFile));

        if (!is_dir($location)) {
            mkdir($location, 0777, true);
        }

        $xliff = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xliff />');
        $xliff->addAttribute('xmlns', 'urn:oasis:names:tc:xliff:document:1.2');
        $xliff->addAttribute('version', '1.2');

        $file = $xliff->addChild('file');
        $file->addAttribute('source-language', 'en');
        $file->addAttribute('target-language', str_replace('_', '-', $locale));
        $file->addAttribute('datatype', 'plaintext');
        $file->addAttribute('original', 'file.ext');

        $body = $file->addChild('body');
        foreach ($translations as $translation) {
            $unit = $body->addChild('trans-unit');
            $unit->addAttribute('id', md5($translation->key));
            $unit->addAttribute('resname', $translation->key);
            $unit->addChild('source', $translation->key);
            $unit->addChild('target', $translation->translation);
        }

        $dom = dom_import_simplexml($xliff)->ownerDocument;
        $dom->formatOutput = true;

        $dom->save($outputFile);
    }
}
