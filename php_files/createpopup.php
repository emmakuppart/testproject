<?php
include 'phpfunctions.php';

$item_id =  $_GET['item_id'];
if ($item_id == 'null') {
	echo createPopupContent();
} else {
	echo createPopupContentForExistingItem($item_id);
}