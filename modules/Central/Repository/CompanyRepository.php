<?php

namespace Modules\Central\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Central\Entities\Company;
use Modules\Central\Events\CompanyEvent;

final class CompanyRepository implements Contracts\CompanyContract
{
    public function find($id): Company
    {
        return Company::find($id);
    }

    public function getCompanyInArrayById(array $id): Builder
    {
        return Company::whereIn('id', $id);
    }

    public function configurate(Model $company, $isDefault = false)
    {
        DB::purge('company');
        config()->set('database.connections.company.database', $company->license);
        config()->set('session.files', storage_path("framework/sessions"));
        DB::reconnect('company');

        Schema::connection('company')->getConnection()->reconnect();
    }

    public function active($isDefault = false)
    {
        config()->set('database.default', $isDefault ? 'company' : env('DB_CONNECTION', 'mysql'));
    }

    public function getByUuid($id)
    {
        return Company::where('uuid', $id)->firstOrFail();
    }

    public function delete($id)
    {
        $obj = $this->getByUuid($id);
        $obj->delete();
        return true;
    }

    public function show($id): Company
    {
        return $this->getByUuid($id);
    }

    public function create(array $data): Company
    {
        $totalPoint = collect(explode('.', $data['domain']));
        $data['license'] = $totalPoint->first();
        $data['theme'] = 'default';

        $obj = Company::create($data);

        event(new CompanyEvent($obj, $data['user']));

        return $obj;
    }

    public function databaseCreate(string $database)
    {
        if ($database != env('DB_DATABASE')) {
            DB::statement("CREATE DATABASE IF NOT EXISTS {$database}");
        }
    }

    public function databaseDrop(string $database)
    {
        if ($database != env('DB_DATABASE')) {
            DB::statement("DROP DATABASE IF EXISTS {$database}");
        }
    }

    public function index(): Builder
    {
        return Company::query();
    }
}
