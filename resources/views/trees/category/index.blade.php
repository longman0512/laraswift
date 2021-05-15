@extends('layouts.template')

@section('title','Tree Varieties')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('app.tree_varietys')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item"><a href="/category-tree">{{__('app.tree_varietys')}}</a></li>
              <li class="breadcrumb-item active">{{__('app.view')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @include('layouts.includes.alerts')
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <a href="/category-tree/create" class="pull-right btn btn-primary">{{__('app.create_variety')}}</a>
                </div>
                <div class="col-md-12">
                  <div class="table-responsive no-padding ">
                <table id="dataTable" class="table table-borderless table-striped table-hover">
                  <thead>
                  <tr>
                    <th class="">{{__('app.image')}}</th>
                    <th class="">{{__('app.variety_name')}}</th>
                    <th class="">{{__('app.description')}}</th>
                    <th class="">{{__('app.abb_carbon_dioxide')}}({{__('app.abb_pound_year')}})</th>
                    <th class="">{{__('app.abb_oxygen_production')}}({{__('app.abb_pound_year')}})</th>
                    <th class="">{{__('app.nitrogen_fixing')}}</th>
                    <th class="">{{__('app.zone')}}</th>
                    <th class="">{{__('app.created_at')}}</th>
                    <th class="">{{__('app.action')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $category)
                  <tr>
                    <td class="text-center">
                      <img src={{asset('uploads/tree/'.$category->media)}} style="width: 70%; min-width: 90px; max-width: 110px;"/>
                    </td>
                    <td class="align-middle text-center">{{$category->name}}</td>
                    <td class="align-middle text-center">{{Str::limit($category->description,80,' (...)')}}</td>
                    <td class="align-middle text-center">{{$category->carbon_absorption}}</td>
                    <td class="align-middle text-center">{{$category->oxygen_production}}</td>
                    <td class="align-middle text-center">{{$category->nitrogen_fixing ? "Yes" : "No"}}</td>
                    <td class="align-middle text-center">{{$category->zone}}</td>
                    <td class="align-middle text-center">{{date('M d, Y',strtotime($category->created_at))}}</td>
                    <td class="align-middle text-center">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="mx-1">
                            <a href="/category-tree/{{$category->slug}}/edit"><button class="btn btn-info" data-toggle="tooltip"  data-placement="bottom" title="{{__('app.edit_category')}}"/><i class="fa fa-edit text-white"></i></button></a>
                          </div>
                          <div class="mx-1">
                            <form action="/category-tree/{{$category->slug}}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger" data-toggle="tooltip"  data-placement="bottom" title="{{__('app.delete_category')}}"/><i class='fa fa-trash text-white'></i></button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                </table>
              </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
