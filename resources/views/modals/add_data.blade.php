<div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true" >
    <div class="modal-dialog modal-default" role="document">
        <form class="modal-content" method="POST" enctype="multipart/form-data" id="add-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Carbon Footprint Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Type<span class="text-danger h4">*</span></label>
                            <select class="form-control form-control-sm p-3 select2" style="width:100%" name="carbon_type" id="carbon_type">
                                <option value="">Select Carbon Footprint Type</option>
                                @if(Auth::user()->role_id == 5)
                                <option value="11">Water Consumption</option>
                                <option value="12">Electricity Consumption</option>
                                <option value="13">Solid Waste Consumption</option>
                                @elseif (Auth::user()->role_id == 6)
                                <option value="21">Fuel Consumption</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Description <span class="text-danger h4">*</span></label>
                            <textarea class="form-control form-control-sm "  rows="2" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">Attachment</label>
                            <input type="file" class="form-control form-control-sm " name="file">
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

