<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QueryableResource
{
    protected $type;
    protected $options;
    protected $apiKey;

    public function __construct($type, $options, $apiKey)
    {
        $this->type = $type;
        $this->options = $options;
        $this->apiKey = $apiKey;
    }

    public function all()
    {
        $url = PokemonTcgApiService::API_URL . $this->type;
        $response = Http::withHeaders($this->getHeaders())->get($url, $this->options);
        return $response->json();
    }

    public function find($id)
    {
        $url = PokemonTcgApiService::API_URL . $this->type . '/' . $id;
        $response = Http::withHeaders($this->getHeaders())->get($url);
        return $response->json();
    }

    public function search($query)
    {
        $url = PokemonTcgApiService::API_URL . $this->type;
        $response = Http::withHeaders($this->getHeaders())->get($url, $query);
        return $response->json();
    }

    private function getHeaders()
    {
        $headers = [];
        if ($this->apiKey) {
            $headers['X-Api-Key'] = $this->apiKey;
        }
        return $headers;
    }
}
