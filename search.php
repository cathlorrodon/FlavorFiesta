<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establish a connection to the database
$servername = "localhost"; // Change this to your database server name (usually "localhost" for XAMPP)
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "flavorfiestamain"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the search query
if (isset($_GET['query'])) {
    // Sanitize the search query to prevent SQL injection
    $query = $conn->real_escape_string($_GET['query']);
    
    // Prepare a SQL statement to search for recipes
    $sql = "SELECT * FROM recipes WHERE name LIKE '%$query%' OR category LIKE '%$query%'";
    $result = $conn->query($sql);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Search Results</title>";
    echo "<style>";
    echo "body { margin: 0; padding: 0; font-family: Verdana, Geneva, Tahoma, sans-serif; }";
    echo "#background-video { position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; width: auto; height: auto; z-index: -1; }";
    echo ".content { position: relative; z-index: 1; }";
    echo ".header-container { text-align: center; padding: 10px; background-color: rgb(255, 255, 255); border-bottom: 2px solid rgb(255, 255, 255); margin-bottom: 20px; }";
    echo ".header-container img { width: 100%; height: 185px; object-fit: cover; }";
    echo "nav { text-align: center; text-decoration: solid; border: 3px solid rgb(0, 0, 0); padding: 10px; margin-top: -20px; }";
    echo ".navbar { font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 25px; background-color: rgb(255, 255, 255); }";
    echo ".navbar a { color: rgb(0, 0, 0); text-decoration: none; display: inline-block; margin: 0 45px; cursor: pointer; font-family: Verdana, Geneva, Tahoma, sans-serif; }";
    echo ".clickable-box { background-color: rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0); padding: 10px; text-align: center; cursor: pointer; width: 193px; margin: 20px; float: left; }";
    echo ".clickable-box img { max-width: 100%; height: auto; border-radius: 8px; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='content'>";
    echo "<div class='header-container'>";
    echo "<img src='header.jpg' alt='FlavorFiesta Header'>";
    echo "</div>";

    echo "<video autoplay muted loop id='background-video'>";
    echo "<source src='bgv1.mp4' type='video/mp4'>";
    echo "Your browser does not support the video tag.";
    echo "</video>";

    echo "<nav class='navbar'>";
    echo "<a href='flavorfiestamain.html'><b>Home</b></a>";
    echo "<a href='allrecipes.html'><b>All Recipes</b></a>";
    echo "<a href='updatednewrecipes.html'><b>Updated Recipes</b></a>";
    echo "<a href='ingredients.html'><b>Ingredients</b></a>";
    echo "<a href='about.html'><b>About Us</b></a>";
    echo "</nav>";

    if ($result) {
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='clickable-box' onclick=\"window.location='" . $row['url'] . "'\">";
                echo "<h2>" . $row['name'] . "</h2>";
                echo "</div>";
            }
        } else {
            echo "<div class='clickable-box'>";
            echo "<h2>No results found.</h2>";
            echo "</div>";
        }
    } else {
        // Handle SQL query error
        echo "<div class='clickable-box'>";
        echo "<h2>Error: " . $sql . "<br>" . $conn->error . "</h2>";
        echo "</div>";
    }

    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    echo "<div class='clickable-box'>";
    echo "<h2>No search query provided.</h2>";
    echo "</div>";
}

// Close the database connection
$conn->close();
?>
