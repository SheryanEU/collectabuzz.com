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
        public int $setId,
        public string $cardId,
        public string $name,
        public string $variant,
        public string $supertype,
        public array $subtypes,
        public string $hp,
        public array $types,
        public array $attacks,
        public array $weaknesses,
        public string $rarity,
        public string $artist,
        public string $image
    )
    {

    }

    public static function fromModel(CardModel $card): self
    {
        return new self(
            $card->set_id,
            $card->card_id,
            $card->name,
            $card->variant,
            $card->supertype,
            $card->subtypes,
            $card->hp,
            $card->types,
            $card->attacks,
            $card->weaknesses,
            $card->rarity,
            $card->artist,
            $card->image
        );
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
