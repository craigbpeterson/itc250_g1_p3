<?php
//foodtruck_postback.php
include 'menu_objects.php';


if (isset($_POST['submit'])) {//show result
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    
    $status = checkQuantity(); //checks user input, returns a string for the following switch block

    
    switch($status)
    {
        case 'quantity is not a number':
            echo '
            <p class="inputerror">Quantity must be a number.</p>
            ';
            break;
        
        case 'quantity is less than 1':
            echo '
            <p class="inputerror">If you want food in your belly, please select at least one menu item.</p>
            ';
            break;
        
        case 'quantity is more than 0':
            echo showTransactionResult();
            break;
            
    }//end switch
      
} else {//show form
    echo showForm();
}

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
    $items_subtotal = 0; //init
    $extras_subtotal = 0; //init
    
    /*
    echo '<pre>';
    var_dump($_POST);
    echo'</pre>';
    */
    
    //start ITEMS ordered table
    //date format May 13, 2018, 1:16 am
    $html = '

        <h2>
            <span>Order Details</span>
        </h2>

        <p style="margin-left:1rem; margin-top:0;">Order Date: ' . date("F j, Y, g:i a") . '</p>
        <div class="menuitem">
            <h3 style="margin-top:0;">Items Ordered:</h3>
            <table style="width:100%">
                <tr>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Item Total</th>
                </tr>
    ';
    
    //this foreach block generates the table rows of ITEMS ordered
    foreach ($_POST as $key => $value) 
    {
        //check $key is an item or a topping
        if (substr($key,0,5) == 'item_') {
            
            //get qty, cast as int
            $quantity = (int)$value;
            
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
                
                //calculate total for this item
                $item_total = $quantity * $price;
                
                //add to over items subtotal
                $items_subtotal += $item_total;
                
                //money format
                $price_output = money_format('%.2n', $price);
                $item_total_output = money_format('%.2n', $item_total);
                    
                $html .= '
                    <tr>
                        <td>' . $name . '</td>
                        <td>' . $quantity . '</td>
                        <td>' . $price_output . '</td>
                        <td>' . $item_total_output . '</td>
                    </tr>
                ';
            }
        }
    }
    
    //money format
    $items_subtotal_output = money_format('%.2n', $items_subtotal);
    
    //finish ITEMS table
    $html .= '
            <tr class="tabletotal">
                <td colspan=3 class="tabletotaltitle">Items Subtotal: </td>
                <td>' . $items_subtotal_output . '</td>
            </tr>
        </table>
    '; 
    
    //start EXTRAS ordered table
    $extras_html = '
        <h3>Extras Ordered:</h3>
        <table style="width:100%">
            <tr>
                <th>Extra</th>

                <th>Qty</th>

                <th>Price</th>
            </tr>
    ';
    
    //this foreach block generates the table rows of EXTRAS ordered
    foreach ($_POST as $key => $value) 
    {
        if (substr($key,0,7) == 'extras_') {
            
            foreach ($value as $extra_key => $extra) {
                
                //seperate string with _ as the delimiter
                $key_array = explode('_',$key);
                
                //cast item number as an integer
                $key_id = (int)$key_array[1];
                
                $associated_item_key = 'item_' . $key_id;
                
                $quantity_of_extra = $_POST[$associated_item_key];
                
                $extra_subtotal = $quantity_of_extra * 0.25; //calculates subtotal of each particular extra
                
                $extras_subtotal += $extra_subtotal; //adds to overall subtotal of all extras
                
                $extra_subtotal_output = money_format('%.2n', $extra_subtotal);

                //add row to EXTRAS table
                $extras_html .= '
                <tr>
                    <td>' . $extra . '</td>

                    <td>' . $quantity_of_extra . '</td>
                    <td>' . $extra_subtotal_output . '</td>

                </tr>
                ';
            }
        }
    }
    
    //money format
    $extras_subtotal_output = money_format('%.2n', $extras_subtotal);
    
    //finish EXTRAS table
    $extras_html .='
            <tr class="tabletotal">

                <td colspan="2" class="tabletotaltitle">Extras Subtotal: </td>

                <td>' . $extras_subtotal_output . '</td>
            </tr>
        </table>
        </div>
    ';
    
    if ($extras_subtotal == 0) {
        $extras_html = '
            <h3>Extras Ordered:</h3>
            <p>No extras were ordered.</p>
            </div>
            ';
    }
    
    $html .= $extras_html;
    
    //calculate tax & totals
    $order_subtotal = $items_subtotal + $extras_subtotal;
    $tax = $order_subtotal * .101; //10.1%
    $grand_total = $order_subtotal + $tax;
    
    //money format
    $order_subtotal = money_format('%.2n', $order_subtotal);
    $tax = money_format('%.2n', $tax);
    $grand_total = money_format('%.2n', $grand_total);

    //display order summary
    $html .= '
        <div class="menuitem">
            <h3 style="margin-top:0;">Order Summary:</h3>
            <table style="width:100%">
                <tr>
                    <td>Item(s) Subtotal: </td>
                    <td>' . $items_subtotal_output . '</td>
                </tr>
                <tr>
                    <td>Extra(s) Subtotal: </td>
                    <td>' . $extras_subtotal_output . '</td>
                </tr>
                <tr>
                    <td>Order Subtotal: </td>
                    <td>' . $order_subtotal . '</td>
                </tr>
                <tr>
                    <td>Tax: </td>
                    <td>' . $tax . '</td>
                </tr>
                <tr class="tabletotal">
                    <td>Grand Total: </td>
                    <td>' . $grand_total . '</td>
                </tr>
            </table>
        </div>
    ';


    return $html;
}


function showForm()
{
    global $config;
    
    //start the form:
    $html = '

    <h2 class="main-course"><span>Our Delicious Menu Items</span></h2>

        <form action="" method="post">
    ';
    
    foreach ($config->items as $item)
    {//generate form block for each menu item
        $html .= '
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
            $html .= '
                <input type="checkbox" name="extras_' . $item->ID . '[]" id="' . str_replace(' ','',$extra) . '" value="' . $extra . '" />
                <label for="' . str_replace(' ','',$extra) . '">' . $extra . '</label>
                <br />
            ';
        }
        $html .= '
                </div>
                
            </div>
        ';
        
    }//end form block for each menu item
    //finish off the form:
    $html .= '
            <div class="formbuttons">
                <input type="submit" name="submit" value="Purchase" />
                <input type="reset" />
            </div>    
        </form>
    ';
    
    return $html;

}

