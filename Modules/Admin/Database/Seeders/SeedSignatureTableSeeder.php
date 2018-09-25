<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Signature;
use Modules\Admin\Entities\User;

class SeedSignatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $users = User::all();
        foreach ($users as $user)
        {
            $sig = new Signature();
            $sig->sUId = $user->id;
            $sig->sPath = 'http://127.0.0.1/IFAB_AdministratorSystem/public/pic/signatures/test_signature.png';
            $sig->save();
        }
    }
}
