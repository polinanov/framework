<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;
use Model\Repository\Product;

class SortByName implements Strategy
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function execute()
    {
        return $this->product->fetchAllSort('name');
    }
}
