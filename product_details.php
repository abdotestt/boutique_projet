<?php

if (!isset($_GET['id'])) {
  
    header("Location: index.php"); 
    exit;
}

// Retrieve the product ID from the URL
$productId = $_GET['id'];

// File path for the CSV file
$filePath = 'products.csv';

// Check if the CSV file exists
if (!file_exists($filePath)) {
    die("The CSV file does not exist.");
}

$file = fopen($filePath, 'r');


$productDetails = null;

// Read the CSV file line by line
while (($line = fgetcsv($file)) !== false) {
    // Check if the first column (ID) matches the requested product ID
    if ($line[0] == $productId) {
        
        $productDetails = [
            'id' => $line[0],
            'productName' => $line[1],
            'description' => $line[2],
            'imageURL' => $line[3],
            'price' => $line[4],
            'category' => $line[5],
            'color' => $line[6],
            'taille' => $line[7]
        ];
        break; 
    }
}

fclose($file);

// If product details are not found, redirect back to the main page or display an error message
if (!$productDetails) {
    // Redirect back to the main page or display an error message
    header("Location: index.php"); // Change 'index.php' to your main page URL
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productDetails['productName']; ?> Details</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
   
    <h1><?php echo $productDetails['productName']; ?> Details</h1>
    <img src="<?php echo $productDetails['imageURL']; ?>" alt="<?php echo $productDetails['productName']; ?>">
    <p>Description: <?php echo $productDetails['description']; ?></p>
    <p>Price: $<?php echo $productDetails['price']; ?></p>
    <p>Category: <?php echo $productDetails['category']; ?></p>
    <p>Color: <?php echo $productDetails['color']; ?></p>
    <p>Taille: <?php echo $productDetails['taille']; ?></p>
    
    

</body>
</html>
