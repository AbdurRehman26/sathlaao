<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryRequestResource\Pages;
use App\Models\Country;
use App\Models\DeliveryRequest;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryRequestResource extends Resource
{
    protected static ?string $model = DeliveryRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        TextInput::make('product_name')->required(),
                        TextInput::make('product_description')->required(),
                        TextInput::make('product_link')->url()->required(),
                        TextInput::make('price')->label('Price (approx)')->required(),
                        Fieldset::make()->schema(
                            [
                                TextInput::make('store_name')->required(),
                                TextInput::make('store_location')->required(),
                            ]
                        )->label('Store Information'),
                    ]),
                Section::make('Delivery Information')
                    ->schema([
                        TextInput::make('delivery_location')->required(),
                        Select::make('delivery_country')->options(
                            Country::all()->pluck('name', 'id')->toArray()
                        )->required(),
                        Fieldset::make()->schema([
                            DateTimePicker::make('preferred_delivery_date')->label('Delivery Date (Min.)')->required(),
                            DateTimePicker::make('delivery_deadline')->label('Delivery Date (Max.)')->required(),
                        ])->columnSpan(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ViewColumn::make('profile_card')
                        ->view('filament.cards.delivery-request'),
                ])
            ])->contentGrid([
                'md' => 3,
                'xl' => 3,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryRequests::route('/'),
        ];
    }
}
