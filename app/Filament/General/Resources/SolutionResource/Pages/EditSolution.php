<?php

namespace App\Filament\General\Resources\SolutionResource\Pages;

use App\Filament\General\Resources\SolutionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolution extends EditRecord
{
    protected static string $resource = SolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
