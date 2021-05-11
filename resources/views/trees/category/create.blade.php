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
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div id="avatar-holder" class="col-md-12 variey-tree-image-holder">
                <img width="40px" height="100px" class="variey-tree-image" src="{{asset('uploads/tree/avatartree.png')}}" alt="Select your photo/video" id="upload_image">
                <label class="btn btn-secondary btn-lg d-block mx-auto mt-5 col-sm-12 mb-0" for="uploadFile">
                  {{__('app.select_image_video')}}
                  <input type="file" class="d-none" id="uploadFile" name="uploadFile" onchange="showBrowsedImage(this)" calss="variey-tree-image">
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8 mx-auto">
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
                          <input type="number" name="carbon_absorption" class="form-control" placeholder="{{__('app.variety_name')}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label-block">{{__('app.oxygen_production')}}:</label>
                          <input type="number" name="oxygen_production" class="form-control" placeholder="{{__('app.variety_name')}}">
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
                          <input type="text" name="zone" class="form-control" placeholder="{{__('app.variety_name')}}">
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
<script src="{{asset('custom/trees/tree-category.js')}}"></script>
@endsection