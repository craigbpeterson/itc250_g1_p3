<?php
//foodtruck_postback.php

include 'menu_objects.php';

if(isset($_POST['submit'])){//show transaction result
    global $config;
    
    //sandbox
    //i apologize for anyone having to read this block of messy code
    //catch post data for toppings
    //add if statement check incase customer doesn't select extra toppings
    $extra1 = $_POST['item_1_extras'];
    $extra2 = $_POST['item_2_extras'];
    //shows string form of toppings
    for($x=1; $x<count($extra1); $x++){
        echo $extra1[$x] . ' ';
    }
    for($x=1; $x<count($extra2); $x++){
        echo $extra2[$x] . ' ';
    }
    //shows price of items
    echo 'price of item 1: ' . $config->items[0]->Price . '<br>';
    echo 'price of item 2: ' . $config->items[1]->Price . '<br>';
    
    //shows quantity of items ordered
    echo '$_POST item_1: ' . $_POST['item_1'] . '<br>';
    echo '$_POST item_2: ' . $_POST['item_2'] . '<br>';
    
    //testing out multiplication
    echo 'item 1 totals: ' . ($_POST['item_1'] * $config->items[0]->Price) . '<br>';
    echo 'item 2 totals: ' . ($_POST['item_2'] * $config->items[1]->Price) . '<br>';
    
    //must do this to add totals?
    $total1 = ($_POST['item_1'] * $config->items[0]->Price);
    $total2 = ($_POST['item_2'] * $config->items[1]->Price);
    $subtotal = $total1 + $total2;
    echo 'sub totals: ' . $subtotal . '<br>';
    
    //count($extra2) might have use somewhere later
    echo '
        <div class="menuitem">
            <p class="itemname">Order Details</p>
            <p class="description">' . date("F j, Y, g:i a") . '</p>
            <p>Order Summary</p>
            <p>Item(s) Subtotal: ' 
                . $subtotal . 
            '</p>
            <p>Toppings: clever code /p>
            <p>Grand Total: goes here<</p>
        </div>
    ';
    echo '<br>var_dump: ';
    echo '<br>';
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}else{//show form
    global $config;
    
    //start the form:
    echo '
        <form action="" method="post">
    ';
    
    foreach ($config->items as $item) 
    {//generate form block for each menu item
        echo '
            <div class="menuitem">
                <label>
                    <p class="itemname">' . $item->Name . '</p>
                    <p class="description">' . $item->Description . '</p>
                    <p>Quantity:<br />
                        <input class="quantity" type="text" name="item_' . $item->ID . '" value="0" required="required" />
                    </p>
                </label>
                <div class="extras">Add Extras (25&cent; each):
                <br />
        ';
        foreach ($item->Extras as $extra) 
        {//generate checkboxes for extras
            echo '
                <input type="checkbox" name="item_' . $item->ID . '_extras[]" id="' . str_replace(' ','',$extra) . '" value="' . $extra . '" />
                <label for="' . str_replace(' ','',$extra) . '">' . $extra . '</label>
                <br />
            ';
        }
        echo '
                </div>
                
            </div>
        ';
    }//end form block for each menu item

    //finish off the form:
    echo '
            <div class="formbuttons">
                <input type="submit" name="submit" value="Purchase" />
                <input type="reset" />
            </div>    
        </form>
    ';

    
}//end show form
