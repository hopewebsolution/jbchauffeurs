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
        <a href="{{ route('operator.fares.create') }}" class="btn btn-primary add-new">Add New</a>
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
                                        <th scope="col">Distance</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vehicle</th>
                                        <th scope="col" style="width: 112px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($fares->total()>0)
                                    @foreach ($fares as $key => $fare)
                                    <tr>
                                        <td>{{ $fares->firstItem() + $key }}</td>
                                        <td>{{ $fare->start }} - {{ $fare->end }}</td>
                                        <td>${{ $fare->rate }}</td>
                                        <td>@if($fare->vehicle) {{$fare->vehicle->name}} @endif</td>
                                        <td class="last">
                                            <a title="Edit Fare" href=" {{ route('operator.fares.edit', $fare->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                            <a title="Delete Fare" href="{{ route('operator.fares.delete', $fare->id) }}" class="btn btn-danger btn-xs delete" data-id="{{$fare->id}}"><i class="fa fa-trash"></i>Delete </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr><td colspan="5" class="text-center">No Record Found</td></tr>
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
            Results: {{ $fares->firstItem() ??0 }} - {{ $fares->lastItem() }} of {{ $fares->total() }}
        </div>
        <div class="vehi_paginationop">
            {{ $fares->links() }}
        </div>
    </div>

</main>

<style>
    .last {
        min-width: 175px;
    }
    .add-new {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
@endsection
