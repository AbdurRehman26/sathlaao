<?php

namespace App\Filament\Resources\TravelResource\Pages;

use App\Filament\Resources\TravelResource;
use App\Filament\Traits\TravelMethods;
use Filament\Resources\Pages\ListRecords;

class ListTravel extends ListRecords
{
    use TravelMethods;

    protected static string $resource = TravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->createTravelAction()
        ];
    }
}
