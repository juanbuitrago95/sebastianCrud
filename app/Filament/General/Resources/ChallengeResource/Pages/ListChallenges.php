<?php

namespace App\Filament\General\Resources\ChallengeResource\Pages;

use App\Filament\General\Resources\ChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChallenges extends ListRecords
{
    protected static string $resource = ChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
