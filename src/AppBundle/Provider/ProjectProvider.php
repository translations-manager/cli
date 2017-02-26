<?php

namespace AppBundle\Provider;

class ProjectProvider extends BaseProvider
{
    /**
     * @param int $projectId
     *
     * @return mixed
     */
    public function getProject($projectId)
    {
        return $this->client->get(sprintf('projects/%d', $projectId));
    }
}
