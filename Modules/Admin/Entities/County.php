<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\DeprivedArea;

class County extends Model
{
    protected $table = 'tbl_counties';
    protected $fillable = [];

    public function creditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id')->orderBy('id', 'DESC');
    }

    public function creditDistributionPlanHasProposal()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id')->has('proposal')->orderBy('id', 'DESC');
    }

    public function creditDistributionTitle()
    {

        return $this->hasMany(CreditDistributionTitle::class , 'cdtCoId' , 'id')->orderBy('id', 'DESC');
    }

    public function capitalAssetsProject()
    {

        return $this->hasMany(CapitalAssetsProject::class , 'cpCoId' , 'id')->orderBy('id', 'DESC');
    }
}
