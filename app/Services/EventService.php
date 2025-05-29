<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Gate;

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

    public function show(int $eventId)
    {
        Gate::authorize('update', new Event());

        return $this->repo->create($params);
    }
}
