// JavaScript Document

GluedTools._DOM = {

	getBrowserType : function () {
		if (navigator.userAgent.indexOf("Opera")!=-1 && document.getElementById) { 
			return "OP";
		} else if (document.all) {
			return "IE";
		} else if (document.layers) { 
			return "NN";
		} else if (!document.all && document.getElementById) {
			return "MO";
		} else {
			return "IE";
		}
	},
	
	getElementByID : function (elementID) {
		if (document.layers) {
			// NN4+
			return document.layers[elementID];
		} else if (document.getElementById) {
			// NN6 + IE5+
			return document.getElementById(elementID);
		} else if (document.all) {
			// IE4
			return document.all[elementID];
		}
	},
	
	getElementsByTagName : function (elementTag) {
		if (document.layers) {
			// NN4+ - Find out about this one
			return null;
		} else if (document.getElementsByTagName) {
			// NN6 + IE5+
			return document.getElementsByTagName(elementID);
		} else if (document.all) {
			// IE4
			return document.all.tags(elementID);
		}
	},
	
	getElementsByClassName : function (className) {
		var foundElements = [];
		var regexp = new RegExp('\\b' + className + '\\b');
		var all_elements = document.all ? document.all : document.getElementsByTagName("*");
		for (var i = 0, j = all_elements.length; i < j; i++) {
			if (regexp.test( all_elements[i].className)) {
				foundElements.push(all_elements[i]);
			}
		}
		return foundElements;
	},
	
	setElementStyle : function (element, attribute, value) {
		if(document.layers) {
			element[attribute] = value;
		} else {
			if (attribute == 'opacity') {
				if (element.filters) {
					element.style.filter = 'alpha(opacity=' + value * 100 + ')';
				} else {
					element.style.opacity = value;
					element.style['-moz-opacity'] = value;
					element.style['-khtml-opacity'] = value;
				}
			} else {
				element.style[attribute] = value;
			}
		}
	},
	
	getElementStyle : function (element, attribute) {
		if(document.layers) {
			return element[attribute];
		} else {
			if (!element.style[attribute]) { 
				if (window.getComputedStyle) {
					this.setElementStyle(element, attribute, window.getComputedStyle(element, null)[attribute]); 
				} else {
					this.setElementStyle(element, attribute, element.currentStyle[attribute]); 
				}
			}
			return element.style[attribute];
		}
	},
	
	addEventListener : function (element, eventtype, callback, captures) {
		if (element.addEventListener) {
			element.addEventListener(eventtype, callback, captures);
		} else if (element.attachEvent) {
			element.attachEvent('on'+eventtype, callback, captures);
		} else {
			element['on'+eventtype] = callback;
		}
	},
	
	getElementPosition : function (element) {
		var position = new Array;
		if (document.getBoxObjectFor) {
			var box = document.getBoxObjectFor(element);
			position['left'] = box.x;
			position['width'] = box.width;
			position['top'] = box.y;
			position['height'] = box.height;
		} else if (element.getBoundingClientRect) {
			var box = element.getBoundingClientRect();
			position['left'] = box.left;
			position['width'] = box.right - box.left;
			position['top'] = box.top;
			position['height'] = box.bottom - box.top;
		} 
		return position;
	},
	
	pageX : function (pos) {
		if (document.all) {
			return document.body.scrollLeft + pos;
		} else {
			return window.pageXOffset + pos;
		}
	},

	pageY : function (pos) {
		if (document.all) {
			return document.body.scrollTop + pos;
		} else {
			return window.pageYOffset + pos;
		}
	},
	
	swapNodes : function (elementA, elementB) {
		var cloneA = elementA.cloneNode(true);
		elementB.parentNode.insertBefore(clonedA, elementB);
		elementA.parentNode.replaceNode(elementB, elementA);
		return true;
	},
	
	getViewportSize : function () {

		var windowSize = { width : 0, height : 0 };
		
		if (typeof window.innerWidth != 'undefined') {
			windowSize = { width : window.innerWidth, height : window.innerHeight };
		} else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
			windowSize = { width : document.documentElement.clientWidth, height : document.documentElement.clientHeight };
		} else {
			windowSize = { width : document.getElementsByTagName('body')[0].clientWidth, height : document.getElementsByTagName('body')[0].clientHeight };
		}
		
		return windowSize;
	},
	
	cloneObject : function (object) {
		var clone = {}

		for (property in object) {
			if (typeof(object[property]) == "object") {
				clone[property] = new GluedTools._DOM.cloneObject(object[property]);
			} else {
				clone[property] = object[property];
			}
		}
		return clone;
	},
	
	checkElementOverlap : function (positionA, positionB) {
		var overlapFlag = true;
		
		if (positionA.top > (positionB.top + positionB.height) && (positionA.top + positionA.height) > (positionB.top + positionB.height)) { overlapFlag = false; }
		if (positionA.top < positionB.top && (positionA.top + positionA.height) < positionB.top) { overlapFlag = false; }

		if (positionA.left > (positionB.left + positionB.width) && (positionA.left + positionA.width) > (positionB.left + positionB.width)) { overlapFlag = false; }
		if (positionA.left < positionB.left && (positionA.left  + positionA.width) < positionB.left) { overlapFlag = false; }
		
		return overlapFlag;
	}

}