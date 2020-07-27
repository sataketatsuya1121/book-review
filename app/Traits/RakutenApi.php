<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait RakutenApi
{
    public function fetchRakutenApiByIsbn($isbn)
    {
        if (strlen($isbn) !== config('const.isbn_length')) {
            return abort(config('const.abort'));
        }
        $url = config('app.rakuten_api_path') . "?applicationId=" . config('app.rakuten_api_app_id') . "&formatVersion=2&isbn=" . $isbn;
        $client = new Client();
        $response = $client->request('GET', $url);
        if (empty(json_decode($response->getBody(), true)['Items'])) {
            return abort(config('const.abort'));
        }
        return json_decode($response->getBody(), true)['Items'][0];
    }
}
