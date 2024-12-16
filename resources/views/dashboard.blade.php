@extends('layouts.app')

@section('content')
@include('components.navbar')
<div class="wrapper">
    <div class="content-wrapper">
            @if(Auth::user()->role_id == 1)
            <div class="card-header text-center">
                <div class="container-fluid">
                    
                        <h1 class="m-0">My Dashboard</h1>
                    
                </div>
            </div>
            @elseif (Auth::user()->role_id == 5)
                    {{-- <h1 class="m-0">Events Calendar</h1> --}}
            @elseif (Auth::user()->role_id == 6)
                {{-- <h1 class="m-0">Events Calendar</h1> --}}
            @endif
            
            
            <section class="card-body">
                <div class="container-fluid">
                    @if(Auth::user()->role_id == 1)
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Users</span>
                                    <span class="info-box-number">{{$users}}</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="/users" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-bullhorn"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Announcements</span>
                                    <span class="info-box-number">{{$announcement}}</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="/announcement" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-leaf"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Carbon Footprint</span>
                                    <span class="info-box-number">{{$carbon_footprint}}</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a href="/carbon-footprint" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Test</span>
                                    <span class="info-box-number">3</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <a class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    @endif
                    @if(Auth::user()->role_id != 1)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header text-center bg-red">
                                    <h1 class="m-0">Announcement</h1>
                                </div>
                                <div class="card-body p-0" style="max-height: 80vh; overflow-y: auto;">
                                    @if($announcements->isNotEmpty())
                                        @foreach ($announcements as $announcement)
                                        <div class="form-group col-lg-12 px-5 pt-4">
                                            <h3 @if($announcement->status == 1) class="text-red" @endif><b>Subject @if($announcement->status == 1) (Important!) @endif:</b> {{$announcement->subject}}</h3>
                                            <div class="d-flex justify-content-between">
                                                <p class="">
                                                    {{$announcement->details}}
                                                </p>
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <span class="float-end"><b>Published Date: </b>{{$announcement->created_at->format('F d, Y')}}</span><br>
                                                <span class="float-end"><b>Published By: </b>{{$announcement->user->firstname ." ". $announcement->user->lastname}}</span>
                                            </div>
                                        </div>
                                        <hr>
                                        @endforeach
                                    @else
                                    <div class="h-20 text-center ">
                                        <h4 class="m-5">No Active Announcement</h4>
                                    </div>
                                    @endif
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header text-center bg-red">
                                    <h1 class="m-0">Events Calendar</h1>
                                </div>
                                <div class="card-body p-0">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
    </div>
</div>
@include('components.script')
@include('custom_js.calendar_js')
@endsection

