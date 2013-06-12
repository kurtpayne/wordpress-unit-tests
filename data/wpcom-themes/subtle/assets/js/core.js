// JavaScript Document

var GluedTools = {

	dom : function() {
		if (!GluedTools._DOM) {
			throw "Glued Tools DOM module is missing.";
		} else {
			return GluedTools._DOM;
		}
	},
	
	animator : function() {
		if (!GluedTools._Animator) {
			throw "Glued Tools Animation module is missing.";
		} else {
			return GluedTools._Animator;
		}
	},
	
	form : function() {
		if (!GluedTools._Form) {
			throw "Glued Tools Form module is missing.";
		} else {
			return GluedTools._Form;
		}
	},

	gui : function() {
		if (!GluedTools._GUI) {
			throw "Glued Tools GUI module is missing.";
		} else {
			return GluedTools._GUI;
		}
	},
	
	widgetFactory : function() {
		if (!GluedTools._WidgetFactory) {
			throw "Glued Tools Widget module is missing.";
		} else {
			return GluedTools._WidgetFactory;
		}
	}
	
}