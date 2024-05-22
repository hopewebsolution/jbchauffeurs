@extends('masters/master')
@section('title', 'Airport Transfer')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <div class="pg-title"><h1>{{$pageData->title}}</h1></div>
                        <div>
                            {!! $pageData->descriptions !!}
                        </div>
                        <div class="services">
                            @if($airports->total()>0)
                            @foreach($airports as $airport)
                            <div class="tabholder">
                                <div class="txtst1" style="margin-bottom:10px;">{{$airport->title}}</div>
                                <div class="clearfix">
                                    <div class="airport-image"><img src="{{$airport->image}}"  width="100%"></div>
                                    <div class="airport-content"><p>
                                        {!!  $airport->short_desc !!}
                                        <a class="read-more" href="{{route('user.airportTransDetails',['airport_id'=>$airport->id,'url_slug'=>$airport->url_slug])}}">Read More »</a>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else 
                                <div class='notification n-information'>No records to display.</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    @if($pageData->side_app_title)
                    <div class="dnwl-holder" style="margin-top:30px;">{{$pageData->side_app_title}}</div>
                    @endif
                    <div style="margin-bottom:25px;">
                        <a href="{{$pageData->side_app_link}}" target="_blank"><img src="{{$pageData->side_app_image}}" alt="" width="100%" /></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush