<?php

namespace Modules\Central\Console;

use Illuminate\Console\Command;
use Modules\Central\Repository\Contracts\CompanyContract;

class CompanyMigrateCommand extends Command
{
    private $repository;

    public function __construct(CompanyContract $companyContract)
    {
        parent::__construct();
        $this->repository = $companyContract;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:migrate {--ids=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate to company.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ids = collect($this->option('ids') ? explode(',', $this->option('ids')) : []);
        foreach($ids as $id){
            $objCompany = $this->repository->find($id);
            $this->repository->configurate($objCompany);

            $this->call('migrate', [
                '--database' => 'company',
                '--path' => 'database/migrations'
            ]);
        }
        return 0;
    }
}
