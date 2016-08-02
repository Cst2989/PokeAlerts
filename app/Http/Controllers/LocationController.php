<?php

namespace App\Http\Controllers;

use Mail;
use App\Location;
use App\Alert;
use App\User;
use App\Pokemon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PokemonRepository;

class LocationController extends Controller
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
        return view('location', [
            'pokemons' => $get_pokemons,
            ]);
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'location_title' => 'required|max:255',
            'city' => 'required|max:255',
            'lat' => 'required|max:255',
            'lang' => 'required|max:255',
            'pokemon_ids' => 'required|max:255',
            ]);

        // Create The Task...
        $request->user()->locations()->create([
            'location_title' => $request->location_title,
            'city' => $request->city,
            'lat' => $request->lat,
            'lang' => $request->lang,
            'pokemon_ids' => $request->pokemon_ids,
            ]);

        //SEND MAIL TO USERS WHO HAVE ALERTS

        $pokemon = Pokemon::where('id', $request->pokemon_ids)->value('name');
        $pokemon_filename = Pokemon::where('id', $request->pokemon_ids)->value('filename');

        $matchThese = ['pokemon_id' => $request->pokemon_ids, 'city' => 'Iasi'];
        $alerts = Alert::where($matchThese)->get();
        foreach ($alerts as $alert) {

           $email_user = User::where('id', $alert->user_id)->value('email');

         //
         //Add Mailgun when going live
         //
           Mail::send('emails.send', ['pokemon' => $pokemon, 'pokemon_filename' => $pokemon_filename], function ($message) use ($email_user)
           {
            $message->subject("New Pokemon Alert!");
            $message->to($email_user);

            });

       }




       return redirect('/location');
   }
}
