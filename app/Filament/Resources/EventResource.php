<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Team;
use App\Models\User;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Event Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\Toggle::make('is_forced_hidden')
                    ->onColor('danger')
                    ->offColor('success')
                    ->required(),
                Forms\Components\Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('created_user_id')
                    ->relationship('event_create_user', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\DateTimePicker::make('end_date'),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('alias')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Section::make('relation')->schema([
                    Forms\Components\Select::make('tags')
                        ->multiple()
                        ->relationship('tags', 'name')
                        ->preload(),
                    Forms\Components\Select::make('categories')
                        ->multiple()
                        ->relationship('categories', 'name')
                        ->preload(),
                    Forms\Components\Repeater::make('timeTables')
                        ->relationship('event_time_tables')
                        ->schema([
                            Forms\Components\TextInput::make('description')
                                ->required(),
                            Forms\Components\DateTimePicker::make('start_date')
                                ->required(),
                            Forms\Components\DateTimePicker::make('end_date')
                                ->required(),
                            Forms\Components\Repeater::make('performers')
                                ->relationship('performers')
                                ->schema([
                                    Forms\Components\MorphToSelect::make('performable')
                                        ->types([
                                            Forms\Components\MorphToSelect\Type::make(User::class)
                                                ->titleAttribute('name'),
                                            Forms\Components\MorphToSelect\Type::make(Team::class)
                                                ->titleAttribute('name'),
                                        ])
                                ])
                        ])
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_create_user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tags')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_forced_hidden')
                    ->label('強制非公開')
                    ->falseIcon('heroicon-o-eye')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-eye-slash')
                    ->trueColor('danger')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('alias')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
