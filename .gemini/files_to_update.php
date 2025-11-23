#!/usr/bin/env php
<?php

// Files to update with their line numbers (from grep search)
$files = [
    'resources/views/layouts/app.blade.php' => [325, 495],
    'resources/views/customer/products/category.blade.php' => [44],
    'resources/views/customer/products/show.blade.php' => [40, 67, 74],
    'resources/views/customer/orders/show.blade.php' => [280],
    'resources/views/customer/home.blade.php' => [159, 212],
    'resources/views/customer/flash-sales/index.blade.php' => [82],
    'resources/views/customer/checkout/index.blade.php' => [142],
    'resources/views/customer/cart/index.blade.php' => [45],
    'resources/views/admin/reviews/index.blade.php' => [54],
    'resources/views/admin/payment-methods/edit.blade.php' => [56],
    'resources/views/admin/products/edit.blade.php' => [66],
    'resources/views/admin/orders/show.blade.php' => [93],
    'resources/views/admin/categories/edit.blade.php' => [45],
    'resources/views/admin/flash-sale-campaigns/products.blade.php' => [98],
];

echo "Files that need to be updated:\n";
foreach ($files as $file => $lines) {
    echo "- $file (lines: " . implode(', ', $lines) . ")\n";
}
