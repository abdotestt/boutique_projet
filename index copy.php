<?php

// // Check if the form is submitted to generate the CSV file
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
// }

// File path for the CSV file
$filePath = 'products.csv';


if (!file_exists($filePath)) {
    die("The CSV file does not exist.");
}


$file = fopen($filePath, 'r');


$products = [];

// Read the CSV file line by line
while (($line = fgetcsv($file)) !== false) {
   
    if ($line[1] == 'Product Name') {
        continue;
    }

    
    $product = [
        'id' => $line[0], // Add ID field
        'productName' => $line[1], 
        'description' => $line[2], 
        'imageURL' => $line[3], 
        'price' => $line[4], 
        'category' => $line[5], 
        'color' => $line[6], 
        'taille' => $line[7] 
    ];

    
    $products[] = $product;
}


fclose($file);
// Filter products based on search query
if (isset($_GET['search'])) {
    $searchQuery = strtolower($_GET['search']);
    $filteredProducts = array_filter($products, function ($product) use ($searchQuery) {
        return strpos(strtolower($product['productName']), $searchQuery) !== false;
    });
    
    // Update products array with filtered products
    $products = $filteredProducts;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <style>
        .product {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            width: 200px;
            float: left;
        }
        .product img {
            width: 100%;
            height: auto;
        }
        .add-to-cart-btn {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .add-to-cart-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form action="" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<!-- <form method="post">
    <button type="submit">Generate CSV File</button>
</form> -->


<?php foreach ($products as $product): ?>
    <div class="product">
        <img src="<?php echo $product['imageURL']; ?>" alt="<?php echo $product['productName']; ?>">
        <h3><?php echo $product['productName']; ?></h3>
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <p>Category: <?php echo $product['category']; ?></p> 
        <p>Color: <?php echo $product['color']; ?></p> 
        <p>Taille: <?php echo $product['taille']; ?></p>
        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="buy-now-btn">Buy Now</a> 
        <form action="cart.php" method="POST" >
        <button class="add-to-cart-btn" id="ToggleButton">
            <!-- <a href="cart.php?action=add&id=<?php echo $product['id']; ?>">Add to Cart</a> -->
        </button>
        </form>
       
    </div>
<?php endforeach; ?>

</body>
</html>
