@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div style="padding-top: 15px;" class="grid-x padding-lr my-callout-box">
            <div class="medium-12">
                <div class="grid-x">
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
        <div style="margin-top: 10px;" class="grid-x my-callout-box">
            <div class="medium-12 column">
                <ul style="border: none;border-bottom: 1px solid #e6e6e6;" class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="sub_season_tab_view" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                    <li class="tabs-title is-active"><a href="#capital_assets" aria-selected="true">تملک دارایی سرمایه ای</a></li>
                    <li class="tabs-title"><a href="#cost">هزینه ای</a></li>
                </ul>
                <div  class="tabs-content" data-tabs-content="sub_season_tab_view">
                    <div id="tinySeasons">
                        @include('budget::pages.sub_seasons.forms')
                        <!--Tab 1-->
                        @include('budget::pages.sub_seasons.capital_assets')
                        <!--Tab 1-->
                            <!--Tab 2-->
                        @include('budget::pages.sub_seasons.cost')
                        <!--Tab 2-->
                        <notifications group="tinySeasonPm"
                                       position="bottom right"
                                       animation-type="velocity"
                                       :speed="700" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

