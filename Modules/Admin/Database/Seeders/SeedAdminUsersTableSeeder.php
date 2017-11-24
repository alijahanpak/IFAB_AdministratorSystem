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
        $user->seFiscalYear = 5;
        $user->name = 'علی جهان پاک';
        $user->email = 'a.jahanpak';
        $user->password = Hash::make('redrose');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'سمیرا رجب پور';
        $user->email = 's.rajabpoor';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->save();
    }
}
