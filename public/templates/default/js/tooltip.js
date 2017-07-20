// JavaScript Document
var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj1=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj1=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
function ShowHelp(id, thecolor, thewidth) { 

  var url =  pathClientAjax+"Services/Handler.asmx/ShowHelp";
  tipobj1.innerHTML="Loading...";

  $.get(url, { id: id },
		function (data) {
		    tipobj1.innerHTML = data;

		});
	enabletip=true
return false
}
function hideHelp(){
	if (ns6||ie){
		enabletip=false
		tipobj1.style.visibility="hidden"
		pointerobj1.style.visibility="hidden"
		tipobj1.style.left="-1000px"
		tipobj1.style.backgroundColor=''
		tipobj1.style.width=''
	}
}
function ddrivetip(thetext, thewidth, thecolor) {
    if (ns6 || ie) {
        if (typeof thewidth != "undefined") tipobj1.style.width = thewidth + "px"
        if (typeof thecolor != "undefined" && thecolor != "") tipobj1.style.backgroundColor = thecolor
        tipobj1.innerHTML = thetext
        enabletip = true
        return false
    }
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj1.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj1.style.left=curX-tipobj1.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj1.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj1.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj1.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj1.offsetHeight){
tipobj1.style.top=curY-tipobj1.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj1.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj1.style.top=curY+offsetfromcursorY+"px"
}
tipobj1.style.visibility="visible"
if (!nondefaultpos)
pointerobj1.style.visibility="visible"
else
pointerobj1.style.visibility="hidden"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj1.style.visibility="hidden"
pointerobj1.style.visibility="hidden"
tipobj1.style.left="-1000px"
tipobj1.style.backgroundColor=''
tipobj1.style.width=''
}
}

document.onmousemove=positiontip