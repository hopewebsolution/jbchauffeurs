@extends('masters/master')
@section('title', 'FAQ')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="leftholder faqs">
                <div class="pg-title"><h1>{{$pageData->title}}</h1></div>
                <div>
                    @if($pageData->image)
                    <img src="{{$pageData->image}}" alt="" width="100%" />
                    @endif
                    {!! $pageData->descriptions !!}
                </div>
                <div aria-multiselectable="true" class="panel-group" id="accordion" role="tablist">
                    @if(!$faqs->isEmpty())
                    @foreach($faqs as $key=>$faq)
                    <div class="panel @if($key==0) panel-default @endif panel-bg">
                        <div class="panel-heading" role="tab">
                            <h4 class="panel-title">
                                <em>
                                    <span style="font-size:14px;">
                                        <span style="font-family:trebuchet ms,helvetica,sans-serif;">
                                            <a aria-controls="faq{{$faq->id}}" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#faq{{$faq->id}}" role="button">{{$faq->question}}</a>
                                        </span>
                                    </span>
                                </em>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse @if($key==0) in @endif" id="faq{{$faq->id}}" role="tabpanel">
                            <div class="panel-body">
                                {!!$faq->answer!!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                
                <!-- <div class='notification n-information'>No records to display.</div> -->
            </div>
        </div>
    </div>
</div>  
@endsection
@push('footer-scripts')
    
@endpush