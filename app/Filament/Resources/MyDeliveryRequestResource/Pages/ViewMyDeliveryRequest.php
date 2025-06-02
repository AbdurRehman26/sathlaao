<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Pages;

use App\Filament\Resources\MyDeliveryRequestResource;
use App\Filament\Resources\MyDeliveryRequestResource\Widgets\DeliveryMatchesWidget;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewMyDeliveryRequest extends ViewRecord
{
    protected static string $resource = MyDeliveryRequestResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Delivery Info')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('delivery_location')->label('Location'),
                            TextEntry::make('deliveryCountry.name')->label('Country'),
                            TextEntry::make('preferred_delivery_date')->label('Preferred Date')->date(),
                            TextEntry::make('delivery_deadline')->label('Deadline')->date(),
                            TextEntry::make('status')->badge()->color(fn (string $state) => match ($state) {
                                'pending' => 'warning',
                                'active' => 'success',
                                'banned' => 'danger',
                                default => 'gray',
                            }),
                            TextEntry::make('created_at')->label('Created')->since(),
                        ]),
                    ]),
            ]);
    }

    protected function getFooterWidgets(): array
    {
        return [
            DeliveryMatchesWidget::class
        ];
    }
}
