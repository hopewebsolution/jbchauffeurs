@extends('app.master')
@section('content')
<main id="main" class="main">
    <div class="pagetitle" style="position: relative;">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Vehicles</li>
            </ol>
        </nav>
        <a href="{{ route('operator.vehicles.create') }}" class="btn btn-primary add-new">Add New</a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif


                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Passengers</th>
                                        <th scope="col">Hand Bags</th>
                                        <th scope="col">Luggages</th>
                                        <th scope="col">Per Stop</th>
                                        <th scope="col">Parking</th>
                                        <th scope="col">Baby Seat</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($vehicles->total()>0)
                                    @foreach ($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->id }}</td>
                                        <td>{{ $vehicle->name }}</td>
                                        <td>@if($vehicle->image)<img class="service_img" src="{{ $vehicle->image }}"> @else NA @endif</td>
                                        <td>{{ $vehicle->passengers }}</td>
                                        <td>{{ $vehicle->suitecases }}</td>
                                        <td>{{ $vehicle->luggages }}</td>
                                        <td>${{ $vehicle->per_stop }}</td>
                                        <td>${{ $vehicle->parking_charge }}</td>
                                        <td>${{ $vehicle->baby_seat }}</td>
                                        <td>{{ $vehicle->created_at->format('d-M-Y') }}</td>
                                        <td class=" last">
                                            <a title="Edit Vehicle" href="{{ route('operator.vehicles.edit', $vehicle->id) }}" class="btn btn-info btn-xs">Edit </a>
                                            @if($vehicle->bookings_count==0)
                                            <a title="Delete Vehicle" href="{{ route('operator.vehicles.delete', $vehicle->id) }}" class="btn btn-danger btn-xs delete" data-id="{{$vehicle->id}}">Delete </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr><td colspan="11" class="text-center">No Record Found</td></tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="pagi_rowop">
        <div class="page_counts">
            Results: {{ $vehicles->firstItem() ??0 }}
            - {{ $vehicles->lastItem() }}
            of
            {{ $vehicles->total() }}
        </div>
        <div class="vehi_paginationop">
            {{ $vehicles->links() }}
        </div>
    </div>

    <!-- <ul class="page">
        <li class="page__btn"><span class="material-icons"><i class="bi bi-arrow-left-short"></i></span></li>
        <li class="page__numbers active">1</li>
        <li class="page__numbers">2</li>
        <li class="page__numbers">3</li>
        <li class="page__numbers">4</li>
        <li class="page__numbers">5</li>
        <li class="page__dots">...</li>
        <li class="page__numbers"> 10</li>
        <li class="page__btn active"><span class="material-icons"><i class="bi bi-arrow-right-short"></i></span></li>
    </ul> -->

</main>

<style>
    .add-new {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
@endsection
