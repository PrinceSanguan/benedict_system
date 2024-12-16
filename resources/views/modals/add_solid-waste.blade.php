<!-- Solid Waste Modal -->
<div class="modal fade" id="solidWasteModal" tabindex="-1" role="dialog" aria-labelledby="solidWasteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="solidWasteModalLabel">Add Solid Waste Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{route('add-solid-waste')}}">
                  @csrf <!-- Laravel CSRF Token -->
              
                  <div class="form-group">
                      <label for="campus">Campus</label>
                      <input type="text" class="form-control" id="campus" name="campus" required>
                  </div>
                  <div class="form-group">
                      <label for="month">Month</label>
                      <input type="text" class="form-control" id="month" name="month" required>
                  </div>
                  <div class="form-group">
                      <label for="year">Year</label>
                      <input type="text" class="form-control" id="year" name="year" required>
                  </div>
                  <div class="form-group">
                      <label for="waste_type">Waste Type</label>
                      <input type="text" class="form-control" id="waste_type" name="waste_type" required>
                  </div>
                  <div class="form-group">
                      <label for="quantity">Quantity</label>
                      <input type="number" step="any" class="form-control" id="quantity" name="quantity" required>
                  </div>
                  <div class="form-group">
                      <label for="remarks">Remarks</label>
                      <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="category">Category</label>
                    <textarea class="form-control" id="category" name="category" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="prev_reading">Previous Reading</label>
                    <textarea class="form-control" id="prev_reading" name="prev_reading" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="total_amount">Total Amount</label>
                    <input type="text" class="form-control" id="total_amount" name="total_amount">
                </div>
                  <div class="form-group">
                      <label for="annually">Annually</label>
                      <input type="text" class="form-control" id="annually" name="annually">
                  </div>
                  <div class="form-group">
                      <label for="semi_annually">Semi-Annually</label>
                      <input type="text" class="form-control" id="semi_annually" name="semi_annually">
                  </div>
                  <div class="form-group">
                      <label for="quarter">Quarter</label>
                      <input type="text" class="form-control" id="quarter" name="quarter">
                  </div>
              
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
  function showModalSolidWaste() {
      $('#solidWasteModal').modal('show');
  }
</script>