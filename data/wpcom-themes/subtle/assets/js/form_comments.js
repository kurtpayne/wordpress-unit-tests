// JavaScript Document

window.onload = function () {
	var DOM = new GluedTools.dom();
	var eCommentArea = DOM.getElementByID('comment_area');
	var eFormComment = DOM.getElementByID('form_comments');
	var eAllowFloat = DOM.getElementByID('input_allow_float');
	var currentPageY = DOM.pageY(0);
	
	if (DOM.getBrowserType() != 'IE') { setInterval(handleMovement, 10); }
	
	function handleMovement () {
		if (DOM.pageY(0) != currentPageY) {
			currentPageY = DOM.pageY(0);
			var posCommentArea = DOM.getElementPosition(eCommentArea);
			var posFormComment = DOM.getElementPosition(eFormComment);
			if (currentPageY > (posCommentArea.top - 20) && eAllowFloat.checked) {
				if (DOM.getElementStyle(eFormComment, 'position') != 'fixed' && parseInt(posCommentArea.height) > parseInt(posFormComment.height) + 100) {
					DOM.setElementStyle(eCommentArea, 'height', parseInt(posCommentArea.height) + 'px');
					DOM.setElementStyle(eFormComment, 'position', 'fixed');
					DOM.setElementStyle(eFormComment, 'top', '20px');
					DOM.setElementStyle(eFormComment, 'marginLeft', '460px');
				}
			} else {
				DOM.setElementStyle(eFormComment, 'position', 'relative');
				DOM.setElementStyle(eFormComment, 'top', '0px');
				DOM.setElementStyle(eFormComment, 'marginLeft', '20px');
			}
		}
	}
}

