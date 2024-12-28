<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Tables;
use App\Models\School;
use Filament\Forms\Form;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SchoolResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SchoolResource\RelationManagers;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make()
                    ->columnSpanFull()
                    ->persistStepInQueryString()
                    ->schema([
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
                                    ->required()
                                    ->columnSpanFull(),

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
                                    ->helperText('Whether the school should be active on the platform'),
                            ]),

                        Wizard\Step::make('Address')
                            ->schema([
                                Group::make()
                                    ->relationship('address')
                                    ->schema([
                                        TextInput::make('street_address')
                                            ->label('Street Address')
                                            ->placeholder('Street Address')
                                            ->maxLength(255)
                                            ->required(),

                                        Grid::make()
                                            ->schema(([
                                                TextInput::make('locality')
                                                    ->placeholder('Locality')
                                                    ->maxLength(255)
                                                    ->required(),

                                                TextInput::make('city_town_village')
                                                    ->label('City/Town/Village')
                                                    ->placeholder('City/Town/Village')
                                                    ->maxLength(255)
                                                    ->required(),
                                            ])),

                                        Grid::make()
                                            ->schema(([
                                                TextInput::make('district')
                                                    ->label('District')
                                                    ->placeholder('District')
                                                    ->maxLength(255)
                                                    ->required(),

                                                TextInput::make('state')
                                                    ->label('State')
                                                    ->placeholder('State')
                                                    ->maxLength(255)
                                                    ->required(),
                                            ])),

                                        Grid::make()
                                            ->schema(([
                                                TextInput::make('pin_code')
                                                    ->label('PIN')
                                                    ->placeholder('PIN')
                                                    ->maxLength(6)
                                                    ->required()
                                                    ->mask('999999'),
                                            ])),
                                    ])
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn(School $school) => Str::limit(strip_tags($school->description), 64))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Active?')

            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active?'),
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
