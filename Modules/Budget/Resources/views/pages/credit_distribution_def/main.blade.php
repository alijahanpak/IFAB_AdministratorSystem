@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
        <div class="medium-10 border-right-line inner-body-pad">
            <div class="grid-x padding-lr">
                <div class="medium-12">
                    <div class="grid-x border-btm-line">
                        <nav aria-label="You are here:" role="navigation">
                            <ul class="breadcrumbs">
                                <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                                <li>
                                    <span class="show-for-sr">Current: </span>مدیریت
                                </li>
                                <li>
                                    <span class="show-for-sr">Current: </span>تعاریف توزیع اعتبار
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @include('budget::pages.credit_distribution_def.forms')
            <div class="grid-x dashboard-padding">
                <div class="medium-12 column">
                    <ul class="tabs tab-color" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="example-tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500">
                        <li class="tabs-title is-active"><a href="#row_tab" aria-selected="true">ردیف توزیع اعتبار</a></li>
                        <li class="tabs-title"><a href="#budget_season_tab">فصول بودجه</a></li>
                        <li class="tabs-title"><a href="#plan_title_tab">عنوان طرح</a></li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="example-tabs">
                        <!--Tab 1 Start-->
                        @include('budget::pages.credit_distribution_def.rows')
                        <!--Tab 1 End-->
                        <!--Tab 2 Start-->
                        @include('budget::pages.credit_distribution_def.budget_seasons')
                        <!--Tab 2 End-->
                        <!--Tab 3 Start-->
                        @include('budget::pages.credit_distribution_def.plan_title')
                        <!--Tab 3 End-->

                    </div>
                </div>
            </div>
        </div>
        <script>
            $('[data-loading-start]').click(function() {
                $(this).addClass('hide')
                $('[data-loading-end]').removeClass('hide')
            });
        </script>
@stop

