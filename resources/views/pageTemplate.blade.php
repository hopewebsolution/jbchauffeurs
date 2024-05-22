@extends('masters/master')
@section('title', $pageData->title)
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-12">
                    <div class="leftholder about-us">
                        <div class="pg-title"><h1>{{$pageData->title}}</h1></div>
                        <div>
                            @if($pageData->image)
                            <img src="{{$pageData->image}}" alt="" width="100%" />
                            @endif
                            {!! $pageData->descriptions !!}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush