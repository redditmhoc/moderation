<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssueReportResource\Pages;
use App\Filament\Resources\IssueReportResource\RelationManagers;
use App\Models\IssueReport;
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

class IssueReportResource extends Resource
{
    protected static ?string $model = IssueReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord)->disabled(fn (Page $livewire) => ! $livewire instanceof CreateRecord)->label('UUID')->default(Str::uuid()),
                Forms\Components\Select::make('user_id')->label('User')->options(User::all()->pluck('username', 'id'))->searchable(),
                Forms\Components\TextInput::make('page_url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('UUID'),
                Tables\Columns\TextColumn::make('user.username'),
                Tables\Columns\TextColumn::make('page_url'),
                Tables\Columns\TextColumn::make('content'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListIssueReports::route('/'),
            'create' => Pages\CreateIssueReport::route('/create'),
            'edit' => Pages\EditIssueReport::route('/{record}/edit'),
        ];
    }
}
