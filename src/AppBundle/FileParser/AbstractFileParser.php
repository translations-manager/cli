<?php

namespace AppBundle\FileParser;

use Monolog\Logger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractFileParser implements FileParserInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
        $this->logger = new Logger('parser');
    }

    /**
     * {@inheritdoc}
     */
    abstract public function parse(\SplFileInfo $file);
}
