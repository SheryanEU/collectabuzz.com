<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Card as CardModel;
use App\Models\Set as SetModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class Card
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public Set         $set,
        public string      $cardId,
        public Pokemon     $pokemon,
        public string      $variant,
        public string      $supertype,
        public ?string     $hp,
        public ?string     $rarity,
        public ?string     $artist,
        public ?array     $image,
        /** @var Type[] $types */
        public array $types,
        /** @var Subtype[] $subtypes */
        public array $subtypes,
        /** @var Attack[] $attacks */
        public array $attacks,
        /** @var Weakness[] $weaknesses */
        public array $weaknesses
    ) {
        foreach ($this->types as $type) {
            if (!$type instanceof Type) {
                throw new \InvalidArgumentException('Expected an array of Type instances');
            }
        }

        foreach ($this->subtypes as $subtype) {
            if (!$subtype instanceof Subtype) {
                throw new \InvalidArgumentException('Expected an array of Subtype instances');
            }
        }

        foreach ($this->attacks as $attack) {
            if (!$attack instanceof Attack) {
                throw new \InvalidArgumentException('Expected an array of Attack instances');
            }
        }

        foreach ($this->weaknesses as $weakness) {
            if (!$weakness instanceof Weakness) {
                throw new \InvalidArgumentException('Expected an array of Weakness instances');
            }
        }
    }

    public static function fromModel(CardModel $card): self
    {
        return new self(
            Set::fromModel(
                $card->set
            ),
            $card->card_id,
            Pokemon::fromModel(
                $card->pokemon
            ),
            $card->variant,
            $card->supertype,
            $card->hp,
            $card->rarity,
            $card->artist,
            $card->image,
            $card->types->map(fn($type) => Type::fromModel($type))->toArray(),
            $card->subtypes->map(fn($subtype) => Subtype::fromModel($subtype))->toArray(),
            $card->attacks->map(fn($attack) => Attack::fromModel($attack))->toArray(),
            $card->weaknesses->map(fn($weakness) => Weakness::fromArray(['type' => Type::fromModel($weakness), 'value' => $weakness->pivot->value]))->toArray(),
        );
    }

    public function toArray(): array
    {
        return [
            'set' => $this->set->toArray(),
            'cardId' => $this->cardId,
            'pokemon' => $this->pokemon->toArray(),
            'variant' => $this->variant,
            'supertype' => $this->supertype,
            'hp' => $this->hp,
            'rarity' => $this->rarity,
            'artist' => $this->artist,
            'image' => $this->image,
            'types' => array_map(fn($type) => $type->toArray(), $this->types),
            'subtypes' => array_map(fn($subtype) => $subtype->toArray(), $this->subtypes),
            'attacks' => array_map(fn($attack) => $attack->toArray(), $this->attacks),
            'weaknesses' => array_map(fn($weakness) => $weakness->toArray(), $this->weaknesses)
        ];
    }
}
