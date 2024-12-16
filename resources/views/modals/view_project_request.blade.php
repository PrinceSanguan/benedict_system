<div class="row">
    <div class="col-lg-6" >
        <div class="form-group">
            <label>SDG <span class="text-danger h4">*</span></label>
            <select class="form-control form-control-sm p-3 select2" style="width:100%" name="approved_sdg" id="approved_sdg">
                <option value=""> Select SDG</option>
                @if($sdg_criteria->isNotEmpty())
                    @foreach($sdg_criteria as $criteria)
                        <option value="{{$criteria->title}}"> {{$criteria->title}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group">
            <label>AI Selected SDG </label>
            <input class="form-control form-control-sm" readonly value="{{$project->sdg_name}}">
        </div>
        <div class="form-group">
            <label>AI Comment on Selected SDG </label>
            <textarea class="form-control form-control-sm" rows="4">{{$project->comment}}</textarea>
        </div>
        
        <fieldset>
            <legend>SDG Criteria</legend>
            <div class="form-group" style="height: 90vh; overflow-y:auto;">
                @if($sdg_criteria->isNotEmpty())
                    @foreach($sdg_criteria as $criteria)
                        <div class="card">
                            <div class="card-header" style="padding-bottom:0">
                                <h6 ><b>{{$criteria->title}}</b></h6>
                            </div>
                            <div class="card-body" style="padding: 5 15px">
                                <div class="form-group">
                                    <label>{{$criteria->header_detail_1}}</label>
                                    <span>{{$criteria->detail_1}}</span><br>
                                    <label>{{$criteria->header_detail_2}}</label>
                                    <span>{{$criteria->detail_2}}</span><br>
                                    <label>{{$criteria->header_detail_3}}</label>
                                    <span>{{$criteria->detail_3}}</span><br>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <input type="hidden" value="{{$project->id}}" name="id" id="id">
            <div class="col-lg-12">
                <b>Title:</b> {{$project->title}}
            </div>
            <div class="col-lg-12">
                <b>Project Manager:</b> {{$project->project_manager}}
            </div>
            <div class="col-lg-12">
                <b>Department:</b> {{$project->department ?? 'N/A'}}
            </div>
            <div class="col-lg-6">
                <b>Date Start:</b> {{ \Carbon\Carbon::parse($project->date_start)->format('F d, Y') }}
            </div>
            <div class="col-lg-6">
                <b>Date End:</b> {{ \Carbon\Carbon::parse($project->date_end)->format('F d, Y') }}
            </div>
            <div class="col-lg-6">
                <b>Attachment</b>@if($project->attachment) <a href="/storage/{{$project->attachment}}"> Download</a> @else No Attachment @endif
            </div>
        </div>
        <div>
            <img src="/storage/{{$project->photo}}" class="col-lg-12">
        </div>
        <div class="col-lg-12">
            <b>Event Information:</b> <br>{{$project->event_information}}
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#viewForm select:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
});
</script>