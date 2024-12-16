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
                                    <td colspan="20" ><center><h4>SDG Generated Report </h4></center></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20">Top 5 SDG</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">SDG</td>
                                    <td colspan="4">Total Count</td>
                                </tr>
                                @foreach ($topSdgCourse as $sdg)
                                    <tr>    
                                        <td colspan="16">{{$sdg['sdg_approved']}}</td>
                                        <td colspan="4">{{$sdg['total_count']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20">Department Participation</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">Department</td>
                                    <td colspan="4">Total Count</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">ICTC</td>
                                    <td colspan="4">{{$department['ICTC']}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">CICS</td>
                                    <td colspan="4">{{$department['CICS']}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">CABEIGHM</td>
                                    <td colspan="4">{{$department['CABEIGHM']}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">CAS</td>
                                    <td colspan="4">{{$department['CAS']}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">CTE</td>
                                    <td colspan="4">{{$department['CTE']}}</td>
                                </tr>
                                <tr>
                                
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20">Most Neglected SDG</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">SDG</td>
                                    <td colspan="4">Total Count</td>
                                </tr> 

                                @foreach ($leastFiveSdgs as $sdg)
                                    <tr>    
                                        <td colspan="16">{{$sdg['title']}}</td>
                                        <td colspan="4">{{$sdg['count']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="20">SDG Events this month of {{$sdgReport->currentMonthName}}</td>
                                </tr>
                                <tr>    
                                    <td colspan="16">SDG</td>
                                    <td colspan="4">Total Count</td>
                                </tr> 

                                @foreach ($sdgResults as $sdg)
                                    <tr>    
                                        <td colspan="16">{{$sdg['sdg_approved']}}</td>
                                        <td colspan="4">{{$sdg['total_count']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
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