<?php

declare(strict_types=1);

namespace App\Services\Card;

use App\Dto\Serie as SerieDto;
use App\Dto\Weakness;
use App\Repositories\Attack\Attack as AttackRepository;
use App\Dto\Card as CardDto;
use App\Repositories\Subtype\Subtype as SubtypeRepository;
use App\Repositories\Type\Type as TypeRepository;
use App\Interfaces\Services\ICard;
use App\Repositories\Card\Card as CardRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final readonly class Card implements ICard
{
    public function __construct(
        private CardRepository $cardRepository,
        private TypeRepository $typeRepository,
        private SubtypeRepository $subtypeRepository,
        private AttackRepository $attackRepository,
    ){}

    public function create(CardDto $card): CardDto
    {
        $card->types = array_map(function($type) {
            return $this->typeRepository->create($type);
        }, $card->types);

        $card->subtypes = array_map(function($subtype) {
            return $this->subtypeRepository->create($subtype);
        }, $card->subtypes);

        $card->attacks = array_map(function($attack) {
            return $this->attackRepository->create($attack);
        }, $card->attacks);

        $card->weaknesses = array_map(function($weakness) {
            $type = $this->typeRepository->create($weakness->type);
            return new Weakness($type, $weakness->value);
        }, $card->weaknesses);

        $card = $this->handleImage($card);

        return $this->cardRepository->create($card);
    }

    /**
     * @throws Exception
     */
    private function handleImage(CardDto $card): CardDto
    {
        $fileNameBase = Str::slug($card->cardId . ' ' . $card->pokemon->number . ' ' . $card->pokemon->name, '_');
        $directory = 'public/card';
        $path = "$directory/$fileNameBase";

        if ($card->image instanceof UploadedFile) {
            $extension = $card->image->getClientOriginalExtension();
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $path = $card->image->storeAs($directory, "$fileNameBase.$extension");
            }

            $card->image = Storage::url($fullPath);
        } elseif (
            filter_var($card->image, FILTER_VALIDATE_URL)
        ) {
            $extension = pathinfo($card->image, PATHINFO_EXTENSION);
            $fullPath = "$path.$extension";

            if (!Storage::exists($fullPath)) {
                $contents = file_get_contents($card->image);
                Storage::put($fullPath, $contents);
            }

            $card->image = Storage::url($fullPath);
        } elseif (
            $card->image !== null
            && !File::exists(storage_path("app/$directory/" . $card->image))
        ) {
            throw new Exception('The provided image is not a valid file in the storage directory.');
        }

        return $card;
    }
}
