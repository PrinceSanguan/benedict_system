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
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-lightbulb"></i> Courses</h3>
                            </div>
                            <div class="card-body row" >
                                <div class="col-lg-6">
                                    <div class="card-header">
                                        <h5 class="card-title font-weight-bolder">SDG Course Requests</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="request-table" class="table table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Project Manager</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody ></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-header">
                                        <h5 class="card-title font-weight-bolder">SDG Course Processed</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="processed-table" class="table table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Project Manager</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody ></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@include('components.script')
@include('custom_js.sec_course_js')
@include('modals.view_base')
@include('modals.view_base_processed')

@endsection
