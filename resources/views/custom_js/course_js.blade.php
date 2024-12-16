<script>
    $(document).ready(function() {
    
    $('#add-user select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    $('#course-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/sdg-course/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "10%" , "orderable": false },
            { 
                "data": "photo", 
                "width": "250px", 
                "orderable": false,
                "render": function(data, type, row) {
                    return '<img src="/storage/' + data + '" width="200">'; 
                }
            },
            { "data": "title", "width": "20%" , "orderable": false },
            { "data": "project_manager", "width": "20%" , "orderable": false },
            { "data": "department", "width": "20%" , "orderable": false },
            { "data": "event_information", "width": "40%" , "orderable": false },
            {
                "data": "status",
                "width": "20%",
                "render": function (data, type, row) {
                    if (data == 0) {
                        return '<label class="badge badge-info" style="padding: 5px 18px; border-radius:15px;">Pending</label>';
                    } else if (data == 1) {
                        return '<label class="badge badge-danger" style="padding: 5px 18px; border-radius:15px;">Rejected</label>';
                    } else if (data == 2) {
                        return '<label class="badge badge-success" style="padding: 5px 18px; border-radius:15px;">Approved</label>';
                    } else {
                        return '';
                    }
                }
            },
            { "data": "sdg_approved", "width": "200" , "orderable": false },
            { "data": "date", "width": "150" , "orderable": false },
            { 
                "data": "attachment", 
                "width": "170px", 
                "orderable": false,
                "render": function(data, type, row) {
                    return '<a href="/storage/' + data + '" download>Download Attachment</a>'; 
                }
            },
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
        "sScrollX": "100%"
    });

    $('.select2').select2();

});

function showModal() {
    $("#add").modal("show");
}

function closeModal() {
    $("#add").modal("hide");
}

function add() {
    var formData = new FormData($('#add-form')[0]);
    console.log(formData);
    $('#overlay').show();
    $('#loaderContainer').show();

    var fieldLabels = {
        'title': 'Title',
        'project_manager': 'Project Manager',
        'event_information': 'Event Information',
        'file': 'Photo',
        'date_start': 'Date Start',
        'date_end': 'Date End',
    };

    $.ajax({
        url: "/sdg-course/create",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,  
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: 'SDG Course Added Successfully',
                    text: '',
                    icon: 'success',
                }).then(function () {
                    var table = $('#course-table').DataTable();
                    table.ajax.reload(null, false);
                    closeModal();
                    document.getElementById("add-form").reset();
                });
            } else {
                Swal.fire({
                    title: 'Failed',
                    text: response.error,
                    icon: 'error',
                    showConfirmButton: true,
                });
            }
        },
        error: function (xhr, status, error) {
            error_prompt(xhr, status, error, fieldLabels);
        },
        complete: function () {
            $('#overlay').hide();
            $('#loaderContainer').hide();
        }
    });
}

function error_prompt(xhr, status, error, fieldLabels) {
    var errorMessages = '';

    if (xhr.responseJSON && xhr.responseJSON.errors) {
        var errors = xhr.responseJSON.errors;

        $.each(errors, function (field, messages) {
            var label = fieldLabels[field] || field;
            $.each(messages, function (index, message) {
                var cleanMessage = message.replace(/(\d+)?\s*field\.?/i, '');
                errorMessages += label + ": " + cleanMessage.trim() + "<br>";
            });
        });
    } else if (xhr.responseJSON && xhr.responseJSON.error) {
        errorMessages = xhr.responseJSON.error;
    } else {
        errorMessages = 'An unexpected error occurred.';
    }

    Swal.fire({
        title: 'Fix Error First',
        html: errorMessages.trim(),
        icon: 'error',
        showConfirmButton: true,
    });
}
</script>