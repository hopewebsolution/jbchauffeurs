@extends('masters/master')
@section('title', 'How It Works')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <div class="pg-title"><h1>{{$pageData->title}}</h1></div>
                        @if($pageData->image)
                        <div class="page_banner"> <img src="{{$pageData->image}}"> </div>
                        @endif
                        <div>
                            {!! $pageData->descriptions !!}
                        </div>
                        <div class="services">
                            @if($services->total()>0)
                                @foreach($services as $service)
                                <div class="tabholder">
                                    <div class="txtst1" style="margin-bottom:10px;">{{$service->name}}</div>
                                    <div>
                                        <div class="airport-image">
                                            <img src="{{$service->image}}" width="100%">
                                        </div>
                                        <div class="airport-content">
                                            <div>
                                                {!!$service->short_desc!!}
                                            </div>
                                            <a class="read-more" href="{{route('user.serviceDetails',['service_id'=>$service->id,'slug'=>$service->url_slug])}}">Read More »</a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                @endforeach
                            
                            <div class="pagi_row">  
                                <div class="page_counts"> 
                                    Results: {{ $services->firstItem() }}
                                    - {{ $services->lastItem() }}
                                    of 
                                  {{ $services->total() }}
                                </div>
                                <div class="vehi_pagination"> 
                                    {{ $services->links() }}
                                </div>
                            </div>
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