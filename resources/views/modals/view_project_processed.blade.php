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
