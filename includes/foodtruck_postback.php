<?php
//foodtruck_postback.php

include 'menu_objects.php';

if(isset($_POST['submit'])){//show data
    
    /* 
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    */
    
}else{//show form
    echo '
    <form action="" method="post">
        <p>
            <label>
            <h3>' . $myItem->Name . '</h3>
            Quantity:<br />
            <input type="text" name="item1" required="required" />
            <br />
            <input type="checkbox" name="addon1" value="addon1" /> Add-On 1<br />
            <input type="checkbox" name="addon2" value="addon2" /> Add-On 2<br />
            <input type="checkbox" name="addon3" value="addon3" /> Add-On 3<br />
            </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Purchase" />
            <input type="reset" />
        </p>    
    </form>    
    ';
}
