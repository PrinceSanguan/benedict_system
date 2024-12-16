@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-lightbulb"></i> Event</h3>
                                <button class="btn btn-danger btn-sm float-right" onclick="showModal()"><i class="fa fa-plus"></i> Add Event</button>
                            </div>
                            <div class="card-body" >
                                <table id="event-table" class="table table-hover table-striped" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Information</th>
                                            <th>Date</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>
                                    <tbody ></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('components.script')
@include('custom_js.event_js')
@include('modals.add_event')

@endsection
