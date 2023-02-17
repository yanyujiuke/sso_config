
<div class="dcat-box custom-data-table dt-bootstrap4">

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

        <div class="filter-box shadow-0 card mb-0">
            <div class="mailbox-attachments {{ $grid->formatTableClass() }} p-0" style="display: flex;
                flex-wrap: wrap;
                flex-direction: row;
                justify-content: flex-start;" id="{{ $tableId }}">
                @foreach($grid->rows() as $row)
                    <div style="padding:10px">
                        <div>{!! $row->column('name') !!}</div>
                        <a href="{!! $row->column('url') !!}" target="_blank"><img src="{!! $row->column('icon') !!}" height="100px" width="100px"></a>
                    </div>
                @endforeach
            </div>
        </div>

    {!! $grid->renderFooter() !!}
</div>
<script>
    $(function () {
        console.log("ssssssssssss");
    })
</script>
