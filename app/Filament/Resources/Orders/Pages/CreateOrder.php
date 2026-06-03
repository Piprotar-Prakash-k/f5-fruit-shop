<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function beforeCreate(): void
    {
        $data = $this->data;
        $product = Product::find($data['product_id']);

        if ($product && $data['quantity'] > $product->quantity) {
            Notification::make()
                ->title('Not enough stock!')
                ->body("Only {$product->quantity} left in stock!")
                ->danger()
                ->send();

            $this->halt();
        }
    }
    protected function afterCreate(): void
    {
        $order = $this->record;
        $product = Product::find($order->product_id);

        if ($product) {
            $product->quantity -= $order->quantity;
            $product->save();
        }
    }
}
