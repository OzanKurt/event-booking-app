<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;

class EventService
{
    /**
     * @param EventRepository $repo
     */
    public function __construct(
        private EventRepository $repo
    ){}

    public function getEvents()
    {
        return $this->repo->getEvents();
    }

    public function create(array $params)
    {
        return $this->repo->create($params);
    }

    /**
     * @throws \Exception
     */
    public function delete(Event $event)
    {
        if ($event->bookings()->count() > 0) {
            throw new \Exception('Cannot delete event with bookings.');
        }

        $event->delete();
    }

    public function getUserEvents(int $userId)
    {
        return $this->repo->getUserEvents($userId);
    }
}
