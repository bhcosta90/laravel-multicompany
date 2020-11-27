<?php

namespace Modules\Central\Repository\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CompanyContract {
    public function delete($id);

    public function find($id);

    public function active($isDefault = false);

    public function getCompanyInArrayById(array $id);

    public function getByUuid($id);

    public function create(array $data);

    public function databaseCreate(string $database);

    public function databaseDrop(string $database);

    public function configurate(Model $obj);

    public function index();
}
