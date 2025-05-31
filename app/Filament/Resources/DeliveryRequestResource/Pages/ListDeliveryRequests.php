<?php

namespace App\Filament\Resources\DeliveryRequestResource\Pages;

use App\Filament\Resources\DeliveryRequestResource;
use App\Models\DeliveryRequestProduct;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryRequests extends ListRecords
{
    protected static string $resource = DeliveryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add Delivery Request')
                ->slideOver()
                ->createAnother(false)
                ->action(function (array $data) {

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

                    // Optionally, you can add a notification here
                    \Filament\Notifications\Notification::make()
                        ->title('Delivery Request Added')
                        ->body('Your delivery request has been successfully added.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
