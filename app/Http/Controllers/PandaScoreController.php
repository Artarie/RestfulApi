<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class PandaScoreController extends Controller
{
    
  public function getPlayer(Request $request, $player)
  {
    $token = $request->bearerToken();
    if ($token) {
      $client = new Client();
      //Ejemplo Faker, Kanavi, 369
      $response = $client->request('GET', 'https://api.pandascore.co/lol/players?filter[name]=' . $player, [
        'headers' => [
          'accept' => 'application/json',
          'authorization' => 'Bearer KSD9cjzfdPnlbjR7v0SNnYyAYjZQCqepZGfkKcxXLhQZP0kE8hM',
        ],
      ]);

      $result = json_decode($response->getBody());
      return $result;
    } else {
      return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
    }
  }


  public function getChampion(Request $request, $champion)
  {
    $token = $request->bearerToken();
    if ($token) {
      $client = new Client();

      $response = $client->request('GET', 'https://api.pandascore.co/lol/champions', [
        'headers' => [
          'accept' => 'application/json',
          'authorization' => 'Bearer ' . env('API_KEY_PANDASCORE'),
        ],
        'query' => [
          'search[name]' => $champion,
        ],
      ]);

      $result = json_decode($response->getBody());
      return $result;
    } else {
      return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
    }
  }

  public function getWeaponValorant(Request $request, $weapon)
  {
    $token = $request->bearerToken();
    if ($token) {
      $client = new Client();

      $response = $client->request('GET', 'https://api.pandascore.co/valorant/weapons', [
        'headers' => [
          'accept' => 'application/json',
          'authorization' => 'Bearer ' . env('API_KEY_PANDASCORE'),
        ],
        'query' => [
          'search[name]' => $weapon,
        ],
      ]);

      $result = json_decode($response->getBody());
      return $result;
    } else {
      return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
    }
  }


  public function getValorantAgents(Request $request)
  {
    $token = $request->bearerToken();
    if ($token) {
      $client = new Client();

      $response = $client->request('GET', 'https://api.pandascore.co/valorant/agents', [
        'headers' => [
          'accept' => 'application/json',
          'authorization' => 'Bearer ' . env('API_KEY_PANDASCORE'),
        ],

      ]);

      $result = json_decode($response->getBody());
      return $result;
    } else {
      return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
    }
  }
}
