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
                                    <span class="show-for-sr">Current: </span>مدیریت
                                </li>
                                <li>
                                    <span class="show-for-sr">Current: </span>ریز فصول
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
                <div class="medium-12 column my-callout">

                </div>
            </div>
        </div>

@stop

