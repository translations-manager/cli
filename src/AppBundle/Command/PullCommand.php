<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PullCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pull')
            ->setDescription('Update your locale files by replacing them with the remote translations')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $project = $this->get('app.provider.project')->getProject($this->getParameter('project_id'));

        $translations = $this->get('app.provider.translation')->getTranslations(
            $this->resolveDomainIds($project),
            $this->resolveFileLocationIds($project),
            $this->resolveLocaleIds($project)
        );

        $this->get('app.handler.write_files')->write($translations);
    }

    /**
     * @param \stdClass $project
     *
     * @return array
     */
    private function resolveDomainIds($project)
    {
        return array_map(function ($domain) {
            return $domain->id;
        }, $project->domains);
    }

    /**
     * @param \stdClass $project
     *
     * @return array
     */
    private function resolveFileLocationIds($project)
    {
        return array_map(function ($fileLocation) {
            return $fileLocation->id;
        }, $project->file_locations);
    }

    /**
     * @param \stdClass $project
     *
     * @return array
     */
    private function resolveLocaleIds($project)
    {
        return array_map(function ($locale) {
            return $locale->id;
        }, $project->locales);
    }
}
