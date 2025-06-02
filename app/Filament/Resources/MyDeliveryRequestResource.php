<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyDeliveryRequestResource\Pages;
use App\Models\DeliveryRequest;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MyDeliveryRequestResource extends Resource
{
    protected static ?string $model = DeliveryRequest::class;

    protected static ?string $navigationLabel = 'My Delivery Requests';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
    }

    protected static ?string $navigationIcon = 'fas-truck-fast';

    public static function table(Table $table): Table
    {
        return $table
            ->query(DeliveryRequest::with('matches'))
            ->columns([
                TextColumn::make('delivery_location'),
                TextColumn::make('deliveryCountry.name')->label('Country'),
                TextColumn::make('preferred_delivery_date')->label('Delivery Date')->date(),
                TextColumn::make('delivery_deadline')->label('Delivery Deadline')->date(),
                TextColumn::make('matches_count')
                    ->label('Matches')
                    ->counts('matches')
                    ->badge(),
            ])->recordUrl(fn(DeliveryRequest $record) => MyDeliveryRequestResource::getUrl('view', [
                'record' => $record->id,
            ]));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyDeliveryRequests::route('/'),
            'view' => Pages\ViewMyDeliveryRequest::route('/{record}'),
        ];
    }
}
