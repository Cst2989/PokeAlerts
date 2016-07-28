@extends('layouts.app')

@section('content')
<style>
 html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

input[type="radio"]{
  width: 20px;
  height: 20px;
  display: block;
  margin:auto;
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
        <div class="panel-heading">Add Alert</div>

        <div class="panel-body">
         <!-- Display Validation Errors -->
         @include('common.errors')
         <!-- New Alert Form -->
         <form action="{{ url('addAlert') }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}
          <!-- Alert Name -->
          <br><br>
          <div class="form-group">
            <label for="city" class="col-sm-3 control-label">City</label>
            <div class="col-sm-6">
              <input type="text" name="city" id="city" value="" class="form-control">
            </div>
          </div>
        
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
            <input type="radio" id="pokids_{{ $pokemon->id }}" name="pokemon_id" value="{{ $pokemon->id }}">
          </div>
          @endforeach
        </div>
        <!-- Add Alert Button -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
              <i class="fa fa-plus"></i> Add Alert
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

  @endsection
