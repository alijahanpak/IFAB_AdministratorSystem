<div class="tabs-panel table-mrg-btm" id="county">
    @if(\Modules\Budget\Entities\DeprivedArea::isExistCounty() == true)
        <div class="medium-12 bottom-mrg">
            <div class="clearfix border-btm-line ">
                <div class="button-group float-left report-mrg">
                    <a  class="clear button"  data-open="modalInsertDeprivedArea"  type="button" data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
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
                    <th>نام</th>
                    <th width="650">شرح</th>
                    <th width="50">ویرایش</th>
                    <th width="65">حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dAreas as $dArea)
                    @if($dArea->daCoId != '' && $dArea->daReId == '' && $dArea->daRdId == '' && $dArea->daViId == '')
                        <tr>
                            <td>{{ \Modules\Admin\Entities\County::find($dArea->daCoId)->coName }}</td>
                            <td>{{ $dArea->daDescription }}</td>
                            <td class="text-center"><a data-open="preloaderModal" onclick="DAUpdateDialogOpen('{{ url('/admin') }}' , '{{ $dArea->daCoId }}' , '{{ $dArea->daReId }}' , '{{ $dArea->daRdId }}' , '{{ $dArea->daViId }}' , '{{ $dArea->daDescription }}' , '{{ $dArea->id }}')"><i class="fi-pencil size-21 edit-pencil"></i></a></td>
                            <td class="text-center"><a data-open="modalDelete{{ $dArea->id }}"><i class="fi-trash size-21 trash-t"></i> </a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @else
    <!--Panel nothing Insert Start-->
        <div class="column">
            <div style="height: 200px;" class="card">
                <div class="card-section text-center" style="margin-top:60px;">
                    <span>کاربر گرامی، </span><span class="login-txt small-font">شهرستان محروم ثبت نشده است!<span><a data-open="modalInsertDeprivedArea" class="custom-btn-pos my-secondary button tiny">ثبت</a></span></span>
                </div>
            </div>
        </div>
        <!--Panel nothing Insert End-->
    @endif
</div>