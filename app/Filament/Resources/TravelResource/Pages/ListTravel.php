<?php

namespace App\Filament\Resources\TravelResource\Pages;

use App\Filament\Resources\TravelResource;
use App\Filament\Traits\DeliveryRequestMethods;
use App\Filament\Traits\TravelMethods;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListTravel extends ListRecords
{
    use TravelMethods, DeliveryRequestMethods;

    protected static string $resource = TravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->createTravelAction()
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->size('lg')
                    ->label('Traveler')
                    ->icon('heroicon-o-user-circle')->extraAttributes([
                        'class' => 'mb-4 font-bold',
                    ]),
                Stack::make([
                    Split::make([
                        TextColumn::make('from_location')
                            ->icon('fas-plane-departure')
                            ->label('From Location'),
                        TextColumn::make('fromCountry.name')
                            ->icon('heroicon-o-globe-americas')
                            ->label('From Country'),
                    ]),
                    Split::make([
                        TextColumn::make('to_location')
                            ->icon('fas-plane-arrival')
                            ->label('To Location'),
                        TextColumn::make('toCountry.name')
                            ->icon('heroicon-o-globe-asia-australia')
                            ->label('To Country'),
                    ]),

                    Split::make([
                        TextColumn::make('departure_date')
                            ->dateTime()
                            ->label('Departure Date'),
                        TextColumn::make('arrival_date')
                            ->dateTime()
                            ->label('Arrival Date'),
                    ]),

                    Split::make([
                        TextColumn::make('weight_available')->suffix('kg')
                            ->size('lg')->label('Available Weight'),
                        TextColumn::make('weight_price'),
                    ]),

                    TextColumn::make('matches_count')
                        ->suffix('  delivery request')
                        ->badge()
                        ->color('info')
//                        ->url(fn($record) => TravelResource::getUrl('view', [
//                            'record' => $record->id,
//                        ]))
                        ->counts('matches'),


                    TextColumn::make('airline')
                        ->label('Airline'),
                    TextColumn::make('notes')
                        ->limit(50)
                        ->label('Notes'),
                ])->space(3),
            ])->actions([
                $this->createDeliveryRequestAction(Action::class)->color('info')
                    ->visible(fn ($record) => $record->user_id !== auth()->user()->id || $record->matches()->where('user_id', auth()->user()->id)->doesntExist()),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ]);
    }
}
