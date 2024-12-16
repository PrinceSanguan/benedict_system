<!-- Electricity Modal -->
<div class="modal fade" id="electricityModal" tabindex="-1" role="dialog" aria-labelledby="electricityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="electricityModalLabel">Add Electricity Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form method="post" action="{{route('add-electricity')}}">
                @csrf <!-- Laravel CSRF Token -->
            
                <div class="form-group">
                    <label for="campus">Campus</label>
                    <input type="text" class="form-control" id="campus" name="campus" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" id="category" name="category" required>
                </div>
                <div class="form-group">
                    <label for="month">Month</label>
                    <input type="text" class="form-control" id="month" name="month" required>
                </div>
                <div class="form-group">
                    <label for="quarter">Quarter</label>
                    <input type="text" class="form-control" id="quarter" name="quarter">
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
                    <label for="year">Year</label>
                    <input type="text" class="form-control" id="year" name="year" required>
                </div>
                <div class="form-group">
                    <label for="prev_reading">Previous Reading</label>
                    <input type="text" class="form-control" id="prev_reading" name="prev_reading" required>
                </div>
                <div class="form-group">
                    <label for="current_reading">Current Reading</label>
                    <input type="text" class="form-control" id="current_reading" name="current_reading" required>
                </div>
                <div class="form-group">
                    <label for="consumption">Consumption</label>
                    <input type="text" class="form-control" id="consumption" name="consumption" required>
                </div>
                <div class="form-group">
                    <label for="multiplier">Multiplier</label>
                    <input type="text" class="form-control" id="multiplier" name="multiplier" required>
                </div>
                <div class="form-group">
                    <label for="total_consumption">Total Consumption</label>
                    <input type="text" class="form-control" id="total_consumption" name="total_consumption" required>
                </div>
                <div class="form-group">
                    <label for="total_amount">Total Amount</label>
                    <input type="text" class="form-control" id="total_amount" name="total_amount" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                </div>
            
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
      </div>
  </div>
</div>

<script>
  function showModalElectricity() {
      $('#electricityModal').modal('show');
  }
</script>