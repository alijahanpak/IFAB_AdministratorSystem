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
                            <div class="grid-x">
                                <div class="medium-2 table-contain-border cell-vertical-center">
                                        فصل اول
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x">
                                        <div class="medium-6 table-contain-border">
                                            مطالعه برای احداث ساختمان و مستحدثات
                                        </div>
                                        <div class="medium-6  table-contain-border">
                                            <a onclick="openTableRowAcc('rowTest')">sadfasdfgsdf</a>
                                        </div>

                                    </div>
                                    <div class="grid-x display-off table-contain-border horizontal-scroll" id="rowTest">
                                        <table>
                                            <thead class="my-thead">
                                            <th class="tbl-rotate-txt">همدان</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            <th class="tbl-rotate-txt">1231234</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                                <td>23452345</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-2 table-contain-border">
                                    dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x">
                                        <div class="medium-6 table-contain-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                        <div class="medium-6  table-contain-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                    </div>
                                    <div class="grid-x table-contain-border">
                                        dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-2 table-border">
                                    fasdf
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x">
                                        <div class="medium-4 table-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                        <div class="medium-4  table-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                        <div class="medium-4  table-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                    </div>
                                    <div class="grid-x table-border">
                                        dfgsdfg
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-2 table-border">
                                    dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x">
                                        <div class="medium-4 table-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                        <div class="medium-4  table-border">
                                            ssdf
                                        </div>
                                        <div class="medium-4  table-border">
                                            dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                        </div>
                                    </div>
                                    <div class="grid-x table-border">
                                        dfsdfghdfgh dfgh dfghd fgh dfghd fghd fghd fghdfghd fghd fghd fghd fghd
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-2 table-border">
                                    fasdf
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x">
                                        <div class="medium-4 table-border">
                                            df
                                        </div>
                                        <div class="medium-4  table-border">
                                            ssdf
                                        </div>
                                        <div class="medium-4  table-border">
                                            sdf
                                        </div>
                                    </div>
                                    <div class="grid-x table-border">
                                        dfgsdfg
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!--Table End-->
                </div>
            </div>
        </div>

@stop

