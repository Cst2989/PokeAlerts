@extends('layouts.app')

@section('content')
<style>
 html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
#map {
  width: 100%;
  height: 400px;
}
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}
a i{
  float: right;
}
.panel-title a{
  display: block;
  width: 100%;
}
input[type="radio"]{
  width: 20px;
  height: 20px;
  display: block;
  margin:auto;
}
.panel-collapse{
  padding-left: 15px;
  padding-right: 15px;
}
#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

.pokemon_box .pokemon_image{
  position: relative;;
  display: block;
  width: 100%;
  height: auto;
}
.pokemon_box {
  border-bottom: 1px solid #ccc;
  position: relative;;
  display: block;
  margin-top: 20px;
  padding-bottom: 20px;
}
.pokemon_box .pokemon_rarity {
  text-align: center;
}
.pokemon_box .pokemon_rarity.uncommon{

}
.pokemon_box .pokemon_rarity.ununcommon{
  color:#7dafd2;
}
.pokemon_box .pokemon_rarity.rare{
  color:#a8a8ce;
}
.pokemon_box .pokemon_rarity.very{
  color:#85b180;
}
.pokemon_box .pokemon_rarity.special{
  color:#f5e283;
}
.pokemon_box .pokemon_rarity.epic{
  color:#d36b6a;
}
.pokemon_box .pokemon_rarity.myths{
  color:#6c9fb2;
}
.pokemon_box .pokemon_name{
  font-size: 24px;
  text-align: center;
  height: 68px;
}
.pokemon_box .pokemon_image img{
  max-width: 100%;
}
#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
#target {
  width: 345px;
}
</style>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Add Pokemon Location</div>

        <div class="panel-body">
         <!-- Display Validation Errors -->
         @include('common.errors')
         <!-- New Task Form -->
         <form action="{{ url('addLocation') }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}
          <input id="pac-input" name="location" class="controls" type="text" placeholder="Search Box">
          <div id="map"></div>
          <!-- Task Name -->
          <br><br>
          <div class="form-group">
            <label for="city" class="col-sm-3 control-label">City</label>
            <div class="col-sm-6">
              <input type="text" name="city" id="city" value="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="location_title" class="col-sm-3 control-label">Location</label>
            <div class="col-sm-6">
              <input type="text" name="location_title" id="location_title" class="form-control">
            </div>
          </div>
          <input type="hidden" id="lat" name="lat" value="">
          <input type="hidden" id="lang" name="lang" value="">
          <div class="form-group">
            <?php
            $path = url('/', $parameters = array(), $secure = null);
            ?>
            @foreach ($pokemons as $pokemon)
            <div class="col-md-2 col-sm-3 col-xs-12 pokemon_box">
             <label for="pokids_{{ $pokemon->id }}">
              <div class="pokemon_name">{{ $pokemon->name }}</div>
              <div class="pokemon_image"><img src="{{$path}}/images/{{ $pokemon->filename }}.jpg" /></div>
              <div class="pokemon_rarity {{ $pokemon->rarity }}">{{ $pokemon->rarity }}</div>
            </label>
            <input type="radio" id="pokids_{{ $pokemon->id }}" name="pokemon_ids" value="{{ $pokemon->id }}">
          </div>
          @endforeach
        </div>
        <!-- Add Task Button -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
              <i class="fa fa-plus"></i> Add Pokemon Location
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<script>
  function initMap() {
    var mapDiv = document.getElementById('map');
    var map = new google.maps.Map(mapDiv, {
      center: {lat: 44.540, lng: -78.546},
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function (position) {
       initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
       map.setCenter(initialLocation);
       //console.log(position.coords.latitude);
     });
   }
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          console.log(places);
          var city = places[0].vicinity;
          var location  = places[0].name + " " + places[0].formatted_address;
          document.getElementById('location_title').value = location;
          document.getElementById('city').value = city;
          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));
            var lat = place.geometry.location.lat();
            var lang = place.geometry.location.lng();
            document.getElementById('lang').value = lang;
            document.getElementById('lat').value = lat;
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbIhQwV_ZhEvJGaXHFRr6uh5jGgIYUokY&libraries=places&callback=initMap">
  </script>
  @endsection
