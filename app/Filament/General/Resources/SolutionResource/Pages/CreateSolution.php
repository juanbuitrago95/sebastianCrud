<?php

namespace App\Filament\General\Resources\SolutionResource\Pages;

use App\Filament\General\Resources\SolutionResource;
use App\Models\Challenge;
use App\Models\Solution;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSolution extends CreateRecord
{
    protected static string $resource = SolutionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function mount(): void
    {
        parent::mount();

        $Challenge = Challenge::orderBy('id', 'asc')->first();
        if (is_null($Challenge)) {
            Notification::make()
                ->title('No hay retos disponibles para ti.')
                ->body('Es necesario agregar al menos un reto para crear una solución.')
                ->danger()
                ->send();

            redirect()->to(url()->previous());

            return;
        }
        $Solution = Solution::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        if (!is_null($Solution)) {
            $Challenge = $Challenge::where('id', '>', $Solution->challenge_id)
                ->orderBy('id', 'asc')->first();
            if (is_null($Challenge)) {
                Notification::make()
                    ->title('No hay retos disponibles para ti.')
                    ->body('Es necesario crear más retos para agregar más soluciones.')
                    ->danger()
                    ->send();

                redirect()->to(url()->previous());

                return;
            }
        }

        $this->form->fill([
            'challenge_id' => $Challenge->id,
        ]);
    }
}
