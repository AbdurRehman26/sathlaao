<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Pages;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MyDeliveryRequestRelationManager extends RelationManager
{
    protected static string $relationship = 'matches';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->recordTitleAttribute('reviewId')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('travel.toCountry.name'),
                TextColumn::make('travel.fromCountry.name'),
                TextColumn::make('travel.from_location'),
                TextColumn::make('travel.to_location'),
                TextColumn::make('travel.arrival_date'),
                TextColumn::make('travel.airline'),
                TextColumn::make('travel.notes'),
                TextColumn::make('travel.user.name'),
                TextColumn::make('status')->badge(),
            ])->actions([
                Action::make('delete')
                    ->label('Delete')
                    ->visible(fn($record) => $record->user_id == auth()->id())
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->delete())
                    ->icon('heroicon-o-x-circle')
                    ->color('danger'),
                Action::make('approve')
                    ->label('Approve')
                    ->visible(fn($record) => $record->user_id != auth()->id())
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->approve())
                    ->icon('heroicon-o-check-circle')
                    ->color('primary'),
                Action::make('reject')
                    ->label('Reject')
                    ->visible(fn($record) => $record->user_id != auth()->id())
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->rejected())
                    ->icon('heroicon-o-x-circle')
                    ->color('danger'),
            ]);
    }
}
