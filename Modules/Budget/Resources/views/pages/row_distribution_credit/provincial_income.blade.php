<div class="tabs-panel table-mrg-btm dynamic-height-level1" id="provincial_income" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div id="dynamicParentId1">
        <div class="medium-12 bottom-mrg">
            <div class="clearfix border-btm-line bottom-mrg">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button" id="show-modal" @click="showModal = true; errorMessage = ''" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                        <i class="fi-plus size-30 secondry-color"></i>
                    </a>
                    <a class="clear button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
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
                <div class="table-contain dynamic-height-level2">
                    <div class="grid-x" v-for="season in tinySeasons">
                        <div class="medium-2 table-contain-border cell-vertical-center">
                            @{{ season.sSubject }}
                        </div>
                        <div class="medium-10">
                            <div class="grid-x selectAbleRow" v-for="tinySeason in season.tiny_season">
                                <div class="medium-6 table-contain-border cell-vertical-center">
                                    @{{ tinySeason.tsSubject }}
                                </div>
                                <div class="medium-6  table-contain-border cell-vertical-center">
                                    <div class="grid-x">
                                    <div class="medium-11">
                                        @{{ tinySeason.tsDescription }}
                                    </div>
                                    <div class="medium-1 cell-vertical-center text-left">
                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + tinySeason.id"><img width="15px" height="15px" src="{{ asset('pic/menu.svg') }}"></a>
                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + tinySeason.id" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font text-right">
                                                <li><a v-on:click.prevent="tinySeasonUpdateDialog(tinySeason , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                <li><a v-on:click.prevent="openDeleteTinySeasonConfirm(tinySeason)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>

