/* Show/Hide
----------------------*/
function show(element) {
	document.getElementById(element).style.display = "none";
	document.getElementById(element+"-hidden").style.display = "";
}

function hide(element) {
	document.getElementById(element).style.display = "";
	document.getElementById(element+"-hidden").style.display = "none";
}

/* Show/Hide comment info
----------------------*/
function ShowInfo() {
	document.getElementById("comment-author").style.display = "";
	document.getElementById("showinfo").style.display = "none";
	document.getElementById("hideinfo").style.display = "";
}

function HideInfo() {
	document.getElementById("comment-author").style.display = "none";
	document.getElementById("showinfo").style.display = "";
	document.getElementById("hideinfo").style.display = "none";
}

/* Show/Hide formatting info
----------------------*/
formattingOpen = false;
function toggleFormatting() {
	if (formattingOpen == false) {
		document.getElementById("tags-allowed").style.display = "";
		formattingOpen = true;
	} else {
		document.getElementById("tags-allowed").style.display = "none";
		formattingOpen = false;
	}
}