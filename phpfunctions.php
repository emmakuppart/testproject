<?php 
include 'connection.php';

function createTableContent() {
	global $connection;
	
	$html = '';
	
	$sql = 'SELECT * FROM andmed ORDER BY ID DESC';
	
	if ($result = $connection -> query($sql)) {
		$i = 1;
		foreach ($result as $row) {
			$html = $html . '	<div class="item">
			';
			$html = $html . '	<div class="counter-wrapper"><p>' . $i . '.</p></div>
			';
			$html = $html . '	<div class="item_values">
			';
			$html = $html . '		<div class="item_value"><input class="item_value" type="text" value="' . $row['thing1'] . '" disabled></div>
			';
			$html = $html . '		<div class="item_value"><input class="item_value" type="text" value="' . $row['thing2'] . '"disabled></div>
			';
			$html = $html . '		<div class="item_value"><input class="item_value" type="text" value="' . $row['thing3'] . '"disabled></div>
			';
			$html = $html . '		<input type="hidden" class="item_id" value="' . $row['ID'] . '">
			';
			$html = $html . '	</div>
			';
			$html = $html . '	<div class="item_buttons">
			';
			$html = $html . '		<input class="item_action_edit" type="image" src="Edit.png">
			';
			$html = $html . '		<input class="item_action_delete" type="image" src="Delete.png">
			';
			$html = $html . '	</div>
			';
			$html = $html . '</div>
			';
			$i++;
		}
	} else {
		echo $connection -> error;
	}
	
	return $html;
}

function createPopupContent() {
	$html = '';
	
	$html = $html . '<input type="text" name="thing1" id="thing1" class="changeable" disabled value="thing1">';
	$html = $html . '<br>';
	$html = $html . '<input type="text" name="thing2" id="thing2" class="changeable" disabled value="thing2">';
	$html = $html . '<br>';
	$html = $html . '<input type="text" name="thing3" id="thing3" class="changeable" disabled value="thing3">';
	$html = $html . '<br>';
	$html = $html . '<input type="hidden" name="item_id" class="item_id" value="null" disabled>';
	$html = $html . '<br>';
	
	return $html;
}

function createPopupContentForExistingItem($id) {
	global $connection;
	
	$html = '';
	
	$sql = 'SELECT * FROM andmed WHERE ID = ' . $id;
	
	if ($result = $connection -> query($sql)) {
		foreach ($result as $row) {
			$html = $html . '<input type="text" name="thing1" id="thing1" class="changeable" disabled value="' . $row['thing1'] . '">';
			$html = $html . '<br>';
			$html = $html . '<input type="text" name="thing2" id="thing2" class="changeable" disabled value="' . $row['thing2'] . '">';
			$html = $html . '<br>';
			$html = $html . '<input type="text" name="thing3" id="thing3" class="changeable" disabled value="' . $row['thing3'] . '">';
			$html = $html . '<br>';
			$html = $html . '<input type="hidden" name="item_id" class="item_id" value="' . $row['ID'] .'" disabled>';
			$html = $html . '<br>';
		}
	} else {
		//echo $connection -> error;
	}
	$connection = null;
	return $html;
}

function addItem($inputArray) {
	global $connection;
	
	$input1 = $inputArray[0];
	$input2 = $inputArray[1];
	$input3 = $inputArray[2];
	
	$sql = 'INSERT INTO andmed (thing1, thing2, thing3) 
			VALUES (:thing1, :thing2, :thing3)';
	
	if ($query = $connection -> prepare($sql)) {
		$query -> bindParam(':thing1', $input1);
		$query -> bindParam(':thing2', $input2);
		$query -> bindParam(':thing3', $input3);
		$query -> execute();
	} else {
		echo $connection -> error;
	}
}

function deleteItem($id) {
	global $connection;
	
	$sql = 'DELETE FROM andmed WHERE id = :id';
	
	if ($query = $connection -> prepare($sql)) {
		$query -> bindParam(':id', $id);
		$query -> execute();
	} else {
		echo $connection -> error;
	}
}

function updateItem($id, $inputArray) {
	global $connection;
	
	$input1 = $inputArray[0];
	$input2 = $inputArray[1];
	$input3 = $inputArray[2];
	
	$sql = 'UPDATE andmed 
			SET thing1 = :thing1, thing2 = :thing2, thing3 = :thing3
			WHERE ID = :id';
			
	echo $sql;
			
	if ($query = $connection -> prepare($sql)) {
		$query -> bindParam(':thing1', $input1);
		$query -> bindParam(':thing2', $input2);
		$query -> bindParam(':thing3', $input3);
		$query -> bindParam(':id', $id);
		$query -> execute();
	} else {
		echo $connection -> error;
	}
}