<?php

namespace App\Filament\General\Resources;

use App\Filament\General\Resources\SolutionResource\Pages;
use App\Filament\General\Resources\SolutionResource\RelationManagers;
use App\Models\Challenge;
use App\Models\Solution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static ?string $modelLabel = 'Solución';
    protected static ?string $pluralModelLabel = 'Soluciones propuestas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('challenge_id')
                    ->label('Reto')
                    ->options(function () {
                        return Challenge::pluck('name', 'id');
                    })
                    // ->default(function ($livewire) {
                    //     if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                    //         $user_id = Auth::user()->id;
                    //         $Challenge = Challenge::orderBy('id', 'asc');
                    //         // if (is_null($Challenge)) {
                    //         //     dd('Es necesario agregar al menos un reto para crear una solución');
                    //         // }

                    //         $Solution = Solution::where('user_id', $user_id)->orderBy('id', 'desc')->first();
                    //         if (!is_null($Solution)) {
                    //             $Challenge = $Challenge->where('id', '>', $Solution->challenge_id);

                    //             // if (is_null($Challenge)) {
                    //             //     dd('Es necesario crear más retos para agregar más soluciones');
                    //             // }
                    //         }

                    //         $Challenge = $Challenge->first();

                    //         return $Challenge->id;
                    //     }
                    //     return null;
                    // })
                    ->disabled()
                    ->dehydrated(
                        fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord
                    )
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('challenge.name')
                    ->label('Reto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Solución propuesta')
                    ->html()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolutions::route('/'),
            'create' => Pages\CreateSolution::route('/create'),
            'edit' => Pages\EditSolution::route('/{record}/edit'),
        ];
    }
}
