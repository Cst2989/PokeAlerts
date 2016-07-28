@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">

          @foreach ($alerts as $alert)
          <?php
          
          $alerted_pokemon = $pokemons->filter(function($item) {
            return $item->id == 1;
          })->first();
          ?>
          <div class="col-md-2 col-sm-3 col-xs-12">
            <div class="pokemon">{{ $alerted_pokemon->name }}</div>
            <div class="location">{{ $alert->city }}</div>
            <form action="{{ url('my-alerts') }}/{{ $alert->id }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              
              <button class="btn btn-danger">Delete Task</button>
            </form>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
