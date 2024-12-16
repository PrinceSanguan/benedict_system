<script>
    $(document).ready(function() {
    
    $('#add select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    $('#event-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/event/data",
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
            { "data": "information", "width": "40%" , "orderable": false },
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
        'information': 'Event Information',
        'file': 'Photo',
        'date': 'Date',
    };

    $.ajax({
        url: "/event/create",
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
                    title: 'Event Added Successfully',
                    text: '',
                    icon: 'success',
                }).then(function () {
                    var table = $('#event-table').DataTable();
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