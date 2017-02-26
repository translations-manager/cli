<?php

namespace AppBundle\FileParser;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractFileParser implements FileParserInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function parse(\SplFileInfo $file);
}
