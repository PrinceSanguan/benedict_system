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
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-bullhorn"></i> Announcement</h3>
                                <button class="btn btn-danger btn-sm float-right" onclick="showModal()"><i class="fa fa-plus"></i> Add Announcement</button>
                            </div>
                            <div class="card-body" >
                                <table id="announcement-table" class="table table-hover table-striped" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                            <th>Date Published</th>
                                            {{-- <th>Actions</th> --}}
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
@include('custom_js.announcement_js')
@include('modals.add_announcement')

@endsection
