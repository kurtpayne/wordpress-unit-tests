function showPic( whichpic ) {

	if ( document.getElementById ) {
		document.getElementById( 'placeholder' ).src = whichpic.href;
	
		if ( whichpic.title ) {
			document.getElementById( 'desc' ).childNodes[0].nodeValue = whichpic.title;
		} else {
			document.getElementById( 'desc' ).childNodes[0].nodeValue = whichpic.childNodes[0].nodeValue;
		}
		
		return false;
		
	} else {
	
		return true;
		
	}
	
}