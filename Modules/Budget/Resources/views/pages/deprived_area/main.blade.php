@extends('budget::layouts.master')
@section('content')
    @include('budget::pages.deprived_area.forms')
    {{--//////////////////////////////////////////////////////////////////--}}
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">داشبورد</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>مدیریت
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>مناطق محروم
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-grid-margin">
            <div class="medium-12 padding-lr">
                <div class="clearfix">
                    <div class="float-left">
                        <div class="input-group float-left">
                            <input class="input-group-field small-font" type="text">
                            <div class="input-group-button">
                                <button type="button" class="my-secondary button"><i class="fi-magnifying-glass"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x dashboard-padding">
            <div class="medium-12 column">
                <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="deprived_area" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                    <li class="tabs-title is-active"><a href="#province" aria-selected="true">استان</a></li>
                    <li class="tabs-title"><a href="#county">شهرستان</a></li>
                    <li class="tabs-title"><a href="#region">بخش</a></li>
                    <li class="tabs-title"><a href="#rural_district">دهستان</a></li>
                    <li class="tabs-title"><a href="#village">روستا</a></li>
                </ul>

                <div class="tabs-content" data-tabs-content="deprived_area">
                    <!--Tab 1 Start-->
                        @include('budget::pages.deprived_area.province')
                    <!--Tab 1 End-->
                    <!--Tab 2 Start-->
                        @include('budget::pages.deprived_area.county')
                    <!--Tab 2 End-->
                    <!--Tab 3 Start-->
                        @include('budget::pages.deprived_area.region')
                    <!--Tab 3 End-->
                    <!--Tab 4 Start-->
                        @include('budget::pages.deprived_area.rural_district')
                    <!--Tab 4 End-->
                    <!--Tab 5 Start-->
                        @include('budget::pages.deprived_area.village')
                    <!--Tab 5 End-->
                </div>
            </div>
        </div>
    </div>
@stop
