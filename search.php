<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establish a connection to the database
$servername = "127.0.0.1"; // Change this to your database server name (usually "localhost" for XAMPP)
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

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Results</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            #background-video {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -1;
            }

            .content {
                position: relative;
                z-index: 1;
                overflow: hidden; /* Added to clear float */
            }

            .header-container {
                text-align: center;
                padding: 10px;
                background-color: rgb(255, 255, 255);
                border-bottom: 2px solid rgb(255, 255, 255);
                margin-bottom: 20px;
            }

            .header-container img {
                width: 100%;
                height: 185px;
                object-fit: cover;
            }

            nav {
                text-align: center;
                text-decoration: solid;
                border: 3px solid rgb(0, 0, 0);
                padding: 10px;
                margin-top: -20px;
            }

            .navbar {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                font-size: 25px;
                background-color: rgb(255, 255, 255);
            }

            .navbar a {
                color: rgb(0, 0, 0);
                text-decoration: none;
                display: inline-block;
                margin: 0 45px;
                cursor: pointer;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            .clickable-box {
                background-color: rgb(255, 255, 255);
                border: 2px solid rgb(0, 0, 0);
                padding: 10px;
                text-align: center;
                cursor: pointer;
                width: 230px; /* Adjusted width */
                margin: 20px;
                float: left;
               
            }

            .clickable-box img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="header-container">
                <img src="header.jpg" alt="FlavorFiesta Header">
            </div>

            <video autoplay muted loop id="background-video">
                <source src="bgv1.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <nav class="navbar">
                <a href="flavorfiestamain.html"><b>Home</b></a>
                <a href="allrecipes.html"><b>All Recipes</b></a>
                <a href="updatednewrecipes.html"><b>Updated Recipes</b></a>
                <a href="ingredients.html"><b>Ingredients</b></a>
                <a href="about.html"><b>About Us</b></a>
            </nav>

            <?php
           if ($result) {
            if ($result->num_rows > 0) {
                // Output data of each row
                $count = 0;
                while($row = $result->fetch_assoc()) {
                    echo "<div class='clickable-box' onclick=\"window.location='" . $row['url'] . "'\">";
                    echo "<h2>" . $row['name'] . "</h2>";
                    echo "</div>";
        
                    // Add a clear fix after every 5th element
                    $count++;
                    if ($count % 5 == 0) {
                        echo "<div style='clear: both;'></div>";
                    }
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
    }
        ?>
