<?php

// Sample product data with categories, ID, color, and taille (size)
$products = [
    ["ID", "Product Name", "Description", "Image URL", "Price", "Category", "Color", "Taille"],
    ["1", "Women's Floral Maxi Dress", "A beautiful floral print maxi dress, perfect for summer outings.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 49.99, "Dresses", "Floral/Red", "M"],
    ["2", "Men's Slim-Fit Jeans", "Classic slim-fit jeans made from high-quality denim.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 59.99, "Jeans", "Blue", "32x34"],
    ["3", "Women's Striped T-Shirt", "Casual striped t-shirt made from soft cotton fabric.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 24.99, "T-Shirts", "Blue/White", "S"],
    ["4", "Men's Leather Jacket", "Stylish leather jacket with a rugged yet sophisticated look.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 129.99, "Jackets", "Black/White", "L"],
    ["5", "Women's Sneakers", "Comfortable and trendy sneakers for everyday wear.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 39.99, "Shoes", "White/black", "US 7 / EU 37"],
    ["6", "Men's Plaid Shirt", "Classic plaid shirt suitable for both casual and formal occasions.", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4sLHPOzYDkOpTPQo0QUXjd6oVUT5bALaeGOZtuRSwXA&s", 34.99, "Shirts", "Red/Black", "XL"]
];

$filePath = 'products.csv';

$file = fopen($filePath, 'w');

// Write each product data to the CSV file
foreach ($products as $product) {
    fputcsv($file, $product);
}

// Close the CSV file
fclose($file);

echo "CSV file generated successfully.";

?>
