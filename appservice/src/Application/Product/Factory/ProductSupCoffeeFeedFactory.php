<?php

namespace App\Application\Product\Factory;

use App\Application\Product\Contract\ProductFactoryContract;
use App\Domain\Entities\Product\Productsup\CoffeeFeed;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @implements ProductFactoryContract<CoffeeFeed>
 */
#[AsAlias(ProductFactoryContract::class)]
class ProductSupCoffeeFeedFactory implements ProductFactoryContract
{
    /**
     * @param array<string, mixed> $rawData
     */
    public function createFromArray(array $rawData): array
    {
        $products = [];
        /**
         * @return CoffeeFeed[]
         */

        foreach ($rawData['item'] ?? [] as $item) {
            $item = $this->normalizeXml($item);
            $products[] = new CoffeeFeed(
                entityId: $item['entity_id'] ?? '',
                categoryName: $item['CategoryName'] ?? '',
                sku: $item['sku'] ?? '',
                name: $item['name'] ?? '',
                description: $item['description'] ?? '',
                shortDescription: $item['shortdesc'] ?? '',
                price: (float) ($item['price'] ?? 0.0),
                link: $item['link'] ?? '',
                image: $item['image'] ?? '',
                brand: $item['Brand'] ?? '',
                rating: (int) ($item['Rating'] ?? 0),
                caffeineType: $item['CaffeineType'] ?? '',
                count: (int) ($item['Count'] ?? 0),
                flavored: filter_var($item['Flavored'] ?? false, FILTER_VALIDATE_BOOLEAN),
                seasonal: filter_var($item['Seasonal'] ?? false, FILTER_VALIDATE_BOOLEAN),
                inStock: filter_var($item['Instock'] ?? false, FILTER_VALIDATE_BOOLEAN),
            );
        }

        return $products;
    }

    /**
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    public function normalizeXml(array $item): array
    {
        foreach ($item as $key => $value) {
            if (is_array($value)) {
                $item[$key] = (string) ($value[0] ?? '');
            } elseif (is_object($value)) {
                $item[$key] = (string) $value;
            }
        }

        return $item;
    }

}
