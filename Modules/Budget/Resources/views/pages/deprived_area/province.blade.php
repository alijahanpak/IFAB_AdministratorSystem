<div class="tabs-panel is-active table-mrg-btm" id="panel1">
    @if(count($dAreas) > 0)
        <div class="columns">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button" type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                        <i class="fi-clipboard-notes size-30 secondry-color"></i>
                    </a>
                </div>
            </div>
        </div>
        </BR>
        <div class="columns">
            <table class="stacked small-font">
                <thead class="my-thead">
                <tr>
                    <th>شهرستان</th>
                    <th>بخش</th>
                    <th>دهستان</th>
                    <th>روستا</th>
                    <th width="350">شرح</th>
                    <th width="50">ویرایش</th>
                    <th width="65">حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dAreas as $dArea)
                    <tr>
                        <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                        <td>{{ $dArea->daReId == '' ? '--' : \Modules\Admin\Entities\Region::find($dArea->daReId)->reName }}</td>
                        <td>{{ $dArea->daRdId == '' ? '--' : \Modules\Admin\Entities\RuralDistrict::find($dArea->daRdId)->rdName }}</td>
                        <td>{{ $dArea->daViId == '' ? '--' : \Modules\Admin\Entities\Village::find($dArea->daViId)->viName }}</td>
                        <td>{{ $dArea->daDescription }}</td>
                        <td class="text-center"><a data-open="preloaderModal" onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                        <td class="text-center"><a href="#" data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                        <!--Modal Delete Start-->
                        <div style="z-index: 9999;" class="tiny reveal" id="modalDelete{{ $dArea->id }}" data-reveal>
                            <div class="modal-margin small-font">
                                <p>کاربر گرامی</p>
                                <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                                <div class="grid-x dashboard-padding">
                                    <div class="medium-6 ">
                                        <a href="{{ url('/budget/admin/deprived_area/delete/' . $dArea->id) }}" class="button primary btn-large-w large-offset-3">بله</a>
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
                    <span>کاربر گرامی، </span><span class="login-txt small-font">منطقه محروم ثبت نشده است!<span><a data-open="modalInsertDeprivedArea" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>