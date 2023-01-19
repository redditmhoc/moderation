<?php

namespace App\Filament\Resources\ModerationActions;

use App\Filament\Resources\ModerationActions\BanResource\Pages;
use App\Filament\Resources\ModerationActions\BanResource\RelationManagers;
use App\Models\ModerationActions\Ban;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BanResource extends Resource
{
    protected static ?string $model = Ban::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListBans::route('/'),
            'create' => Pages\CreateBan::route('/create'),
            'edit' => Pages\EditBan::route('/{record}/edit'),
        ];
    }    
}
