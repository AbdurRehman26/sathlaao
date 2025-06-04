<?php

namespace App\Filament\Resources\DeliveryRequestResource\Pages;

use App\Filament\Resources\DeliveryRequestResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\DeliveryRequestMethods;

class ListDeliveryRequests extends ListRecords
{
    use DeliveryRequestMethods;

    protected static string $resource = DeliveryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->createDeliveryRequestAction()
        ];
    }
}
