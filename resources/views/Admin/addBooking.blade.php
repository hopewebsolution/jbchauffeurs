@extends('Admin/masters/master')
@section('title', 'Add Fare')
@push('page-scripts')
@endpush

@section('content')
<div class="container banner-wrap">
        @if($site_settings->maintenance=="1")
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 service-block-in-sp" style="text-align: center;margin: 15% 0px;">
                <h3 style="font-weight: 700;text-transform: uppercase;background-color: #00000038;color: #fff;">{{$common->currCountry['name']}} Site Under Maintenance</h3>
            </div>
        </div>
        @else
        @include('Admin.masters.locationForm',['formType'=>'adminhomeForm'])
        @endif
    </div>
@endsection
@push('footer-scripts')
@endpush