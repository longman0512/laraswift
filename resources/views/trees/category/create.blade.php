@extends('layouts.template')

@section('title','Tree Variety Create')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
            <li class="breadcrumb-item"><a href="/category-tree">{{__('app.tree_varietys')}}</a></li>
            <li class="breadcrumb-item active">{{__('app.create')}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form class="" action="/category-tree" method="post" onsubmit="return validateForm()">
      @csrf
    <div class="container-fluid">
      <div class="row">
        @include('layouts.includes.alerts')
        <div class="col-lg-5 col-md-12">
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div id="avatar-holder" class="col-md-12">
                  <div class="variey-tree-image-holder">
                    <img width="40px" height="100px" class="avatar-image" src="{{asset('uploads/tree/avatartree.png')}}" alt="Select your photo/video" id="upload_image">
                  </div>
                  <video width="290" id="video_display_element" style="display: none;" controls autopaly>
                    <source src="{{asset('uploads/tree/mov_bbb.mp4')}}" class="video_display">
                    Your browser does not support HTML5 video.
                  </video>
                  <label class="btn btn-secondary btn-lg d-block mx-auto mt-5 col-sm-12 mb-0" for="uploadFile">
                    {{__('app.select_image_video')}}
                    <input type="file" class="d-none" id="uploadFile" name="uploadFile" onchange="showBrowsedImage(this)">
                    <input type="hidden" class="d-none" id="cropedImage" name="cropedImage">
                  </label>
                </div>
                <div id="avatar-updater" class="col-xs-12 text-center mx-auto" style="display:none;">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="upload-demo"></div>
                    </div>
                    <div class="col-md-12">
                      <button type="button"  id="crop_image_btn" class="btn btn-primary col-sm-12">{{__('app.crop_image')}}</button>
                      <button type="button" id="crop_image_cancel" name="button" class="btn btn-secondary col-sm-12 mt-1">{{__('app.cancel')}}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-12 mx-auto">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="text" name="name" class="form-control" id="variety_name" placeholder="{{__('app.variety_name')}}">
                        </div>
                        <div class="form-group">
                          <textarea name="description" class="form-control textarea-resize-none" id="variety_description" rows="3" placeholder="{{__('app.description')}}"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label-block">{{__('app.carbon_dioxide')}}:</label>
                          <input type="number" name="carbon_absorption" class="form-control" placeholder="{{__('app.abb_carbon_dioxide')}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label-block">{{__('app.oxygen_production')}}:</label>
                          <input type="number" name="oxygen_production" class="form-control" placeholder="{{__('app.abb_oxygen_production')}}">
                        </div>
                      </div>
                    </div>  
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="">{{__('app.nitrogen_fixing')}}:</label>
                          <select name="nitrogen_fixing" class="form-control form-control-inline-block">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label-block">{{__('app.zone')}}:</label>
                          <input type="text" name="zone" class="form-control" placeholder="{{__('app.zone')}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="submit" class="btn btn-primary col-md-12" value="{{__('app.create_variety')}}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
@section('script')
<script>
  var resize = $('#upload-demo').croppie({
      enableExif: true,
      enableOrientation: true,    
      viewport: { // Default { width: 100, height: 100, type: 'square' } 
          width: 200,
          height: 200,
          type: 'square' //square
      },
      boundary: {
          width: 300,
          height: 300
      }
  });
  
  $('#crop_image_cancel').on('click', function (ev) {
    
    $('#uploadFile').val("");
    $('#avatar-holder').show();
    $('#upload_image').show();
    $('#avatar-updater').hide();
  });
  
  $('#crop_image_btn').on('click', function (ev) {
    
    resize.croppie('result', {
      type: 'canvas',
      size: 'original'
    }).then(function (img) {
      // html = '<img src="' + img + '" />';
      console.log(img.size);
      $("#upload_image").attr("src",img);
      $("#cropedImage").val(img);
      
      $('#avatar-holder').show();
      $('#upload_image').show();
      $('#avatar-updater').hide();
    });
  });
  </script>
  <script src="{{asset('custom/trees/tree-category.js')}}"></script>
@endsection