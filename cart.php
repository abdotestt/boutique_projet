<?php
session_start();
require 'middleware.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Check if the productId is not set or empty
if (!isset($_POST["productId"]) || empty($_POST["productId"])) {
    // Redirect to the main page if productId is not set or empty
    header("Location: index.php");
    exit;
}

// Retrieve the product ID from the form
$productId = $_POST["productId"];

// File path for the CSV file
$filePath = 'products.csv';

// Check if the CSV file exists
if (!file_exists($filePath)) {
    // Display an error message if the CSV file does not exist
    die("The CSV file does not exist.");
}

// Open the CSV file
$file = fopen($filePath, 'r');

// Initialize $productDetails array
$productDetails = null;

// Read the CSV file line by line
while (($line = fgetcsv($file)) !== false) {
    // Check if the first column (ID) matches the requested product ID
    if ($line[0] == $productId) {
        // Assign product details to $productDetails array
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
        break; // Exit the loop once product details are found
    }
}

// Close the CSV file
fclose($file);

// If product details are not found, redirect back to the main page or display an error message
if (!$productDetails) {
    // Redirect back to the main page if product details are not found
    header("Location: index.php");
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>


<?php
    require('middleware.php');
  ?>

<div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Product details -->
                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <li class="flex py-6">
                                            <!-- Product image -->
                                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                <img src="<?php echo $productDetails['imageURL']; ?>" alt="<?php echo $productDetails['productName']; ?>" class="h-full w-full object-cover object-center">
                                            </div>
                                            <!-- Product details -->
                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>
                                                            <!-- Product name -->
                                                            <a href="#"><?php echo $productDetails['productName']; ?></a>
                                                        </h3>
                                                        <p class="ml-4"><?php echo $productDetails['price']; ?></p>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500"><?php echo $productDetails['color']; ?></p>
                                                </div>
                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <p class="text-gray-500">Qty 1</p>
                                                    <!-- Button to remove product -->
                                                    <div class="flex">
                                                        <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- More products... -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Subtotal and checkout -->
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p>$<?php echo $productDetails['price']; ?></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>or
                                    <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500"><a href="home.php">Continue Shopping </a><span aria-hidden="true"> &rarr;</span></button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
