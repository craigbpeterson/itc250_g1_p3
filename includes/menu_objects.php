<?php
//menu_objects.php

$myItem = new Item(1,'Taco','Our tacos are awesome!',3.99);
$myItem->addExtra('Sour Cream');
$myItem->addExtra('Salsa');
$myItem->addExtra('Guacamole');
$myItem->addExtra('Cheese');
$myItem->addExtra('Hot Sauce');
$config->items[] = $myItem;

$myItem = new Item(2,'Hot Dog','The price is worth it!',199.99);
$myItem->addExtra('Ketchup');
$myItem->addExtra('Mustard');
$myItem->addExtra('Relish');
$myItem->addExtra('Cream Cheese');
$config->items[] = $myItem;

class Item
{
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Extras = array();
    
    public function __construct($ID,$Name,$Description,$Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
    
    public function addExtra($extra)
    {
        $this->Extras[] = $extra;
        
    }#end addExtra()

}#end Item class