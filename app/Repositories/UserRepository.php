<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

final class UserRepository implements Contracts\UserContract {

    public function create(array $data)
    {
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function find($id) :User
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $objUser = $this->find($id);

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        
        $objUser->update($data);
        return $objUser;
    }

    public function getByEmail(string $email): Builder
    {
        return User::where('email', $email);
    }

}