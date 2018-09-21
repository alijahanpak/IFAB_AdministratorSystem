<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\Category;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\Role;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\UserGroup;
use Modules\Admin\Entities\UserPermission;
use Modules\Admin\Entities\Village;
/**
 * @resource admin controller
 *
 * manage all subSystem values
 */
class AdminController extends Controller
{

    /**
     * fetch all Region by county id
     *
     * you have pass above params:
     *
     * 1- cId => countyId
     *
     */
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

    public function getRoleAndPermissions()
    {
        $role = Role::where('id' , '=' , Auth::user()->rId)->first();

        return \response()->json(
            ["rRole" => $role->rRole,
                "permissions" => UserPermission::where('upUId' , '=' , Auth::user()->id)
                    ->with('permission')
                    ->get()
            ]
        );
    }

    public function uploadAvatar(Request $request)
    {
        if ($request->hasFile('avatar_img'))
        {
            $result = DB::transaction(function () use($request){
                try{
                    $file = $request->file('avatar_img');
                    $filePath = $file->storeAs(
                        'pic/avatars',
                        'avatar' . Auth::user()->id . '.' . $file->clientExtension());
                    User::where('id' , '=' , Auth::user()->id)->update(['avatarPath' => $filePath]);
                    return \response()->json(['imgPath' => $filePath]);
                }catch (Exception $e){
                    return \response()->json([] , 500);
                }
            });
            return $result;
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

    public function fetchMyCategoryUsers(Request $request)
    {
        $result = User::whereHas('role.category' , function ($q) use($request){
            return $q->where('rcCId' , '=' , $request->cId);
        })->where('id' , '<>' , Auth::user()->id)
            ->select('id' , 'rId' , 'name')
            ->with('role')
            ->get();
        return \response()->json($result);
    }

    public function fetchDirectorGeneralUsers(Request $request)
    {
        $result = User::whereHas('role.category' , function ($q){
            return $q->where('rcCId' , '=' , Category::where('cCategory' , '=' , 'DIRECTOR_GENERAL')->value('id'));
        })->select('id' , 'rId' , 'name')
            ->with('role')
            ->get();
        return \response()->json($result);
    }
}
