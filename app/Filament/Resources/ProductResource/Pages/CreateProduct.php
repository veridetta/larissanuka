<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(isset($data['isPromosi'])){
            //set semua data isPromosi jadi 0
            Product::where('isPromosi', 1)->update(['isPromosi' => 0]);
            $data['isPromosi'] = 1;
        }else{
            $data['isPromosi'] = 0;
        }
        return $data;
    }
}
