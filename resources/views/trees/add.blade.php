@extends('layouts.template')

@section('title','Trees Add')
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
            <li class="breadcrumb-item"><a href="/trees">{{__('app.planted_tree')}}</a></li>
            <li class="breadcrumb-item active">{{__('app.planted_add')}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          @include('layouts.includes.alerts')
          <!-- Profile Image -->
          <div class="card">
            <div class="card-body text-center">
              <div class="row">
                <div id="avatar-holder" class="col-md-12">
                  <img id="tree-img" width="40px" height="100px" class="img profile-user-img img-responsive" src="{{asset('uploads/avatar/avatar.png')}}" alt="Select your photo/video">
                  <label class="btn btn-secondary btn-lg d-block mx-auto mt-5 col-sm-12 mb-0" for="avatarCrop">
                    {{__('app.upload_image_video')}}
                    <input type="file" class="d-none" id="avatarCrop">
                  </label>
                </div>
                <div id="avatar-updater" class="col-xs-12 d-none">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="image-preview"></div>
                    </div>
                    <div class="col-md-12">
                      <input type="text" name="avatar-url" class="d-none" value="{{route('update-avatar',Auth::user()->id)}}">
                      <button type="button" id="rotate-image" class="btn btn-info col-sm-12 mb-1">{{__('app.rotate_image')}}</button>
                      <button type="button" id="crop_image" class="btn btn-primary col-sm-12">{{__('app.crop_image')}}</button>
                      <button type="button" id="avatar-cancel-btn" name="button" class="btn btn-secondary col-sm-12 mt-1">{{__('app.cancel')}}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-8">
          <form class="form-horizontal" method="POST" action="/trees/create" onsubmit="return validateForm()">
            @csrf
            @method('put')
            <div class="card">
              <div class="card-body">
                <ul class="nav nav-tabs flex-space-between" id="myTab" role="tablist">
                  <li class="nav-item shadow mb-3 mr-2">
                    <a class="nav-link white" id="account-details-tab" role="tab" aria-controls="account-details">{{__('app.planting_detail')}}</a>
                  </li>
                  <li class="nav-item mb-3 mr-2">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="share" id="public" onclick="updateShareStatus('public')" checked />
                      <label class="form-check-label" for="flexRadioDefault1"> Public </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="share" id="private" onclick="updateShareStatus('private')" />
                      <label class="form-check-label" for="flexRadioDefault2"> Private </label>
                    </div>
                    <input type="hidden" name="share_status" id="share_status" value="public" />
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content mt-3 mx-0">
                  <div class="tab-pane active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">

                    <div class="col-md-12 mx-0">
                      <div><label class="label-block">{{__('app.caption_description')}}:</label></div>
                      <input type="text" name="caption" id="caption" class="form-control" placeholder="{{__('app.caption_description')}}">
                    </div>
                    <div class="row form-group">
                      <div class="col-md-6 mb-1 mt-2">
                        <div><label class="label-block">{{__('app.tree_variety')}}:</label></div>
                        <select name="variety" id="variety" class="form-control form-control-inline-block">
                          @foreach ($categories as $category)
                          <option value="{{$category->slug}}">{{$category->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6 mt-2">
                        <div><label class="label-block">{{__('app.latitude')}}:</label></div>
                        <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                      </div>
                      <div class="col-md-6 mt-2">
                        <div><label class="label-block">{{__('app.quantity')}}:</label></div>
                        <input type="number" name="quantity" id="quantity" class="form-control" value=1 onchange="calculateCoin()" onkeyup="calculateCoin()">
                      </div>
                      <div class="col-md-6 mt-2">
                        <div><label class="">{{__('app.longitude')}}:</label></div>
                        <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                      </div>
                      <div class="col-md-6 mt-2">
                        <div class="row">
                          <div class="col-md-6 v-center-left">
                            <div><label class="label-block">{{__('app.earned_coin')}}:</label></div>
                          </div>
                          <div class="col-md-6">
                            <input type="number" name="coin" id="coin" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mt-2">
                        <button type="submit" class="btn btn-primary col-sm-12">{{__('app.save')}}</button>
                      </div>

                    </div>
                    <div class="col-md-8 mx-auto">

                    </div>

                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </form>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div id="tree-map" class="map"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
  </section>

</div>
<!-- /.content-wrapper -->

@endsection
@section('script')
<script>
  var markerFlag = false;
  mapboxgl.accessToken = 'pk.eyJ1IjoiYmFuemFhciIsImEiOiJ4akIxdlZBIn0.D431j0UB6ko4pLzO7P8edw';

  var map = new mapboxgl.Map({
    container: 'tree-map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-77.034084142948, 38.909671288923],
    zoom: 13,
    scrollZoom: true
  });
  //   navigator.geolocation.getCurrentPosition(position => { 
  //     map.setCenter([position.coords.longitude, position.coords.latitude])
  // }); 
  geocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken, // Set the access token
    mapboxgl: mapboxgl, // Set the mapbox-gl instance
    marker: true, // Use the geocoder's default marker style
    bbox: [-77.210763, 38.803367, -76.853675, 39.052643] // Set the bounding box coordinates
  });

  map.addControl(geocoder, 'top-left');

  map.addControl(new mapboxgl.NavigationControl());
  var marker = "";
  map.on('click', function(e) {
    if (marker) marker.remove();
    document.getElementById("latitude").value = e.lngLat.lat;
    document.getElementById("longitude").value = e.lngLat.lng;
    marker = new mapboxgl.Marker({
        draggable: true,
        color: "#FA7A35"
      })
      .setLngLat(e.lngLat)
      .addTo(map);

    markerFlag = true;
    marker.on("dragend", function(e) {
      console.log(e);
      document.getElementById("latitude").value = e.target._lngLat.lat;
      document.getElementById("longitude").value = e.target._lngLat.lng;
    })
  });
</script>
<script src="{{asset('custom/trees/tree.js')}}"></script>
@endsection