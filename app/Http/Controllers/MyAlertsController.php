<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pokemon;
use App\Alert;
use App\Repositories\PokemonRepository;
class MyAlertsController extends Controller
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
		$alerts = Alert::where('user_id', $request->user()->id)->get();
		return view('alerts', [
			'alerts' => $alerts,
			'pokemons' => $get_pokemons
			]);
	}
	public function destroy(Request $request, Alert $alert)
	{
		
    	$this->authorize('destroy', $alert);
    	$alert->delete();
    	return redirect('/my-alerts');
	}
}
