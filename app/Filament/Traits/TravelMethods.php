<?php

namespace App\Filament\Traits;

use App\Models\Country;
use App\Models\Travel;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

trait TravelMethods
{
    protected function createTravelAction(): CreateAction
    {
        return
            CreateAction::make()
                ->slideOver()
                ->form([
                    Fieldset::make()->schema([
                        TextInput::make('from_location')
                            ->label('From Location (city, airport etc)')->required(),
                        TextInput::make('to_location')
                            ->label('To Location (city, airport etc)')->required(),
                        Select::make('from_country')
                            ->searchable()
                            ->options(Country::all()->pluck('name', 'id'))
                            ->label('From Country')->required(),
                        Select::make('to_country')
                            ->searchable()
                            ->options(Country::all()->pluck('name', 'id'))
                            ->label('To Country')->required(),
                        DateTimePicker::make('departure_date')
                            ->label('Departure Date')->required(),
                        DateTimePicker::make('arrival_date')
                            ->label('Arrival Date')->required(),
                        TextInput::make('weight_available')->placeholder('Available weight (kg)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('weight_price')->placeholder('Price per kg (optional) with currency'),
                        TextInput::make('airline')
                            ->label('Airline (optional)'),
                        TextInput::make('notes')
                            ->label('Notes (optional)')
                    ]),
                ])
                ->label('Add Travel Information')
                ->createAnother(false)
                ->action(function (array $data) {
                    Travel::query()->create(
                        array_merge(
                            [
                                ...$data
                            ],
                            [
                                'user_id' => auth()->user()->id
                            ]
                        ));

                    Notification::make('Travel Information Added')
                        ->body('Your travel information has been successfully added.')
                        ->success()
                        ->send();
                });
    }
}
