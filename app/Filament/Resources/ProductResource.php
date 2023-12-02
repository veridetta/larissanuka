<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Stores';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel="Produk";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Section Product')
                    ->description('Masukan Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('category_id')
                        ->required()
                        ->label('Kategori')
                        ->options(Category::all()->pluck('nama', 'id'))
                        ->searchable(),
                    Forms\Components\RichEditor::make('deskripsi')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('stok')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('harga')
                        ->required()
                        ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 2)
                        ->numeric(),
                    Radio::make('isPromosi')
                        ->label('Tetapkan sebagai produk promosi')
                        ->options([
                            1 => 'Promosi',
                            0 => 'Tidak Promosi',
                        ])
                        ->inline()
                        ->boolean()
                        ->required(),
                        Repeater::make('dimension')
                            ->label('Dimensi Produk')
                            ->relationship()
                            ->maxItems(1)
                            ->schema([
                                Section::make('Masukan Dimensi Produk')
                                    ->schema([
                                        Forms\Components\TextInput::make('panjang')
                                            ->required()
                                            ->suffix('cm')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('lebar')
                                            ->required()
                                            ->suffix('cm')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('tinggi')
                                            ->required()
                                            ->suffix('cm')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('berat')
                                            ->required()
                                            ->suffix('gram')
                                            ->numeric(),
                                    ])
                            ]),
                        Repeater::make('productImage')
                            ->relationship()
                            ->schema([
                                Section::make('Unggah foto produk')
                                    ->schema([
                                        FileUpload::make('path')
                                        ->required()
                                        ->visibility('public')
                                        ->directory('product-images')
                                    ])
                            ]),


                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.nama')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('slug')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga')
                    ->currency('IDR',2)
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
