@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
        <div class="medium-10 border-right-line inner-body-pad main-margin">
            <div class="grid-x padding-lr">
                <div class="medium-12">
                    <div class="grid-x border-btm-line">
                        <nav aria-label="You are here:" role="navigation">
                            <ul class="breadcrumbs">
                                <li><a href="">داشبورد</a></li>
                                <li>
                                    <a class="disabled">مدیریت</a>
                                </li>
                                <li>
                                    <span class="show-for-sr">Current: </span>ریز فصول
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @include('budget::pages.sub_seasons.forms')
            <div class="grid-x dashboard-padding">
                <div class="medium-12 column">
                    <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="sub_season_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                        <li class="tabs-title is-active"><a href="#capital_assets" aria-selected="true">تملک دارایی سرمایه ای</a></li>
                        <li class="tabs-title"><a href="#cost">هزینه ای</a></li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="sub_season_tab_view">
                        <!--Tab 1-->
                    @include('budget::pages.sub_seasons.capital_assets')
                    <!--Tab 1-->
                        <!--Tab 2-->

                    <!--Tab 2-->

                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
@stop

