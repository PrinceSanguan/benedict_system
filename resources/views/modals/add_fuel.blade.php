<!-- Fuel Modal -->
<div class="modal fade" id="fuelModal" tabindex="-1" role="dialog" aria-labelledby="fuelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fuelModalLabel">Add Fuel Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('add-fuel')}}">
                    @csrf 
                    <div class="form-group">
                        <label for="campus">Campus</label>
                        <input type="text" class="form-control" id="campus" name="campus" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="driver">Driver</label>
                        <input type="text" class="form-control" id="driver" name="driver" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle">Vehicle</label>
                        <input type="text" class="form-control" id="vehicle" name="vehicle" required>
                    </div>
                    <div class="form-group">
                        <label for="plate_no">Plate Number</label>
                        <input type="text" class="form-control" id="plate_no" name="plate_no" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="form-group">
                        <label for="fuel_type">Fuel Type</label>
                        <input type="text" class="form-control" id="fuel_type" name="fuel_type" required>
                    </div>
                    <div class="form-group">
                        <label for="item_description">Item Description</label>
                        <input type="text" class="form-control" id="item_description" name="item_description" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction_no">Transaction Number</label>
                        <input type="text" class="form-control" id="transaction_no" name="transaction_no" required>
                    </div>
                    <div class="form-group">
                        <label for="odometer">Odometer</label>
                        <input type="text" class="form-control" id="odometer" name="odometer" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step="any" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="total_amount">Amount</label>
                        <input type="number" step="any" class="form-control" id="total_amount" name="total_amount" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="any" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="month">Month</label>
                        <input type="text" class="form-control" id="month" name="month" required>
                    </div>
                    <div class="form-group">
                        <label for="quarter">Quarter</label>
                        <input type="text" class="form-control" id="quarter" name="quarter" required>
                    </div>
                    <div class="form-group">
                        <label for="prev_reading">Previous Reading</label>
                        <input type="text" class="form-control" id="prev_reading" name="prev_reading" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="text" class="form-control" id="year" name="year" required>
                    </div>
                    <div class="form-group">
                        <label for="annually">Annually</label>
                        <input type="text" class="form-control" id="annually" name="annually" required>
                    </div>
                    <div class="form-group">
                        <label for="semi_annually">Semi-Annually</label>
                        <input type="text" class="form-control" id="semi_annually" name="semi_annually" required>
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
    function showModalFuel() {
        $('#fuelModal').modal('show');
    }
</script>