<?php

namespace App\Filament\Resources\DeliveryRequestResource\Pages;

use App\Filament\Resources\DeliveryRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryRequests extends ListRecords
{
    protected static string $resource = DeliveryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add Delivery Request')
                ->createAnother(false),
        ];
    }
}
