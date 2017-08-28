@extends('budget::layouts.master')
@section('content')
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="#">داشبورد</a></li>
                            <li><span class="show-for-sr">Current: </span>مدیریت</li>
                            <li>
                                <span class="show-for-sr">Current: </span>سال مالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="grid-x">
            <div class="medium-12 column">
                <!--Tab 1 Start-->
                <div class="tabs-panel is-active table-mrg-btm" id="panel1">
                    <div class="columns">
                        <table class="stacked small-font">
                            <thead class="my-thead">
                            <tr>
                                <th>سال مالی</th>
                                <th>شرح</th>
                                <th>وضعیت</th>
                                <th width="100">مجوزها</th>
                                <th width="100">فعال سازی</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\Modules\Admin\Entities\FiscalYear::all() as $fiscalYear)
                                <tr>
                                    <td>{{ $fiscalYear->fyLabel }}</td>
                                    <td>{{ $fiscalYear->fyDescription }}</td>
                                    <td>{{ \Modules\Admin\Entities\FiscalYear::getFYStatus($fiscalYear->fyStatus) }}</td>
                                    <td class="text-center">
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
                                    </td>
                                    <td class="text-center">
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
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Tab 1 End-->
            </div>
        </div>
    </div>
    <!--Inner body End-->
@stop
