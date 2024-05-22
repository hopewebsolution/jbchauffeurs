@extends('Admin/masters/master')
@section('title', 'Dashboard')
@push('page-scripts')
@endpush
@section('content')
  <style>
    .page-title{
      display: none;
    }
  </style>
  <!-- top tiles -->
  <div class="row tile_count">
    {{--
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.users') }}">
        <span class="count_top"><i class="fa fa-users"></i> Total Users</span>
        <div class="count">{{ $counters->users }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.partners') }}">
      <span class="count_top"><i class="fa fa-users"></i></i> Total Partners</span>
      <div class="count">{{ $counters->partners }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders') }}">
      <span class="count_top"><i class="fa fa-first-order"></i> Total Orders</span>
      <div class="count">{{ $counters->orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"accepted"]) }}">
      <span class="count_top"><i class="fa fa-user"></i> New Orders</span>
      <div class="count" style="color: #FF9800;">{{ $counters->accepted_orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"assigned"]) }}">
      <span class="count_top"><i class="fa fa-user"></i> Assigned Orders</span>
      <div class="count" style="color: #03A9F4;">{{ $counters->assigned_orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"inprogress"]) }}">
      <span class="count_top"><i class="fa fa-user"></i> Inprogress Orders</span>
      <div class="count" style="color: #3f51b5;">{{ $counters->inprogress_orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"completed"]) }}">
        <span class="count_top"><i class="fa fa-user"></i> Completed Orders</span>
        <div class="count green">{{ $counters->completed_orders }}</div>
      </a>
    </div> 
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"cancelled"]) }}">
        <span class="count_top"><i class="fa fa-user"></i> Cancelled Orders</span>
        <div class="count red">{{ $counters->cancelled_orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.service.orders',["status"=>"failed"]) }}">
        <span class="count_top"><i class="fa fa-user"></i> Failed Orders</span>
        <div class="count red">{{ $counters->failed_orders }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.partners.balance',["balance_type"=>"creditors"]) }}">
        <span class="count_top"><i class="fa fa-money"></i> Partner Wallet</span>
        <div class="count green">{{ $counters->total_partner_pay }}</div>
      </a>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <a href="{{ route('admin.partners.balance',["balance_type"=>"debtors"]) }}">
        <span class="count_top"><i class="fa fa-money"></i> Pendding In Partne</span>
        <div class="count green">{{ $counters->total_quikzon_pay }}</div>
      </a>
    </div>
    --}}    
  </div>
<!-- /top tiles -->
@endsection