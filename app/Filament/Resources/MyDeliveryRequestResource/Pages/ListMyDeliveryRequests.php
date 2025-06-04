<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Pages;

use App\Filament\Resources\MyDeliveryRequestResource;
use App\Filament\Traits\DeliveryRequestMethods;
use Filament\Resources\Pages\ListRecords;

class ListMyDeliveryRequests extends ListRecords
{
    use DeliveryRequestMethods;

    protected static string $resource = MyDeliveryRequestResource::class;

    protected ?string $heading = 'My Delivery Requests';

    protected function getHeaderActions(): array
    {
        return [
            $this->createDeliveryRequestAction()
        ];
    }
}
