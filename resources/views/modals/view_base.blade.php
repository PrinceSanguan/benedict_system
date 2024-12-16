<div class="modal fade" id="view" style="background: rgba(0, 0, 0, 0.8);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h4 class="modal-title"><b>View Details</b></h4>
                <div class="close" style="opacity: 1 !important;">
                    <button onclick="approve()" type="button" class="btn btn-success fload-end">Approved</button>
                    <button onclick="reject()" type="button" class="btn btn-danger px-3 fload-end">Reject</button>
                    <button type="button" class="btn btn-light fload-end" data-bs-dismiss="modal" onclick="closeModal()">Cancel</button>
                </div>
                    
            </div>
            <div class="modal-body">
                <form class="card-body" id="viewForm">
                    
                </form>
            </div>
            
        </div>
    </div>
</div>
