<?php

namespace App\Domain\Entities\Product\Productsup;

class CoffeeFeed
{
    public function __construct(
        public string  $entityId,
        public string  $categoryName,
        public string  $sku,
        public string  $name,
        public ?string $description,
        public ?string $shortDescription,
        public float   $price,
        public string  $link,
        public string  $image,
        public string  $brand,
        public int     $rating,
        public string  $caffeineType,
        public int     $count,
        public bool    $flavored,
        public bool    $seasonal,
        public bool    $inStock,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->entityId,
            $this->categoryName,
            $this->sku,
            $this->name,
            $this->description,
            $this->shortDescription,
            $this->price,
            $this->link,
            $this->image,
            $this->brand,
            $this->rating,
            $this->caffeineType,
            $this->count,
            $this->flavored ? 'Yes' : 'No',
            $this->seasonal ? 'Yes' : 'No',
            $this->inStock ? 'Yes' : 'No',
        ];
    }

}
