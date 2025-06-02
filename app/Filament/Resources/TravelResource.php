<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyTravelResource\Pages\ListMyTravel;
use App\Filament\Resources\TravelResource\Pages;
use App\Models\Travel;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class TravelResource extends Resource
{
    protected static ?string $model = Travel::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->size('lg')
                    ->label('Traveler')
                    ->icon('heroicon-o-user-circle'),
                Stack::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('from_location')
                            ->icon('fas-plane-departure')
                            ->label('From Location'),
                        Tables\Columns\TextColumn::make('fromCountry.name')
                            ->icon('heroicon-o-globe-americas')
                            ->label('From Country'),
                    ]),
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('to_location')
                            ->icon('fas-plane-arrival')
                            ->label('To Location'),
                        Tables\Columns\TextColumn::make('toCountry.name')
                            ->icon('heroicon-o-globe-asia-australia')
                            ->label('To Country'),
                    ]),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('departure_date')
                            ->dateTime()
                            ->label('Departure Date'),
                        Tables\Columns\TextColumn::make('arrival_date')
                            ->dateTime()
                            ->label('Arrival Date'),
                    ]),
                    Tables\Columns\TextColumn::make('airline')
                        ->label('Airline'),
                    Tables\Columns\TextColumn::make('notes')
                        ->limit(50)
                        ->label('Notes'),
                ])->space(2)
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravel::route('/'),
            'view' => Pages\ViewTravel::route('/{record}'),
        ];
    }
}
