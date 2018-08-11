<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\Group;
use Modules\Admin\Entities\GroupPermission;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\UserGroup;
use Modules\Admin\Entities\Village;

class AdminController extends Controller
{
    public function getRegionsByCountyId(Request $request)
    {
            $region = Region::where('reCoId' , '=' , $request->coId)->get();
            return \response()->json($region);
    }

    public function getRuralDistrictByRegionId(Request $request)
    {
        $ruralDistricts = RuralDistrict::where('rdReId' , '=' , $request->reId)->get();
        return \response()->json($ruralDistricts);
    }

    public function getVillagesByRuralDistrictId(Request $request)
    {
        $ruralDistricts = Village::where('viRdId' , '=' , $request->rdId)->get();
        return \response()->json($ruralDistricts);
    }

    public function getAllCounties()
    {
        return \response()->json(County::all());
    }

    public function getAllSeasons()
    {
        return \response()->json(Season::all());
    }

    public function getProvincePlanLabel(Request $request)
    {
        return \response()->json(PublicSetting::getProvincePlanLebel());
    }

    public function getPublicParams()
    {
        return \response()->json(
            PublicSetting::all()
        );
    }

    public function getAmountBase()
    {
        return \response()->json(
            User::select(['seInPutAmount' , 'seDispAmount'])
                ->with('inPutAmountUnit')
                ->with('dispAmountUnit')
                ->where('id' , '=' , Auth::user()->id)
                ->first()
        );
    }

    public function getRoleAndGroupPermissions()
    {
        $role = Role::where('id' , '=' , Auth::user()->rId)->first();
        $gIDs = UserGroup::where('ugUId' , '=' , Auth::user()->id)->pluck('ugGId')->toArray();

        return \response()->json(
            ["rRole" => $role->rRole, "groupPermissions" => GroupPermission::whereIn('gpGId' , $gIDs)
                ->with('permission')
                ->get()]
        );
    }

    public function uploadAvatar(Request $request)
    {

        if ($request->hasFile('avatar_img'))
        {
            $file = $request->file('avatar_img');
            $filePath = $file->storeAs(
                'pic/avatars',
                'avatar' . Auth::user()->id . '.' . $file->clientExtension());
            User::where('id' , '=' , Auth::user()->id)->update(['avatarPath' => $filePath]);
            return \response()->json(['imgPath' => $filePath]);
        }
    }

    public function changeAmountBase(Request $request)
    {
        User::where('id' , '=' , Auth::user()->id)
            ->update(['seInPutAmount' => $request->auId , 'seDispAmount' => $request->auId]);
        return \response()->json([] , 200);
    }

    public function getAllAmountBase()
    {
        return \response()->json(
            AmountUnit::all()
        );
    }

    public function fetchMyGroupsUsers()
    {
        if (Auth::user()->superUser != true)
        {
            $myGroups = UserGroup::where('ugUId' , '=' , Auth::user()->id)->pluck('ugGId');
            $usersId = UserGroup::whereIn('ugGId' , $myGroups)->pluck('ugUId');
            $usersInfo = User::whereIn('id' , $usersId)
                ->where('id' , '<>' , Auth::user()->id)
                ->select('id' , 'name' , 'rId')
                ->with('role')
                ->get();
        }else{
            $usersId = UserGroup::pluck('ugUId');
            $usersInfo = User::whereIn('id' , $usersId)
                ->where('id' , '<>' , Auth::user()->id)
                ->select('id' , 'name' , 'rId')
                ->with('role')
                ->get();
        }

        return \response()->json(
            $usersInfo
        );
    }
}
