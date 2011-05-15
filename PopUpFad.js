var tmr;
var t;
var obj;

function PopUpFadOpen() {
	obj = PopUpFadObj();
	PopUpFadLft();
	PopUpFadShw(true);
	t = 0;
	PopUpFadTmr();
}

function PopUpFadCloseX() {
	t = -100;
	document.getElementById('PopUpFad').style.display = "none";
	PopUpFadTmr();
	return false;
}

function PopUpFadTmr() {
	tmr = setInterval("PopUpFad()",20);
}

function PopUpFad() {
	var amt = Math.abs(t+=10);
	if(amt == 0 || amt == 100) clearInterval(tmr);
	amt = (amt == 100)?99.999:amt;
  	
	obj.style.filter = "alpha(opacity:"+amt+")";
	obj.style.KHTMLOpacity = amt/100;
	obj.style.MozOpacity = amt/100;
	obj.style.opacity = amt/100;
	
	if(amt == 0) shw(false);
}

function PopUpFadLft() {
	var w = 160;	// set this to 1/2 the width of the PopUpFad div defined in the style sheet 
					// there's not a reliable way to retrieve an element's width via javascript!!
					
	var l = (document.body.innerWidth)? document.body.innerWidth / 2:document.body.offsetWidth / 2;

	obj.style.left = (l - w)+"px";
}

function PopUpFadObj() {
	return document.getElementById("PopUpFad");	
}

function PopUpFadShw(b) {
	(b)? obj.className = 'show':obj.className = '';	
}