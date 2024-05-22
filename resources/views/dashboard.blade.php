@extends('masters/master')
@section('title', 'Dashboard')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div id="contentainer">
            @include('customerNav')
            <div class="dashboard-desp">
                <div class="page-header">Welcome To Customer Dashboard</div>
                <div class="content-box">You have Sucessfully Logged in.<br />
                    Please use the Navigation to manage your website.</div>
            </div>
            <div class="dashboard-desp">
                <div class="page-header red">Security Alert</div>
                <div class="content-box">Please do not forget to logout after managing your website.</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush