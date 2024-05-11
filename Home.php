<?php
// $userFilePath = 'user_info.csv';

// if (!file_exists($userFilePath)) {
//     die("The user CSV file does not exist.");
// }

// // Read user information from CSV file
// $userFile = fopen($userFilePath, 'r');
// $userData = fgetcsv($userFile);
// fclose($userFile);

// // Extract the chosen category from user data
// if (!empty($userData) && isset($userData[1])) {
//     $selectedCategory = $userData[1];
// } else {
//     // Default category if user data is not available or incomplete
//     $selectedCategory = 'default_category';
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

if (isset($_GET['search'])) {
  $searchQuery = strtolower($_GET['search']);
  $filteredProducts = array_filter($products, function ($product) use ($searchQuery) {
      return strpos(strtolower($product['productName']), $searchQuery) !== false;
  });
} else {
  $filteredProducts = $products;
  
}

if (isset($_GET['price-range'])) {
  $priceRange = $_GET['price-range'];
  if ($priceRange === '0-20') {
      $filteredProducts = array_filter($filteredProducts, function ($product) {
          return $product['price'] >= 0 && $product['price'] <= 20;
      });
  } elseif ($priceRange === '21-59') {
      $filteredProducts = array_filter($filteredProducts, function ($product) {
          return $product['price'] >= 21 && $product['price'] <= 59;
      });
  }
  // Add more elseif conditions for other price ranges if needed
}
$products = $filteredProducts;
if (isset($_GET['category'])) {
    $selectedCategory = $_GET['category'];
    $filteredProducts = array_filter($products, function ($product) use ($selectedCategory) {
        return strtolower($product['category']) == strtolower($selectedCategory);
    });
    
    // Update products array with filtered products
    $products = $filteredProducts;
}

?>




<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Style.CSS">
</head>
<body>

<div class="flex flex-col lg:flex-row justify-between items-center">
    <!-- Menu -->
    <ul class="menu flex flex-wrap lg:flex-nowrap ">
        <li><a href="?category=Dresses" class="catg">Women's Dresses</a></li>
        <li><a href="?category=Jeans" class="catg">Men's Jeans</a></li>
        <li><a href="?category=T-Shirts" class="catg">Women's T-Shirts</a></li>
        <li><a href="?category=Jackets" class="catg">Men's Jackets</a></li>
        <li><a href="?category=Shoes" class="catg">Women's Shoes</a></li>
        <li><a href="?category=Shirts" class="catg">Men's Shirts</a></li>
    </ul>
    <!-- Search Form -->
    <div class="search-container flex items-center mt-4 lg:mt-0">
        <form action="" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:border-blue-500">
            <select name="price-range" class="px-4 py-2 border border-gray-300 rounded-none focus:outline-none focus:border-blue-500">
                <option value="">Select Price Range</option>
                <option value="0-20">0 to 20</option>
                <option value="21-59">21 to 59</option>
                <!-- Add more options for other price ranges if needed -->
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Search</button>
        </form>
    </div>
</div>



    
    <div class="relative overflow-hidden bg-cover bg-no-repeat" style="
        background-position: 50%;
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLhDXi0ODWew9cJx6qaY6RA2Zh_2S_Of7BYHw1tbvU8Q&s');
        height: 500px;
      ">
    <div class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-[hsla(0,0%,0%,0.75)] bg-fixed">
      <div class="flex h-full items-center justify-center">
        <div class="px-6 text-center text-white md:px-12">
          <h1 class="mt-2 mb-16 text-5xl font-bold tracking-tight md:text-6xl xl:text-7xl">
            The best offer on the market <br /><span>for your business</span>
          </h1>
          <a href="index.php"><button type="button" class="rounded border-2 border-neutral-50 px-[46px] pt-[14px] pb-[12px] text-sm font-medium uppercase leading-normal text-neutral-50 transition duration-150 ease-in-out hover:border-neutral-100 hover:bg-neutral-100 hover:bg-opacity-10 hover:text-neutral-100 focus:border-neutral-100 focus:text-neutral-100 focus:outline-none focus:ring-0 active:border-neutral-200 active:text-neutral-200" data-te-ripple-init data-te-ripple-color="light">
            Get started
          </button>
          </a>
        </div>
      </div>
    </div>
  </div>

<Script src="SCR5IPT.JS"></Script>

<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Products</h2>

    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
    <?php foreach ($products as $product): ?>
      <div class="group relative">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
          <img src="<?php echo $product['imageURL']; ?>" alt="<?php echo $product['productName']; ?>"  class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>
        <div class="mt-4 flex justify-between">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="product_details.php?id=<?php echo $product['id']; ?>">
                <span aria-hidden="true" class="absolute inset-0"></span>
                <?php echo $product['productName']; ?>
              </a>
            </h3>
            
            <p class="mt-1 text-sm text-gray-500">Color: <?php echo $product['color']; ?></p>
            <p class="mt-1 text-sm text-gray-500">taille: <?php echo $product['taille']; ?></p>
          </div>

          <p class="text-sm font-medium text-gray-900">Price: $<?php echo $product['price']; ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<!-- Category section -->



<footer
  class="bg-zinc-50 text-center text-surface/75 dark:bg-neutral-700 dark:text-white/75 lg:text-left">
  <div
    class="flex items-center justify-center border-b-2 border-neutral-200 p-6 dark:border-white/10 lg:justify-between">
  
    <!-- Social network icons container -->
   

  <!-- Main container div: holds the entire content of the footer, including four sections (TW Elements, Products, Useful links, and Contact), with responsive styling and appropriate padding/margins. -->
  <div class="mx-6 py-10 text-center md:text-left">
    
    <div class="grid-1 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
      <!-- TW Elements section -->
      <div class="">
        <h6
          class="mb-4 flex items-center justify-center font-semibold uppercase md:justify-start">
          <span class="me-3 [&>svg]:h-4 [&>svg]:w-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor">
              <path
                d="M12.378 1.602a.75.75 0 00-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03zM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 00.372-.648V7.93zM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 00.372.648l8.628 5.033z" />
            </svg>
          </span>
          NEXTON
        </h6>
        <p>
          Here you can use rows and columns to organize your footer
          content. Lorem ipsum dolor sit amet, consectetur adipisicing
          elit.
        </p>
      </div>
      <!-- Products section -->
      <div>
        <h6
          class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
          Quick Link
        </h6>
        <p class="mb-4">
          <a href="#!">Home</a>
        </p>
        <p class="mb-4">
          <a href="#!">Product</a>
        </p>
        <p class="mb-4">
          <a href="#!">card</a>
        </p>
        
      </div>
      <!-- Useful links section -->
      <div>
        <h6
          class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
          Category
        </h6>
        <p class="mb-4">
          <a href="#!">Shirt</a>
        </p>
        <p class="mb-4">
          <a href="#!">Shoes</a>
        </p>
        <p class="mb-4">
          <a href="#!">T-shirt</a>
        </p>
        <p>
          <a href="#!">Jeans</a>
        </p>
      </div>
      <div class="flex justify-center">
      <a href="#!" class="me-6 [&>svg]:h-4 [&>svg]:w-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 320 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
        </svg>
      </a>
      <a href="#!" class="me-6 [&>svg]:h-4 [&>svg]:w-4 ">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 512 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
        </svg>
      </a>
      <a href="#!" class="me-6 [&>svg]:h-4 [&>svg]:w-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 488 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
        </svg>
      </a>
      <a href="#!" class="me-6 [&>svg]:h-4 [&>svg]:w-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 448 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
        </svg>
      </a>
      <a href="#!" class="me-6 [&>svg]:h-4 [&>svg]:w-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 448 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z" />
        </svg>
      </a>
      <a href="#!" class="[&>svg]:h-4 [&>svg]:w-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 496 512">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
          <path
            d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z" />
        </svg>
      </a>
    </div>
  </div>
      
    </div>
  </div>

  <!--Copyright section-->
  <div class="bg-black/5 p-6 text-center">
    <span>© 2024 Copyright:</span>
    <a class="font-semibold" href=""
      >NEXTON</a
    >
  </div>
</footer>


</body>
</html> 
 


