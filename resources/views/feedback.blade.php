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
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-comment"></i> Feedback</h3>
                                @if ($role_id == 6 || $role_id == 5 || $role_id == 4)
                                <button class="btn btn-danger btn-sm float-right" onclick="showModal()"><i class="fa fa-plus"></i> Add Feedback</button>
                                @endif
                            </div>
                            <div class="card-body" >
                                <table id="feedback-table" class="table table-hover table-striped" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>SDG</th>
                                            <th>Information</th>
                                            <th>Submitted By</th>
                                            <th>Date Submitted</th>
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
@include('custom_js.feedback_js')
@include('modals.add_feedback')

@endsection
