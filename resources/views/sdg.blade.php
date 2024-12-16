@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper ">
    <div class="content-wrapper">
        <div class="card-header text-center">
            <div class="container-fluid ">
                <h1 class="m-0">SDG Event Analytics</h1>
                <button class="btn btn-primary col-lg-4" onclick="generateSdg()"> Generate Report</button>
            </div>
        </div>
        <section class="card-body  container">
            <div class="container-fluid row">
                <div class="card col-lg-6" >
                    <div class="card-header">
                        <h3 class="card-title">
                          <i class="far fa-chart-bar"></i>
                          TOP 5 SDG
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="bar-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card  col-lg-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <div class="col-md-12 row d-flex align-items-center">
                                        <div class="px-4" aria-label="ICT">
                                            <i class="far fa-circle text-success"></i> ICTC
                                        </div>
                                        <div class="px-4" aria-label="CICS">
                                            <i class="far fa-circle text-cyan"></i> CICS
                                        </div>
                                        <div class="px-4" aria-label="CABEIGHM">
                                            <i class="far fa-circle text-warning"></i> CABEIGHM
                                        </div>
                                        <div class="px-4" aria-label="CAS">
                                            <i class="far fa-circle" style="color: #dc3545;"></i> CAS
                                        </div>
                                        <div class="px-4" aria-label="CTE">
                                            <i class="far fa-circle" style="color: #3538dc;"></i> CTE
                                        </div>
                                    </div>
                                    <canvas id="pieChart" height="100"></canvas>
                                    <center><h3>Department Participation</h3></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-lg-12">
                    <div class="card-header">
                        <h4>Most Neglected SDG</h4>
                    </div>
                    <div class="card-body row">
                        @foreach ($leastFiveSdgs as $sdg)
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>{{ $sdg['title'] }}</label> <br>
                                <span><label>Total Event:</label> {{ $sdg['count'] }}</span>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="card col-lg-12">
                    <div class="card-header">
                        <h4>SDG Events this month of {{$currentMonthName}}</h4>
                    </div>
                    <div class="card-body row">
                        @foreach ($sdgResults as $sdg)
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>{{ $sdg->sdg_approved }}</label> <br>
                                    <span><label>Total Event:</label> {{ $sdg->total_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
        </section>
    </div>
</div>
@include('components.script')
<script>
$(function () {
    'use strict'

    var sdgData = @json($topSdgCourse); 
    var barData = [];
    var ticks = [];

    sdgData.forEach(function(item, index) {
        barData.push([index + 1, parseInt(item.total_count)]); 
        var sdgNumber = item.sdg_approved.split(':')[0].trim();
        ticks.push([index + 1, sdgNumber]);
    });

    var plotData = {
        data: barData,
        bars: { show: true }
    };

    $.plot('#bar-chart', [plotData], {
        grid: {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor: '#f3f3f3'
        },
        series: {
            bars: {
                show: true, barWidth: 0.5, align: 'center',
            },
        },
        colors: ['#dc3545'],
        xaxis: {
            ticks: ticks 
        }
    });
    
    
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var departmentCounts = [{{$department['ICTC']}}, {{$department['CICS']}}, {{$department['CABEIGHM']}}, {{$department['CAS']}}, {{$department['CTE']}}];

    var total = departmentCounts.reduce(function (sum, value) {
        return sum + value;
    }, 0);

    var percentageData = departmentCounts.map(function (value) {
        return ((value / total) * 100).toFixed(2); 
    });

    var pieData = {
        labels: ['ICTC', 'CICS', 'CABEIGHM', 'CAS', 'CTE'],
        datasets: [{
            data: percentageData,
            backgroundColor: ['green', 'cyan', 'orange', '#dc3545', '#3538dc']
        }]
    };

    var pieOptions = {
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    var value = data.datasets[0].data[tooltipItem.index] || 0;
                    return label + ': ' + value + '%';
                }
            }
        },
        legend: {
            display: false
        }
    };

    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    });

    
});
</script>
<script>
    function generateSdg() {

        const button = document.querySelector('button[onclick="generateSdg()"]');
        button.innerHTML = 'Generating...';
        button.disabled = true;

        fetch('/generate-sdg-report', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({ 
                topSdgCourse: {!! json_encode($topSdgCourse) !!},
                department: {!! json_encode($department) !!},
                leastFiveSdgs: {!! json_encode($leastFiveSdgs) !!},
                sdgResults: {!! json_encode($sdgResults) !!},
                currentMonthName: '{{ $currentMonthName }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Report generated successfully!');
            } else {
                alert('Error generating report: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while generating the report.');
        })
        .finally(() => {
            button.innerHTML = 'Generate Report';
            button.disabled = false;
        });
    }
</script>
@endsection