
@extends('app.master')

@section('content')

@php
    $days = [
        'total' => 'Total',
        'today' => 'Today',
        'month' => 'This Month',
        'year' => 'This Year'
    ];
@endphp
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-4 col-sm-12">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item submitBookings" href="javascript:void(0)" data-value="total">Total</a></li>
                    <li><a class="dropdown-item submitBookings" href="javascript:void(0)" data-value="today">Today</a></li>
                    <li><a class="dropdown-item submitBookings" href="javascript:void(0)" data-value="month">This Month</a></li>
                    <li><a class="dropdown-item submitBookings" href="javascript:void(0)" data-value="year">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                    <a href="{{ route('booking') }}">
                        <h5 class="card-title">Total Booking <span>| {{ isset(request()->booking_days)?$days[request()->booking_days]:'Total' }}</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                            </div>
                            <div class="ps-3">
                            <h6>{{ $bookingCountAll }}</h6>
                            {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                            </div>
                        </div>
                    </a>
                </div>

              </div>
            </div>

            <div class="col-xxl-4 col-md-4 col-sm-12">
                <div class="card info-card sales-card">
                  <div class="card-body">
                      <a href="{{ route('booking', ['status' => 'intransit',]) }}">
                          <h5 class="card-title">In-Transit Booking <span>| {{ 'Today' }}</span></h5>

                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                              <i class="bi bi-cart"></i>
                              </div>
                              <div class="ps-3">
                              <h6>{{ $bookingInTransit }}</h6>
                              {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                              </div>
                          </div>
                      </a>
                  </div>

                </div>
            </div>


            <div class="col-xxl-4 col-md-4 col-sm-12">
                <div class="card info-card sales-card">
                  <div class="card-body">
                      <a href="{{ route('booking', ['status' => 'pending',]) }}">
                          <h5 class="card-title">Pending Booking <span>| {{ 'Today' }}</span></h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                 <i class="bi bi-cart"></i>
                              </div>
                              <div class="ps-3">
                                <h6>{{ $bookingCountPending }}</h6>
                              </div>
                          </div>
                      </a>
                  </div>

                </div>
            </div>

            <div class="col-xxl-4 col-md-4 col-sm-12">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start"><h6>Filter</h6></li>
                            <li><a class="dropdown-item submitCompletedBookings" href="javascript:void(0)" data-value="total">Total</a></li>
                            <li><a class="dropdown-item submitCompletedBookings" href="javascript:void(0)" data-value="today">Today</a></li>
                            <li><a class="dropdown-item submitCompletedBookings" href="javascript:void(0)" data-value="month">This Month</a></li>
                            <li><a class="dropdown-item submitCompletedBookings" href="javascript:void(0)" data-value="year">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('booking', ['status' => 'completed']) }}">
                            <h5 class="card-title">Completed Booking <span>| {{ (request()->booking_days)?$days[request()->booking_days]:'Today' }}</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                    <h6>{{ $bookingCountCompleted }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
              </div>
            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-4 col-sm-12">
                <div class="card info-card revenue-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
                      <li><a class="dropdown-item submitEarning" href="javascript:void(0)" data-value="total">Total</a></li>
                      <li><a class="dropdown-item submitEarning" href="javascript:void(0)" data-value="today">Today</a></li>
                      <li><a class="dropdown-item submitEarning" href="javascript:void(0)" data-value="month">This Month</a></li>
                      <li><a class="dropdown-item submitEarning" href="javascript:void(0)" data-value="year">This Year</a></li>
                    </ul>
                  </div>
                  <div class="card-body">
                      <a href="javascript:void(0)">
                      <h5 class="card-title">Earning <span>| {{ (request()->earning_days)?$days[request()->earning_days]:'Total' }}</span></h5>

                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                            <h6>${{ number_format($bookingAmount) }}</h6>
                          </div>
                      </div>
                      </a>
                  </div>

                </div>
              </div><!-- End Revenue Card -->

          </div>
        </div><!-- End Left side columns -->


      </div>
    </section>
  </main>
  <form id="submitForm" action="{{ route('operator.dashboard') }}" method="GET">
    <input type="hidden" id="earning_days" name="earning_days" value="{{ request()->get('earning_days') }}">
    <input type="hidden" id="booking_days" name="booking_days" value="{{ request()->get('booking_days') }}">
    <input type="hidden" id="completed_booking_days" name="completed_booking_days" value="{{ request()->get('completed_booking_days') }}">
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".submitBookings").click(function(event){
                event.preventDefault();
                $("#booking_days").val($(this).data('value'));
                $('#submitForm').submit();
            });

            $(".submitCompletedBookings").click(function(event){
                event.preventDefault();
                $("#completed_booking_days").val($(this).data('value'));
                $('#submitForm').submit();
            });

            $(".submitEarning").click(function(event){
                event.preventDefault();
                $("#earning_days").val($(this).data('value'));
                $('#submitForm').submit();
            });
        });
    </script>
@endsection


