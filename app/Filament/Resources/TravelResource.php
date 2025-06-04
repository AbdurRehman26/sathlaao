<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TravelResource\Pages;
use App\Models\Country;
use App\Models\DeliveryMatch;
use App\Models\DeliveryRequestProduct;
use App\Models\Product;
use App\Models\Travel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                ])->space(3),
            ])->actions([
                Tables\Actions\Action::make('add_delivery_request')
                    ->hidden(fn($record) => $record->user_id !== auth()->id())
                    ->label('Add Delivery Request')
                    ->button()
                    ->slideOver()
                    ->icon('heroicon-o-plus-circle')
                    ->form([
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
                    ])->action(function (Travel $record, array $data) {

                        $productData = [
                            'product_name' => $data['product_name'],
                            'product_link' => $data['product_link'],
                            'product_description' => $data['product_description'],
                            'user_id' => auth()->user()->id, // Assuming the user is authenticated
                            'store_name' => $data['store_name'],
                            'store_location' => $data['store_location'],
                            'price' => $data['price'],
                        ];

                        $product = Product::create($productData);

                        // Assuming you have a DeliveryRequest model
                        $deliveryRequest =  \App\Models\DeliveryRequest::query()->create(
                            array_merge(
                                [
                                    'product_id' => $product->id,
                                    ...$data
                                ],
                                [
                                    'user_id' => auth()->user()->id // Assuming the user is authenticated
                                ]
                            )
                        );

                        DeliveryRequestProduct::query()->create([
                            'delivery_request_id' => $deliveryRequest->id,
                            'product_id' => $product->id,
                        ]);

                        DeliveryMatch::query()->create([
                            'travel_id' => $record->id,
                            'delivery_request_id' => $deliveryRequest->id,
                            'user_id' => auth()->id(),
                        ]);

                        // Optionally, you can add a notification here
                        \Filament\Notifications\Notification::make()
                            ->title('Delivery Request Added')
                            ->body('Your delivery request has been successfully added.')
                            ->success()
                            ->send();

                    })
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravel::route('/')
        ];
    }
}
