<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('push')
            ->setDescription('Update your remote translations by replacing them with the local ones')
            ->addArgument(
                'files',
                InputArgument::IS_ARRAY,
                'Provide a list, separated by spaces, of files you want to push',
                []
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<fg=cyan>Fetching project...</>');

        try {
            $project = $this->get('app.provider.project')->getProject($this->getParameter('project_id'));
        } catch (\Exception $e) {
            $output->writeln('<fg=red>Unable to fetch project</>');
            $output->writeln($e->getMessage());
            die;
        }
        $output->writeln(sprintf('<fg=cyan>Project %s fetched. Reading local translations...</>', $project->name));

        $translations = $this
            ->get('app.handler.read_files')
            ->read(
                $project->id,
                $input->getArgument('files'),
                $this->resolveFileLocations($project),
                '',
                '',
                $this->getParameter('format')
            )
        ;

        $output->writeln('<fg=cyan>Ok, now uploading everything...</>');
        $provider = $this->get('app.provider.translation');

        foreach ($translations as $slice) {
            $output->writeln(sprintf(
                '<info>Uploading translations from %s %s</info>',
                $slice['file_path'],
                isset($slice['domain']) ? '(domain ' . $slice['domain'] . ')' : ''
            ));
            $provider->upTranslations($slice);
        }

        $output->writeln(sprintf('<fg=cyan>Done.</>'));
    }

    /**
     * @param \stdClass $project
     *
     * @return array
     */
    private function resolveFileLocations($project)
    {
        return array_map(function ($fileLocation) {
            return $fileLocation->path;
        }, $project->file_locations);
    }
}
