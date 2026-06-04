<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required(),
                TextInput::make('quality')
                    ->required(),

                FileUpload::make('image')
                    ->image()
                    ->disk('cloudinary')
                    ->visibility('public')
                    ->columnSpanFull(),
            ]);
    }
}
