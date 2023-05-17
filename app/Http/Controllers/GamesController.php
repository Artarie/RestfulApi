<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GamesController extends Controller
{
   //RAWG API e5ec46ad09ff4afabe75878ada11ba59
    //Para hacer una consulta va por ID o el nombre en slug Ej, elden-ring, forza-horizon
    public function getGame(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $game = request()->query("game");

            $client = new Client();
            $response = $client->request("GET", "https://api.rawg.io/api/games/" . $game, [
                "query" => [
                    "key" => env('API_KEY_RAWG')
                ]

            ]);

            //json_decode($response->getBody()->getContents());
            $result = json_decode($response->getBody());

            return $result;
        } else {
            return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
    }

    public function getAchievement(Request $request, $game)
    {
        $token = $request->bearerToken();
        if ($token) {
            $client = new Client();
            $response = $client->request("GET", "https://api.rawg.io/api/games/" . $game . "/achievements", [
                "query" => [
                    "key" => env('API_KEY_RAWG')
                ]

            ]);

            //json_decode($response->getBody()->getContents());
            $result = json_decode($response->getBody());

            return $result;
        } else {
            return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
    }


    public function getScreenshot(Request $request, $game)
    {
        $token = $request->bearerToken();
        if ($token) {
            $client = new Client();
            $response = $client->request("GET", "https://api.rawg.io/api/games/" . $game . "/screenshots", [
                "query" => [
                    "key" => env('API_KEY_RAWG')
                ]

            ]);

            //json_decode($response->getBody()->getContents());
            $result = json_decode($response->getBody());

            return $result;
        } else {
            return response()->json(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
    }
}
