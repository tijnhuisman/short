<?php

if (isset($_POST['long-url'])) {
    $long_url = $_POST['long-url'];

    // Generate a unique identifier for the short URL
    $id = uniqid();

    // Save the mapping between the short URL ID and the long URL in a database or file
    // For example, you could use a simple CSV file:
    file_put_contents('urls.csv', "{$id},{$long_url}\n", FILE_APPEND);

    // Build the short URL using the unique ID
    $short_url = "http://{$_SERVER['HTTP_HOST']}/{$id}";

    // Output the short URL to the user
    echo "Short URL: <a href=\"{$short_url}\">{$short_url}</a>";
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Load the mapping between the short URL ID and the long URL from the database or file
    // For example, you could use a simple CSV file:
    $lines = file('urls.csv');
    foreach ($lines as $line) {
        $parts = explode(',', trim($line));
        if ($parts[0] == $id) {
            $long_url = $parts[1];
            break;
        }
    }

    // Redirect the user to the long URL
    header("Location: {$long_url}");
    exit();
}

?>

<form method="post" action="shorten.php">
    <label for="long-url">Enter URL:</label>
    <input type="text" name="long-url" id="long-url">
    <input type="submit" value="Shorten">
</form>
