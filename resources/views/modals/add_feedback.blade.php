<div class="modal fade" id="add" tabindex="-1" role="dialog"  aria-hidden="true" >
    <div class="modal-dialog modal-default" role="document">
        <form class="modal-content" method="POST" enctype="multipart/form-data" id="add-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Send Feedback</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">SDG <span class="text-danger h4">*</span></label>
                            <select class="form-control form-control-sm p-3 select2" style="width:100%" name="sdg" id="sdg">
                                <option value=""> Select SDG</option>
                                @if($sdg_criterias->isNotEmpty())
                                    @foreach ($sdg_criterias as $sdg)
                                        <option value="{{$sdg->title}}">{{$sdg->title}}</option>
                                    @endforeach
                                @endif
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="name">Details <span class="text-danger h4">*</span></label>
                            <textarea class="form-control form-control-sm "  rows="6" name="details"></textarea>
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

