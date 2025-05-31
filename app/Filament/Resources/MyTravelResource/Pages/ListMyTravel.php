<?php

namespace App\Filament\Resources\MyTravelResource\Pages;

use App\Filament\Resources\MyTravelResource;
use App\Models\Travel;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMyTravel extends ListRecords
{
    protected static string $resource = MyTravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->label('Add Travel Information')
                ->createAnother(false)
                ->action(function (array $data) {
                    Travel::query()->create(
                        array_merge(
                            [
                                ...$data
                            ],
                            [
                                'user_id' => auth()->user()->id
                            ]
                        ));

                    Notification::make('Travel Information Added')
                        ->body('Your travel information has been successfully added.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
