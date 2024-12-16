<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Syllabi</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area, #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <section class="invoice">
            <div class="container border">
                <div class="row col-lg-10 offset-lg-1" id="print-area">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20" ><center><h4>Carbon Footprint Report</h4></center></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20"><h5>Report Title : {{$carbonReport->report_title}}</h5></td>
                                </tr>
                                <tr>
                                    <td colspan="20"><h6>Calculated Carbon Footprint : {{$carbonReport->calculated_data}}</h6></td>
                                </tr>
                                <tr>
                                    <td colspan="14">Category</td>
                                    <td colspan="2">Value</td>
                                    <td colspan="2">Type</td>
                                    <td colspan="2">Unit</td>
                                </tr>
                                <tr>
                                    <td colspan="14">Fuel Consumption</td>
                                    <td colspan="2">{{$carbonReport->fuel_value}}</td>
                                    <td colspan="2">{{$carbonReport->fuel_type}}</td>
                                    <td colspan="2">{{$carbonReport->fuel_unit}}</td>
                                </tr>
                                <tr>
                                    <td colspan="14">Water Consumption</td>
                                    <td colspan="2">{{$carbonReport->water_value}}</td>
                                    <td colspan="4">{{$carbonReport->water_unit}}</td>
                                </tr>
                                <tr>
                                    <td colspan="14">Electricity Consumption</td>
                                    <td colspan="2">{{$carbonReport->electricity_value}}</td>
                                    <td colspan="4">{{$carbonReport->electricity_unit}}</td>
                                </tr>
                                <tr>
                                    <td colspan="14">Waste Consumption</td>
                                    <td colspan="2">{{$carbonReport->waste_value}}</td>
                                    <td colspan="3">{{$carbonReport->waste_unit}}</td>
                                </tr>
                                <tr>
                                    <td colspan="20"><h6>AI Comment On Report Based on Presnt Values</h6></td>
                                </tr>
                                <tr>
                                    <td colspan="20">{{$carbonReport->comment}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="10">SDGs</td>
                                    <td colspan="10">Possible Solutions</td>
                                </tr>
                                @foreach ($carbonSolution as $carbon)
                                    <tr>    
                                        <td colspan="10">{{$carbon['title']}}</td>
                                        <td colspan="10">{{$carbon['description']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>
</html>