@extends('layouts.template')

@section('title','Dashboard')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('app.dashboard')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('app.dashboard')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      @include('layouts.includes.alerts')
      <div class="row">
		<!--============================ View for Non-Admin ============================-->
		@unlessrole('admin')

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <a href="/profile"  Class="info-box-icon bg-dark elevation-1" data-toggle="tooltip" data-placement="bottom" title="See {{__('app.profile')}}"><i class="fa fa-user-circle-o"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">{{__('app.profile')}}</span>
                <span class="info-box-number">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <a href="/trees/add"  Class="info-box-icon bg-info elevation-1" data-toggle="tooltip" data-placement="bottom" title="See {{__('app.planted_tree')}}"><i class="fa fa-tree"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">{{__('app.planted_tree')}}</span>
                <span class="info-box-number">
                  {{$tree_count}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

    @endunlessrole

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
