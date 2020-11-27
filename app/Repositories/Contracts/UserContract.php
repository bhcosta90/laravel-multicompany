<?php

namespace App\Repositories\Contracts;

interface UserContract {
    public function create(array $data);

    public function update($id, array $data);

    public function getByEmail(string $email);

    public function find($id);
}