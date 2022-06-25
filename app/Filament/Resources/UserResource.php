<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\RelationManagers\RolesRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
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
use STS\FilamentImpersonate\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord)->disabled(fn (Page $livewire) => ! $livewire instanceof CreateRecord)->label('UUID')->default(Str::uuid()),
                Forms\Components\TextInput::make('username')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord)->disabled(fn (Page $livewire) => ! $livewire instanceof CreateRecord)->label('Reddit username'),
                Forms\Components\Toggle::make('password_enabled')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)->helperText('Set only if password enabled'),
                Forms\Components\MultiSelect::make('roles')->relationship('roles', 'name')->helperText('Always give the "Access" role')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->prependActions([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Impersonate::make('impersonate')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
