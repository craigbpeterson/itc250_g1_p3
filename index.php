<?php 
//index.php

//change the following variable to update
$foodTruckName = 'Food Truck Name';

//header.php does not exist...yet
//when the page style has been completed, move <html> through </header> to a header.php file and un-comment the next line
//include 'includes/header.php';

?>

<!DOCTYPE html>
<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $foodTruckName ?></title>  
        <link rel="stylesheet" href="css/styles.css" />
    </head>
    
<body>
    <header>
        <h1><?= $foodTruckName ?></h1>
    </header>
    
    <div class="orderform">
        <h2>Menu</h2>
        <?php include "includes/foodtruck_postback.php" ?>
    </div>
    
    <footer>
        <p>&copy; 2018 <?= $foodTruckName ?></p>
    </footer>

</body>
</html>

<?php
//footer.php does not exist...yet
//when the page style has been completed, move <footer> through </html> to a footer.php file and un-comment the next line
//include 'includes/footer.php';

?>

