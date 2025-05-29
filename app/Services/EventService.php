<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    /**
     * @param EventRepository $repo
     */
    public function __construct(
        private EventRepository $repo
    ){}

    public function getAuthEvents()
    {
        return $this->repo->getAuthEvents();
    }

    public function create(array $params)
    {
        return $this->repo->create($params);
    }
}
