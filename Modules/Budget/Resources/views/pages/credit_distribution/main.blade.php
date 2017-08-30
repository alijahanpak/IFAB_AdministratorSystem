@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>توزیع اعتبار
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>تملک داریی های سرمایه ای
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>استانی
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>طرح های توزیع اعتبار
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @include('budget::pages.credit_distribution.forms')
        <div class="grid-x dashboard-padding">
            <div class="medium-12 column">
                <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="credit_distribution_plan_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                    <li class="tabs-title is-active"><a href="#credit_distribution_plan_all_tab" aria-selected="true">طرح های توزیع اعتبار</a></li>
                    <li class="tabs-title"><a href="#row_tab">ردیف</a></li>
                    <li class="tabs-title"><a href="#budget_season_tab">فصل بودجه</a></li>
                    <li class="tabs-title"><a href="#county_tab">شهرستان</a></li>
                </ul>

                <div class="tabs-content" data-tabs-content="credit_distribution_plan_tab_view">
                    <!--Tab 1-->
                        @include('budget::pages.credit_distribution.plans')
                    <!--Tab 1-->
                    <!--Tab 2-->
                        @include('budget::pages.credit_distribution.rows')
                    <!--Tab 2-->
                    <!--Tab 3-->
                        @include('budget::pages.credit_distribution.budget_season')
                    <!--Tab 3-->
                    <!--Tab 3-->
                        @include('budget::pages.credit_distribution.county')
                    <!--Tab 3-->
                </div>
            </div>
        </div>
    </div>
@stop
