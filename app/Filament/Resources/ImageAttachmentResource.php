<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageAttachmentResource\Pages;
use App\Filament\Resources\ImageAttachmentResource\RelationManagers;
use App\Models\ImageAttachment;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImageAttachmentResource extends Resource
{
    protected static ?string $model = ImageAttachment::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->label('UUID')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord),
                Forms\Components\Select::make('user_id')->label('User')->options(User::all()->pluck('username', 'id'))->searchable(),
                Forms\Components\TextInput::make('url')->label('URL'),
                Forms\Components\TextInput::make('caption')
                    ->maxLength(255),
                Forms\Components\TextInput::make('attachable_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('attachable_id')
                    ->required()
                    ->maxLength(36),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('UUID'),
                Tables\Columns\TextColumn::make('user.username')->label('Uploaded by'),
                Tables\Columns\TextColumn::make('attachable_id')->label('Attached to UUID'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()
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
            'index' => Pages\ListImageAttachments::route('/'),
            'create' => Pages\CreateImageAttachment::route('/create'),
            'edit' => Pages\EditImageAttachment::route('/{record}/edit'),
        ];
    }
}
