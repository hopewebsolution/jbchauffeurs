@extends('masters/master')
@section('title', 'PAGE NOT FOUND')
@section('content')
<style type="text/css">
    .icon-table .icon img{
        width: 55px;
        height: 55px;
        object-fit: contain;
    }
    .cntblock .pg-title {
        background: none;
    }
    .cntblock h1 {
        background-position: bottom center;
    }
</style>
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="leftholder about-us">
                <div class="pg-title">
                    <h1 style="text-align: center">{{ $statusCode ?? '404 - PAGE NOT FOUND' }}</h1>
                </div>
                <div style="min-height: 300px;">

                    <div style="line-height:24px;">
                        <p>Sorry, the page you are looking for could not be found.</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@push('footer-scripts')

@endpush
