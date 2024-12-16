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
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-lightbulb"></i> Reports</h3>
                            </div>
                            <div class="card-body row" >
                                <div class="col-lg-6">
                                    <div class="card-header">
                                        <h5 class="card-title font-weight-bolder">SDG Reports</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="sdg-table" class="table table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date Generated</th>
                                                    <th>Month</th>
                                                    <th>Report</th>
                                                </tr>
                                            </thead>
                                            <tbody ></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-header">
                                        <h5 class="card-title font-weight-bolder">Carbon Reports</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="carbon-table" class="table table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date Generated</th>
                                                    <th>Report Title</th>
                                                    <th>Attachments</th>
                                                    <th>Report</th>
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
@include('custom_js.report_js')

@endsection
