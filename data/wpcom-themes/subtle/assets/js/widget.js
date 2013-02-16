// JavaScript Document

GluedTools._WidgetFactory = {
	
	bindElement : function (protoWidget, elementid) {
		var elementBase = GluedTools._DOM.getElementByID(elementid);
		var widget = GluedTools._DOM.cloneObject(protoWidget);
		widget.elements.base = elementid;
		widget.id = elementid;
		
		if (elementBase) {
			for (attribute in elementBase.attributes) {
				if (elementBase.attributes[attribute] != null && typeof(elementBase.attributes[attribute].name) == "string") {
					var attrNamespace = elementBase.attributes[attribute].name.split(":");
					if (attrNamespace[0] == "widget") {
						var attributeName = "widget";
						for (index = 1; index < attrNamespace.length; index++) {
							if (typeof(eval(attributeName + "." + attrNamespace[index].toLowerCase())) === "undefined") {
								eval(attributeName + "." + attrNamespace[index].toLowerCase() + "= {}");
							}
							attributeName = attributeName + "." + attrNamespace[index].toLowerCase();
						}
						if (elementBase.attributes[attribute].value == "true") { 
							eval(attributeName + " = true");
						} else if (elementBase.attributes[attribute].value == "false") {
							eval(attributeName + " = false");
						} else {
							eval(attributeName + " = elementBase.attributes[attribute].value");
						}
					}
				}
			}

			if (typeof(widget.dragdrop) != "undefined") {
				if (widget.dragdrop.drag || widget.dragdrop.target) { this.makeDragDrop(widget); }
			}
			
			if (GluedTools._DOM.getElementStyle(elementBase, "left").indexOf("px") < 0) { widget.virtualLeft = 0; } else { widget.virtualLeft = parseInt(GluedTools._DOM.getElementStyle(elementBase, "left")); }
			if (GluedTools._DOM.getElementStyle(elementBase, "top").indexOf("px") < 0) { widget.virtualTop = 0; } else { widget.virtualTop = parseInt(GluedTools._DOM.getElementStyle(elementBase, "top")); }

			return widget;
		} else {
			return false;
		}
	},

	getRootWidget : function (object) {
		if (object.parentWidget === false) {
			return object;
		} else {
			return this.getRootWidget(object.parentWidget);
		}
	},
	
	moveElement : function (widget, element, deltaLeft, deltaTop) {
		var elementTop = parseInt(GluedTools._DOM.getElementStyle(element, "top"));
		var elementLeft = parseInt(GluedTools._DOM.getElementStyle(element, "left"));
		
		widget.virtualTop = widget.virtualTop + deltaTop;
		widget.virtualLeft = widget.virtualLeft + deltaLeft;
		
		if (parseInt(widget.aliasVert) > 0 ) { var displayTop = Math.round(widget.virtualTop / parseInt(widget.aliasVert)) * parseInt(widget.aliasVert); } else { var displayTop = widget.virtualTop; }
		if (parseInt(widget.aliasHoriz) > 0 ) { var displayLeft = Math.round(widget.virtualLeft / parseInt(widget.aliasHoriz)) * parseInt(widget.aliasHoriz); } else { var displayLeft = widget.virtualLeft; }

		if (displayTop < parseInt(widget.mintop)) { displayTop = parseInt(widget.mintop); }
		if (displayTop > parseInt(widget.maxtop)) { displayTop = parseInt(widget.maxtop); }
		if (displayLeft < parseInt(widget.minleft)) { displayLeft = parseInt(widget.minleft); }
		if (displayLeft > parseInt(widget.maxleft)) { displayLeft = parseInt(widget.maxleft); }

		if (this.getRootWidget(widget).animator && widget.animationTemplate["dragHoriz"] && displayLeft != elementLeft) {
			widget.animationTemplate["dragHoriz"].element = element;
			widget.animationTemplate["dragHoriz"].endValue = displayLeft + "px";
			this.getRootWidget(widget).animator.animateAttribute(widget.animationTemplate["dragHoriz"]);
		} else {
			GluedTools._DOM.setElementStyle(element, "left", displayLeft + "px")
		}

		if (this.getRootWidget(widget).animator && widget.animationTemplate["dragVert"] && displayTop != elementTop) {
			widget.animationTemplate["dragVert"].element = element;
			widget.animationTemplate["dragVert"].endValue = displayTop + "px";
			this.getRootWidget(widget).animator.animateAttribute(widget.animationTemplate["dragVert"]);
		} else {
			GluedTools._DOM.setElementStyle(element, "top", displayTop + "px")
		}
	},


	makeDragDrop : function (widget) {

		var onMouseDown_handler = function (event) {
			if (widget.dragdrop.drag) {
				var elementDrag = GluedTools._DOM.getElementByID(widget.elements.drag);
				widget.dragdrop.mousedown = true;
				widget.dragdrop.selected = true;
				widget.dragdrop.clientx = event.clientX;
				widget.dragdrop.clienty = event.clientY;

				if (GluedTools._DOM.getElementStyle(elementDrag, "position") == "absolute") {
					var positionDrag = GluedTools._DOM.getElementPosition(elementDrag);
					if (GluedTools._DOM.getElementStyle(elementDrag, "left").indexOf("px") < 0) { GluedTools._DOM.setElementStyle(elementDrag, "left", positionDrag.left + "px"); }
					if (GluedTools._DOM.getElementStyle(elementDrag, "top").indexOf("px") < 0) { GluedTools._DOM.setElementStyle(elementDrag, "top", positionDrag.top + "px"); }
				}

				widget.onDragStart(widget);
			}
		}

		var onMouseMove_handler = function (event) {
			if (widget.dragdrop.mousedown && widget.dragdrop.drag && !widget.dragdrop.locked) {
				widget.dragdrop.dragging = true;

				widget.onDrag(widget);
				GluedTools._WidgetFactory.moveElement(widget, GluedTools._DOM.getElementByID(widget.elements.drag), event.clientX - widget.dragdrop.clientx, event.clientY - widget.dragdrop.clienty);

				widget.dragdrop.clientx = event.clientX;
				widget.dragdrop.clienty = event.clientY;
				
				GluedTools._WidgetFactory.getRootWidget(widget).handleBubble("this.onDragOver_handler", widget);
			}
		}

		var onMouseUp_handler = function (event) {
			if (widget.dragdrop.mousedown) {
				widget.dragdrop.mousedown = false;
				widget.dragdrop.dragging = false;
				widget.onDragEnd(widget);
				GluedTools._WidgetFactory.getRootWidget(widget).handleBubble("this.onDrop_handler", widget);
			}
		}
		
		widget.onDragOver_handler = function (widgetDrag) {
			if (this.dragdrop.target && widgetDrag != this && this.group === widgetDrag.group) {
				var elementBase = GluedTools._DOM.getElementByID(this.elements.base);
				var elementDrag = GluedTools._DOM.getElementByID(widgetDrag.elements.drag);
				
				var positionBase = GluedTools._DOM.getElementPosition(elementBase);
				if (widgetDrag.dragdrop.targetstyle == "cursor") {
					var positionDrag = { top : widgetDrag.dragdrop.clienty, left : widgetDrag.dragdrop.clientx, height : 0, width : 0 }
				} else {
					var positionDrag = GluedTools._DOM.getElementPosition(elementDrag);
				}
				
				if (GluedTools._DOM.checkElementOverlap(positionBase, positionDrag)) {
					if (!this.dragdrop.targeted) {
						this.dragdrop.targeted = true;
						this.onDragEnter(widgetDrag);
						widgetDrag.onDragOver(this);
					}
				} else if (this.dragdrop.targeted) {
					this.onDragLeave(widgetDrag);
					this.dragdrop.targeted = false;
					widgetDrag.onDragOut(this);
				}
			}
		}
		
		widget.onDrop_handler = function (widgetDrag) {
			if (this.dragdrop.targeted && this != widgetDrag && this.group == widgetDrag.group) {
				this.onDrop(widgetDrag);
			}
		}

		if (typeof(widget.elements.handle) != "string") { widget.elements.handle = widget.elements.base; }
		if (typeof(widget.elements.drag) != "string") { widget.elements.drag = widget.elements.base; }

		widget.dragdrop.clientx = null;
		widget.dragdrop.clienty = null;
		widget.dragdrop.dragging = false;
		widget.dragdrop.mousedown = false;
		widget.dragdrop.selected = false;
		widget.dragdrop.targeted = false;
			
		if (typeof(widget.dragdrop.targetstyle) == "undefined") { widget.dragdrop.targetstyle = "cursor"; }
		if (typeof(widget.dragdrop.locked) == "undefined") { widget.dragdrop.targetstyle = false; }

		if (typeof(widget.onSelect) == "undefined") { widget.onSelect = function () {}; }
		if (typeof(widget.onDragStart) == "undefined") { widget.onDragStart = function () {}; }
		if (typeof(widget.onDrag) == "undefined") { widget.onDrag = function () {}; }
		if (typeof(widget.onDragEnd) == "undefined") { widget.onDragEnd = function () {}; }
		if (typeof(widget.onDragOver) == "undefined") { widget.onDragOver = function () {}; }
		if (typeof(widget.onDragOut) == "undefined") { widget.onDragOut = function () {}; }

		if (typeof(widget.onDragEnter) == "undefined") { widget.dragOver = function () {}; }
		if (typeof(widget.onDragLeave) == "undefined") { widget.dragOver = function () {}; }
		if (typeof(widget.onDrop) == "undefined") { widget.dropOn = function () {}; }

		GluedTools._DOM.addEventListener(GluedTools._DOM.getElementByID(widget.elements.handle), "mousedown", onMouseDown_handler, true);
		GluedTools._DOM.addEventListener(document, "mouseup", onMouseUp_handler, true);
		GluedTools._DOM.addEventListener(document, "mousemove", onMouseMove_handler, true);
	},


	prototypes : {

		generic : function () {
			var widget = {
				id : null,
				type : null,
				form : null,
				group : "default",

				elements : { base : null },
				parentWidget : false,
				childWidgets : new Array,

				animator : null,
				animationTemplate : new Array,

				virtualTop : null,
				virtualLeft : null,
				aliasHoriz : "0px",
				aliasVert : "0px",
				mintop : null,
				maxtop : null,
				minleft : null,
				maxleft : null,
	
				appendWidget : function (widget) {
					widget.parentWidget = this;
					this.childWidgets[widget.id] = widget;
				},
				
				handleBubble : function (method, args) {
					if (typeof(eval(method)) != "undefined") { eval(method + "(args)"); }
					for (childIndex in this.childWidgets) { 
						this.childWidgets[childIndex].handleBubble(method, args); 
					}
				}
				
			}
			
			return widget;
		},
		
		form : function () {
			var widget = new GluedTools._WidgetFactory.prototypes.generic();
			
			widget.directives = new Array;
			widget.hasXHR = false;
			
			widget.startQueue = function () {
				var self = this;
				
				var processDirectives = function () {

					var XHR;
					var directives = widget.directives;
					var action = GluedTools._DOM.getElementByID(self.elements.base).action;
					var request = { 
						formID : self.id,
						directives : directives
					}
					
					if (action && directives.length > 0) {
						try { 
							XHR = new ActiveXObject("Msxml2.XMLHttp"); 
						} catch(e) { 
							try { 
								XHR = new ActiveXObject("Microsoft.XMLHttp"); 
							} catch(e2) { } 
						}
						
						if (XHR == undefined && (typeof XMLHttpRequest != 'undefined')) { XHR = new XMLHttpRequest(); }
		
						XHR.onreadystatechange = function () { self.processResponse(XHR); }
						XHR.open("POST", action, true);
						XHR.send(JSON.stringify(request));
						
						self.clearDirectives();
						
					} else {
						return false;
					}
				}
				
				setInterval(processDirectives, 1000);
		
			}
			
			widget.addDirective = function (method, args) {
				widget.directives[widget.directives.length] = { method : method, args : args };
				return widget.directives.length;
			}
			
			widget.removeDirective = function (directiveID) {
			}
			
			widget.clearDirectives = function () {
				widget.directives = new Array;
				return true;
			}
			
			widget.processResponse = function (XHR) {
				if (XHR.readyState == 4) {
					if(XHR.status == "200") {
						var response = JSON.parse(XHR.responseText);
						for (directive in response) {
							eval("this." + response[directive]['method'] + "(response[directive]['args'])");
						}
					}
				}
			}
			
			return widget;
		}

	}

}