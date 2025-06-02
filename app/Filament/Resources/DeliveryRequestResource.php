<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryRequestResource\Pages;
use App\Models\Country;
use App\Models\DeliveryMatch;
use App\Models\DeliveryRequest;
use App\Models\Travel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DeliveryRequestResource extends Resource
{
    protected static ?string $model = DeliveryRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('myMatch');
    }

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
            ])
            ->actions([
                Action::make('i_can_bring')
                    ->label('I can bring')
                    ->icon('heroicon-o-hand-raised')
                    ->color('success')
                    ->form([
                            Select::make('travel_id')
                                ->label('Select Travel')
                                ->options(Travel::query()
                                        ->where('user_id', auth()->id())
                                        ->get()
                                        ->mapWithKeys(function ($record) {
                                            return [
                                                $record->id => "{$record->from_location}, {$record->fromCountry->name} to {$record->to_location}, {$record->toCountry->name} \n ( Departure: {$record->departure_date}) - ( Departure: {$record->arrival_date})"
                                            ];
                                        })->toArray(),
                                )
                                ->searchable(),
                            TextInput::make('message')
                                ->label('Additional Information')
                                ->placeholder('Any additional information you want to provide'),
                        ])
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Delivery Request')
                    ->modalSubheading('Are you sure you want to opt for bringing this delivery?')
                    ->modalButton('Yes, I can bring it')
                    ->action(function (array $data, DeliveryRequest $record) {

                        DeliveryMatch::query()->create([
                            'travel_id' => $data['travel_id'],
                            'delivery_request_id' => $record->id,
                            'message' => $data['message'] ?? '',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Your Delivery Request is Created')
                            ->body('Your delivery request has been successfully created.')
                            ->success()
                            ->send();
                    })

            ])
            ->contentGrid([
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
