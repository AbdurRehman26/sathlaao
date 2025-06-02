<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Pages;

use App\Filament\Resources\MyDeliveryRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListMyDeliveryRequests extends ListRecords
{
    protected static string $resource = MyDeliveryRequestResource::class;

    protected ?string $heading = 'My Delivery Requests';
}
