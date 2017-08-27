@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مدیریت
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>ثبت طرح های توزیع اعتبار
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
                    <li class="tabs-title"><a href="#city_tab">شهرستان</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="credit_distribution_plan_tab_view">
                    <!--Tab 1 Start-->
                        @include('budget::pages.credit_distribution.plans')
                    <!--Tab 1 End-->
                </div>
            </div>
        </div>
    </div>
    <script>
        $('[data-loading-start]').click(function() {
            $(this).addClass('hide')
            $('[data-loading-end]').removeClass('hide')
        });
    </script>
@stop