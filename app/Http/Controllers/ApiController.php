<?php

namespace App\Http\Controllers;

use App\Location;
use App\Pokemon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PokemonRepository;
class ApiController extends Controller
{
     protected $pokemons;


    public function __construct(PokemonRepository $pokemons)
    {
        $this->pokemons = $pokemons;
    }

    public function pokemon(Request $request)
    {
        $get_pokemons =  $this->pokemons->getPokemon();
        return response()->json(json_encode($get_pokemons));
    }
    public function index(Request $request)
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        return response()->json(json_encode($locations));
       
    }
}
