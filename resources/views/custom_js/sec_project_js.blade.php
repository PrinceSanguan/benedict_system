<script>
    $(document).ready(function() {
    
    $('#add-user select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    $('#request-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/sec-sdg-project/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "10%" , "orderable": false },
            { "data": "title", "width": "40%" , "orderable": false },
            { "data": "project_manager", "width": "40%" , "orderable": false },
            {
                "data": null,
                "width": "150px",
                "orderable": false ,
                "render": function (data, type, row) {
                    return '<div class="d-flex justify-content-around">'
                    +'<button class="btn btn-outline-primary  pr-2 pl-2 rounded-3" onclick="viewModal('+ row.id +')"><i class="fa fa-eye" ></i> View</button>' ;
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

    $('#processed-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/sec-sdg-project-processed/data",
            "type": "GET",
        },
        "columns": [
            { "data": "id", "width": "10%" , "orderable": false },
            { "data": "title", "width": "40%" , "orderable": false },
            { "data": "project_manager", "width": "30%" , "orderable": false },
            {
                    "data": "status",
                    "width": "20%",
                    "render": function (data, type, row) {
                        if (data == 1) {
                            return '<label class="badge badge-danger" style="padding: 5px 18px; border-radius:15px;">Rejected</label>';
                        } else if (data == 2) {
                            return '<label class="badge badge-success" style="padding: 5px 18px; border-radius:15px;">Approved</label>';
                        } else {
                            return '';
                        }
                    }
                },
            {
                "data": null,
                "width": "150px",
                "orderable": false ,
                "render": function (data, type, row) {
                    return '<div class="d-flex justify-content-around">'
                    +'<button class="btn btn-outline-primary  pr-2 pl-2 rounded-3" onclick="viewModal2('+ row.id +')"><i class="fa fa-eye" ></i> View</button>' ;
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



function closeModal() {
    $("#view").modal("hide");
}

function viewModal(row_id) {
    $.ajax
    ({
    type:"GET",
    url:"/sec-sdg-project-view/" + row_id,
    success:function(response)
        { 
            $('#view').modal('show');
            $('#viewForm').html(response);
        }
    });
}

function closeModal2() {
    $("#view-processed").modal("hide");
}

function viewModal2(row_id) {
    $.ajax
    ({
    type:"GET",
    url:"/sec-sdg-project-view-processed/" + row_id,
    success:function(response)
        { 
            $('#view-processed').modal('show');
            $('#viewForm2').html(response);
        }
    });
}

function approve() {
    var id = $('#id').val();
    var approved_sdg = $('#approved_sdg').val();

    if (approved_sdg === "") {
        Swal.fire({
            title: 'Failed',
            text: "Please Select Your Approved SDG",
            icon: 'error',
            showConfirmButton: true,
        });
        return;
    } 
    
    Swal.fire({
        title: "Are you sure you want to approve this project? ",
        text: '',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#overlay').show();
            $('#loaderContainer').show();

            $.ajax({
                type: "PUT", 
                url: "/sec-sdg-project-approve/"+id +"/"+approved_sdg, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Successful!',
                        text: 'Project Approved Successfully',
                        icon: 'success',
                        showConfirmButton: true,
                    }).then(() => {
                        var table = $('#request-table').DataTable();
                        table.ajax.reload(null, false);
                        var table2 = $('#processed-table').DataTable();
                        table2.ajax.reload(null, false);
                        $("#view").modal("hide");
                    });
                },
                error: function (xhr) {
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.message) {
                        errorMessage = xhr.responseJSON.errors.message;
                    }
                    Swal.fire({
                        title: 'Failed',
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true,
                    });
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $('#overlay').hide();
                    $('#loaderContainer').hide();
                }
            });
        }
    });
    
}

function reject() {
    var id = $('#id').val();
    Swal.fire({
        title: "Are you sure you want to reject this project? ",
        text: '',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#overlay').show();
            $('#loaderContainer').show();

            $.ajax({
                type: "PUT", 
                url: "/sec-sdg-project-reject/"+id , 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Successful!',
                        text: 'Project has been rejected',
                        icon: 'success',
                        showConfirmButton: true,
                    }).then(() => {
                        var table = $('#request-table').DataTable();
                        table.ajax.reload(null, false);
                        var table2 = $('#processed-table').DataTable();
                        table2.ajax.reload(null, false);
                        $("#view").modal("hide");
                    });
                },
                error: function (xhr) {
                    let errorMessage = 'An unexpected error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.message) {
                        errorMessage = xhr.responseJSON.errors.message;
                    }
                    Swal.fire({
                        title: 'Failed',
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true,
                    });
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $('#overlay').hide();
                    $('#loaderContainer').hide();
                }
            });
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
