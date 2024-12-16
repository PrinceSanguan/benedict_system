<div class="form-group">
    <input type="hidden" value="{{$course->id}}" name="id" id="id">
    <div class="col-lg-12">
        <b>Title:</b> {{$course->title}}
    </div>
    <div class="col-lg-12">
        <b>Project Manager:</b> {{$course->project_manager}}
    </div>
    <div class="col-lg-12">
        <b>Department:</b> {{$course->department ?? 'N/A'}}
    </div>
    <div class="col-lg-6">
        <b>Date Start:</b> {{ \Carbon\Carbon::parse($course->date_start)->format('F d, Y') }}
    </div>
    <div class="col-lg-6">
        <b>Date End:</b> {{ \Carbon\Carbon::parse($course->date_end)->format('F d, Y') }}
    </div>
    <div class="col-lg-6">
        <b>Attachment</b>@if($course->attachment) <a href="/storage/{{$course->attachment}}"> Download</a> @else No Attachment @endif
    </div>
</div>
<div>
    <img src="/storage/{{$course->photo}}" class="col-lg-12">
</div>
<div class="col-lg-12">
    <b>Event Information:</b> <br>{{$course->event_information}}
</div>
