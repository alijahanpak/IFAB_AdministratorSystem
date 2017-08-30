@extends('budget::layouts.master')
@section('content')
    @include('budget::pages.sub_seasons.forms')
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
            <div class="grid-x dashboard-padding">
                <div class="medium-12 column my-callout">
                    <div class="grid-x bottom-mrg">
                        <div class="medium-12">

                            <div class="clearfix border-btm-line">
                                <div class="button-group float-left report-mrg">
                                    <a  class="clear button"  data-open="SS_ModalInsert" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                    </div>

                    <!--Table Start-->
                    <div class="columns">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-2 table-border">
                               <strong>فصل</strong>
                            </div>
                            <div class="medium-10">
                                <div class="grid-x">
                                    <div class="medium-6 table-border">
                                        <strong>ریز فصل</strong>
                                    </div>
                                    <div class="medium-6  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Header End-->
                        <div class="table-contain">
                            <?php $rowColor = 0; ?>
                            @foreach($subSeasons as $subSeason)
                            <div class="grid-x">
                                <div class="medium-2 table-contain-border cell-vertical-center">{{ $subSeason->season->sSubject }}</div>
                                <div class="medium-10">
                                    @foreach(\Modules\Budget\Entities\TinySeason::getTinySeasonWithSId($subSeason->tsSId) as $sb)
                                        <div class="grid-x {{ $rowColor % 2 == 0 ? 'tableRowColor' : '' }} selectAbleRow">
                                            <div class="medium-6 table-contain-border">{{ $sb->tsSubject }}</div>
                                            <div class="medium-6  table-contain-border">{{ $sb->tsDescription }}</div>
                                        </div>
                                        <?php $rowColor++; ?>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                    <!--Table End-->
                </div>
            </div>
        </div>

@stop

