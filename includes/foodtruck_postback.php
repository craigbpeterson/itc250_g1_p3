<?php
//foodtruck_postback.php

include 'menu_objects.php';

if(isset($_POST['submit'])){//show transaction result
    
     
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
            //' . $extra . '
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
