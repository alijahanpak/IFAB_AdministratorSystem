<div class="tabs-panel table-mrg-btm" id="plan_title_tab">
    @if(count($creditDPs) > 0)
        <div class="medium-12 bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="CDPT_ModalInsert"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                        <i class="fi-plus size-30 secondry-color"></i>
                    </a>
                    <a  class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                        <i class="fi-clipboard-notes size-30 secondry-color"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="columns">
            <table class="stacked small-font">
                <thead class="my-thead">
                <tr>
                    <th width="150">شماره</th>
                    <th>عنوان</th>
                    <th>فصل بودجه</th>
                    <th>شرح</th>
                    <th width="50">ویرایش</th>
                    <th width="65">حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach($creditDPs as $creditDP)
                    <tr>
                        <td>{{ $creditDP->cdtIdNumber }}</td>
                        <td>{{ $creditDP->cdtSubject }}</td>
                        <td>{{ $creditDP->budgetSeason->bsSubject }}</td>
                        <td>{{ $creditDP->cdtDescription }}</td>
                        <td class="text-center"><a onclick="CDPTUpdateDialogOpen('{{ url('/admin') }}' , '{{ $creditDP->cdtBsId }}' , '{{ $creditDP->cdtIdNumber }}' , '{{ $creditDP->cdtSubject }}' , '{{ $creditDP->cdtDescription }}' , '{{ $creditDP->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                        <td class="text-center"><a data-open="CDPT_modalDelete{{ $creditDP->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                        <!--Modal Delete Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="CDPT_modalDelete{{ $creditDP->id }}" data-reveal>
                            <div class="modal-margin small-font">
                                <p>کاربر گرامی</p>
                                <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                <div class="grid-x dashboard-padding">
                                    <div class="medium-6 ">
                                        <a href="{{ url('/budget/admin/credit_distribution_def/plan_title/delete/' . $creditDP->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                        <!--Modal Delete End-->
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!--Panel nothing Insert Start-->
        <div class="column">
            <div style="height: 200px;" class="card">
                <div class="card-section text-center" style="margin-top:60px;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font"> عنوان طرح ثبت نشده است!<span><a data-open="CDPT_ModalInsert" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>