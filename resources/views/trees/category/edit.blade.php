@extends('layouts.template')

@section('title', 'Tree Variety Edit')
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
                            <li class="breadcrumb-item"><a href="/">{{ __('app.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="/category-tree">{{ __('app.tree_variety') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('app.edit') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        @include('layouts.includes.alerts')
                        <div class="row">
                            <div class="col-md-12">
                              <form class="" action="/category-tree/{{ $category->slug }}" method="post">
                                @method('PUT')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="text" name="name" value="{{ $category->name }}"
                                                            class="form-control" id="title"
                                                            placeholder="{{ __('app.category_name') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="description"
                                                            class="form-control textarea-resize-none" id="description"
                                                            rows="3"
                                                            placeholder="{{ __('app.category_description') }}">{{ $category->description }}</textarea>
                                                    </div>
                                                
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-block">{{ __('app.carbon_dioxide') }}:</label>
                                                    <input type="number" name="carbon_absorption" class="form-control"
                                                        placeholder="{{ __('app.variety_name') }}" value="{{ $category->carbon_absorption }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-block">{{ __('app.oxygen_production') }}:</label>
                                                    <input type="number" name="oxygen_production" class="form-control"
                                                        placeholder="{{ __('app.variety_name') }}" value="{{ $category->oxygen_production }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">{{ __('app.nitrogen_fixing') }}:</label>
                                                    <select name="nitrogen_fixing"
                                                        class="form-control form-control-inline-block">
                                                        @if($category->nitrogen_fixing)
                                                          <option value="yes" selected>Yes</option>
                                                          <option value="no">No</option>
                                                        @else
                                                          <option value="yes">Yes</option>
                                                          <option value="no" selected>No</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-block">{{ __('app.zone') }}:</label>
                                                    <input type="text" name="zone" class="form-control"
                                                        placeholder="{{ __('app.variety_name') }}" value="{{ $category->zone }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary col-md-12"
                                                        value="{{ __('app.update_variety') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
