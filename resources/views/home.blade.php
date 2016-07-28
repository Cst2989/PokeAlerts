@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          
          @foreach ($locations as $location)
          <?php
          
          $desired_pokemon = $pokemons->filter(function($item) {
            return $item->id == 1;
          })->first();
          ?>
          <div class="col-md-2 col-sm-3 col-xs-12">
            <div class="pokemon">{{ $desired_pokemon->name }}</div>
            <div class="location">{{ $location->location_title }}</div>
            <div class="city ">{{ $location->city }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
