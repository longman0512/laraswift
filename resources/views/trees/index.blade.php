@extends('layouts.template')

@section('title','My Planted Trees')
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
            <li class="breadcrumb-item active"><a href="/trees">{{__('app.planted_tree')}}</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <section class="content">
    
    @include('layouts.includes.alerts')
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
      {{-- <div class="card">
        <div class="card-body text-center"> --}}
        <a class="add-more" href="/trees/add">{{__('app.add_more')}}</a>
        </div>
      {{-- </div>
      </div> --}}
    </div>

      @foreach($trees as $big_key=>$tree)
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body text-center">
              <div class="row mb-3">
                <div class="col-md-12">
                  <!-- button section start -->
                  <ul class="nav nav-tabs wd-100">
                    <li class="nav-item shadow mb-3 mr-2">
                      <a class="nav-link white" href="/trees/add_more/{{$tree->id}}">{{__('app.add_more_pic_vid')}}</a>
                    </li>
                    <li class="nav-item">
                      <div>
                        @if($tree->share_status == 'public')
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="share{{$big_key}}" id="public{{$big_key}}" onclick="upgradeShareStatus('{{$tree->id}}', 'public')" checked />
                          <label class="form-check-label" for="flexRadioDefault1">{{__('app.public')}}</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="share{{$big_key}}" id="private{{$big_key}}" onclick="upgradeShareStatus('{{$tree->id}}', 'private')" />
                          <label class="form-check-label" for="flexRadioDefault2">{{__('app.private')}}</label>
                        </div>
                        @else
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="share{{$big_key}}" id="public{{$big_key}}" onclick="upgradeShareStatus('{{$tree->id}}', 'public')" />
                          <label class="form-check-label" for="flexRadioDefault1">{{__('app.public')}}</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="share{{$big_key}}" id="private{{$big_key}}" onclick="upgradeShareStatus('{{$tree->id}}', 'private')" checked />
                          <label class="form-check-label" for="flexRadioDefault2">{{__('app.private')}}</label>
                        </div>
                        @endif
                      </div>

                      <input type="hidden" name="share_status" id="share_status" value="public" />
                    </li>
                  </ul>
                  <!-- button section end -->
                </div>
              </div>
              <div class="row">
                <!-- Image/video container start -->
                <div class="col-md-7">
                  <div class="owl-carousel owl-theme">
                    @foreach($tree->trees as $small_key=>$media)
                    @if ( $media->media_type == 'image')
                      <div class="item">
                        <div>
                          <div class="carouse-caption">{{$media->created_at}}</div>
                          <img src="{{asset('uploads/tree/'.$media->media)}}" />
                          <div class="carouse-caption">{{$media->caption}}</div>
                        </div>
                      </div>
                      @elseif ( $media->media_type == 'video')
                      <div class="item-video">
                          <div>
                            <div class="carouse-caption">{{$media->created_at}}</div>
                            <video width="320" height="240" controls>
                              <source src="{{asset('uploads/tree/'.$media->media)}}">
                            </video>
                            <div class="carouse-caption">{{$media->caption}}</div>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>
                <!-- Image/video container End -->
                <!-- Infomation container start -->
                <div class="col-md-5 v-center-column-left">
                  <div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="label-block">{{__('app.tree_variety')}}:</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly value="{{$tree->variety_slug}}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="label-block">{{__('app.quantity')}}:</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly value="{{$tree->quantity}}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="label-block">{{__('app.latitude')}}:</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly value="{{$tree->latitude}}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="">{{__('app.longitude')}}:</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly value="{{$tree->longitude}}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="label-block">{{__('app.earned_coin')}}:</label>
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly value="{{$tree->quantity * 1000}}">
                      </div>
                    </div>

                  </div>
                </div>
                <!-- Information container End -->
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card map-card">
            <div class="card-body">
              <!-- map container start -->
              <div id="map{{$big_key}}" class="map">
              </div>
              <!-- map container end -->
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

</div>
<!-- /.content-wrapper -->
<script>
  var trees = {!! !empty($trees) ? json_encode($trees) : "[]"!!}
</script>
@endsection
@section('script')
<script>
  function upgradeShareStatus(id, status) {
    console.log(id, status);
    $.ajax({
      url: '/trees/updateShareStatus',
      type: 'POST',
      data: {
        id: id,
        status: status,
        _token: '{{ csrf_token() }}'
      },
      success: function(res) {
        notify('Status is updated', 'success');
      },
      error: function(err) {
        notify('Something wrong, Please try again', 'error');
      }
    })
  }

  function addMap(latitude, longitude, id) {
    var markerFlag = false;
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmFuemFhciIsImEiOiJ4akIxdlZBIn0.D431j0UB6ko4pLzO7P8edw';

    var map = new mapboxgl.Map({
      container: 'map' + id,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [longitude, latitude],
      zoom: 13,
      scrollZoom: true
    });

    var marker = "";
    marker = new mapboxgl.Marker({
        color: "#FA7A35"
      })
      .setLngLat({
        lat: latitude,
        lng: longitude
      })
      .addTo(map);
  }
  $(document).ready(function() {
    console.log(trees);
    for (var i = 0; i < trees.length; i++) {
      addMap(Number(trees[i].latitude), Number(trees[i].longitude), i)
    }
  });
  $('.owl-carousel').owlCarousel({
    items: 1,
    nav:1,
    dots:0,
    loop: true,
    margin: 10,
    video: true,
    lazyLoad: true,
    center: true,
  })
</script>
@endsection