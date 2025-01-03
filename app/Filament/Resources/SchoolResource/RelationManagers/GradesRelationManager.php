<?php

namespace App\Filament\Resources\SchoolResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Grade;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class GradesRelationManager extends RelationManager
{
    protected static string $relationship = 'grades';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('grade_parent.name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn(Grade $grade) => $grade->grade_parent ? $grade->grade_parent->name : 'None'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active?')
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active?'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->recordTitle(function ($record) {
                        $parentName = $record->grade_parent->name ?? null;
                        return $parentName
                            ? "{$parentName} ({$record->name})"
                            : $record->name;
                    })
                    ->preloadRecordSelect()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
