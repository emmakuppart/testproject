// ---------------- page elements: --------------
var addNewItemButton = document.getElementById("add_item");

var items = document.getElementsByClassName("item");
var editItemButtons = document.getElementsByClassName("edit_item");
var deleteItemButtons = document.getElementsByClassName("delete_item");

var closePopup = document.getElementById("close");
var saveButton = document.getElementById("save");
var deleteButton = document.getElementById("delete");
var editButton = document.getElementById("edit");
var mainpage = document.getElementById("content");

// ------------------ on click events: ------------

window.onclick = e => {
    var el = e.target;
	var className = el.className;
	var id = el.id;
	
	if (id == "popup-content-wrapper" 
	|| (id == "popup" && className == "popup") 
	|| (id == "" && className == "")) {
		if (popupIsOpen()) {
			popupClose();
		}
	}
	
	if (className.search("item_action") != -1) {
		var item_id = el.parentNode.parentNode.getElementsByClassName("item_id")[0].getAttribute("value");
		if (className == "item_action_edit") {
			clickedEditExistingItem(item_id)
		}
		if (className == "item_action_delete") {
			clickedDeleteExistingItem(item_id);
		}
	}
}
	
addNewItemButton.onclick = clickedAddNewItem;
editButton.onclick =  enableInputs;
saveButton.onclick = clickedSaveItem;
deleteButton.onclick = clickedDeleteItem;
		
function clickedAddNewItem() { //adding a new item
	loadPopup(null);
	popupOpen();
}

function clickedEditExistingItem(item_id) { 
	loadPopup(item_id);
	popupOpen();
}

function clickedDeleteExistingItem(item_id) {
	deleteItem(item_id);
	loadTable();
	popupClose();
}

function clickedDeleteItem() {
	var item_id = this.parentNode.parentNode.parentNode.getElementsByClassName("item_id")[0].getAttribute("value");
	console.log(item_id);
	if (item_id != 'null') {
		deleteItem(item_id);
		popupClose();
		loadTable();
	} else {
		alert("Can't delete a non-existing item");
	}
}

function clickedSaveItem() {
	var item_id = this.parentNode.parentNode.parentNode.getElementsByClassName("item_id")[0].getAttribute("value");
	var things = this.parentNode.parentNode.parentNode.getElementsByClassName("changeable");
	var thing1 = things[0].value;
	var thing2 = things[1].value;
	var thing3 = things[2].value;
	if (thing1 == "" || thing2 == "" || thing3 == "") {
		alert("You can't save the item with empty fields!");
	} else {
		var inputs = [thing1, thing2, thing3];
		saveItem(item_id, inputs);
		loadTable();
		popupClose();
	}
}

//------------------- functions: -----------------

function popupIsOpen() {
	var attr = document.getElementById("popup").style.display;
	if (attr == "block") {
		return true;
	} else {
		return false;
	}
}

function enableInputs() {
	var inputs = document.getElementsByClassName("changeable");
	for (i=0; i < inputs.length; i++) {
		inputs[i].removeAttribute("disabled");
	}
}

function popupOpen() {
	var popup = document.getElementById("popup");
	$("#container").attr("style", "opacity: 0.5");
	popup.style.display = "block";
}

function popupClose() {
	$("#container").attr("style", "opacity: 1");
	popup.style.display = "none";
}

function saveItem(item_id, inputArray) {

	sendGETXhttpRequest(
			"saveitem.php?item_id=" + item_id + 
			"&thing1=" + inputArray[0] + 
			"&thing2=" + inputArray[1] + 
			"&thing3=" + inputArray[2]
			, null);
}

function deleteItem(item_id) {

	sendGETXhttpRequest("deleteitem.php?item_id=" + item_id, null);
}

function loadPopup(item_id) {
	
	sendGETXhttpRequest("createpopup.php?item_id=" + item_id, "#values");
}

function loadTable() { //vaadata äkki saab ajaxi peale ümber teha
	
	sendGETXhttpRequest("createtable.php", "#added_items");
}

function sendGETXhttpRequest(url, IdOfelementToBeChanged) {
	
	//ajax xml was working but i wanted to try ajax jquery as well
	/*var xhttp = new XMLHttpRequest();
	
	$('document').ready(function(){
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (IdOfelementToBeChanged != null) {
					document.getElementById(IdOfelementToBeChanged).innerHTML = this.responseText;
			}
		}
	};
	});
	
	xhttp.open("GET", url, true);
	xhttp.send();*/
	
	$.ajax({
		type: "GET",
		url: url, 
		success: function(result) {
			if (IdOfelementToBeChanged != null) {
				$(IdOfelementToBeChanged).html(result);
			}
		}
	});
}