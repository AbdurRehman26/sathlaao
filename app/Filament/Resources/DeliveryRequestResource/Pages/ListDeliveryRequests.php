<?php

namespace App\Filament\Resources\DeliveryRequestResource\Pages;

use App\Filament\Resources\DeliveryRequestResource;
use App\Filament\Resources\MyDeliveryRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\DeliveryRequestMethods;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ListDeliveryRequests extends ListRecords
{
    use DeliveryRequestMethods;

    protected static string $resource = DeliveryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->createDeliveryRequestAction(CreateAction::class),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ViewColumn::make('profile_card')
                        ->view('filament.cards.delivery-request')
                ]),
            ])
            ->actions([
                $this->iCanBringAction(Action::class),
                Action::make('view_details')
                    ->label('View Details')
                    ->url(fn($record) => MyDeliveryRequestResource::getUrl('view',
                        [
                            'record' => $record]
                    ))
                    ->button()
                    ->color('info'),

            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 3,
            ]);
    }
}
