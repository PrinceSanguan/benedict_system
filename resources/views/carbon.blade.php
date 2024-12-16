@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper ">
    <div class="content-wrapper">
        <div class="card-header text-center">
            <div class="container-fluid ">
                <h1 class="m-0">Carbon Analytics</h1>
            </div>
        </div>
        <section class="card-body ">
            <div class="container-fluid row">
                <div class="card col-lg-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i> Fuel Consumption Last 10 Reports
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="fuel-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card col-lg-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i> Water Usage Last 10 Reports
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="water-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card col-lg-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i> Electricity Consumption Last 10 Reports
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="electricity-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card col-lg-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i> Waste Generated Last 10 Reports
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="waste-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card col-lg-6" >
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i> Compiled Total This Record
                          
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="bar-chart" style="height:300px;"></div>
                    </div>
                </div>
                <div class="card col-lg-6">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-line"></i> Carbon Trend
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="carbon-trend-chart" style="height: 200px !important; max-heigh:200px !important;"></canvas>
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

    var fuelData = @json($fuelData);
    var waterData = @json($waterData);
    var electricityData = @json($electricityData);
    var wasteData = @json($wasteData);

    var totals = {
        Fuel: 0,
        Water: 0,
        Electricity: 0,
        Waste: 0
    };

    fuelData.forEach(function(item) {
        totals.Fuel += parseFloat(item.fuel_value) || 0;
    });

    waterData.forEach(function(item) {
        totals.Water += parseFloat(item.water_value) || 0;
    });

    electricityData.forEach(function(item) {
        totals.Electricity += parseFloat(item.electricity_value) || 0;
    });

    wasteData.forEach(function(item) {
        totals.Waste += parseFloat(item.waste_value) || 0;
    });

    var barData = [];
    var ticks = [];

    barData.push([1, totals.Fuel]);
    barData.push([2, totals.Water]);
    barData.push([3, totals.Electricity]);
    barData.push([4, totals.Waste]);

    ticks.push([1, 'Fuel']);
    ticks.push([2, 'Water']);
    ticks.push([3, 'Electricity']);
    ticks.push([4, 'Waste']);

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
                show: true,
                barWidth: 0.5,
                align: 'center',
            },
        },
        colors: ['#dc3545'],
        xaxis: {
            ticks: ticks 
        }
    });

    var fuelData = @json($fuelData);
    var waterData = @json($waterData);
    var electricityData = @json($electricityData);
    var wasteData = @json($wasteData);

    function prepareData(data, key) {
        return data.map((item, index) => [index + 1, parseInt(item[key] || 0)]);
    }

    var fuelValues = prepareData(fuelData, 'fuel_value');
    var waterValues = prepareData(waterData, 'water_value');
    var electricityValues = prepareData(electricityData, 'electricity_value');
    var wasteValues = prepareData(wasteData, 'waste_value');

    function plotGraph(elementId, plotData, color) {
        $.plot(elementId, [plotData], {
            grid: { borderWidth: 1, borderColor: '#f3f3f3', tickColor: '#f3f3f3' },
            series: { bars: { show: true, barWidth: 0.5, align: 'center' } },
            colors: [color],
            xaxis: { ticks: Array.from({ length: 10 }, (_, i) => [i + 1, `Report ${i + 1}`]) }
        });
    }

    plotGraph('#fuel-chart', fuelValues, '#dc3545');
    plotGraph('#water-chart', waterValues, '#28a745');
    plotGraph('#electricity-chart', electricityValues, '#17a2b8');
    plotGraph('#waste-chart', wasteValues, '#ffc107');





    var carbonData = @json($carbonData); 
        var trendData = [];
        var labels = [];

        carbonData.forEach(function(item) {
            labels.push(item.created_at); 
            trendData.push({
                fuel: parseFloat(item.fuel_value),
                water: parseFloat(item.water_value),
                electricity: parseFloat(item.electricity_value),
                waste: parseFloat(item.waste_value)
            });
        });

        var ctx = document.getElementById('carbon-trend-chart').getContext('2d');

        var trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, 
                datasets: [
                    {
                        label: 'Fuel',
                        data: trendData.map(d => d.fuel),
                        borderColor: '#dc3545',
                        fill: false,
                    },
                    {
                        label: 'Water',
                        data: trendData.map(d => d.water),
                        borderColor: '#007bff',
                        fill: false,
                    },
                    {
                        label: 'Electricity',
                        data: trendData.map(d => d.electricity),
                        borderColor: '#28a745',
                        fill: false,
                    },
                    {
                        label: 'Waste',
                        data: trendData.map(d => d.waste),
                        borderColor: '#ffc107',
                        fill: false,
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        type: 'time', 
                        time: {
                            unit: 'day' 
                        }
                    },
                    y: {
                        beginAtZero: true 
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Carbon Trend Over Time'
                    }
                }
            }
        });


});
</script>
<style>
    #carbon-trend-chart {
    height: 350px !important; /* Force fixed height */
    width: 100%; /* Ensure it takes full width */
}
</style>
@endsection