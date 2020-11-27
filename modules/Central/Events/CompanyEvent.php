<?php

namespace Modules\Central\Events;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Modules\Central\Entities\Company;

class CompanyEvent
{
    use SerializesModels;

    private $company;
    private $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Company $company, array $userData)
    {
        $this->company = $company;
        $this->user = $userData;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
