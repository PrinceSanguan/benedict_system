<script>
$(document).ready(function() {
    
    $('#add-user select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    $('#user-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/user/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "20%" , "orderable": false },
            { "data": "name", "width": "40%", "orderable": false  },
            { "data": "email", "width": "40%" , "orderable": false },
            {
                "data": "role_id",
                "width": "40%",
                "render": function (data, type, row) {
                    if (data == 1) {
                        return 'Admin';
                    } else if (data == 2) {
                        return 'SDC Head';
                    } else if (data == 3) {
                        return 'SDC Sec';
                    } else if (data == 4) {
                        return 'SDC Coordinator';
                    } else if (data == 5) {
                        return 'EMU';
                    } else if (data == 6) {
                        return 'GSO';
                    } else {
                        return 'N/A';
                    }
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
        "sScrollX": "100%"
    });

    $('.select2').select2();

});

function showUserModal() {
    $("#add-user").modal("show");
}

function closeUserModal() {
    $("#add-user").modal("hide");
}

function addUser() {
    event.preventDefault(); 

    var fieldLabels = {
        'firstname': 'First Name',
        'lastname': 'Last Name',
        'email': 'Email',
        'role_id': 'Role',
    };

    var formData = new FormData($('#add-form')[0]);
    console.log(formData);
    $('#overlay').show();
    $('#loaderContainer').show();
    $.ajax({
        url: "/user/create",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,  
        contentType: false,
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: 'Added Successfully',
                    text: '',
                    icon: 'success',
                }).then(function () {
                    var table = $('#user-table').DataTable();
                    table.ajax.reload(null, false);
                    closeUserModal();
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
        title: 'Validation Errors',
        html: errorMessages.trim(),
        icon: 'error',
        showConfirmButton: true,
    });
}
</script>