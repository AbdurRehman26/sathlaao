<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Widgets;

use App\Models\DeliveryMatch;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class DeliveryMatchesWidget extends TableWidget
{
    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table->query(
            DeliveryMatch::query()->latest()
        )->columns([
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
            Action::make('approve')
                ->label('Approve')
                ->requiresConfirmation()
                ->icon('heroicon-o-check-circle')
                ->color('primary'),
            Action::make('reject')
                ->label('Reject')
                ->requiresConfirmation()
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ]);
    }
}
