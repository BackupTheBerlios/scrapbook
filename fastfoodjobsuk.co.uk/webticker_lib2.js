
// WebTicker by Mioplanet
// www.mioplanet.com

TICKER_CONTENT = document.getElementById("TICKER2").innerHTML;
 
TICKER_RIGHTTOLEFT = false;
TICKER_SPEED = 1;
TICKER_STYLE = "font-family:Arial; font-size:12px; color:#444444";
TICKER_PAUSED = false;

ticker_start();

function ticker_start() {
	var tickerSupported = false;
	TICKER_WIDTH = document.getElementById("TICKER2").style.width;
	var img = "<img src=ticker_space.gif width="+TICKER_WIDTH+" height=0>";

	// Firefox
	if (navigator.userAgent.indexOf("Firefox")!=-1 || navigator.userAgent.indexOf("Safari")!=-1) {
		document.getElementById("TICKER2").innerHTML = "<TABLE  cellspacing='0' cellpadding='0' width='100%'><TR><TD nowrap='nowrap'>"+img+"<SPAN style='"+TICKER_STYLE+"' ID='TICKER_BODY' width='100%'>&nbsp;</SPAN>"+img+"</TD></TR></TABLE>";
		tickerSupported = true;
	}
	// IE
	if (navigator.userAgent.indexOf("MSIE")!=-1 && navigator.userAgent.indexOf("Opera")==-1) {
		document.getElementById("TICKER2").innerHTML = "<DIV nowrap='nowrap' style='width:100%;'>"+img+"<SPAN style='"+TICKER_STYLE+"' ID='TICKER_BODY' width='100%'></SPAN>"+img+"</DIV>";
		tickerSupported = true;
	}
	if(!tickerSupported) document.getElementById("TICKER2").outerHTML = ""; else {
		document.getElementById("TICKER2").scrollLeft = TICKER_RIGHTTOLEFT ? document.getElementById("TICKER2").scrollWidth - document.getElementById("TICKER2").offsetWidth : 0;
		document.getElementById("TICKER_BODY").innerHTML = TICKER_CONTENT;
		document.getElementById("TICKER2").style.display="block";
		TICKER_tick();
	}
}

function TICKER_tick() {
	if(!TICKER_PAUSED) document.getElementById("TICKER2").scrollLeft += TICKER_SPEED * (TICKER_RIGHTTOLEFT ? -1 : 1);
	if(TICKER_RIGHTTOLEFT && document.getElementById("TICKER2").scrollLeft <= 0) document.getElementById("TICKER2").scrollLeft = document.getElementById("TICKER2").scrollWidth - document.getElementById("TICKER2").offsetWidth;
	if(!TICKER_RIGHTTOLEFT && document.getElementById("TICKER2").scrollLeft >= document.getElementById("TICKER2").scrollWidth - document.getElementById("TICKER2").offsetWidth) document.getElementById("TICKER2").scrollLeft = 0;
	window.setTimeout("TICKER_tick()", 30);
}
