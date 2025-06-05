<?php

namespace App\Filament\Resources\MyDeliveryRequestResource\Pages;

use App\Filament\Resources\MyDeliveryRequestResource;
use App\Models\DeliveryMatch;
use App\Models\DeliveryRequest;
use App\Models\Travel;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use \App\Filament\Traits\DeliveryRequestMethods;

class ViewMyDeliveryRequest extends ViewRecord
{
    use DeliveryRequestMethods;

    protected static string $resource = MyDeliveryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->createDeliveryRequestAction(CreateAction::class),
            $this->iCanBringAction(\Filament\Actions\Action::class)
        ];
    }

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
                            TextEntry::make('delivery_weight'),
                            TextEntry::make('delivery_price')->label('Price - willing to pay (Approx.)'),
                            TextEntry::make('created_at')->label('Created')->since(),
                        ]),
                    ]),
            ]);
    }
}
