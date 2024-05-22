@extends('Admin/masters/master')
@section('title', 'Add Faq')
@push('page-scripts')
@endpush
@if($faq->id)
  @section('page_title','Edit Faq')
@else
  @section('page_title','Add Faq')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.faqs.create',$faq->id],'class'=>'add_package','id'=>'add_package','files' => true]) !!}
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
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="question" class="hws_form_label">Title:<span class="text-danger small">* </span></label>
                        {!! Form::text('question',$faq->question,['class'=>'form-control','required'=>'required','data-type'=>'text']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('question') }}</span>
                      </div>
                    </div>
                                        
                    <div class="row"> 
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="answer" class="hws_form_label">Answer:</label>
                        {!! Form::textarea('answer',$faq->answer,['class'=>'form-control','rows'=>"5",'id'=>'editor']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('answer') }}</span>
                      </div>
                    </div>

                  </div>
              </div>
          </div>
          <div class="col-sm-4">
              <div class="x_panel">
                  <div class="x_content text-center">
                      <button class="btn btn-primary btn-fw" type="submit"><i class="fa fa-check"></i> Update &amp; Save</button>
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

  </script>
@endpush