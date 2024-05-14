<?php

namespace App\Filament\Resources\InstanceTypeResource\Pages;

use App\Filament\Resources\InstanceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInstanceTypes extends ManageRecords
{
    protected static string $resource = InstanceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
