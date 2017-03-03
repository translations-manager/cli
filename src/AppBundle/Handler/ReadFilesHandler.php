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
     *
     * @return array
     */
    public function read($projectId, array $filePatterns, array $fileLocations = [], $domainName = '', $localeCode = '')
    {
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
            $set[] = [
                'translations' => $this->fileParsers['xlf']->parse($file),
                'file_path' => $file->getPathname(),
                'project_id' => $projectId
            ];
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
