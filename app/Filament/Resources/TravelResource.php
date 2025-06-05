<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TravelResource\Pages;
use App\Models\Country;
use App\Models\DeliveryMatch;
use App\Models\DeliveryRequestProduct;
use App\Models\Product;
use App\Models\Travel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class TravelResource extends Resource
{
    protected static ?string $model = Travel::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravel::route('/')
        ];
    }
}
