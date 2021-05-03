@extends('layouts.template')

@section('title','Activity Logs')
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
              <li class="breadcrumb-item active">{{__('app.activity_log')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
              <div class="card">
                 <div class="card-body">
                   <div class="row">
                     <div class="col-md-12 mb-3">
                       <h3 class="pull-right">{{__('app.activity_log')}}</h3>
                     </div>
                     <div class="col-md-12">
                       <div class="table-responsive no-padding">
                         <table id="dataTable" class="table table-hover table-striped table-borderless">
                           <thead>
                             <tr>
                               <th class="">{{__('app.activity_log_name')}}</th>
                               <th class="">{{__('app.activity_log_description')}}</th>
                               <th class="">{{__('app.activity_log_actionby')}}</th>
                               <th class="">{{__('app.created_at')}}</th>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($activities as $activity)
                             <tr>
                               <td>{{($activity->properties['name'])?$activity->properties['name']:'N/A'}}</td>
                               <td>{{$activity->description}}</td>
                               <td>{{$activity->properties['by']}}</td>
                               <td>{{date('Y-m-d h:i',strtotime($activity->created_at))}}</td>
                             </tr>
                             @endforeach
                           </tbody>
                          </table>
                        </div>
                     </div>
                   </div>

                  </div>
                   <!-- /.card-body -->
                </div>
              </div>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
