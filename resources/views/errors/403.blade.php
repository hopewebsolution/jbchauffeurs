@extends('masters/master')
@section('title', 'Forbidden Asccess')
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
                    <h1 style="text-align: center">{{ $statusCode ?? '403 - Forbidden Asccess' }}</h1>
                </div>
                <div style="min-height: 300px;">

                    <div style="line-height:24px;">
                        <p>Sorry, you do not have permission to access this page.</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@push('footer-scripts')

@endpush
