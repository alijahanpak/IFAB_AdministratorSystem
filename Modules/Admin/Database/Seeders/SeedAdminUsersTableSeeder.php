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
        $user->name = 'حسین خورشیدی';
        $user->email = 'h.khorshidi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 3;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'سمیرا رجب پور';
        $user->email = 's.rajabpoor';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 1;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'مرتضی امزاجردی';
        $user->email = 'm.amzajerdi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 4;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'علی جهان پاک';
        $user->email = 'a.jahanpak';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 2;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'آقای کریمی';
        $user->email = 'a.karimi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 5;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 5;
        $user->name = 'خانم خسروی';
        $user->email = 'k.khosravi';
        $user->superUser = true;
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 5;
        $user->save();
    }
}
