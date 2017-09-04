@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x">
            <div class="medium-12 bottom-mrg">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="{{ url('/budget') }}">داشبورد</a></li>
                            <li><a class="disabled" href="#">مدیریت</a></li>
                            <li>
                                <span class="show-for-sr">Current: </span>سال مالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x">
            <div id="dynamicParentId1" class="medium-12 column my-callout dynamic-height-level1">
                <!--Tab 1 Start-->
                <div class="tabs-panel is-active table-mrg-btm">
                    <div class="columns">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-2 table-border">
                                <strong>سال مالی</strong>
                            </div>
                            <div class="medium-4 table-border">
                                <strong>شرح</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>وضعیت</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>مجوزها</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>فعالسازی</strong>
                            </div>
                        </div>
                        <!--Header End-->
                        <div id="dynamicParentId2" class="table-contain dynamic-height-level2">
                            <?php $rowColor = 0; ?>
                            @foreach(\Modules\Admin\Entities\FiscalYear::all() as $fiscalYear)
                                <div class="grid-x {{ $rowColor % 2 == 1 ? 'tableRowColor' : '' }} selectAbleRow">
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ $fiscalYear->fyLabel }}</div>
                                    <div class="medium-4 table-contain-border cell-vertical-center">{{ $fiscalYear->fyDescription }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center">{{ \Modules\Admin\Entities\FiscalYear::getFYStatus($fiscalYear->fyStatus) }}</div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                        @if($fiscalYear->fyStatus != 0)
                                            <a href="#" data-open="modalPermission{{ $fiscalYear->fyLabel }}"><i class="fi-clipboard-pencil size-21 blue-color"></i> </a>
                                            <!--Modal Permission Start-->
                                            <div style="z-index: 9999;" class="large reveal" id="modalPermission{{ $fiscalYear->fyLabel }}" data-reveal data-animation-in="someAnimationIn">
                                                <div class="modal-margin small-font">
                                                    <div class="grid-x">
                                                        <div class="medium-12 column">
                                                            <ul class="accordion" data-accordion>
                                                                <li class="accordion-item is-active" data-accordion-item>
                                                                    <a href="#" class="accordion-title">بودجه</a>
                                                                    <div class="accordion-content" data-tab-content >
                                                                        <?php
                                                                        $fyBPermissions = \Modules\Budget\Entities\FyPermissionInBudget::where('pbFyId' , '=' , $fiscalYear->id)->get();
                                                                        $fyPbActiveCount = \Modules\Budget\Entities\FyPermissionInBudget::where('pbFyId' , '=' , $fiscalYear->id)->where('pbStatus' , '=' , true)->count();
                                                                        ?>
                                                                        <div style="margin-bottom: 20px;" class="grid-x column">
                                                                            <div class="medium-12">
                                                                                <div class="grid-x padding-lr">
                                                                                    <div class="medium-1">
                                                                                        <div class="switch tiny">
                                                                                            <input class="switch-input" id="budgetPermissionAll" onchange="changeFySectionPermissionState('{{ url('/budget/admin/fiscal_year') }}' , 'budget' , this.id , '{{ $fiscalYear->id }}' , '{{ count($fyBPermissions) }}')" type="checkbox" {{ count($fyBPermissions) == $fyPbActiveCount ? 'checked' : ''}} autocomplete="off">
                                                                                            <label class="switch-paddle" for="budgetPermissionAll">
                                                                                                <span class="switch-active" aria-hidden="true">بلی</span>
                                                                                                <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="medium-11">
                                                                                        <p>همه موارد</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @for($i = 0 ; $i < count($fyBPermissions) ; $i++)
                                                                            <div class="grid-x column">
                                                                                <div class="medium-6">
                                                                                    <div class="grid-x padding-lr">
                                                                                        <div class="medium-2">
                                                                                            <div class="switch tiny">
                                                                                                <input class="switch-input" onchange="changeBudgetItemPermissionState('{{ url('/budget/admin/fiscal_year') }}' , '{{ $fyBPermissions[$i]->id }}' , this.id , '{{ $fyBPermissions[$i]->pbFyId }}')" {{ $fyBPermissions[$i]->pbStatus == true ? 'checked' : '' }} id="budgetPermission{{ $i }}" type="checkbox" autocomplete="off">
                                                                                                <label class="switch-paddle" for="budgetPermission{{ $i }}">
                                                                                                    <span class="switch-active" aria-hidden="true">بلی</span>
                                                                                                    <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="medium-10">
                                                                                            <p>{{ $fyBPermissions[$i++]->pbLabel }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="medium-6">
                                                                                    @if($i < count($fyBPermissions) - 1)
                                                                                        <div class="grid-x padding-lr">
                                                                                            <div class="medium-2">
                                                                                                <div class="switch tiny">
                                                                                                    <input class="switch-input" onchange="changeBudgetItemPermissionState('{{ url('/budget/admin/fiscal_year') }}' , '{{ $fyBPermissions[$i]->id }}' , this.id , '{{ $fyBPermissions[$i]->pbFyId }}')" {{ $fyBPermissions[$i]->pbStatus == true ? 'checked' : '' }} id="budgetPermission{{ $i }}" type="checkbox" autocomplete="off">
                                                                                                    <label class="switch-paddle" for="budgetPermission{{ $i }}">
                                                                                                        <span class="switch-active" aria-hidden="true">بلی</span>
                                                                                                        <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="medium-10">
                                                                                                <p>{{ $fyBPermissions[$i]->pbLabel }}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endfor
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="close-button" data-close aria-label="Close modal" type="button">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!--Modal Permission End-->
                                        @endif
                                    </div>
                                    <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                        @if($fiscalYear->fyStatus == 0)
                                            <a href="#" data-open="modalFYActivate{{ $fiscalYear->id }}"><i class="fi-checkbox size-21 edit-pencil"></i> </a>
                                            <!--modalFYActivate Start-->
                                            <div style="z-index: 9999;" class="tiny reveal" id="modalFYActivate{{ $fiscalYear->id }}" data-reveal data-animation-in="someAnimationIn">
                                                <div class="modal-margin small-font">
                                                    <p>کاربر گرامی</p>
                                                    <p class="large-offset-1 modal-text">آیا مایل به فعال سازی سال مالی <span>{{ $fiscalYear->fyLabel }}</span>هستید؟</p>
                                                    <div class="grid-x dashboard-padding">
                                                        <div class="medium-6 ">
                                                            {!! Form::open(array('id' => 'fyActivationForm' , 'url' => '/budget/admin/fiscal_year/activation' , 'class' => 'form')) !!}
                                                            <input type="hidden" name="fyId" value="{{ $fiscalYear->id }}">
                                                            <button type="submit" class="button primary btn-large-w large-offset-3">بله</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                        <div class="medium-6">
                                                            <a data-close aria-label="Close modal" class="button primary hollow btn-large-w large-offset-4">خیر</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="close-button" data-close aria-label="Close modal" type="button">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <?php $rowColor++; ?>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--Tab 1 End-->
            </div>
        </div>
    </div>
    <!--Inner body End-->
@stop
