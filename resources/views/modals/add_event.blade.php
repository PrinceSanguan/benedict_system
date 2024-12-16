<div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true" >
    <div class="modal-dialog modal-default" role="document">
        <form class="modal-content" method="POST" enctype="multipart/form-data" id="add-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Event</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Title <span class="text-danger h4">*</span></label>
                            <input class="form-control form-control-sm" name="title"  type="text"> 
                        </div>
                        <div class="form-group">
                            <label for="name">Photo <span class="text-danger h4">*</span></label>
                            <input type="file" class="form-control form-control-sm " name="file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="name">Attachment </label>
                            <input type="file" class="form-control form-control-sm " name="file2" accept=".doc,.docx,.pdf,.txt,.xls,.xlsx,.ppt,.pptx">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="name">Date <span class="text-danger h4">*</span></label>
                            <input class="form-control form-control-sm" name="date" type="date"> 
                        </div>
                        <div class="form-group">
                            <label for="name">Information <span class="text-danger h4">*</span></label>
                            <textarea class="form-control form-control-sm "  rows="6" name="information"></textarea>
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

