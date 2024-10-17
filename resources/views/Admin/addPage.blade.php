@extends('Admin/masters/master')
@section('title', 'Add Page')
@push('page-scripts')
@endpush
@if ($page->id)
    @section('page_title', 'Edit Page')
@else
    @section('page_title', 'Add Page')
@endif
@section('content')
    <!-- page content -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {!! Form::open(['route' => ['admin.pages.create', $page->id], 'files' => true]) !!}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-sm-8">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="sub_title">Page Content</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback"
                                    style="position: relative;">
                                    <label for="name" class="hws_form_label">Page Name:<span class="text-danger small">*
                                        </span></label>
                                    {!! Form::text('name', $page->name, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <span class="hws_error text-right text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback"
                                    style="position: relative;">
                                    <label for="title" class="hws_form_label">Title:<span class="text-danger small">*
                                        </span></label>
                                    {!! Form::text('title', $page->title, ['class' => 'form-control']) !!}
                                    <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group has-feedback"
                                            style="position: relative;">
                                            <label for="page_type" class="hws_form_label">Page Type:<span
                                                    class="text-danger small">* </span></label>
                                            {!! Form::select('page_type', $page_types, $page->page_type, [
                                                'placeholder' => 'Select Type',
                                                'class' => 'form-control',
                                                'id' => 'page_type',
                                            ]) !!}
                                            <span
                                                class="hws_error text-danger text-right">{{ $errors->first('page_type') }}</span>
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group has-feedback"
                                            style="position: relative;">
                                            <label for="header" class="hws_form_label">Header:<span
                                                    class="text-danger small">*
                                                </span></label>
                                            {!! Form::select('header', ['0' => 'No', '1' => 'YES'], $page->header, [
                                                'placeholder' => 'Select Type',
                                                'class' => 'form-control',
                                                'id' => 'header',
                                                'required' => 'required',
                                            ]) !!}
                                            <span
                                                class="hws_error text-danger text-right">{{ $errors->first('header') }}</span>
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group has-feedback"
                                            style="position: relative;">
                                            <label for="footer" class="hws_form_label">Footer:<span
                                                    class="text-danger small">*
                                                </span></label>
                                            {!! Form::select('footer', ['0' => 'No', '1' => 'YES'], $page->footer, [
                                                'placeholder' => 'Select Type',
                                                'class' => 'form-control',
                                                'id' => 'footer',
                                                'required' => 'required',
                                            ]) !!}
                                            <span
                                                class="hws_error text-danger text-right">{{ $errors->first('footer') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 repeator form-group"
                                    style="display: {{ $page->page_type == 'custom_page' ? 'block' : 'none' }};">
                                    <label for="section_type" class="hws_form_label">Page Section Type:<span
                                            class="text-danger small">*</span></label>
                                    <div class="row form-group">
                                        <div class="col-md-11 col-sm-12 col-xs-12">
                                            <select name="section_type" id="section_type" class="form-control">
                                                <option value="">Select Section</option>
                                                <option value="left_section">Left Section</option>
                                                <option value="right_section">Right Section</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1 col-sm-6 col-xs-6">
                                            <button type="button" class="btn btn-sm btn-primary add_section"
                                                id="add_section">
                                                <i class="fa fa-plus"></i> Add</button>
                                        </div>

                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="clone_here" style="padding: 0 10px;">
                                                @if ($page->sections)
                                                    @foreach ($page->sections as $section)
                                                        @include('Admin.pageSection', [
                                                            'section' => $section,
                                                        ])
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div id="clone_section" style="display: none">
                                                @include('Admin.pageSection', [
                                                    'section' => null,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback"
                                    style="position: relative;">
                                    <label for="descriptions" class="hws_form_label">Description:</label>
                                    {!! Form::textarea('descriptions', $page->descriptions, [
                                        'class' => 'form-control',
                                        'rows' => '5',
                                        'id' => 'editor',
                                    ]) !!}
                                    <span
                                        class="hws_error text-danger text-right">{{ $errors->first('descriptions') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="sub_title">Page Image</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="form-group">
                                <label>Image<small> (Size 500 x 385px)</small></label>
                                {!! Form::file('image', ['class' => 'form-control', 'id' => 'image', 'onchange' => 'preview(this);']) !!}
                            </div>
                            <div id="icon_img">
                                @if ($page->image)
                                    <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i
                                            class="fa fa-trash"></i> </a>
                                    <input type="hidden" name="bannerImage" value="{{ $page->image }}">
                                    <img class="side_img" src="{{ $page->image }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="sub_title">Sidebar App</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group has-feedback" style="position: relative;">
                                <label for="side_app_title" class="hws_form_label">Title:<span
                                        class="text-danger small">*
                                    </span></label>
                                {!! Form::text('side_app_title', $page->side_app_title, ['class' => 'form-control']) !!}
                                <span
                                    class="hws_error text-right text-danger">{{ $errors->first('side_app_title') }}</span>
                            </div>
                            <div class="form-group has-feedback" style="position: relative;">
                                <label for="side_app_link" class="hws_form_label">Link:<span class="text-danger small">*
                                    </span></label>
                                {!! Form::text('side_app_link', $page->side_app_link, ['class' => 'form-control']) !!}
                                <span
                                    class="hws_error text-right text-danger">{{ $errors->first('side_app_link') }}</span>
                            </div>
                            <div class="form-group">
                                <label>Image<small> (Size 500 x 385px)</small></label>
                                {!! Form::file('side_app_image', [
                                    'class' => 'form-control',
                                    'id' => 'side_app_image',
                                    'onchange' => 'preview(this,#side_app_image);',
                                ]) !!}
                            </div>
                            <div id="side_app_image">
                                @if ($page->side_app_image)
                                    <a title="Delete side_app_image" href="#"
                                        class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                                    <input type="hidden" name="imageName" value="{{ $page->side_app_image }}">
                                    <img class="side_img" src="{{ $page->side_app_image }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="x_content text-center">
                            <button class="btn btn-primary btn-fw" type="submit"><i class="fa fa-check"></i> Update
                                &amp;
                                Save</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- /page content -->
@endsection
@push('footer-scripts')
    <script>
        $(document).ready(function() {

            $(document).on('change', '#page_type', function() {
                // Remove the closest parent with the 'row' class
                if ($(this).val() == 'custom_page') {
                    $('.repeator').show();
                } else {
                    $('.repeator').hide();
                }
            });

            $(document).on('click', '#add_section', function() {
                var selectedSection = $('#section_type').val(); // Get the selected section value

                if (selectedSection) { // Check if a section is selected
                    var clone_section = $('#clone_section').clone(); // Clone the section
                    clone_section.removeAttr('id'); // Remove the 'id' attribute from the cloned section
                    clone_section.css('display', 'block'); // Ensure the cloned section is visible

                    // Add section type based on selected value
                    if (selectedSection === 'left_section') {
                        clone_section.addClass(
                            'left-section'); // Add a class for Left Section (you can style this later)
                        clone_section.find('.section-title').text(
                            'Left Section'); // Optionally change a section title or label
                    } else if (selectedSection === 'right_section') {
                        clone_section.addClass('right-section'); // Add a class for Right Section
                        clone_section.find('.section-title').text('Right Section');
                    }
                    clone_section.find('.section_type_show').html((selectedSection === 'left_section' ?
                        'Left' : 'Right'));

                    clone_section.find('.use_section').val('1');
                    clone_section.find('.use_section').attr('value', '1');;
                    clone_section.find('.section_type').val(selectedSection);
                    clone_section.find('.section_type').attr('value', selectedSection);

                    $('.clone_here').append(clone_section); // Append the cloned section to the container

                    // Reset the select field after cloning
                    $('#section_type').val(''); // Reset dropdown to the default "Select Section" value

                } else {
                    alert('Please select a section type before adding.');
                }
            });

            $(document).on('click', '.remove_section', function() {
                // Remove the closest parent with the 'row' class
                $(this).closest('.remove_this_section').remove();
            });
        });
    </script>
@endpush
