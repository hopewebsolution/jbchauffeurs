@extends('app.master')
@section('content')
<main id="main" class="main">
    <div class="pagetitle" style="position: relative;">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $title ??'' }}</li>
            </ol>
        </nav>
    </div>
    {{-- {{ $errors }} --}}
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('operator.fares.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="operator_id" value="{{ Auth::guard('weboperator')->user()->id }}"> --}}
                    <input type="hidden" name="id" value="{{ $fare->id??'' }}">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $title }}</h5>

                            <div class="row mb-3">

                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="start" class="col-form-label">Start</label>
                                        <input name="start" type="number" class="form-control" id="start" value="{{ isset($fare->start)?$fare->start:old('start') }}">
                                        @if($errors->has('start' ))
                                            <p class="help-block">
                                                {{ $errors->first('start') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="end" class="col-form-label">End</label>
                                        <input name="end" type="number" class="form-control" id="end" value="{{ isset($fare->end)?$fare->end:old('end') }}">
                                        @if($errors->has('end' ))
                                            <p class="help-block">
                                                {{ $errors->first('end') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="rate" class="col-form-label">Rate</label>
                                        <input name="rate" type="number" class="form-control" id="rate" value="{{ isset($fare->rate)?$fare->rate:old('rate') }}">
                                        @if($errors->has('rate' ))
                                            <p class="help-block">
                                                {{ $errors->first('rate') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 col-md-6">
                                    <div class="form-group">
                                        <label for="vehicle_id" class="col-form-label">Vehicle</label>
                                        <select name="vehicle_id" id="vehicle_id" class="form-select">
                                            <option value="">Select Vehicle</option>
                                            @foreach ($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ isset($fare->vehicle_id) && $fare->vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('vehicle_id' ))
                                            <p class="help-block">
                                                {{ $errors->first('vehicle_id') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-left col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</main>

<style>
    .add-new {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
@endsection
