<?php

namespace App\Filament\Resources\TemplatesResource\Pages;

use App\Filament\Resources\TemplatesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTemplates extends CreateRecord
{
    protected static string $resource = TemplatesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $title = $data['title'];
        $subtitle = $data['subtitle'];
        $thumbnail = $data['thumbnail'];
        $categoriesId = $data['category_template_id'];
        $userId = auth()->id();

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'thumbnail' => $thumbnail,
            'category_template_id' => $categoriesId,
            'user_id' => $userId,
        ];
    }

    protected function getRedirectUrl(): string
    {
        if(is_null($this->record)) {
            abort(400);
        }

        $templateId = $this->record->id;

        return "/builder?file/q=$templateId/mode/create";
    }
}
