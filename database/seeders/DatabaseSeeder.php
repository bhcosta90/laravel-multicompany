<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $total = 10;
        
        if(User::count() == 0){
            User::factory()->create(['email' => 'admin@admin.com.br']);
            $total -= 1;
        }
        User::factory($total)->create();
    }
}
