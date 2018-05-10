<?php
//foodtruck_postback.php

include 'menu_objects.php';

if(isset($_POST['submit'])){//show transaction result
    
    /* 
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    */
    
}else{//show form
    global $config;
    
    //start the form:
    echo '<form action="" method="post">';
    
    foreach ($config->items as $item) 
    {//generate form block for each menu item
        echo '
        <form action="" method="post">
            <p class="menuitem">
                <label>
                <h3>' . $item->Name . '</h3>
                Quantity:<br />
                <input type="text" name="item1" required="required" />
                <br />';
        foreach ($item->Extras as $extra) 
        {//generate checkboxes for add-ons
            echo '<input type="checkbox" name="' . $extra . '" value="' . $extra . '" /> '. $extra . '<br />';
        }
    }//end form block for each menu item

    //finish off the form:
    echo '
    </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Purchase" />
            <input type="reset" />
        </p>    
    </form>                    
    ';

    
}//end show form
