<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyDeliveryRequestResource\Pages;
use App\Filament\Resources\MyDeliveryRequestResource\Pages\MyDeliveryRequestRelationManager;
use App\Models\DeliveryRequest;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MyDeliveryRequestResource extends Resource
{
    protected static ?string $model = DeliveryRequest::class;

    protected static ?string $navigationLabel = 'My Delivery Requests';

    protected static ?string $navigationIcon = 'fas-truck-fast';

    public static function table(Table $table): Table
    {
        return $table
            ->query(DeliveryRequest::with('matches')->where('user_id', auth()->user()->id))
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Delivery Info')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('delivery_location')->label('Location'),
                            TextEntry::make('deliveryCountry.name')->label('Country'),
                            TextEntry::make('preferred_delivery_date')->label('Preferred Date')->date(),
                            TextEntry::make('delivery_deadline')->label('Deadline')->date(),
                            TextEntry::make('status')->badge()->color(fn (string $state) => match ($state) {
                                'pending' => 'warning',
                                'active' => 'success',
                                'banned' => 'danger',
                                default => 'gray',
                            }),
                            TextEntry::make('created_at')->label('Created')->since(),
                        ]),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyDeliveryRequests::route('/'),
            'view' => Pages\ViewMyDeliveryRequest::route('/{record}'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            MyDeliveryRequestRelationManager::class
        ];
    }
}
