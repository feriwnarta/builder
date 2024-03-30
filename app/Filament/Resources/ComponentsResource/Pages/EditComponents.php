<?php

namespace App\Filament\Resources\ComponentsResource\Pages;

use App\Filament\Resources\ComponentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComponents extends EditRecord
{
    protected static string $resource = ComponentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
