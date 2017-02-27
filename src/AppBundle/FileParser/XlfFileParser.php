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
        $rawData = file_get_contents($file->getPathname());
        $rawData = preg_replace_callback('/<!\[CDATA\[(.*)\]\]>/', [$this, 'escapeCDATA'], $rawData);
        $data = simplexml_load_string($rawData);
        foreach ($data->file->body->{'trans-unit'} as $unit) {
            $translations[] = [
                'key' => (string) $unit->source,
                'translation' => preg_replace_callback(
                    '/CDATA(.*)\\CDATA/',
                    [$this, 'reverseEscapeCDATA'],
                    (string) $unit->target
                )
            ];
        }

        return $translations;
    }

    /**
     * @param array $matches
     *
     * @return string
     */
    private function escapeCDATA(array $matches)
    {
        return 'CDATA' . htmlspecialchars($matches[1]) . '\CDATA';
    }

    /**
     * @param array $matches
     *
     * @return string
     */
    private function reverseEscapeCDATA(array $matches)
    {
        return sprintf('<![CDATA[%s]]>', htmlspecialchars_decode($matches[1]));
    }
}
