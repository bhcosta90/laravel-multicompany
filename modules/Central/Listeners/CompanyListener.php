<?php

namespace Modules\Central\Listeners;

use App\Models\User;
use App\Repositories\Contracts\UserContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Modules\Central\Events\CompanyEvent;
use Modules\Central\Repository\Contracts\CompanyContract;

class CompanyListener implements ShouldQueue
{
    private $repository;

    private $user;

    public function __construct(CompanyContract $companyContract, UserContract $userContract)
    {
        $this->repository = $companyContract;
        $this->user = $userContract;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CompanyEvent $event)
    {
        $license = $event->getCompany()->license;
        
        $this->repository->databaseCreate($license);
        $this->repository->configurate($event->getCompany(), true);
        
        Artisan::call('company:migrate', [
            '--ids' => $event->getCompany()->id,
        ]);

        $this->repository->active(true);

        $builderUser = $this->user->getByEmail($event->getUser()['email']);
        $total = $builderUser->count();
        
        if ($total == 0) {
            $this->user->create($event->getUser());
        } else {
            $this->user->update($builderUser->first()->id, $event->getUser());
        }
    }
}
