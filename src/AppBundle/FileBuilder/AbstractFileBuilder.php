<?php

namespace AppBundle\FileBuilder;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractFileBuilder implements FileBuilderInterface
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
    abstract public function build($location, $domain, $locale, array $translations);
}
