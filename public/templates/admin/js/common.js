function ShowQuickHelp(container, title, desc)
{
	div = document.createElement("div");
	div.id = 'help';
	div.style.zIndex = 1;
	div.style.display = 'block';
	div.className = 'helpTipCorners';
	div.style.position = 'absolute';
	div.style.width = '185px';
	div.style.backgroundColor = '#FEFCD5';
	div.style.border = 'solid 1px #E7E3BE';
	div.style.padding = '10px';
	if(title != '') {
		div.innerHTML = '<div class="helpTip"><strong style="font-size:14px">' + title + '</strong></div><br />';
	}

	div.innerHTML += '<div style="padding-left:0px" class="helpTip">' + desc + '</div>';

	SetQuickHelpPosition(div, container, 185)

	container.parentNode.appendChild(div);
}

function SetQuickHelpPosition(d, container, width)
{
	var containerX = 0;
	var containerY = 0;
	var containerTemp = container;
	while( containerTemp != null ) {
		containerX += containerTemp.offsetLeft;
		containerY += containerTemp.offsetTop;
		containerTemp = containerTemp.offsetParent;
	}
	var scrollXY = getScrollXY();
	var windowRight = document.documentElement.clientWidth;
	var divX = windowRight-width;
	var divY = containerY+15;
	if (divX<=containerX-scrollXY[0]) {
		d.style.left= divX+'px';
	}
	else if(width+containerX+50 > $j(window).width()) {
		d.style.left = (divX-width-50)+'px';
	}
	d.style.top = divY+'px';
}

function getScrollXY()
{
	var scrOfX = 0, scrOfY = 0;
	if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		//DOM compliant
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		//IE6 standards compliant mode
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	}
	return [ scrOfX, scrOfY ];
}

function HideQuickHelp(p)
{
	if ($j("#help").length) {
		$j("#help").css('display','none');
		setTimeout('RemoveHelp()', 1);
	}
}

function RemoveHelp() {
	$j("#help").remove();
}


function ShowHelp(img, title, desc)
{
	img = document.getElementById(img);
	div = document.createElement('div');
	div.id = 'help';

	div.style.display = 'inline';
	div.style.position = 'absolute';
	div.style.width = '250px';
	div.className = 'helpTipCorners';

	div.style.backgroundColor = '#fff9d3';
	div.style.border = 'solid 1px #e2ce49';
	div.style.padding = '15px';
	div.innerHTML = '<span class=helpTip><strong style="font-size:14px">' + title + '<\/strong><\/span><br /><img src=images/1x1.gif width=1 height=5><br /><div style="padding-left:10; padding-right:5" class=helpTip>' + desc + '<\/div>';

	//img.parentNode.appendChild(div);
	var parent = img.parentNode;
	if(img.nextSibling)
		parent.insertBefore(div, img.nextSibling);
	else
		parent.appendChild(div)
}

function HideHelp(img)
{
	if ($j("#help").length) {
		$j("#help").css('display','none');
		setTimeout('RemoveHelp()', 1);
	}
}

function PopupHelp(iframeUrl) {
    $j.fancybox({
        'width': 1000,
        'height': 550,
        'href': iframeUrl,
        'autoScale': false,
        'title': 'Trung tâm trợ giúp & Hướng dẫn sử dụng Bizweb',
        'titlePosition': 'outside',
        'transitionIn': 'fade',
        'transitionOut': 'fade',
        'type': 'iframe'
    });
    return false;
}

function g(Id) {
    return document.getElementById(Id);
}

function CurrencyFormatted(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num)) num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);
}
function keypress(e) {
    var keypressed = null;
    if (window.event) { keypressed = window.event.keyCode; }
    else { keypressed = e.which; }
    if (keypressed < 48 || keypressed > 57) {
        if (keypressed == 8 || keypressed == 127 || keypressed == 0) { return; }
        return false;
    }
}