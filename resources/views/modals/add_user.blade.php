<div class="modal fade" id="add-user" tabindex="-1" role="dialog"  aria-hidden="true" >
    <div class="modal-dialog modal-default" role="document">
        <form class="modal-content" method="POST" enctype="multipart/form-data" id="add-form">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeUserModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">First Name <span class="text-danger h4">*</span></label>
                            <input type="text" class="form-control form-control-sm "  placeholder="Juan" name="firstname">
                        </div>
                        <div class="form-group">
                            <label for="name">Last Name <span class="text-danger h4">*</span></label>
                            <input type="text" class="form-control form-control-sm "  placeholder="Dela Cruz" name="lastname">
                        </div>
                        <div class="form-group">
                            <label for="name">Email <span class="text-danger h4">*</span></label>
                            <input type="text" class="form-control form-control-sm "  placeholder="Email Address" name="email">
                        </div>
                        <div class="form-group">
                            <label>Role <span class="text-danger h4">*</span></label>
                            <select class="form-control form-control-sm p-3 select2" style="width:100%" name="role_id" id="role_id">
                                <option value=""> Select Role </option>
                                <option value="1"> Admin</option>
                                <option value="2"> SDO Head</option>
                                <option value="3"> SDO Sec</option>
                                <option value="4"> SDO Coordinator</option>
                                <option value="5"> EMU</option>
                                <option value="6"> GSO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addUser()">Submit</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeUserModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

