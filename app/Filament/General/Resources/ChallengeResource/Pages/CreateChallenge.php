<?php

namespace App\Filament\General\Resources\ChallengeResource\Pages;

use App\Filament\General\Resources\ChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateChallenge extends CreateRecord
{
    protected static string $resource = ChallengeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
