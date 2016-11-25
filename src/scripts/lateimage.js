var Imgs = [];

function ImgLoad(cls) {
	var as = zxcByClassName(cls);

	for(var z0=0;z0<as.length;z0++) {
		if(as[z0].getAttribute('href') && as[z0].getElementsByTagName('IMG')[0]) {
			var oop = new Fade(as[z0].getElementsByTagName('IMG')[0],as[z0].getAttribute('href'));
			Imgs.push(oop);
		}
	}

	CkTop();
}

function Fade(img,src) {
	this.img = img;
	this.src = src;
	this.opc = 0;

	zxcOpacity(this.img,0);
}

Fade.prototype.fade = function() {
	if(this.opc==0) 
		this.img.src = this.src;

		zxcOpacity(this.img,this.opc++);

		var oop = this;

		if(this.opc<101) 
			setTimeout(function(){ oop.fade(); },10);
}

function CkTop() {
	for(var z0=0;z0<Imgs.length;z0++) {
		if(zxcPos(Imgs[z0].img)[1] < zxcWWHS()[1]+zxcWWHS()[3] && Imgs[z0].opc==0) {
			Imgs[z0].fade();
			Imgs.splice(z0,1);
			z0--;
		}
	}
}

function zxcOpacity(obj,opc) {
	if(opc < 0 || opc > 100) 
		return;
		
	obj.style.filter			 = 'alpha(opacity='+opc+')';
	obj.style.opacity			 = opc/100-.001;
	obj.style.MozOpacity   = opc/100-.001;
	obj.style.KhtmlOpacity = opc/100-.001;
}

function zxcWWHS() {
	if(window.innerHeight) 
		return [window.innerWidth  -10,
						window.innerHeight -10,
						window.pageXOffset,
						window.pageYOffset];
						
	if(document.documentElement.clientHeight) 
		return [document.documentElement.clientWidth  -10,
						document.documentElement.clientHeight -10,
						document.documentElement.scrollLeft,
						document.documentElement.scrollTop];
						
	return [document.body.clientWidth,
					document.body.clientHeight,
					document.body.scrollLeft,
					document.body.scrollTop];
}

function zxcPos(obj) {
	var rtn=[0,0];
	
	while(obj) {
		rtn[0] += obj.offsetLeft;
		rtn[1] += obj.offsetTop;
		obj = obj.offsetParent;
	}

	return rtn;
}

function zxcByClassName(nme,el,tag) {
	if(typeof(el)=='string') 
		el = document.getElementById(el);
		
	el = el || document;

	for(var tag=tag || '*',reg=new RegExp('\\b'+nme+'\\b'),els=el.getElementsByTagName(tag),ary=[],z0=0; z0<els.length;z0++) {
		if(reg.test(els[z0].className)) 
			ary.push(els[z0]);
	}

	return ary;
}

window.onscroll = CkTop;