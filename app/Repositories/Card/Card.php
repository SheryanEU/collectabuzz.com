<?php

declare(strict_types=1);

namespace App\Repositories\Card;

use App\Dto\Card as CardDto;
use App\Interfaces\Repositories\ICard;
use App\Models\Attack;
use App\Models\Card as CardModel;
use App\Models\Pokemon;
use App\Models\Set;
use App\Models\Subtype;
use App\Models\Type;

final readonly class Card implements ICard
{

    public function create(CardDto $card): CardDto
    {
        $set = Set::where('set_id', $card->set->setId)->firstOrFail();
        if ($card->pokemonId) {
            $number = Pokemon::where('number', $card->pokemonId)->firstOrFail();
        }

        $cardModel = CardModel::firstOrCreate([
            'set_id' => $set->id,
            'card_id' => $card->cardId,
            'name' => $card->name,
            'variant' => $card->variant,
        ],
        [
            'pokemon_id' => $number->id ?? null,
            'supertype' => $card->supertype,
            'hp' => $card->hp,
            'rarity' => $card->rarity,
            'artist' => $card->artist,
            'thumbnail' => $card->thumbnail,
            'image' => $card->image
        ]);

        $this->attachRelations($cardModel, $card);

        return $cardModel->toDto();
    }

    private function attachRelations(CardModel $cardModel, CardDto $cardDto): void
    {
        $typeIds = array_map(function($typeDto) {
            return Type::where('name', $typeDto->name)->firstOrFail()->id;
        }, $cardDto->types);

        $subtypeIds = array_map(function($subtypeDto) {
            return Subtype::where('name', $subtypeDto->name)->firstOrFail()->id;
        }, $cardDto->subtypes);

        $attackData = array_map(function($attackDto) {
            $attackModel = Attack::where('name', $attackDto->name)
                ->where('converted_energy_cost', $attackDto->convertedEnergyCost)
                ->where('damage', $attackDto->damage)
                ->firstOrFail();

            return [
                'attack_id' => $attackModel->id,
                'cost' => $attackDto->convertedEnergyCost,
            ];
        }, $cardDto->attacks);

        $weaknessData = array_map(function ($weaknessDto) {
            $typeId = Type::where('name', $weaknessDto->type->name)->firstOrFail()->id;
            return [
                'type_id' => $typeId,
                'value' => $weaknessDto->value,
            ];
        }, $cardDto->weaknesses);

        $cardModel->types()->sync($typeIds);
        $cardModel->subtypes()->sync($subtypeIds);
        $cardModel->attacks()->sync($attackData);
        $cardModel->weaknesses()->sync($weaknessData);
    }
}
