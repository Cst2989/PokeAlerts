<?php

namespace App\Http\Controllers;

use App\Location;
use App\Http\Requests;
use App\Pokemon;
use Illuminate\Http\Request;
use App\Repositories\PokemonRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    protected $pokemons;


    public function __construct(PokemonRepository $pokemons)
    {
        $this->middleware('auth');
        $this->pokemons = $pokemons;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $get_pokemons =  $this->pokemons->getPokemon();
        $locations = Location::orderBy('created_at', 'desc')->get();
        return view('home', [
        'locations' => $locations,
        'pokemons' => $get_pokemons
    ]);
    }
}
