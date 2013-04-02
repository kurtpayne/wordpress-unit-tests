function pp_go( selectObj )
{
	var selected = selectObj.options[selectObj.selectedIndex].value;
	if ( selected ) {
		window.location.href = selected;
	}
}

function pp_toggle( toggleID )
{
	var projectList = document.getElementById( toggleID );
	if ( !projectList ) {
		return;
	}
	if ( projectList.style.display == 'none' ) {
		projectList.style.display = 'block';
	} else {
		projectList.style.display = 'none';
	}
}

function pp_switch_feeds( linksID, linkObj, showFeedID, hideFeedID )
{
	var links = document.getElementById( linksID );
	if ( !links ) {
		return;
	}
	if ( !linkObj ) {
		return;
	}
	var showFeed = document.getElementById( showFeedID );
	if ( !showFeed ) {
		return;
	}
	var hideFeed = document.getElementById( hideFeedID );
	if ( !hideFeed ) {
		return;
	}
	hideFeed.style.display = 'none';
	showFeed.style.display = 'block';
	for ( var x = 0; x < links.childNodes.length; x++ ) {
		links.childNodes[x].className = '';
	}
	linkObj.parentNode.className = 'active';
}