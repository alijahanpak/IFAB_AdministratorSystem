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
                                <span class="show-for-sr">Current: </span>پیشنهاد دستگاه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x dashboard-padding">
            <div class="medium-12 column">
                <ul class="vertical tabs" data-tabs id="example-tabs">
                    <li class="tabs-title is-active"><a href="#panel1v" aria-selected="true">Tab 1</a></li>
                    <li class="tabs-title"><a href="#panel2v">Tab 2</a></li>
                    <li class="tabs-title"><a href="#panel3v">Tab 3</a></li>
                    <li class="tabs-title"><a href="#panel4v">Tab 4</a></li>
                    <li class="tabs-title"><a href="#panel5v">Tab 5</a></li>
                    <li class="tabs-title"><a href="#panel6v">Tab 6</a></li>
                </ul>
            </div>
            <div class="medium-9 columns">
                <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel" id="panel1v">
                        <p>One</p>
                        <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                    <div class="tabs-panel" id="panel2v">
                        <p>Two</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-7.jpg">
                    </div>
                    <div class="tabs-panel" id="panel3v">
                        <p>Three</p>
                        <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                    <div class="tabs-panel" id="panel4v">
                        <p>Four</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-2.jpg">
                    </div>
                    <div class="tabs-panel" id="panel5v">
                        <p>Five</p>
                        <p>Check me out! I'm a super cool Tab panel with text content!</p>
                    </div>
                    <div class="tabs-panel" id="panel6v">
                        <p>Six</p>
                        <img class="thumbnail" src="assets/img/generic/rectangle-8.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
