// Revision: 2.4
// Last updated: 20th January 2006
function commentAdded(request) {
	if ($('errors')) { Element.remove('errors'); }
	new Effect.Appear($('commentlist').lastChild);
	$('comment').value = '';
	$('comment').disabled = true;
	$('submit').disabled = true;
	if ($('nocomment')) { Element.remove('nocomment'); }
	if ($('hidelist')) { Element.remove('hidelist'); }
}

function failure(request) {
	Element.show('errors');
	$('errors').innerHTML = request.responseText;
	new Effect.Highlight('errors',{queue:'end'});
	if ($('nocomment')) { Element.show('nocomment'); }
}

function loading() {
	if ($('nocomment')) { Element.hide('nocomment'); }
	$('submit').disabled = true;
	$('comment').disabled = true;  
	Element.show('loading');
}

function complete(request) {
	Element.hide('loading');
	Element.show('commentform');
	$('submit').disabled = false;
	$('comment').disabled = false;  

	if (request.status == 200) {commentAdded()}
	else {failure(request)};
}
