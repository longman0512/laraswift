@extends('layouts.template')

@section('title', 'Trees Add')
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
                            <li class="breadcrumb-item"><a href="/trees">{{ __('app.planted_tree') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('app.planted_add') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <form class="form-horizontal" method="POST" action="/trees/create" enctype="multipart/form-data"
                onsubmit="return validateForm()">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-12">
                            @include('layouts.includes.alerts')
                            <!-- Profile Image -->
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div id="avatar-holder" class="col-md-12">
                                            <div class="variey-tree-image-holder">
                                                <img width="40px" height="100px" class="avatar-image"
                                                    src="{{ asset('uploads/tree/avatartree.png') }}"
                                                    alt="Select your photo/video" id="upload_image">
                                            </div>
                                            <video width="290" id="video_display_element" style="display: none;" controls
                                                autopaly>
                                                <source src="{{ asset('uploads/tree/mov_bbb.mp4') }}" class="video_display">
                                                Your browser does not support HTML5 video.
                                            </video>
                                            <label class="btn btn-secondary btn-lg d-block mx-auto mt-5 col-sm-12 mb-0"
                                                for="uploadFile">
                                                {{ __('app.select_image_video') }}
                                                <input type="file" class="d-none" id="uploadFile" name="uploadFile"
                                                    onchange="showBrowsedImage(this)">
                                                <input type="hidden" class="d-none" id="cropedImage" name="cropedImage">
                                            </label>
                                        </div>
                                        <div id="avatar-updater" class="col-xs-12 text-center mx-auto"
                                            style="display:none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="upload-demo"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" id="crop_image_btn"
                                                        class="btn btn-primary col-sm-12">{{ __('app.crop_image') }}</button>
                                                    <button type="button" id="crop_image_cancel" name="button"
                                                        class="btn btn-secondary col-sm-12 mt-1">{{ __('app.cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-lg-7 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs flex-space-between" id="myTab" role="tablist">
                                        <li class="nav-item shadow mb-3 mr-2">
                                            <a class="nav-link white" id="account-details-tab" role="tab"
                                                aria-controls="account-details">{{ __('app.planting_detail') }}</a>
                                        </li>
                                        <li class="nav-item mb-3 mr-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="share" id="public"
                                                    onclick="updateShareStatus('public')" checked />
                                                <label class="form-check-label" for="flexRadioDefault1"> Public </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="share" id="private"
                                                    onclick="updateShareStatus('private')" />
                                                <label class="form-check-label" for="flexRadioDefault2"> Private </label>
                                            </div>
                                            <input type="hidden" name="share_status" id="share_status" value="public" />
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3 mx-0">
                                        <div class="tab-pane active" id="account-details" role="tabpanel"
                                            aria-labelledby="account-details-tab">

                                            <div class="col-md-12 pd-0">
                                                <div><label class="label-block">{{ __('app.caption_description') }}:</label>
                                                </div>
                                                <input type="text" name="caption" id="caption" class="form-control"
                                                    placeholder="{{ __('app.caption_description') }}">
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-6 mb-1 mt-2">
                                                    <div><label class="label-block">{{ __('app.tree_variety') }}:</label>
                                                    </div>
                                                    <select name="variety" id="variety"
                                                        class="form-control form-control-inline-block">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->slug }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div><label class="label-block">{{ __('app.latitude') }}:</label></div>
                                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div><label class="label-block">{{ __('app.quantity') }}:</label></div>
                                                    <input type="number" name="quantity" id="quantity" class="form-control"
                                                        value=1 onchange="calculateCoin()" onkeyup="calculateCoin()">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div><label class="">{{ __('app.longitude') }}:</label></div>
                                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-6 v-center-left">
                                                            <div><label
                                                                    class="label-block">{{ __('app.earned_coin') }}:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" name="coin" id="coin" class="form-control"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <button type="submit"
                                                        class="btn btn-primary col-sm-12">{{ __('app.save') }}</button>
                                                </div>

                                            </div>
                                            <div class="col-md-8 mx-auto">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="tree-map" class="map"></div>
                                    <img id="preview" style="" onclick="togglemap()"></img>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </form>
        </section>

    </div>
    <!-- /.content-wrapper -->

@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 285,
                height: 200,
                type: 'square' //square
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#crop_image_cancel').on('click', function(ev) {

            $('#uploadFile').val("");
            $('#avatar-holder').show();
            $('#upload_image').show();
            $('#avatar-updater').hide();
        });

        $('#crop_image_btn').on('click', function(ev) {

            resize.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function(img) {
                // html = '<img src="' + img + '" />';
                console.log(img.size);
                $("#upload_image").attr("src", img);
                $("#cropedImage").val(img);

                $('#avatar-holder').show();
                $('#upload_image').show();
                $('#avatar-updater').hide();
            });
        });

        var types = 1;
        var markerFlag = false;
        mapboxgl.accessToken = 'pk.eyJ1IjoiYmFuemFhciIsImEiOiJ4akIxdlZBIn0.D431j0UB6ko4pLzO7P8edw';

        function togglemap() {
            if (types == 1) {
                map.setStyle('mapbox://styles/mapbox/satellite-v9')
                types = 2;
            } else {
                map.setStyle('mapbox://styles/mapbox/streets-v11')
                types = 1;
            }

        }

        function setStreetMap() {
            var bounds = map.getBounds().toArray()
            bounds = [bounds[0][0], bounds[0][1], bounds[1][0], bounds[1][1]]

            var size = [100, 100];

            var vp = geoViewport.viewport(bounds, size, 0, 24, 512);
            document.getElementById('preview').src = 'https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/' + vp
                .center.join(',') + ',' + vp.zoom + ',0,0/' + size.join('x') + '?' +
                'attribution=false&logo=false&access_token=' + mapboxgl.accessToken;
        }

        function setMapPreview() {
            var bounds = map.getBounds().toArray()
            bounds = [bounds[0][0], bounds[0][1], bounds[1][0], bounds[1][1]]

            var size = [100, 100];

            var vp = geoViewport.viewport(bounds, size, 0, 24, 512);
            document.getElementById('preview').src = 'https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/' + vp
                .center.join(',') + ',' + vp.zoom + ',0,0/' + size.join('x') + '?' +
                'attribution=false&logo=false&access_token=' + mapboxgl.accessToken;
        }
        

        var map = new mapboxgl.Map({
            container: 'tree-map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-77.034084142948, 38.909671288923],
            zoom: 13,
            scrollZoom: true
        });

        navigator.geolocation.getCurrentPosition(position => {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
                if (marker) marker.remove();
                marker = new mapboxgl.Marker({
                        draggable: true,
                        color: "#FA7A35"
                    })
                    .setLngLat({
                        lng: position.coords.longitude,
                        lat: position.coords.latitude
                    })
                    .addTo(map);

                //   markerFlag = true;
                marker.on("dragend", function(e) {
                    console.log(e);
                    document.getElementById("latitude").value = e.target._lngLat.lat;
                    document.getElementById("longitude").value = e.target._lngLat.lng;
                })

                // map.setCenter([position.coords.longitude, position.coords.latitude])
            });
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

        map.on('load', function() {
          if (types == 1) {
                    setMapPreview()
                } else {
                    setStreetMap();
                }
                map.addControl(
                    new MapboxGeocoder({
                        accessToken: mapboxgl.accessToken,
                        mapboxgl: mapboxgl
                    })
                );
                map.addControl(new mapboxgl.NavigationControl());

           
        })
        

    </script>
    <script src="{{ asset('custom/trees/tree.js') }}"></script>
@endsection
