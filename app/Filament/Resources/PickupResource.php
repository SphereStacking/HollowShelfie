<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Team;
use App\Models\User;
use Filament\Tables;
use App\Models\Event;
use App\Models\Pickup;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\PickupResource\Pages;

class PickupResource extends Resource
{
    protected static ?string $model = Pickup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('pickupable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(User::class)
                            ->titleAttribute('name'),
                        Forms\Components\MorphToSelect\Type::make(Team::class)
                            ->titleAttribute('name'),
                        Forms\Components\MorphToSelect\Type::make(Event::class)
                            ->titleAttribute('title'),
                    ])
                    ->label('Pickupable'),
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
                Tables\Columns\TextColumn::make('pickupable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickupable_id')
                    ->numeric()
                    ->sortable(),

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
            'index' => Pages\ListPickups::route('/'),
            'create' => Pages\CreatePickup::route('/create'),
            'edit' => Pages\EditPickup::route('/{record}/edit'),
        ];
    }
}
