@extends('app.master')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Booking</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body p-0">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Booking Id</th>
                                    <th scope="col">Booked Date / Time</th>
                                    <th scope="col">Journey Form</th>
                                    <th scope="col">Journey To</th>
                                    <th scope="col">Pickup Date / Time</th>
                                    <th scope="col">Fare</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>5/20/2024 / 1:08PM</td>
                                    <td>Jaipur</td>
                                    <td>Delhi</td>
                                    <td>5/21/2024 / 3:08PM</td>
                                    <td>Test</td>
                                    <td>India</td>
                                    <td>Test</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <ul class="page">
        <li class="page__btn"><span class="material-icons"><i class="bi bi-arrow-left-short"></i></span></li>
        <!---->
        <!---->
        <li class="page__numbers active">1</li>
        <li class="page__numbers">2</li>
        <li class="page__numbers">3</li>
        <li class="page__numbers">4</li>
        <li class="page__numbers">5</li>
        <li class="page__dots">...</li>
        <li class="page__numbers"> 10</li>
        <li class="page__btn active"><span class="material-icons"><i class="bi bi-arrow-right-short"></i></span></li>
    </ul>
</main>
@endsection