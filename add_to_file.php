<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user details from the form
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
        $categories = $_POST["categories"];
    $categoriesString = '"' . implode('","', $categories) . '"';
    
    // Construct the CSV line
    $csvLine = "$email,$password,$name,$categories" . PHP_EOL;

    // File path to the CSV
    $file = 'data.csv';
    
    // Append the CSV line to the file
    file_put_contents($file, $csvLine, FILE_APPEND | LOCK_EX);
    
    // Redirect back to the form or to a success page
    header("Location: index.php");
    exit();
}
?>
