<?php

namespace App\Filament\Resources;

use App\Models\School;
use Filament\Forms;
use Filament\Tables;
use App\Models\Grade;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GradeParent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GradeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GradeResource\RelationManagers;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationGroup = 'Manage Classes';

    protected static ?string $modelLabel = 'Class';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder('Name')
                    ->required()
                    ->maxLength(255),

                Select::make('grade_parent_id')
                    ->label('Parent')
                    ->placeholder('Parent')
                    ->options(GradeParent::get()->pluck('name', 'id'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grade_parent')
                    ->label('Parent')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn(Grade $grade) => isset($grade->grade_parent) ? $grade->grade_parent->name : '-'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active?')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
        ];
    }
}
