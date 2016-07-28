<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pokemon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PokemonRepository;

class AlertController extends Controller
{
	protected $pokemons;

    public function __construct(PokemonRepository $pokemons)
    {
        $this->middleware('auth');
         $this->pokemons = $pokemons;
    }

    public function index(Request $request)
    {
        $get_pokemons =  $this->pokemons->getPokemon();
        return view('alert', [
            'pokemons' => $get_pokemons,
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|max:255',
            'pokemon_id' => 'required|max:255',
        ]);

        // Create The Task...
        $request->user()->alerts()->create([
            'city' => $request->city,
            'pokemon_id' => $request->pokemon_id,
        ]);

        return redirect('/alert');
    }
}
