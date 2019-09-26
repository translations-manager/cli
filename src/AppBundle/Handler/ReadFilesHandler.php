<?php

namespace AppBundle\Handler;

use AppBundle\FileParser\FileParserInterface;
use Symfony\Component\Finder\Finder;

class ReadFilesHandler
{
    /**
     * @var FileParserInterface[]
     */
    private $fileParsers = [];

    /**
     * @param int $projectId
     * @param array $filePatterns
     * @param array $fileLocations
     * @param string $domainName
     * @param string $localeCode
     * @param string $format
     *
     * @return array
     */
    public function read(
        $projectId,
        array $filePatterns,
        array $fileLocations = [],
        $domainName = '',
        $localeCode = '',
        $format = ''
    ) {
        $set = [];
        $finder = new Finder();

        $finder->files();

        if ($filePatterns) {
            $finder->append($filePatterns);
        } else {
            foreach ($fileLocations as $fileLocation) {
                $finder->in($fileLocation);
            }
        }

        if ($domainName) {
            $finder->name(sprintf('%s.*', $domainName));
        }

        if ($localeCode) {
            $finder->name(sprintf('*.%s.*', $localeCode));
        }

        foreach ($finder as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if ($format === 'json') {
                foreach ($this->fileParsers[$format]->parse($file) as $domain => $translations) {
                    $set[] = [
                        'translations' => $translations,
                        'file_path' => $file->getPathname(),
                        'project_id' => $projectId,
                        'domain' => $domain
                    ];
                }
            } else {
                $set[] = [
                    'translations' => $this->fileParsers[$format]->parse($file),
                    'file_path' => $file->getPathname(),
                    'project_id' => $projectId
                ];
            }
        }

        return $set;
    }

    /**
     * @param string $alias
     * @param FileParserInterface $fileParser
     */
    public function addFileParser($alias, FileParserInterface $fileParser)
    {
        $this->fileParsers[$alias] = $fileParser;
    }
}
