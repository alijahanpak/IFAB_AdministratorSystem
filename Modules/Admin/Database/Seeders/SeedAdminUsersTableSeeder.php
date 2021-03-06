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
        $user->seFiscalYear = 1;
        $user->name = 'جلال قره باغی';
        $user->email = 'j.g_baghi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 3;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'سمیرا رجب پور';
        $user->email = 's.rajabpoor';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 1;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'علی نجاری';
        $user->email = 'a.najari';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        //$user->avatarPath = 'pic/avatars/avatar3.png';
        $user->rId = 4;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'فاطمه قیاسوند';
        $user->email = 'f.ghiasvand';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        //$user->avatarPath = 'pic/avatars/avatar4.png';
        $user->rId = 4;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'آقای کریمی';
        $user->email = 'a.karimi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 5;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'خانم خسروی';
        $user->email = 'k.khosravi';
        $user->superUser = true;
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 10;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'علی مالمیر';
        $user->email = 'a.malmir';
        $user->superUser = true;
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        //$user->avatarPath = 'pic/avatars/avatar7.jpg';
        $user->rId = 6;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'رضا حیرانیان';
        $user->email = 'r.heyranian';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 7;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'احمد ترابی';
        $user->email = 'a.torabi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        //$user->avatarPath = 'pic/avatars/avatar9.jpeg';
        $user->rId = 8;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'سید کمال الدین طوسی';
        $user->email = 'k.toosee';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 9;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'ماکان جابری';
        $user->email = 'm.jabery';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 11;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'رضا محمدی';
        $user->email = 'r.mohammadi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 12;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'علیرضا طاهری';
        $user->email = 'a.taheri';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 13;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'علی مرادی';
        $user->email = 'a.moradi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 14;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'فاطمه لطفی';
        $user->email = 'f.lotfi';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 4;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'داود صفا';
        $user->email = 'd.safa';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 4;
        $user->save();

        $user = new User;
        $user->seFiscalYear = 1;
        $user->name = 'امین بهمن پور';
        $user->email = 'a.bahmanpoor';
        $user->password = Hash::make('1234');
        $user->seInPutAmount = 3;
        $user->seDispAmount = 3;
        $user->rId = 4;
        $user->save();
    }
}
