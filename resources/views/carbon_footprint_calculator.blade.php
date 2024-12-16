@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper">
    <div class="content-wrapper">
        <section class="card-body">
            <div class="container-fluid">
                <form class="row" method="POST" enctype="multipart/form-data" id="calculate-form">
                    <div class="col-lg-4 card" style="max-height: 700px; display: flex; flex-direction: column; justify-content: space-between;" >
                        <div class="card-header">
                            <h4>Campus Carbon Footprint Calculator</h4>
                        </div>
                        <div class="card-body row" style="max-height: 700px;">
                            <div class="form-group col-lg-12">
                                <label>Fuel Consumption</label>
                                <div class="row">
                                    <input type="text"  class="form-control col-lg-8" name="fuel">
                                    <input type="text"  class="form-control col-lg-2" value="gasoline" name="fuel_type">
                                    <input type="text"  class="form-control col-lg-2" value="liter" name="fuel_unit">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Water Consumption</label>
                                <div class="row">
                                    <input type="text"  class="form-control col-lg-8" name="water">
                                    <input type="text"  class="form-control col-lg-4" value="liter" name="water_unit">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Electricity Consumption</label>
                                <div class="row">
                                    <input type="text"  class="form-control col-lg-8" name="electricity">
                                    <input type="text"  class="form-control col-lg-4" value="kilowatt hour" name="electricity_unit">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Solid Waste Consumption</label>
                                <div class="row">
                                    <input type="text"  class="form-control col-lg-8" name="waste">
                                    <input type="text"  class="form-control col-lg-4" value="kilogram" name="waste_unit">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" class="btn btn-success btn-sm form-control"  onclick="calculate()"><i class="fa fa-calculator"></i> Calculate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 card">
                        <div class="card-header">
                            <h4>Possible Solutions</h4>
                        </div>
                        <div class="card-body row" id="solutions"  >

                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@include('components.script')
@include('custom_js.calculator_js')
@endsection