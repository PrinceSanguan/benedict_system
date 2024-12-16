<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container-fluid px-5">
    <a href="/dashboard" class="navbar-brand"><img src="{{ asset('assets/images/logo.png') }}" width="40px" alt="Logo" class="me-2">
      <span class="brand-text font-weight-bold">SDG</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3 ml-4" id="navbarCollapse">
      <ul class="navbar-nav">
        @if(Auth::user()->role_id == 1)
        <li class="nav-item">
          <a href="/users" class="nav-link"><i class="fa fa-users"></i> Users</a>
        </li>
        <li class="nav-item">
          <a href="/announcement" class="nav-link"><i class="fa fa-bullhorn"></i> Announcement</a>
        </li>
        @endif
        @if(Auth::user()->role_id == 4)
        <li class="nav-item">
          <a href="/sdg-projects" class="nav-link"><i class="fas fa-city"></i> SDG Projects</a>
        </li>
        <li class="nav-item">
          <a href="/sdg-courses" class="nav-link"><i class="fas fa-lightbulb"></i> SDG Courses</a>
        </li>
        <li class="nav-item">
          <a href="/feedback" class="nav-link"><i class="fas fa-comment"></i> Feedback</a>
        </li>
        @endif
        @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 6)
        <li class="nav-item">
          <a href="/carbon-footprint" class="nav-link"><i class="fas fa-leaf"></i> Carbon Footprint</a>
        </li>
        <li class="nav-item">
          <a href="/feedback" class="nav-link"><i class="fas fa-comment"></i> Feedback</a>
        </li>
        @endif
        @if(Auth::user()->role_id == 3)
        <li class="nav-item">
          <a href="/carbon-footprint-all" class="nav-link"><i class="fas fa-leaf"></i> Carbon Footprint Data</a>
        </li>
        <li class="nav-item">
          <a href="/sec-sdg-projects" class="nav-link"><i class="fas fa-city"></i> SDG Projects</a>
        </li>
        <li class="nav-item">
          <a href="/sec-sdg-courses" class="nav-link"><i class="fas fa-lightbulb"></i> SDG Courses</a>
        </li>
        <li class="nav-item">
          <a href="/events" class="nav-link"><i class="fa fa-calendar-check"></i> Events</a>
        </li>
        <li class="nav-item">
          <a href="/announcement" class="nav-link"><i class="fa fa-bullhorn"></i> Announcement</a>
        </li>
        @endif
        @if(Auth::user()->role_id == 2)
        <li class="nav-item">
          <a href="/users" class="nav-link"><i class="fa fa-users"></i> Users</a>
        </li>
        <li class="nav-item">
          <a href="/sdg" class="nav-link"><i class="fas fa-hands-helping"></i> SDG</a>
        </li>
        <li class="nav-item">
          <a href="/carbon" class="nav-link"><i class="fas fa-leaf"></i> Carbon</a>
        </li>
        <li class="nav-item">
          <a href="/feedback" class="nav-link"><i class="fas fa-comment"></i> Feedback</a>
        </li>
        <li class="nav-item">
          <a href="/reports" class="nav-link"><i class="fa fa-file-alt"></i> Reports</a>
        </li>
        @endif
        
      </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="dropdown user user-menu">
        <div class="dropdown">
          <button class="btn  dropdown-toggle text-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{auth()->user()->firstname . " " . auth()->user()->lastname}}
          </button>
          <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="/logout">Logout</a>
            <a class="dropdown-item" onclick="showChangePassword()">Change Password</a>
          </div>
        </div>
      </li>
  </ul>
  </div>
</nav>

<div class="modal fade" id="changePassword" tabindex="-1" role="dialog"  aria-hidden="true" >
  <div class="modal-dialog modal-default" role="document">
      <form class="modal-content" method="POST" enctype="multipart/form-data" id="change-form">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel-2">Change Password</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeChangePassword()">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="name">Current Password<span class="text-danger h4">*</span></label>
                          <input type="password" class="form-control form-control-sm "  placeholder="Type your current password here" name="current_password" id="current_password">
                      </div>
                      <div class="form-group">
                          <label for="name">New Password<span class="text-danger h4">*</span></label>
                          <input type="password" class="form-control form-control-sm "  placeholder="Type your current password here" name="new_password" id="new_password">
                      </div>
                      <div class="form-group">
                          <label for="name">Confirm Password<span class="text-danger h4">*</span></label>
                          <input type="password" class="form-control form-control-sm "  placeholder="Type your current password here" name="confirm_password" id="confirm_password">
                      </div>
                  </div>
              </div>
          </div>

          <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="changePassword()">Submit</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeChangePassword()">Cancel</button>
          </div>
      </form>
  </div>
</div>

<script>
  function showChangePassword() {
    $('#changePassword').modal('show');
  }
  
  function closeChangePassword() {
    $('#changePassword').modal('hide');
  }
  
  function changePassword() {
    if ($('#new_password').val() === '' || $('#confirm_password').val() === '' || $('#current_password').val() === '') {
        Swal.fire({
            title: 'Error',
            text: 'Password Field cannot be empty',
            icon: 'error',
            showConfirmButton: true,
        });
        return;
    }
  
    if ($('#confirm_password').val() !== $('#new_password').val()) {
        Swal.fire({
            title: 'Error',
            text: 'Password and Confirm Password do not match',
            icon: 'error',
            showConfirmButton: true,
        });
        return;
    }
    isSubmittingLogin = true;
  
    $('#overlay').show();
    $('#loaderContainer').show();
  
    var formData = {
        current_password: $('#current_password').val(),
        new_password: $('#new_password').val(),
        confirm_password: $('#confirm_password').val(),
        user_id: $('#user_id').val(),
    };
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
        type: 'POST',
        data: formData,
        url: "/change_password",
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            if (response.errors) {
                Swal.fire({
                    title: 'Failed',
                    text: response.errors,
                    icon: 'error',
                    showConfirmButton: true,
                });
            } else if (response.error && response.error.password) {
                var errorMessage = 'Please correct the following errors:\n';
                $.each(response.error.password, function(index, message) {
                        errorMessage += '- ' + message + '\n';
                });
                Swal.fire({
                    title: 'Failed',
                    text: errorMessage,
                    icon: 'error',
                    showConfirmButton: true,
                });
            } else {
                Swal.fire({
                    title: 'Password Changed Successfully',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                });
                $('#changePassword').modal('hide');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
        complete: function () {
            isSubmittingLogin = false;
            $('#overlay').hide();
            $('#loaderContainer').hide();
            $('#current_password').val('');
            $('#new_password').val('');
            $('#confirm_password').val('');
  
        }
    });
  }
  </script>