/**
 * Animation object constructor.  Allows for simplified animation of 
 * elements and their attributes on a page.
 * 
 */

GluedTools._Animator = {

	framesPerSecond : 15,
	interval : 67,
	currentFrame : 0,
	animationQueue : new Array,
	DOM : new GluedTools.dom(),

	startAnimator : function () {
		var self = this;

		var renderAnimationQueue = function () {
			var currentFrame = self.currentFrame++;
			var animationQueue = self.animationQueue;
			var emptyQueue = true;

			for (requestIndex in animationQueue) {
				var currentRequest = animationQueue[requestIndex];

				if (currentRequest != null) {
					emptyQueue = false;

					if (currentFrame > currentRequest.endFrame) {
						if (currentRequest.attribute.indexOf("style[") > -1) {
							self.DOM.setElementStyle(currentRequest.element, currentRequest.attribute.substring(7, currentRequest.attribute.length - 2), self.toValueString(currentRequest.aliasedValue));
						} else {
							eval("currentRequest.element." + currentRequest.attribute + " = self.toValueString(currentRequest.aliasedValue)");
						}
						animationQueue[requestIndex] = null;
					} else {

						if (currentFrame >= currentRequest.startFrame) {

							if (currentFrame < currentRequest.easeTo) {
								var frameSpeed = (currentFrame - currentRequest.startFrame) / (currentRequest.easeTo - currentRequest.startFrame);
							} else if (currentFrame > currentRequest.easeFrom) {
								var frameSpeed = (currentRequest.endFrame - currentFrame) / (currentRequest.endFrame - currentRequest.easeFrom);
							} else {
								var frameSpeed = 1
							}
							
							if (currentRequest.easeToMethod == "cos") {
								var frameSpeed = Math.cos((Math.PI / 2) * frameSpeed);
							} else if (currentRequest.easeToMethod == "sin") {
								var frameSpeed = Math.sin((Math.PI / 2) * frameSpeed);
							}

							if (currentRequest.easeFromMethod == "cos") {
								var frameSpeed = Math.cos((Math.PI / 2) * frameSpeed);
							} else if (currentRequest.easeFromMethod == "sin") {
								var frameSpeed = Math.sin((Math.PI / 2) * frameSpeed);
							}

							for (valuePart in currentRequest.incrementValue.value) {
								currentRequest.currentValue.value[valuePart] = currentRequest.currentValue.value[valuePart] + (currentRequest.incrementValue.value[valuePart] * frameSpeed);
								
								if (currentRequest.startValue.value[valuePart] > currentRequest.endValue.value[valuePart]) {
									if (currentRequest.endValue.value[valuePart] > currentRequest.currentValue.value[valuePart]) {currentRequest.currentValue.value[valuePart] = currentRequest.endValue.value[valuePart];}
								} else {
									if (currentRequest.endValue.value[valuePart] < currentRequest.currentValue.value[valuePart]) {currentRequest.currentValue.value[valuePart] = currentRequest.endValue.value[valuePart];}
								}

								if (currentRequest.aliasValue.value[valuePart] > 0) {
									currentRequest.aliasedValue.value[valuePart] = Math.round(currentRequest.currentValue.value[valuePart] / currentRequest.aliasValue.value[valuePart]) * currentRequest.aliasValue.value[valuePart];
								} else {
									currentRequest.aliasedValue.value[valuePart] = currentRequest.currentValue.value[valuePart];
								}

							}
							
							if (currentRequest.attribute.indexOf("style[") > -1) {
								self.DOM.setElementStyle(currentRequest.element, currentRequest.attribute.substring(7, currentRequest.attribute.length - 2), self.toValueString(currentRequest.aliasedValue));
							} else {
								eval("currentRequest.element." + currentRequest.attribute + " = self.toValueString(currentRequest.aliasedValue)");
							}

						}
					}
				}
			}
			if (emptyQueue) {
				self.animationQueue = new Array;
			}
		}

		setInterval(renderAnimationQueue, 1000 / this.framesPerSecond);
		
	},



	animateAttribute : function (arguments) {
		
		if (arguments.element && arguments.attribute && arguments.endValue) {
			
			var previousRequest = null;
			var animationQueue = this.animationQueue;
			var currentFrame = this.currentFrame;
			var startFrame = this.currentFrame;
			
			var element = arguments.element;
			var elementID = arguments.element.id;
			var attribute = arguments.attribute;
			var endValue = this.parseValue(arguments.endValue);
			var animationOffset = (arguments.animationOffset == null) ? 0 : this.toFrame(arguments.animationOffset);
			var animationLength = (arguments.animationLength == null) ? 0 : this.toFrame(arguments.animationLength);
			var easeIn = (arguments.easeIn == null) ? 0 : this.toFrame(arguments.easeIn);
			var easeInMethod = (arguments.easeIn == null) ? "linear" : arguments.easeIn;
			var easeOut = (arguments.easeOut == null) ? 0 : this.toFrame(arguments.easeOut);
			var easeOutMethod = (arguments.easeOut == null) ? "linear" : arguments.easeOut;
			var append = (arguments.append == null) ? true : arguments.append;
			var aliasValue = (arguments.aliasValue == null) ? this.parseValue("0") : this.parseValue(arguments.aliasValue);
			
			for (requestIndex in animationQueue) {
				var currentRequest = animationQueue[requestIndex];
				if (currentRequest != null) {
					if (currentRequest.elementID == elementID && currentRequest.attribute == attribute) {
						if (append) {
							var previousRequest = currentRequest;
							startFrame = currentRequest.endFrame + 1;
						} else {
							currentRequest = null;
						}
					}
				}
			}
			
			if (arguments.startValue == null) {
				if (previousRequest == null) {
					var startValue = eval("this.parseValue(element." + attribute + ")");
				} else {
					var startValue = previousRequest.endValue;
				}
			} else {
				var startValue = this.parseValue(arguments.startValue);
			}

			if (easeIn > animationLength) { easeIn = animationLength; }
			if (easeIn + easeOut > animationLength) { easeOut = animationLength - easeIn; }
			var easedLength = animationLength - (easeIn / 2) - (easeOut / 2);
			
			var incrementValue = { value : new Array, type : endValue.type };
			for (valuePart in startValue.value) {
				incrementValue.value[valuePart] = (endValue.value[valuePart] - startValue.value[valuePart]) / easedLength;
			}

			var animationRequest = {
				element : element,
				elementID : elementID,
				attribute : attribute,
				startValue : startValue, 
				endValue : endValue, 
				incrementValue : incrementValue,
				startFrame : startFrame + animationOffset, 
				animationLength : animationLength, 
				endFrame : startFrame + animationOffset + animationLength, 
				easeTo : startFrame + easeIn, 
				easeToMethod : easeInMethod,
				easeFrom : (startFrame + animationOffset + animationLength) - easeOut, 
				easeFromMethod : easeOutMethod,
				aliasValue : aliasValue,
				currentValue : this.parseValue(this.toValueString(startValue)),
				aliasedValue : this.parseValue(this.toValueString(startValue))
			}

			animationQueue[animationQueue.length] = animationRequest;

		} else {
			throw "The animation could not be initialized: missing arguments";
		}
	},



	toFrame : function (valueString) {
		var numericPart = parseFloat(valueString);
		var frames = null;

		if (isNaN(valueString)) {
			if (valueString.indexOf("ms") > -1) { 
				frames = Math.round(numericPart / this.interval); 
			} else if (valueString.indexOf("sec") > -1) { 
				frames = Math.round((numericPart * 1000) / this.interval); 
			} else {
				frames = Math.round(numericPart); 
			}
		} else {
			frames = Math.round(numericPart); 
		}
		return frames;
	},



	parseValue : function (valueString) {
		if (isNaN(valueString)) {
			if (valueString.indexOf("#") > -1) {
				return { value : { r : parseInt(valueString.substr(valueString.indexOf("#") + 1, 2), 16), g :  parseInt(valueString.substr(valueString.indexOf("#") + 3, 2), 16),  b : parseInt(valueString.substr(valueString.indexOf("#") + 5, 2), 16) } , type : "color" };
			} else if (valueString.indexOf("rgb") > -1) {
				var colorString = valueString.split("rgb(");
				var colorValues = colorString[1].split(",")
				return { value : { r : parseInt(colorValues[0]), g :  parseInt(colorValues[1]),  b :parseInt(colorValues[2]) }, type : "color" };
			} else {
				valueFloat = parseFloat(valueString);
				if (valueString.length == valueFloat.toString(10).length) {
					return { value : [ valueFloat ], type : "numeric" };
				} else {
					var valueLabel = valueString.substr(valueFloat.toString(10).length);
					return { value : [ valueFloat ], type : valueLabel };
				}
			}
		} else {
			return { value : { 0 : valueString }, type : "numeric" }
		}
	},



	toValueString : function (valueObject) {
		if (valueObject.type == "numeric") {
			return valueObject.value[0];
		} else if (valueObject.type == "color") {
			return "#" + this.toColorPart(valueObject.value.r) + this.toColorPart(valueObject.value.g) + this.toColorPart(valueObject.value.b);
		} else {
			if (valueObject.type == "px") {
				return parseInt(valueObject.value[0]).toString(10) + valueObject.type;
			} else {
				return valueObject.value[0].toString(10) + valueObject.type;
			}
		}
	},



	toColorPart : function (decimalColor) {
		var decimalColor = parseInt(decimalColor);

		if (!isNaN(decimalColor)) {
			if (decimalColor < 0 ) { decimalColor = 0; }
			if (decimalColor > 255 ) { decimalColor = 255; }
			var hexString = decimalColor.toString(16);
			if (decimalColor < 16) { hexString = "0" + hexString; }
		} else {
			var hexString = "00";
		}
		return hexString;
	}
	
}