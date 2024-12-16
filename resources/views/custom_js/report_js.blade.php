<script>
    $(document).ready(function() {
    
    $('#add-user select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    $('#sdg-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/sdg-report/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "10%" , "orderable": false },
            { "data": "created_at", "width": "40%" , "orderable": false },
            { "data": "currentMonthName", "width": "40%" , "orderable": false },
            { 
                "data": "attachment", 
                "width": "170px",
                "orderable": false ,
                "render": function (data, type, row) {
                    return  '<a class="btn btn-outline-primary btn-sm  pr-2 pl-2 rounded-3" href="/sdg-report-view/'+row.id+'" target="_blank"><i class="fa fa-download"> Download</i></a>' 
                }
            }
        ],
        "createdRow": function(row, data, dataIndex) {
            var statusCell = $(row).find('td[data-status]');
            var status = statusCell.data('status');
            if (status === 'deactivate') {
                statusCell.addClass('deactivate-class');
            } else if (status === 'active') {
                statusCell.addClass('active-class');
            } else if (status === 'inactive') {
                statusCell.addClass('inactive-class');
            }
        },
        "paging": true,
        "searching": true,
        "info": true,
        "lengthMenu": [10, 25, 50, 75, 100],
        "pageLength": 10,
        "autoWidth": true,
        "sScrollX": "100%",
        "order": [[0, 'desc']]
    });

    $('#carbon-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/carbon-report/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "10%" , "orderable": false },
            { "data": "created_at", "width": "40%" , "orderable": false },
            { "data": "report_title", "width": "30%" , "orderable": false },
            {
                "data": "supportng_document",
                "width": "170px",
                "orderable": false,
                "render": function (data, type, row) {
                    if (data === null || data === "") {
                        return 'No Supporting Document';
                    } else {
                        return '<a class="btn btn-outline-success btn-sm pr-2 pl-2 rounded-3" href="/storage/' + data + '"><i class="fa fa-download"> Download</i></a>';
                    }
                }
            },
            {  
                "width": "170px",
                "orderable": false ,
                "render": function (data, type, row) {
                    return  '<a class="btn btn-outline-success btn-sm  pr-2 pl-2 rounded-3" target="_blank" href="/carbon-report-view/'+row.id+'"><i class="fa fa-download"> Download</i></a>' 
                }
            }
        ],
        "createdRow": function(row, data, dataIndex) {
            var statusCell = $(row).find('td[data-status]');
            var status = statusCell.data('status');
            if (status === 'deactivate') {
                statusCell.addClass('deactivate-class');
            } else if (status === 'active') {
                statusCell.addClass('active-class');
            } else if (status === 'inactive') {
                statusCell.addClass('inactive-class');
            }
        },
        "paging": true,
        "searching": true,
        "info": true,
        "lengthMenu": [10, 25, 50, 75, 100],
        "pageLength": 10,
        "autoWidth": true,
        "sScrollX": "100%",
        "order": [[0, 'desc']]
    });
    $('.select2').select2();
});






</script>
