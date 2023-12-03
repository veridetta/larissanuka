<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Transactions';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel="Transaksi";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Transaksi')
                ->description('Berikut merupakan ringkasan transaksi')
                ->schema([
                    Forms\Components\TextInput::make('transaction_code')
                    ->required()
                    ->label('KodeTransaksi')
                    ->disabled()
                    ->columnSpanFull(),
                    Forms\Components\TextInput::make('total')
                    ->label('Total Harga')
                    ->required()
                    ->disabled()
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 2)
                    ->numeric(),
                    TextInput::make('no_resi')
                    ->label('Masukkan Nomor Resi')
                    ->columnSpanFull(),
                    Forms\Components\Select::make('status')
                    ->required()
                    ->label('Status')
                    ->options([
                        'menunggu pembayaran' => 'Menunggu Pembayaran',
                        'menunggu konfirmasi' => 'Menunggu Konfirmasi',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                    ]),
                    Section::make('Informasi Pengiriman')
                    ->description('Berikut merupakan informasi pengiriman atas transaksi ini.')
                    ->schema([
                        Repeater::make('service')
                        ->relationship()
                        ->maxItems(1)
                        ->schema([
                            TextInput::make('nama')
                            ->label('Expedisi')
                            ->disabled(),
                            TextInput::make('servis')
                            ->label('Layanan')
                            ->disabled(),
                            TextInput::make('deskripsi')
                            ->label('Deskripsi')
                            ->disabled(),
                            TextInput::make('value')
                            ->label('Biaya Kirim')
                            ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 2)
                            ->disabled(),
                        ]),
                        Repeater::make('customer')
                        ->relationship()
                        ->maxItems(1)
                        ->schema([
                            TextInput::make('nama')
                            ->label('Nama Penerima')
                            ->disabled(),
                            TextInput::make('provinsi_name')
                            ->label('Provinsi')
                            ->disabled(),
                            TextInput::make('kota_name')
                            ->label('Kota / Kabupaten')
                            ->disabled(),
                            TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->disabled(),
                            TextInput::make('kelurahan')
                            ->label('Kelurahan / Desa')
                            ->disabled(),
                            TextInput::make('alamat')
                            ->label('Alamat')
                            ->disabled(),
                            TextInput::make('kodepos')
                            ->label('Kode Pos')
                            ->disabled(),
                            TextInput::make('no_telp')
                            ->label('Nomor Telepon')
                            ->disabled(),
                        ])
                    ]),
                    Section::make('Rincian Transaksi')
                    ->description('Berikut merupakan rincian barang dari transaski ini.')
                    ->schema([
                        Repeater::make('transactionDetail')
                        ->relationship()
                        ->maxItems(function($record){
                            return $record->transactionDetail()->count();
                        })
                        ->schema([
                            Placeholder::make('product.name')
                            ->label('Nama Barang')
                            ->content(function($record){
                                $produk = Product::where('id',$record->product_id)->first();
                                return $produk->nama;
                            }),
                            TextInput::make('qty')
                            ->label('Jumlah')
                            ->disabled(),
                            TextInput::make('price')
                            ->label('Harga')
                            ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 2)
                            ->disabled(),
                            TextInput::make('total')
                            ->label('Subtotal')
                            ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 2)
                            ->disabled(),
                        ])
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //tanggal
                TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime(),
                TextColumn::make('transaction_code')
                ->label('Kode')
                ->searchable(),
                TextColumn::make('user.name')
                ->label('Nama Pembeli')
                ->searchable(),
                TextColumn::make('customer.telp')
                ->label('No Telp')
                ->searchable(),
                TextColumn::make('customer.kota')
                ->label('Kota')
                ->searchable(),
                TextColumn::make('customer.alamat')
                ->label('Alamat'),
                TextColumn::make('total')
                ->currency('IDR',2)
                ->badge(),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'menunggu pembayaran' => 'gray',
                    'menunggu konfirmasi' => 'blue',
                    'dikirim' => 'yellow',
                    'selesai' => 'green',
                    'pembayaran gagal' => 'red',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
