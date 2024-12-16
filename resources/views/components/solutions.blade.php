
<div class="form-group col-lg-12">
    <div class="row col-lg-12">
        <div class="col-lg-3">
            <h6><b>Calculated Carbon Footprint:</b></h6>
        </div>
        <div class="col-lg-9">
            <input class="form-control form-control-sm" value="{{$decodedContent['calculated_carbon_footprint']}}" name="calculated_data" readonly>
        </div>
    </div>
</div>
<div class="form-group col-lg-12">
    <div class="row col-lg-12">
        <div class="col-lg-3">
            <h6><b>Report Title <span class="text-red">*</span></b></h6>
        </div>
        <div class="col-lg-9">
            <input type="text" class="form-control form-control-sm" name="report_title">
        </div>
    </div>
</div>
<div class="form-group col-lg-12">
    <div class="row col-lg-12">
        <div class="col-lg-3">
            <h6><b>Upload A Supporting Document</b></h6>
        </div>
        <div class="col-lg-9">
            <input type="file" class="form-control form-control-sm" name="file">
        </div>
    </div>
</div>
@foreach ($decodedContent['solutions'] as $solution)
<div class="form-group col-lg-12">
    <div class="col-lg-12 row">
        <div class="col-lg-3 d-flex align-items-end">
            <b class="col-lg-12 text-end">TITLE:</b><br><br>
        </div>
        <div class="col-lg-9">
            <input class="form-control form-control-sm" value="{{$solution['title']}}" name="title[]" readonly>
        </div>
    </div>
    <div class="col-lg-12 row">
        <div class="col-lg-3 d-flex align-items-end">
            <b class="col-lg-12 text-end">Description:</b><br><br>
        </div>
        <div class="col-lg-9">
            <textarea name="desription[]" class="form-control form-control-sm" readonly>{{$solution['description']}}</textarea>
        </div>
        
    </div>
</div>
@endforeach
<div class="col-lg-12 row">
    <div class="col-lg-3">
        <b class="col-lg-12 text-end">AI Comment:</b>
    </div>
    <div class="col-lg-9">
        <textarea class="form-control form-control-sm" name="comment" rows="4" readonly>{{$decodedContent['comment']}}</textarea>
    </div>
</div>
<div class="col-lg-12 row mt-3">
    <div class="col-lg-3"></div>
    <div class="col-lg-6"><button type="button" class="btn btn-primary col-lg-12" onclick="submitReport()"> Submit Report</button></div>
</div>