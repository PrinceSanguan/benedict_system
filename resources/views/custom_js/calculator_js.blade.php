<script>


function calculate() {
    var formData = $('#calculate-form').serializeArray();
    $('#overlay').show();
    $('#loaderContainer').show();

    $.ajax
    ({
        url: "/openai/calculate",
        type: 'GET',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        { 
            $('#solutions').html(response);
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

function submitReport() {

    var formData = new FormData($('#calculate-form')[0]);
    // var calculateForm = $('#calculate-form').serializeArray();
    $('#overlay').show();
    $('#loaderContainer').show();

    var fieldLabels = {
        'report_title': 'Report Title',
    };

    $.ajax({
        url: "/carbon-create-report",
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
                    title: 'Carbon Footprint Report Created Successfully',
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
</script>