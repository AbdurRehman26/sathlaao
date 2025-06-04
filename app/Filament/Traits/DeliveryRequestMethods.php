<?php

namespace App\Filament\Traits;

use App\Models\Country;
use App\Models\DeliveryRequestProduct;
use App\Models\Product;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

trait DeliveryRequestMethods
{
    public function createDeliveryRequestAction(): CreateAction
    {
        return CreateAction::make()->label('Add Delivery Request')
            ->form([
                Toggle::make('add_product')->reactive()->default(true),
                Section::make('Product Information')
                    ->visible(fn($get) => $get('add_product'))
                    ->schema([
                        TextInput::make('product_name')->required(),
                        TextInput::make('product_description')->required(),
                        TextInput::make('product_link')->url()->required(),
                        Fieldset::make()->schema(
                            [
                                TextInput::make('store_name')->required(),
                                TextInput::make('store_location')->required(),
                            ]
                        )->label('Store Information'),
                    ]),
                Section::make('Delivery Request Information')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                TextInput::make('delivery_price')->label('Price with currency - willing to pay (Approx.)')->required(),
                                TextInput::make('delivery_weight')->required()->label('Delivery Weight (Approx.)'),
                            ])->columnSpan(1),
                        TextInput::make('delivery_note')->required()->columnSpan(2),
                        TextInput::make('delivery_location')->label('Delivery Location (city, area etc)')->required()->columnSpan(2),
                        Select::make('delivery_country')->options(
                            Country::all()->pluck('name', 'id')->toArray()
                        )->searchable()->required(),
                        Fieldset::make('Dates between you want your package')->schema([
                            DateTimePicker::make('preferred_delivery_date')->label('Delivery Date (Min.)')->required(),
                            DateTimePicker::make('delivery_deadline')->label('Delivery Date (Max.)')->required(),
                        ])->columnSpan(2)
                    ])
            ])
            ->slideOver()
            ->createAnother(false)
            ->action(function (array $data) {

                if($data['add_product'] ?? false) {
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
                }


                // Assuming you have a DeliveryRequest model
                $deliveryRequest =  \App\Models\DeliveryRequest::query()->create(
                    array_merge(
                        [
                            'product_id' => isset($product) ? $product->id : null,
                            ...$data
                        ],
                        [
                            'user_id' => auth()->user()->id // Assuming the user is authenticated
                        ]
                    )
                );

                if(! empty($product)){
                    DeliveryRequestProduct::query()->create([
                        'delivery_request_id' => $deliveryRequest->id,
                        'product_id' => $product->id,
                    ]);
                }

                // Optionally, you can add a notification here
                \Filament\Notifications\Notification::make()
                    ->title('Delivery Request Added')
                    ->body('Your delivery request has been successfully added.')
                    ->success()
                    ->send();
            });
    }
}
