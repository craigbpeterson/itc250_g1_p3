<?php
//foodtruck_postback.php

include 'menu_objects.php';

if (isset($_POST['submit'])) {//show result
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    
    $status = checkQuantity(); //checks user input, returns $quantity_status
    
    switch($status)
    {
        case 'quantity is not a number':
            echo '
            <p class="inputerror">Quantity must be a number.</p>
            ';
            break;
        
        case 'quantity is less than 1':
            echo '
            <p class="inputerror">If you want food in your belly, please select at least one menu item.<p>
            ';
            break;
        
        case 'quantity is more than 0':
            echo showTransactionResult();
            break;
            
    }//end switch
      
} else {//show form
    global $config;
    
    //start the form:
    echo '
    <h2>Menu</h2>
        <form action="" method="post">
    ';
    
    foreach ($config->items as $item)
    {//generate form block for each menu item
        echo '
            <div class="menuitem">
                <label>
                    <p class="itemname">' . $item->Name . '</p>
                    <p class="itemprice">$' . $item->Price . '</p>
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
                <input type="checkbox" name="extras_' . $item->ID . '[]" id="' . str_replace(' ','',$extra) . '" value="' . $extra . '" />
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


/* FUNCTION DEFINITIONS */

function checkQuantity() 
{//this function checks if user has selected at least one item
    $quantity_check = 0; //init
    foreach ($_POST as $key => $value) 
    {
        if (substr($key,0,5) == 'item_') 
        {
            if (!is_numeric($value)) {
                $quantity_status = 'quantity is not a number';
                return $quantity_status;
            } else {
                $quantity_check += (int)$value;
            }
        }
    }
    
    if ($quantity_check < 1) {
        $quantity_status = 'quantity is less than 1';
        
    } elseif ($quantity_check > 0) {
        $quantity_status = 'quantity is more than 0';
    }
    
    return $quantity_status;
}

function showTransactionResult()
{//this function gets user input, calculates totals, returns $html output
    global $config;
    $items_total = 0; //init
    $extras_total = 0; //init
    
    //date format May 13, 2018, 1:16 am
    $html = '
        <h2>Order Details</h2>
        <h2>For now table display only works if there is both an item(s) and topping(s) for all options.</h2>
        <div class="menuitem">
            <p style="margin:0;">Order Date</p>
            <p class="description">' . date("F j, Y, g:i a") . '</p>
            <table style="width:100%">
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th># of Toppings</th>
                    <th>Total</th>
                </tr>
    ';
    
    foreach ($_POST as $key => $value)
    {
        //check $key is an item or a topping
        if (substr($key,0,5) == 'item_') {
            
            //get qty, cast as int
            $quantity = (int)$_POST[$key];
            
            //check if there is an order for this item
            if ($quantity > 0) {
                
                //seperate string with _ as the delimiter
                $key_array = explode('_',$key);
                
                //cast item number as an integer
                $key_id = (int)$key_array[1];
                
                //get price, cast as float
                $price = (float)$config->items[$key_id - 1]->Price;
                
                //get name
                $name = $config->items[$key_id - 1]->Name;
                
                //calculate and add to total
                $items_total += $quantity * $price;
                
                $html .= '
                <tr>
                    <td>' . $name . '</td>
                    <td>' . $quantity . '</td>
                    <td>' . $price . '</td>
                ';
            }
        } elseif (substr($key,0,7)=='extras_') {
            
            //each topping is $0.25
            $extras_total += $prev_quantity * count($value) * 0.25;
            
            $html .= '
                    <td>' . $prev_quantity * count($value) . '</td>
                    <td>' . money_format('%.2n', ($prev_quantity * count($value) * 0.25 + $prev_quantity * $prev_price)) . '</td>
                </tr>
            ';
            
        }
        //save qty & price for extras
        $prev_quantity = (int)$_POST[$key];
        $prev_price = (float)$config->items[$key_id - 1]->Price;
        //finish <tr> if customer didn't select any toppings
        /* // sandbox: $_POST[$key] != '0' && substr($key,0,4) == 'item'
        if (...) {
        
        
            echo '
                    <td>0</td>
                    <td>' . $prev_quantity * $prev_price . '</td>
                </tr>
            ';
        }
        */
    }
        
    //calculate tax & totals
    $subtotal = $items_total + $extras_total;
    $tax = $subtotal * .101; //10.1%
    $grand_total = $items_total + $extras_total + $tax;

    //money format
    $items_total = money_format('%.2n', $items_total);
    $extras_total = money_format('%.2n', $extras_total);
    $subtotal = money_format('%.2n', $subtotal);
    $tax = money_format('%.2n', $tax);
    $grand_total = money_format('%.2n', $grand_total);


    $html .= '
            </table>
        </div>
        <div class="menuitem">
            <p style="margin-top:0;">Order Summary</p>
            <p>Item(s) Total: ' . $items_total . '</p>
            <p>Topping(s) Total: ' . $extras_total . '</p>
            <p>Subtotal: ' . $subtotal . '</p>
            <p>Tax: ' . $tax . '</p>
            <p style="margin-bottom: 0;">Grand Total: ' . $grand_total . '</p>
        </div>
    ';

    return $html;
}
