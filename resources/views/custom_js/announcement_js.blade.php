<script>
    $(document).ready(function() {
        
        $('#add-user select:not(.normal)').each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });
    
        $('#announcement-table').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "/announcement/data",
                "type": "GET",
            },
            "columns": [
                { "data": "id", "width": "10%" , "orderable": false },
                { "data": "subject", "width": "20%" , "orderable": false },
                { "data": "details", "width": "50%" , "orderable": false },
                {
                    "data": "status",
                    "width": "120",
                    "orderable": false,
                    "render": function (data, type, row) {
                        if (data == 0) {
                            return '<span class="px-3 p-1 bg-primary rounded">Normal</span>';
                        } else if (data == 1) {
                            return '<span class="px-3 p-1 bg-danger rounded">Important</span>';
                        } else {
                            return '<span class="px-3 p-1 bg-default rounded">N/A</span>';
                        }
                    }
                },
                { "data": "created_at", "width": "150" , "orderable": false },
               
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
    
    function showModal(){
        $('#add').modal('show');
    }
    
    function closeModal() {
        $("#add").modal("hide");
    }
    
    function add() {
        var formData = $('#add-form').serializeArray();
        console.log(formData);
        $('#overlay').show();
        $('#loaderContainer').show();
    
        var fieldLabels = {
            'subject': 'Subject',
            'details': 'Announcement Details',
            'status': 'Announcement Status',
        };
    
        $.ajax({
            url: "/announcement/create",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Announcement Added Successfully',
                        text: '',
                        icon: 'success',
                    }).then(function () {
                        var table = $('#announcement-table').DataTable();
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