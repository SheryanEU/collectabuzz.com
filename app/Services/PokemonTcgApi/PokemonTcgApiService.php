<?php

declare(strict_types=1);

namespace App\Services\PokemonTcgApi;

class PokemonTcgApiService
{
    const API_URL = 'https://api.pokemontcg.io/v2/';

    protected string $apiKey;
    protected array $options;
    protected array $cache;

    public function __construct($apiKey = null, $options = [])
    {
        $this->apiKey = $apiKey;
        $this->options = $options;
        $this->cache = [
            'resources' => [],
            'options' => [],
        ];
    }

    public function setApiKey(?string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getCard()
    {
        return $this->getQueriableResource('cards');
    }

    public function getSet()
    {
        return $this->getQueriableResource('sets');
    }

    public function getType()
    {
        return $this->getJsonResource('types');
    }

    public function getSubtype()
    {
        return $this->getJsonResource('subtypes');
    }

    public function getSupertype()
    {
        return $this->getJsonResource('supertypes');
    }

    public function getRarity()
    {
        return $this->getJsonResource('rarities');
    }

    private function getQueriableResource($type)
    {
        if (!array_key_exists($type, $this->cache['resources']) || $this->haveOptionsBeenUpdated($type, $this->options)) {
            $this->cache['options'][$type] = $this->options;
            $this->cache['resources'][$type] = new QueryableResource($type, $this->options, $this->apiKey);
        }
        return $this->cache['resources'][$type];
    }

    private function getJsonResource($type)
    {
        if (!array_key_exists($type, $this->cache['resources']) || $this->haveOptionsBeenUpdated($type, $this->options)) {
            $this->cache['options'][$type] = $this->options;
            $this->cache['resources'][$type] = new JsonResource($type, $this->options, $this->apiKey);
        }
        return $this->cache['resources'][$type];
    }

    private function haveOptionsBeenUpdated($key, array $options = [])
    {
        if (array_key_exists($key, $this->cache)) {
            return ($this->cache[$key] != $options);
        }
        return false;
    }
}
