<?php

namespace AppBundle\FileParser;

class JsonFileParser extends AbstractFileParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileInfo $file)
    {
        $this->output->writeln(sprintf('<info>Reading file %s', $file->getPathname()));

        $translations = [];
        $rawData = file_get_contents($file->getPathname());
        $data = json_decode($rawData, true);
        foreach ($data as $domain => $tree) {
            $translations[$domain] = [];
            foreach ($this->flatten($tree) as $key => $translation) {
                $translations[$domain][] = [
                    'key' => $key,
                    'translation' => $translation
                ];
            }
        }

        return $translations;
    }

    private function flatten($array, $prefix = '') {
        $result = [];
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $result = $result + $this->flatten($value, $prefix . $key . '.');
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }
}
