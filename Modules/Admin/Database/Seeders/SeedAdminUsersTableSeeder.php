<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\User;

class SeedAdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = new User;

        $user->name = 'علی جهان پاک';
        $user->email = 'a.jahanpak';
        $user->password = Hash::make('redrose');
        $user->save();
    }
}
