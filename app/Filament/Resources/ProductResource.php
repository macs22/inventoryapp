<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('price')
                    ->rules(['required', 'numeric']),
                Select::make('category')
                    ->label('Category')
                    ->options([
                        'electronics' => 'Electronics',
                        'clothing' => 'Clothing',
                        'shoes' => 'Shoes',
                    ])
                    ->searchable()
                    ->required(),
                TextInput::make('stock')
                    ->rules(['required', 'numeric']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money('usd', true),
                TextColumn::make('stock'),
                TextColumn::make('category')->searchable()
                    ->getStateUsing( function (Product $record){
                        return ucfirst($record->category);
                    }),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('Categories'))
                    ->options([
                        'electronics' => 'Electronics',
                        'clothing' => 'Clothing',
                        'shoes' => 'Shoes',
                    ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }   
}
