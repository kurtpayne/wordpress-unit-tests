/*
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 Bitflux GmbH                                      |
// +----------------------------------------------------------------------+
// | Licensed under the Apache License, Version 2.0 (the "License");      |
// | you may not use this file except in compliance with the License.     |
// | You may obtain a copy of the License at                              |
// | http://www.apache.org/licenses/LICENSE-2.0                           |
// | Unless required by applicable law or agreed to in writing, software  |
// | distributed under the License is distributed on an "AS IS" BASIS,    |
// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
// | implied. See the License for the specific language governing         |
// | permissions and limitations under the License.                       |
// +----------------------------------------------------------------------+
// | Author: Bitflux GmbH <devel@bitflux.ch>                              |
// +----------------------------------------------------------------------+

*/
var liveSearchReq = false;
var t = null;
var liveSearchLast = "";
var isIE = false;
// on !IE we only have to initialize it once
if (window.XMLHttpRequest) {
	liveSearchReq = new XMLHttpRequest();
}

function liveSearchInit() {
	
	if (navigator.userAgent.indexOf("Safari") > 0) {
		document.getElementById('livesearch').addEventListener("keydown",liveSearchKeyPress,false);
	} else if (navigator.product == "Gecko") {
		document.getElementById('livesearch').addEventListener("keypress",liveSearchKeyPress,false);
		
	} else {
		document.getElementById('livesearch').attachEvent('onkeydown',liveSearchKeyPress);
		isIE = true;
	}

}

function liveSearchKeyPress(event) {
	if (event.keyCode == 40 )
	//KEY DOWN
	{
		highlight = document.getElementById("LSHighlight");
		if (!highlight) {
			highlight = document.getElementById("LSResult").firstChild.firstChild.nextSibling.nextSibling.firstChild;
		} else {
			highlight.removeAttribute("id");
			highlight = highlight.nextSibling;
		}
		if (highlight) {
			highlight.setAttribute("id","LSHighlight");
		} 
		if (!isIE) { event.preventDefault(); }
	} 
	//KEY UP
	else if (event.keyCode == 38 ) {
		highlight = document.getElementById("LSHighlight");
		if (!highlight) {
			highlight = document.getElementById("LSResult").firstChild.firstChild.nextSibling.nextSibling.lastChild;
		} 
		else {
			highlight.removeAttribute("id");
			highlight = highlight.previousSibling;
		}
		if (highlight) {
				highlight.setAttribute("id","LSHighlight");
		}
		if (!isIE) { event.preventDefault(); }
	} 
	//ESC
	else if (event.keyCode == 27) {
		highlight = document.getElementById("LSHighlight");
		if (highlight) {
			highlight.removeAttribute("id");
		}
		document.getElementById("LSResult").style.display = "none";
		document.forms.searchform.s.value = '';
	} 
}
function liveSearchStart() {
	if (t) {
		window.clearTimeout(t);
	}
	t = window.setTimeout("liveSearchDoSearch()",200);
}

function liveSearchDoSearch() {
	if (liveSearchLast != document.forms.searchform.s.value) {
	if (liveSearchReq && liveSearchReq.readyState < 4) {
		liveSearchReq.abort();
	}
	if ( document.forms.searchform.s.value == "") {
		document.getElementById("LSResult").style.display = "none";
		highlight = document.getElementById("LSHighlight");
		if (highlight) {
			highlight.removeAttribute("id");
		}
		return false;
	}
	if (window.XMLHttpRequest) {
	// branch for IE/Windows ActiveX version
	} else if (window.ActiveXObject) {
		liveSearchReq = new ActiveXObject("Microsoft.XMLHTTP");
	}
	liveSearchReq.onreadystatechange= liveSearchProcessReqChange;
	liveSearchReq.open("GET", "/livesearch.php?s=" + document.forms.searchform.s.value);
	liveSearchLast = document.forms.searchform.s.value;
	liveSearchReq.send(null);
	}
}

function liveSearchProcessReqChange() {
	
	if (liveSearchReq.readyState == 4) {
		var  res = document.getElementById("LSResult");
		res.style.display = "block";
		/* res.firstChild.innerHTML = liveSearchReq.responseText; */
		res.firstChild.innerHTML = '<div id="searchcontrols" class="oddresult"><div class="alignleft"><small>arrow keys & enter</small></div><div class="alignright"><small><a href="javascript://" title="Close results" onclick="closeLiveSearch()">close (esc)</a></small></div><br /></div><div id="searchheader" style="display: none;"><strong><small>top 10 results</small></strong></div>'+liveSearchReq.responseText;
	}
}

function liveSearchSubmit() {
	var highlight = document.getElementById("LSHighlight");
	if (highlight && highlight.firstChild) {
		window.location = highlight.firstChild.getAttribute("href");
		return false;
	} 
	else {
		return true;
	}
}

function closeResults() {
    document.getElementById("LSResult").style.display = "none";
}
