@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2"></div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bolder"><i class="fa fa-leaf"></i> Carbon Footprint Data</h3>
                                <!-- Buttons -->
                            
                                @if(auth()->user()->role_id !== 5)
                                    <button class="btn btn-success btn-sm float-right" style="margin-right:10px" onclick="showModalFuel()">
                                        <i class="fa fa-plus"></i> Fuel
                                    </button>
                                @endif
                            
                                @if(auth()->user()->role_id !== 6)
                                    <button class="btn btn-danger btn-sm float-right" style="margin-right:10px" onclick="showModalElectricity()">
                                        <i class="fa fa-plus"></i> Electricity
                                    </button>
                                    <button class="btn btn-secondary btn-sm float-right" style="margin-right:10px" onclick="showModalSolidWaste()">
                                        <i class="fa fa-plus"></i> Solid Waste
                                    </button>
                                    <button class="btn btn-warning btn-sm float-right" style="margin-right:10px" onclick="showModalWater()">
                                        <i class="fa fa-plus"></i> Water
                                    </button>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="carbon-table" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Campus</th>
                                            <th>Category</th>
                                            <th>Month</th>
                                            <th>Quarter</th>
                                            <th>Year</th>
                                            <th>Previous Reading</th>
                                            <th>Total Consumption</th>
                                        </tr>
                                    </thead>
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
@include('custom_js.carbon_js')
@include('modals.add_solid-waste')
@include('modals.add_electricity')
@include('modals.add_water')
@include('modals.add_fuel')
@endsection