<div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true" >
    <div class="modal-dialog modal-default" role="document">
        <form class="modal-content" method="POST" enctype="multipart/form-data" id="add-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Announcement</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Subject <span class="text-danger h4">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="name">Details <span class="text-danger h4">*</span></label>
                            <textarea class="form-control form-control-sm "  rows="6" name="details"></textarea>
                        </div>
                        <div class="form-group  col-lg-12">
                            <label class="col-sm-12 col-form-label">Status <span class="text-danger h4">*</span></label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="status"  value="0" >Normal <i class="input-helper"></i></label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="status" value="1"  > Important <i class="input-helper"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add()">Submit</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

