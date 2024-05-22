@extends('masters/master')
@section('title', 'Page Not Found 404')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 service-block-in-sp" style="text-align: center;margin: 15% 0px;">
                <h3 style="font-weight: 700;text-transform: uppercase;">Site Under Maintenance</h3>
                <a href="{{ route('user.home') }}" class="common-btn-hp">Return To Home</a>
            </div>
        </div>
    </div>
</div>  
@endsection
@push('footer-scripts')
    
@endpush