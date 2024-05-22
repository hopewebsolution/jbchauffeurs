@extends('masters/master')
@section('title', 'Service Details')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <div class="pg-title"><h1>{{$service->name}}</h1></div>
                        <div>
                            <div style="float:left; width:296px; margin-right:15px;">
                                <img src="{{$service->image}}" width="100%" />
                            </div>
                            <div style="line-height:24px;">{!!$service->descriptions!!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush