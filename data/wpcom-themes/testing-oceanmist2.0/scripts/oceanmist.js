// Loads up the various functions we are going to use
$(document).ready(function(){
	jsEnabled();
	lastLi();
	corners();
	imgLeft();
	imgRight();
	newerEntries();
	olderEntries();
});

// Adds a class to the body so I can style differently depending on whether Javascript is enabled.
function jsEnabled() {
	$("body").addClass("jsenabled");	
}
function lastLi() {
	$("ul li:last-child").addClass("lastLi");	
}
function imgLeft() {
	$("img[align=left]").addClass("alignleft");	
}
function imgRight() {
	$("img[align=right]").addClass("alignright");	
}
// adds lots of divs used to create the rounded corners
function corners() {
  $("#header").append('<div class="rightShade"></div><div class="leftShade"></div><div class="leftCorner"><div class="dot1a dot dot0"></div><div class="dot1b dot dot0"></div><div class="dot1c dot dot30"></div><div class="dot1d dot dot50"></div><div class="dot2a dot dot0"></div><div class="dot2b dot dot50"></div><div class="dot2c dot"></div><div class="dot2d dot"></div><div class="dot3a dot dot30"></div><div class="dot3b dot"></div><div class="dot3c dot"></div><div class="dot3d dot"></div><div class="dot4a dot dot50"></div><div class="dot4b dot"></div><div class="dot4c dot"></div><div class="dot4d dot"></div></div><div class="rightCorner"><div class="dot1a dot dot0"></div><div class="dot1b dot dot0"></div><div class="dot1c dot dot30"></div><div class="dot1d dot dot50"></div><div class="dot2a dot dot0"></div><div class="dot2b dot dot50"></div><div class="dot2c dot"></div><div class="dot2d dot"></div><div class="dot3a dot dot30"></div><div class="dot3b dot"></div><div class="dot3c dot"></div><div class="dot3d dot"></div><div class="dot4a dot dot50"></div><div class="dot4b dot"></div><div class="dot4c dot"></div><div class="dot4d dot"></div></div>');
  $("#footer").append('<div class="rightShade"></div><div class="leftShade"></div><div class="leftCorner"><div class="dot1a dot dot0"></div><div class="dot1b dot dot0"></div><div class="dot1c dot dot30"></div><div class="dot1d dot dot50"></div><div class="dot2a dot dot0"></div><div class="dot2b dot dot50"></div><div class="dot2c dot"></div><div class="dot2d dot"></div><div class="dot3a dot dot30"></div><div class="dot3b dot"></div><div class="dot3c dot"></div><div class="dot3d dot"></div><div class="dot4a dot dot50"></div><div class="dot4b dot"></div><div class="dot4c dot"></div><div class="dot4d dot"></div></div><div class="rightCorner"><div class="dot1a dot dot0"></div><div class="dot1b dot dot0"></div><div class="dot1c dot dot30"></div><div class="dot1d dot dot50"></div><div class="dot2a dot dot0"></div><div class="dot2b dot dot50"></div><div class="dot2c dot"></div><div class="dot2d dot"></div><div class="dot3a dot dot30"></div><div class="dot3b dot"></div><div class="dot3c dot"></div><div class="dot3d dot"></div><div class="dot4a dot dot50"></div><div class="dot4b dot"></div><div class="dot4c dot"></div><div class="dot4d dot"></div></div>');
  $("#mainCol").append('<div class="rightShade"></div>');
}
function newerEntries() {
	$("h2.title a:contains('Newer Entries')").addClass("newerEntries");	
}
function olderEntries() {
	$("h2.title a:contains('Older Entries')").addClass("olderEntries");	
}
