<div class="box-filter">


    <div class="filter-item">
        <div class="form-group">
            <label>Hình</label>
            <select data-gtm-event="mbn-event-link" data-gtm-category="mbn-listing" data-gtm-action="listing-filter-image"
                    class="hidden" data-bind="chosen: { source: Images, selectedValue: ImageValue, displayProp: 'Name', valueProp: 'Value', chosenOption: { disable_search: true } }"></select>
        </div>
    </div>



    <div class="filter-item">
        <div class="form-group">
            <label>Thời gian đăng</label>
            <select data-gtm-event="mbn-event-link" data-gtm-category="mbn-listing" data-gtm-action="listing-filter-date"
                    class="hidden" data-bind="chosen: { source: Times, selectedValue: TimeValue, displayProp: 'Name', valueProp: 'Value', chosenOption: { disable_search: true } }"></select>
        </div>
    </div>


    <a class="clear-filter" data-gtm-event="mbn-event-link" data-gtm-category="mbn-listing" data-gtm-action="listing-remove-filter"
       href="javascript:void(0)" data-bind="click: ClearFilter" title="Xóa bộ lọc tìm kiếm"><i class="icon icon-delete30"></i></a>
    <div class="clearfix"></div>
</div>