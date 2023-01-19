<?php

namespace App\Filament\Resources\ModerationActions;

use App\Filament\Resources\ModerationActions\MuteResource\Pages;
use App\Filament\Resources\ModerationActions\MuteResource\RelationManagers;
use App\Models\ModerationActions\Mute;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MuteResource extends Resource
{
    protected static ?string $model = Mute::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord)->disabled(fn (Page $livewire) => ! $livewire instanceof CreateRecord)->label('UUID')->default(Str::uuid()),
                Forms\Components\TextInput::make('reddit_username')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord)->disabled(fn (Page $livewire) => ! $livewire instanceof CreateRecord)->label('Reddit username'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('reddit_username'),
                Tables\Columns\TextColumn::make('duration_in_hours'),
                Tables\Columns\TextColumn::make('responsibleUser.username')->label('Moderator')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMutes::route('/'),
            'create' => Pages\CreateMute::route('/create'),
            'edit' => Pages\EditMute::route('/{record}/edit'),
        ];
    }
}
