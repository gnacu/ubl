//Some common stuff.

function constant(constName,value) {
	Object.defineProperty(window,constName,{"value":			 value,
																					"writable":		 false,
																					"enumerable":	 true,
																					"configurable":false});
}

constant('UNENUMERABLE',   1<<0);// 1  // the property is not visible in for..in loops
constant('UNWRITABLE',   	 1<<1);// 2  // the value of the property cannot be changed
constant('UNCONFIGURABLE', 1<<2);// 4  // the property cannot be deleted or reconfigured

Object.defineProperty(Object.prototype,"define", {
 	value:				function(name,value,flags) {
									if(!flags)
										flags = 0;

									Object.defineProperty(this,name, {
										value: 				value,
										enumerable: 	!(flags & UNENUMERABLE),
										writable: 		!(flags & UNWRITABLE),
										configurable: !(flags & UNCONFIGURABLE)
									});
								},
 enumerable:		false,
 writable:			false,
 configurable:	false
});

constant("SUCCESS",  0);
constant("FAILURE", -1);
constant("NOTFOUND",-1);

constant("YES",true);
constant("NO", !YES);

function queryParameter(aParam) {
  aParam = aParam.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  
  var regexS  = "[\\?&]" + aParam + "=([^&#]*)";
  var regex   = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  
  if(results == null)
    return("");
  
  var value = results[1].replace(/\+/g, " ");
  
  return(decodeURIComponent(value));
}

HTMLElement.prototype.addClassName = function(className) {
	var classNames = className.split(" ");

	if(classNames.length > 1) {
		for(var i=0;i<classNames.length;i++)
			this.addClassName(classNames[i]);
		return this;
	}

	var classNameWasAdded = NO;

	if(this.className == "") {
		classNameWasAdded = YES;
		this.className 		= className;
	
	} else {
		var classes = this.className.split(" ");

		if(classes.indexOf(className) == NOTFOUND) {
			classNameWasAdded = YES;
			classes.push(className);
		}
	
		this.className = classes.join(" ");
	}

	//Allows any given panel to tap into the event of its className changing	
	if(classNameWasAdded && typeof this.classNameWasAdded == "function")
		this.classNameWasAdded(className);

	return this; //Convenient way to get back so this can be chained with other things.
};

HTMLElement.prototype.removeClassName = function(className) {
	if(this.className == "")
		return this;

	var classNames = className.split(" ");
	if(classNames.length > 1) {
		for(var i=0;i<classNames.length;i++)
			this.removeClassName(classNames[i]);
		return this;
	}

	var classNames 			 = this.className.split(" ");
	var indexOfClassName = classNames.indexOf(className);

	if(indexOfClassName == NOTFOUND)
		return this;

	classNames.splice(indexOfClassName,1);
	this.className = classNames.join(" ");

	if(typeof this.classNameWasRemoved == "function")
		this.classNameWasRemoved(className);

	return this; //Convenient way to get back so this can be chained with other things.
};

HTMLElement.prototype.hide = function() {
	return this.addClassName("hidden");
};

HTMLElement.prototype.show = function() {
	return this.removeClassName("hidden");
};
