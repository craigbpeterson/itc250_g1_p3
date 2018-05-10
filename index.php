<?php 
//index.php

//header.php does not exist...yet
//when the page style has been completed, place <html> through </header> in the header.php file and un-comment the next line
//include 'includes/header.php';

?>

<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Food Truck Name</title>  
        <link rel="stylesheet" href="css/styles.css" />
    </head>
    
<body>
    <header>
        <h1>Food Truck Name</h1>
        <h2>ITC-250 - Team 1</h2>
    </header>
    
    <div class="orderform">
        <?php include "includes/foodtruck_postback.php" ?>
    </div>
    
    <footer>
        <h3>Thanks for visiting!</h3>
    </footer>

</body>
</html>

<?php
//footer.php does not exist...yet
//when the page style has been completed, place <footer> through </html> in the footer.php file and un-comment the next line
//include 'includes/footer.php';

?>

