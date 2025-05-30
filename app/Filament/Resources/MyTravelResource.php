<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyTravelResource\Pages;
use App\Models\Country;
use App\Models\Travel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MyTravelResource extends Resource
{
    protected static ?string $model = Travel::class;

    protected static ?string $label = 'My Travel';

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('from_location')
                    ->label('From Location (city, airport etc)')->required(),
                TextInput::make('to_location')
                    ->label('To Location (city, airport etc)')->required(),
                Select::make('from_country')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->label('From Country')->required(),
                Select::make('to_country')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->label('To Country')->required(),
                DateTimePicker::make('departure_date')
                    ->label('Departure Date')->required(),
                DateTimePicker::make('arrival_date')
                    ->label('Arrival Date')->required(),
                TextInput::make('airline')
                    ->label('Airline (optional)'),
                TextInput::make('notes')
                    ->label('Notes (optional)')
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from_location')
                    ->label('From Location'),
                Tables\Columns\TextColumn::make('to_location')
                    ->label('To Location'),
                Tables\Columns\TextColumn::make('fromCountry.name')
                    ->label('From Country'),
                Tables\Columns\TextColumn::make('toCountry.name')
                    ->label('To Country'),
                Tables\Columns\TextColumn::make('departure_date')
                    ->dateTime()
                    ->label('Departure Date'),
                Tables\Columns\TextColumn::make('arrival_date')
                    ->dateTime()
                    ->label('Arrival Date'),
                Tables\Columns\TextColumn::make('airline')
                    ->label('Airline'),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->label('Notes'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyTravel::route('/'),
        ];
    }
}
