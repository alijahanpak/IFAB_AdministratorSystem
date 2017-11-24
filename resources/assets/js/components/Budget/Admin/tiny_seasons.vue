<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
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
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="sub_season_tab_view">
                    <li class="tabs-title is-active"><a href="#capital_assets" aria-selected="true">تملک دارایی سرمایه ای</a></li>
                    <li class="tabs-title"><a href="#cost">هزینه ای</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="sub_season_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="capital_assets"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDown">تعداد نمایش<span> {{ itemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="changeItemInPage(2 , 0)">2<span v-show="itemInPage == 2" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(4 , 0)">4<span v-show="itemInPage == 4" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(8 , 0)">8<span v-show="itemInPage == 8" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(10 , 0)">10<span v-show="itemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <div class="inner-addon right-addon">
                                            <i v-if="planSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="planSearchValue != ''" v-on:click.stop="removeFilter(0)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="planSearchValue" v-on:keyup.enter="search(0)" class="search" type="text" placeholder="جستجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="medium-12 column">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="250px"/>
                                            <col width="350px"/>
                                            <col width="200px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">فصل</th>
                                            <th class="tbl-head-style-cell">عنوان فصل</th>
                                            <th class="tbl-head-style-cell">ریز فصل</th>
                                            <th class="tbl-head-style-cell">شرح</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-level2">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="150px"/>
                                                <col width="250px"/>
                                                <col width="350px"/>
                                                <col width="200px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <template v-for="season in tinySeasons">
                                                <tr class="tbl-head-style-cell">
                                                    <td :rowspan="getSeasonCount(season.capital_assets_season_title)"> {{ season.sSubject }}</td>
                                                    <td :rowspan="season.capital_assets_season_title[0].capital_assets_tiny_season.length">  {{ season.capital_assets_season_title[0].castSubject }}</td>
                                                    <td> {{ season.capital_assets_season_title[0].capital_assets_tiny_season[0].catsSubject }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ season.capital_assets_season_title[0].capital_assets_tiny_season[0].catsDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + season.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + season.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(season.capital_assets_season_title[0].capital_assets_tiny_season[0] , season.id , 0)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(season.capital_assets_season_title[0].capital_assets_tiny_season[0].id , 0)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(seasonTitle , sIndex) in season.capital_assets_season_title">
                                                    <tr class="tbl-head-style-cell" v-if="sIndex > 0">
                                                        <td :rowspan="seasonTitle.capital_assets_tiny_season.length">{{seasonTitle.castSubject}}</td>
                                                        <td>{{seasonTitle.capital_assets_tiny_season[0].catsSubject}}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{seasonTitle.capital_assets_tiny_season[0].catsDescription}}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + season.id + seasonTitle.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + season.id + seasonTitle.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(seasonTitle.capital_assets_tiny_season[0] , season.id , 0)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(seasonTitle.capital_assets_tiny_season[0].id , 0)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <template v-for="(seasonTiny, ssIndex) in seasonTitle.capital_assets_tiny_season">
                                                        <tr class="tbl-head-style-cell" v-if="ssIndex > 0">
                                                            <td>{{seasonTiny.catsSubject}}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{seasonTiny.catsDescription}}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + season.id + seasonTitle.id + seasonTiny.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + season.id + seasonTitle.id + seasonTiny.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent="openUpdateModal(seasonTiny , season.id  , 0)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent="openDeleteModal(seasonTiny.id , 0)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="plan_pagination"
                                                     v-on:click.native="fetchCapitalAssetsData(plan_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="cost" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="">
                            <div class="medium-12 bottom-mrg">
                                <div class="clearfix tool-bar">
                                    <div class="button-group float-right report-mrg">
                                        <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                        <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="costDropDown">تعداد نمایش<span> {{ costItemInPage }} </span></button>
                                        <div style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="costDropDown" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font ltr-dir">
                                                <li><a  @click="changeItemInPage(2 , 1)">2<span v-show="costItemInPage == 2" class="fi-check checked-color size-14"></span></a></li>
                                                <li><a  @click="changeItemInPage(4 , 1)">4<span v-show="costItemInPage == 4" class="fi-check checked-color size-14"></span></a></li>
                                                <li><a  @click="changeItemInPage(8 , 1)">8<span v-show="costItemInPage == 8" class="fi-check checked-color size-14"></span></a></li>
                                                <li><a  @click="changeItemInPage(10 , 1)">10<span v-show="costItemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="float-left">
                                        <div class="input-group float-left">
                                            <div class="inner-addon right-addon">
                                                <i v-if="costSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                                <i v-if="costSearchValue != ''" v-on:click.stop="removeFilter(1)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                                <input v-model="costSearchValue" v-on:keyup.enter="search(1)" class="search" type="text" placeholder="جستجو">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Table Start-->
                                <div class="medium-12 column">
                                    <div class="tbl-div-container">
                                        <table class="tbl-head">
                                            <colgroup>
                                                <col width="150px"/>
                                                <col width="250px"/>
                                                <col width="350px"/>
                                                <col width="200px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style">
                                            <tr class="tbl-head-style-cell">
                                                <th class="tbl-head-style-cell">فصل</th>
                                                <th class="tbl-head-style-cell">عنوان فصل</th>
                                                <th class="tbl-head-style-cell">ریز فصل</th>
                                                <th class="tbl-head-style-cell">شرح</th>
                                                <th class="tbl-head-style-cell"></th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--Table Head End-->
                                        <!--Table Body Start-->
                                        <div class="tbl_body_style dynamic-height-level2">
                                            <table class="tbl-body-contain">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="350px"/>
                                                    <col width="200px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style-cell">
                                                <template v-for="cSeason in tinySeasonsCost">
                                                    <tr class="tbl-head-style-cell">
                                                        <td :rowspan="getSeasonCostCount(cSeason.cost_season_title)"> {{ cSeason.sSubject }}</td>
                                                        <td :rowspan="cSeason.cost_season_title[0].cost_tiny_season.length">  {{ cSeason.cost_season_title[0].cstSubject }}</td>
                                                        <td> {{ cSeason.cost_season_title[0].cost_tiny_season[0].ctsSubject }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ cSeason.cost_season_title[0].cost_tiny_season[0].ctsDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'ctsTinySeason' + cSeason.id "><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'ctsTinySeason' + cSeason.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(cSeason.cost_season_title[0].cost_tiny_season[0] , cSeason.id , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(cSeason.cost_season_title[0].cost_tiny_season[0].id , 1)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <template v-for="(cSeasonTitle , sIndex) in cSeason.cost_season_title">
                                                        <tr class="tbl-head-style-cell" v-if="sIndex > 0">
                                                            <td :rowspan="cSeasonTitle.cost_tiny_season.length">{{cSeasonTitle.cstSubject}}</td>
                                                            <td>{{cSeasonTitle.cost_tiny_season[0].ctsSubject}}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{cSeasonTitle.cost_tiny_season[0].ctsDescription}}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'ctsTinySeason' + cSeason.id + cSeasonTitle.id "><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'ctsTinySeason' + cSeason.id + cSeasonTitle.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent="openUpdateModal(cSeasonTitle.cost_tiny_season[0] , cSeason.id , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent="openDeleteModal(cSeasonTitle.cost_tiny_season[0].id , 1)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <template v-for="(cSeasonTiny, ssIndex) in cSeasonTitle.cost_tiny_season">
                                                            <tr class="tbl-head-style-cell" v-if="ssIndex > 0">
                                                                <td>{{cSeasonTiny.ctsSubject}}</td>
                                                                <td>
                                                                    <div class="grid-x">
                                                                        <div class="medium-11">
                                                                            {{cSeasonTiny.ctsDescription}}
                                                                        </div>
                                                                        <div class="medium-1 cell-vertical-center text-left">
                                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + cSeason.id + cSeasonTitle.id + cSeasonTiny.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + cSeason.id + cSeasonTitle.id + cSeasonTiny.id" data-dropdown data-auto-focus="true">
                                                                                <ul class="my-menu small-font text-right">
                                                                                    <li><a v-on:click.prevent="openUpdateModal(cSeasonTiny , cSeason.id , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                                    <li><a v-on:click.prevent="openDeleteModal(cSeasonTiny.id , 1)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="cost_pagination"
                                                         v-on:click.native="fetchCostData(cost_pagination.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!--Tab 2-->
                </div>
                <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="createTinySeason">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>فصل
                                        <select class="form-element-margin-btm" v-model="selectedSeason" @change="getSeasonTitle" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="tinySeasonsInput.tsStId" name="season_title" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season_title')}">
                                            <option value=""></option>
                                            <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ planOrCost == 0 ? seasonTitle.castSubject :  seasonTitle.cstSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('season_title')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>ریز فصل
                                        <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="tinySeasonsInput.tsSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                    </label>
                                    <span v-show="errors.has('tsSubject')" class="error-font">لطفا ریزفصل انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsInput.tsDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- update modal -->
                <modal-tiny v-if="showUpdateModal" @close="showUpdateModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateTinySeason">
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>فصل
                                        <select class="form-element-margin-btm" v-model="selectedSeason" @change="getSeasonTitle" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="tinySeasonsFill.tsStId" name="season_title" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season_title')}">
                                            <option value=""></option>
                                            <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ planOrCost == 0 ? seasonTitle.castSubject :  seasonTitle.cstSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('season_title')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>ریز فصل
                                        <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="tinySeasonsFill.tsSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                    </label>
                                    <span v-show="errors.has('tsSubject')" class="error-font">لطفا ریزفصل انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsFill.tsDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- delete modal -->
                <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-on:click="deleteTinySeason" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </modal-tiny>
            </div>
        </div>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                planOrCost: 0,
                errorMessage: '',
                errorMessage_update: '',
                selectedSeason: '',
                tinySeasons: [],
                tinySeasonsCost: [],
                tinySeasonsInput: {},
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showIcon:false,
                itemInPage: 2,
                costItemInPage: 2,
                planSearchValue:'',
                costSearchValue:'',
                tinySeasonsFill: {},
                tsIdDelete: '',
                seasons: {},
                searchValue:'',
                seasonTitles: {},
                cost_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                plan_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },

        created: function () {
            this.fetchCostData();
            this.fetchCapitalAssetsData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
        },

        mounted: function () {
            console.log("mounted tiny season component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchCapitalAssetsData: function (page = 1) {
                axios.get('/budget/admin/sub_seasons/capital_assets/fetchData?page=' + page , {params:{
                    searchValue: this.planSearchValue,
                    itemInPage: this.itemInPage
                }})
                    .then((response) => {
                        this.tinySeasons = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostData: function (page = 1) {
                axios.get('/budget/admin/sub_seasons/cost/fetchData?page=' + page , {params:{
                    searchValue: this.costSearchValue,
                    itemInPage: this.costItemInPage
                }})
                    .then((response) => {
                        this.tinySeasonsCost = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            search: function (type) {
                if (type == 0)
                {
                    this.fetchCapitalAssetsData();
                }else{
                    this.fetchCostData();
                }
            },

            changeItemInPage: function (number , type) {
                if (type == 0)
                {
                    this.itemInPage = number;
                    this.fetchCapitalAssetsData();
                }else{
                    this.costItemInPage = number;
                    this.fetchCostData();
                }
            },

            removeFilter: function (type) {
                if (type == 0)
                {
                    this.planSearchValue = '';
                    this.fetchCapitalAssetsData();
                }else{
                    this.costSearchValue = '';
                    this.fetchCostData();
                }
            },

            makePagination: function(data , type){
                if (type == "cost")
                {
                    this.cost_pagination.current_page = data.current_page;
                    this.cost_pagination.to = data.to;
                    this.cost_pagination.last_page = data.last_page;
                }else if (type == "plan")
                {
                    this.plan_pagination.current_page = data.current_page;
                    this.plan_pagination.to = data.to;
                    this.plan_pagination.last_page = data.last_page;
                }
            },

            getSeasons: function () {
                axios.get('/admin/get_all_seasons')
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getSeasonTitle: function () {
                axios.get(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/getWithSeasonId' : '/budget/admin/season_title/cost/getWithSeasonId' , {params:{sId: this.selectedSeason}})
                    .then((response) => {
                        this.seasonTitles = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function (pOrC) {
                this.getSeasons();
                this.selectedSeason = '';
                this.tinySeasonsInput = [];
                this.planOrCost = pOrC;
                this.showInsertModal = true;
            },

            getSeasonCount: function (season) {
                var count = 0;
                season.forEach(seasonTitle => {
                    count += seasonTitle.capital_assets_tiny_season.length;
                });
                return count;
            },

            getSeasonCostCount: function (cSeason) {
                var cCount = 0;
                cSeason.forEach(cSeasonTitle => {
                    cCount += cSeasonTitle.cost_tiny_season.length;
                });
                return cCount;
            },


            createTinySeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/register' : '/budget/admin/sub_seasons/cost/register' , {
                            stId: this.tinySeasonsInput.tsStId ,
                            subject: this.tinySeasonsInput.tsSubject ,
                            description: this.tinySeasonsInput.tsDescription,
                            searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                            itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
                        }).then((response) => {
                                if(this.planOrCost == 1)
                                {
                                    this.tinySeasonsCost = response.data.data;
                                    this.makePagination(response.data , "cost");
                                }
                                else
                                {
                                    this.tinySeasons = response.data.data;
                                    this.makePagination(response.data , "plan");
                                }
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                this.tinySeasonsInput = [];
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }});
            },

            openUpdateModal: function (item , sId , planOrCost) {
                this.getSeasons();
                this.selectedSeason = sId;
                this.planOrCost = planOrCost;
                this.getSeasonTitle();
                if (this.planOrCost == 0)
                {
                    this.tinySeasonsFill.tsStId = item.catsCastId;
                    this.tinySeasonsFill.tsSubject = item.catsSubject;
                    this.tinySeasonsFill.tsDescription = item.catsDescription;
                    this.tinySeasonsFill.id = item.id;
                }
                else if (this.planOrCost == 1)
                {
                    this.tinySeasonsFill.tsStId = item.ctsCstId;
                    this.tinySeasonsFill.tsSubject = item.ctsSubject;
                    this.tinySeasonsFill.tsDescription = item.ctsDescription;
                    this.tinySeasonsFill.id = item.id;
                }
                this.showUpdateModal = true;
            },

            updateTinySeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/update' : '/budget/admin/sub_seasons/cost/update' , {
                            id: this.tinySeasonsFill.id,
                            stId: this.tinySeasonsFill.tsStId ,
                            subject: this.tinySeasonsFill.tsSubject ,
                            description: this.tinySeasonsFill.tsDescription,
                            searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                            itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
                        }).then((response) => {
                            if(this.planOrCost == 1)
                                {
                                    this.tinySeasonsCost = response.data.data;
                                    this.makePagination(response.data , "cost");
                                }
                            else
                                {
                                    this.tinySeasons = response.data.data;
                                    this.makePagination(response.data , "plan");
                                }
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                        }
                });
            },

            openDeleteModal: function (ts , type) {
                this.tsIdDelete = ts;
                this.planOrCost = type;
                this.showDeleteModal = true;
            },

            deleteTinySeason: function () {
                axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/delete' : '/budget/admin/sub_seasons/cost/delete' , {
                    id: this.tsIdDelete,
                    searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                    itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
                }).then((response) => {
                        if (response.status != 204) //http status code for error in delete (no content)
                        {
                            if(this.planOrCost == 1)
                                this.tinySeasonsCost = response.data.data;
                            else
                                this.tinySeasons = response.data.data;
                        }
                        this.showDeleteModal = false;
                        console.log(response);
                        this.$parent.displayNotif(response.status);
                    },(error) => {
                        console.log(error);
                });
            }
        }
    }
</script>
