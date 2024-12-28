<?php

namespace App\Filament\Resources\GradeParentResource\Pages;

use App\Filament\Resources\GradeParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGradeParents extends ManageRecords
{
    protected static string $resource = GradeParentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
