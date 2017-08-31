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
            <div class="medium-12 my-callout">
                <div class="medium-12  bottom-mrg">
                    <div class="clearfix border-btm-line ">
                        <div class="button-group float-left report-mrg">
                            <a  class="clear button"  data-open="CDP_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                                <i class="fi-plus size-30 secondry-color"></i>
                            </a>
                            <a  class="clear button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                                <i class="fi-clipboard-notes size-30 secondry-color"></i>
                            </a>
                        </div>
                        <div class="float-right">
                            <div class="input-group float-left">
                                <input class="input-group-field small-font" type="text">
                                <div class="input-group-button">
                                    <button type="button" class="my-secondary button"><i class="fi-magnifying-glass"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div  class="grid-x collapse">
                    <div style="height: 300px;overflow-y: auto;direction: ltr;" class="medium-1 columns">
                        <ul style="min-height: 300px;" class="vertical tabs" data-tabs id="example-tabs">
                            <li class="tabs-title is-active"><a href="#panel1v" aria-selected="true">همدان</a></li>
                            <li class="tabs-title"><a href="#panel2v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel3v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel4v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel5v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel5v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel5v">همدان</a></li>
                            <li class="tabs-title"><a href="#panel5v">همدان</a></li>

                        </ul>
                    </div>
                    <div style="overflow-y: auto;height: 300px;" class="medium-11 columns my-callout">
                        <div class="tabs-content" data-tabs-content="example-tabs">
                            <div class="tabs-panel is-active" id="panel1v">
                                <div class="columns">
                                    <!--Header Start-->
                                    <div class="grid-x table-header">
                                        <div class="medium-2 table-border">
                                            <strong>کد</strong>
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x">
                                                <div class="medium-4 table-border">
                                                    <strong>عنوان</strong>
                                                </div>
                                                <div class="medium-4  table-border">
                                                    <strong>اعتبار پیشنهادی</strong>
                                                </div>
                                                <div class="medium-4  table-border">
                                                    <strong>شرح</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-contain">
                                        <div class="grid-x">
                                            <div class="medium-2 table-contain-border cell-vertical-center"></div>
                                            <div class="medium-10">

                                                    <div class="grid-x">
                                                        <div class="medium-4 table-contain-border">dfd</div>
                                                        <div class="medium-4  table-contain-border">dfsdf</div>
                                                        <div class="medium-4  table-contain-border">dfsdfd</div>
                                                    </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                                    <!--Header End-->
                            </div>
                            <div class="tabs-panel" id="panel2v">
                                <p>Two</p>
                                <img class="thumbnail" src="//foundation.zurb.com/sites/docs/assets/img/generic/rectangle-7.jpg">
                            </div>
                            <div class="tabs-panel" id="panel3v">
                                <p>Three</p>
                                <p>Check me out! I'm a super cool Tab panel with text content!</p>
                            </div>
                            <div class="tabs-panel" id="panel4v">
                                <p>Four</p>
                                <img class="thumbnail" src="//foundation.zurb.com/sites/docs/assets/img/generic/rectangle-2.jpg">
                            </div>
                            <div class="tabs-panel" id="panel5v">
                                <p>Five</p>
                                <p>Check me out! I'm a super cool Tab panel with text content!</p>
                            </div>
                            <div class="tabs-panel" id="panel6v">
                                <p>Six</p>
                                <img class="thumbnail" src="//foundation.zurb.com/sites/docs/assets/img/generic/rectangle-8.jpg">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
