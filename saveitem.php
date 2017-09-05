<?php
include 'phpfunctions.php';
	
$item_id =  $_GET['item_id'];
$thing1 =  $_GET['thing1'];
$thing2 =  $_GET['thing2'];
$thing3 =  $_GET['thing3'];
$inputArray = array($thing1, $thing2, $thing3);

if ($item_id == 'null') {
	addItem($inputArray);
} else {
	updateItem($item_id, $inputArray);
}
