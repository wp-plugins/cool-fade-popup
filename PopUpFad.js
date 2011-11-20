/**
 *     Cool fade popup
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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