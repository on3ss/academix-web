<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolResource\Pages;
use App\Filament\Resources\SchoolResource\RelationManagers;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Wizard\Step::make('Basic Details')
                        ->schema([
                            Grid::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->placeholder('Name')
                                        ->helperText('Name of the school')
                                        ->required()
                                        ->maxLength(255),
                                ]),

                            RichEditor::make('description')
                                ->placeholder('Description')
                                ->helperText('Description for the school')
                                ->required(),

                            Grid::make()
                                ->schema([
                                    TextInput::make('phone')
                                        ->placeholder('Phone')
                                        ->helperText('Phone number for use to contact the school')
                                        ->required()
                                        ->tel()
                                        ->length(10)
                                        ->mask('9999999999'),

                                    TextInput::make('email')
                                        ->placeholder('Email')
                                        ->helperText('Email address for use to contact the school')
                                        ->required()
                                        ->maxLength(255)
                                        ->email(),
                                ]),

                            Toggle::make('is_active')
                                ->label('Active?')
                                ->helperText('Whether the school should be active on the platform')
                        ]),

                    Wizard\Step::make('Address')
                        ->schema([
                            TextInput::make('street_address')
                                ->label('Street Address')
                                ->placeholder('Street Address')
                                ->required()
                                ->maxLength(255),

                            Grid::make()
                                ->schema([
                                    TextInput::make('locality')
                                        ->placeholder('Locality')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('city_town_village')
                                        ->label('City/Town/Village')
                                        ->placeholder('City/Town/Village')
                                        ->required()
                                        ->maxLength(255),
                                ]),

                            Grid::make()
                                ->schema([
                                    TextInput::make('district')
                                        ->placeholder('District')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('state')
                                        ->placeholder('State')
                                        ->required()
                                        ->maxLength(255),
                                ]),
                            Grid::make()
                                ->schema([
                                    TextInput::make('pin_code')
                                        ->placeholder('PIN')
                                        ->required()
                                        ->maxLength(6)
                                        ->numeric()
                                        ->mask('999999'),
                                ]),

                        ])
                ])
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
