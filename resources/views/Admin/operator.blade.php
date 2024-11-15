@extends('Admin/masters/master')
@section('title', 'Pages')
@push('page-scripts')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>All Operator</h2>
                    <!--   <div class="navbar-right">
                                                                                                                                                                                                                                                                                          <a href="{{ route('admin.pages.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add New</a>
                                                                                                                                                                                                                                                                                      </div> -->
                    <div class="clearfix"></div>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" id="search_key" class="form-control searchInput"
                                placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="x_content hws_table_responsive" id="ajax_data">
                    @include('Admin.operatorTable')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteOperator(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.operator.delete') }}",
                        method: 'POST',
                        data: {
                            'id': id
                        }
                    }).done(function(response) {
                        if (response.success == 1) {
                            new PNotify({
                                title: 'Success',
                                text: response.message,
                                delay: 2000,
                                type: 'success',
                                styling: 'bootstrap3'
                            });
                            location.reload();
                        }
                    })
                }
            })
        }

        $(document).ready(function() {
            $('.submitFromStatuss').change(function() {
                $(this).closest('form').submit();
            });


        });


        $(document).ready(function() {
            $('.searchInput').on('keyup', function() {
                var out_put = $("#ajax_data");
                var search_key = $(this).val();
                if (search_key != "") {
                    search_key = "/" + search_key;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.pages.search') }}" + search_key,
                    method: 'GET',
                }).done(function(data) {
                    out_put.html(data);
                }).fail(function() {
                    console.log("unable to get data!");
                });
            });
        });
    </script>
@endpush
