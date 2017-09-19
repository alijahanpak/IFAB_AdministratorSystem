@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>عنوان طرح / برنامه
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x dashboard-padding">
            <div class="medium-12 column">
                <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="title_of_plans_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                    <li class="tabs-title is-active"><a href="#cost_tab" aria-selected="true">هزینه ای</a></li>
                    <li class="tabs-title "><a href="#capital_assets_tab" aria-selected="true">تملک دارایی های سرمایه ای</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="title_of_plans_tab_view">
                    <div id="titleOfPlans">
                        @include('budget::pages.title_of_plans.forms')
                        <!--Tab 1-->
                        @include('budget::pages.title_of_plans.cost')
                        <!--Tab 1-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

