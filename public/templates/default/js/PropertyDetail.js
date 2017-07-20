var GetPrice="";
var mText = "";
var sTimeCache = 14400;
var _d = (new Date()).getTime()+ sTimeCache;
function ShowFormSendMailFriend() {
    $('.pDialog').hide();
	var url = pathClientAjax + "Services/Misc.asmx/ShowFormSendMailFriend";
	$.post(url, {},
			function (data) {
			    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
			        $("#sendEmailbox").centerInClient();
			        $('#sendEmailboxContent').html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
			        $('#sendEmailbox').show();
                }			    
			}
		);
}
function StatisticsClickSendMail() {
    var ver = 0;
    if ($("#version").val().toLowerCase() == "off")
        ver = 1;
    StatisticsClick(1, $('#ctrContactAgentID_spPropertyListingID').val(), ver);
}
function expandEmail(){
	Element.hide("DivContactAgent");	
	Element.show("DivEmailFriend");		
}
function expandContactAgent(){
	Element.hide("DivEmailFriend");
	Element.show("DivContactAgent");	
}
function expandLogin(){
	Element.hide("DivForgotPass");
	Element.show("DivLogin");
}
function expandForgotPw(){
	Element.hide("DivLogin");
	Element.show("DivForgotPass");
}

function EmailFriend(){	
	var ctrEmailID = $("hEmailControlID").value;
	var txEmailFrom = $(ctrEmailID + "_txtEmailFrom").value;
	var txEmailTo = $(ctrEmailID + "_txtEmailTo").value;
	if(txEmailTo!="" && !check_email(txEmailTo))
	{
		alert("Vui lòng nhập email hợp lệ");
		return ;
	}
	var txtNote = $(ctrEmailID + "_txtMessage").value;
	var act = "act=mf";
	var url = pathClientAjax+"handler/Misc.aspx?"+ act +"&from="+ encodeURI(txEmailFrom) +"&to="+ encodeURI(txEmailTo)+"&message="+ encodeURI(txMessage) +nocacheAjax();
	Element.setInnerHTML(ctrEmailID + "_mess", "Xin đợi trong giây lát...");
	new Ajax.Request(url, {   
		method: 'get',					
		onSuccess: function(transport) {
			Element.setInnerHTML(ctrEmailID + "_mess", "Cảm ơn, thư của bạn đã được gửi.");
			},
		onFailure: function(e){ alert(e.responseText);
		}
		}
	);
}

function LoadCurrentPriceQuyDoi()
{
	var gchuan = $("#hdGChuan").val();
	var ltien = $("#hdlTien").val();

	if(gchuan=="0" || gchuan=="") {
	    if ($('#hdgiasqm').val() == "") {
	        $('#dvPriceBoard').hide();
	    }
	    else {
	        $('#dvPriceBoard').show();
         }
	}
	else{
	    var url = pathClientAjax + "Services/getcurrentPrice.asmx/LoadCurrentPrice";
		$.post(url, {gc: gchuan, ltien: ltien},
			function (data) {
			    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
			        // alert(data.getElementsByTagName("string")[0].childNodes[0].nodeValue)
			        $('#dvPriceBoard').html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
			        $('#dvPriceBoard').show();
			        PriceClick(0);
                }			    
			}
		);	
	}		
}

function CheckPhoneNumber(phoneNumber)
{
    var phoneRegex = /^(\d{7}|\d{8}|\d{9}|\d{10}|\d{11}|\d{12}|\d{13}|\d{14})$/;
	if( !phoneNumber.match( phoneRegex ) ) return false;
	return true;
}

function CheckMobileOrVinaPhoneNumber(phoneNumber)
{
	return true;
}

function isWhitespace (s)
{   
	var whitespace = " \t\n\r";
	var i;

  if (isEmpty(s)) return true;
  for (i = 0; i < s.length; i++)
  {   
    var c = s.charAt(i);
    if (whitespace.indexOf(c) == -1) return false;
  }
  return true;
}

function isEmpty(s)
{   
	return ((s == null) || (s.length == 0))
}

function isEmail (s)
{   
	if (isEmpty(s)) 
		if (isEmail.arguments.length == 1) return false;
		else return (isEmail.arguments[1] == true);
		
  if (isWhitespace(s)) return false;
  
  var i = 1;
  var sLength = s.length;

  while ((i < sLength) && (s.charAt(i) != "@"))
  { i++
  }

  if ((i >= sLength) || (s.charAt(i) != "@")) return false;
  else i += 2;

  while ((i < sLength) && (s.charAt(i) != "."))
  { i++
  }
  		
	/*if ((s.indexOf(".com")<5)&&(s.indexOf(".org")<5)
		&&(s.indexOf(".gov")<5)&&(s.indexOf(".net")<5)
		&&(s.indexOf(".mil")<5)&&(s.indexOf(".edu")<5))
	{
		return false;
	}*/

  if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
  else return true;
}
function check_email (emailStr) {
        var emailPat=/^(.+)@(.+)$/
        var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
        var validChars="\[^\\s" + specialChars + "\]"
        var quotedUser="(\"[^\"]*\")"
        var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
        var atom=validChars + '+'
        var word="(" + atom + "|" + quotedUser + ")"
        var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
        var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
        var matchArray=emailStr.match(emailPat)
        if (matchArray==null) {
                /* Too many/few @'s or something; basically, this address doesn't even fit the general mould of a valid e-mail address. */
                //alert("Email address seems incorrect (check @ and .'s)")
                return false
        }

        var user=matchArray[1]
        var domain=matchArray[2]
        if (user.match(userPat)==null) {
                // user is not valid
                //alert("The username doesn't seem to be valid.")
            return false
        }
        var IPArray=domain.match(ipDomainPat)
        if (IPArray!=null) {
                // this is an IP address
                 for (var i=1;i<=4;i++) {
                        if (IPArray[i]>255) {
                                return false
                        }
                 }
                 return true
        }
        // Domain is symbolic name
        var domainArray=domain.match(domainPat)
        if (domainArray==null) {
                return false
        }
        var atomPat=new RegExp(atom,"g")
        var domArr=domain.match(atomPat)
        var len=domArr.length
        if (domArr[domArr.length-1].length<2 || domArr[domArr.length-1].length>3) {
            return false
        }

        if (len<2) {
           return false
        }
         return true;
}
function ContactAgent(){	


	var ctrContactAgentID = document.getElementById("hContactAgentControlID").value;
	var spPropertyListingID= document.getElementById("ctrContactAgentID_spPropertyListingID").value;
	var txEmail = document.getElementById("ctrContactAgentID_txtEmail").value;
	
	if(txEmail =="")
	{
		alert("Vui lòng nhập email");
		document.getElementById("ctrContactAgentID_txtEmail").focus();
		return ;
	}
	if(txEmail !="" && !isEmail(txEmail))
	{
		alert("Email không hợp lệ");
		document.getElementById("ctrContactAgentID_txtEmail").focus();
		return ;
	}
	
	var txAgent = document.getElementById("ctrContactAgentID_emailList").value;
	var txAgentID = document.getElementById("ctrContactAgentID_agentIDlList").value;
	var txName = document.getElementById("ctrContactAgentID_txtName").value;
	var txPhone = document.getElementById("ctrContactAgentID_txtPhone").value;
	
	if(txPhone =="")
	{
		alert("Vui lòng nhập số điện thoại của bạn");
		document.getElementById("ctrContactAgentID_txtPhone").focus();
		return;
	}
	if(txPhone !="" && !CheckPhoneNumber(txPhone))
	{
		 alert("Vui lòng nhập đúng số điện thoại. Số điện thoại phải có dạng như sau: 0893612666, 99999999");	
		 document.getElementById("ctrContactAgentID_txtPhone").focus();
		 return ;
	}
	var txMessage = document.getElementById("ctrContactAgentID_txtMessage").value;
	
	var act = "act=magt";
	var url = pathClientAjax+"handler/Misc.aspx?"+ act +"&from="+ encodeURI(txEmail) + "&listAgent="+ txAgentID +"&to="+ encodeURI(txAgent) +"&name="+ encodeURI(txName) +"&id="+ spPropertyListingID +"&phone="+ encodeURI(txPhone) +"&message="+ encodeURI(txMessage) +"&d="+ _d;
	Element.setInnerHTML("ctrContactAgentID_mess", "Xin đợi trong giây lát...");
	new Ajax.Request(url, {   
		method: 'get',					
		onSuccess: function(transport) {
			if (transport.responseText == "Failed") {
				alert("Hệ thống không cho phép gửi Mail cho người bán !");
				Element.setInnerHTML("ctrContactAgentID_mess", "<a href=\"javascript:ContactAgent()\"><div>Gửi mail</div></a>");
			}
			else			
			{
				alert("Cảm ơn, thư của bạn đã được gửi");
				Element.setInnerHTML("ctrContactAgentID_mess", "<a href=\"javascript:ContactAgent()\"><div>Gửi mail</div></a>");
			}
			},
		onFailure: function(e){ 
			//alert(e.responseText);
				alert("Hệ thống không cho phép gửi Mail cho người bán !");
				Element.setInnerHTML("ctrContactAgentID_mess", "<a href=\"javascript:ContactAgent()\"><div>Gửi mail</div></a>");
		}
	 }
	);
}
function ContactAgentVp(kind, idStatistics, isMBND) {	


	var spPropertyListingID= document.getElementById("ctrContactAgentID_spPropertyListingID").value;
	var txEmail = document.getElementById("ctrContactAgentID_txtEmail").value;
	
	if(txEmail =="")
	{
		alert("Vui lòng nhập email!");
		document.getElementById("ctrContactAgentID_txtEmail").focus();
		return ;
	}
	if(txEmail !="" && !isEmail(txEmail))
	{
		alert("Email không hợp lệ!");
		document.getElementById("ctrContactAgentID_txtEmail").focus();
		return ;
	}
	
	var txAgent = document.getElementById("ctrContactAgentID_emailList").value;
	var txAgentID = document.getElementById("ctrContactAgentID_agentIDlList").value;
	var txName = document.getElementById("ctrContactAgentID_txtName").value;
	var txPhone = document.getElementById("ctrContactAgentID_txtPhone").value;
	
	if(txPhone =="")
	{
		alert("Vui lòng nhập số điện thoại!");
		document.getElementById("ctrContactAgentID_txtPhone").focus();
		return;
	}
	
	var txMessage = document.getElementById("ctrContactAgentID_txtMessage").value;
	if (txMessage == "" || txMessage == "Nhập nội dung...")
	{
		alert("Vui lòng nhập nội dung!");
		document.getElementById("ctrContactAgentID_txtMessage").focus();
		return;
	}
		
	var url = pathClientAjax + "services/Misc.asmx/ContactAgentVp";
	$('#btSendMail').html("<a class=\"LinkViewGallery\">Đang xử lý</a>");
	$.post(url, { id: spPropertyListingID, listAgent: txAgentID, to: txAgent, from: txEmail, phone: txPhone, message: txMessage, name: txName },
			function (data) {
			    if (data == "Failed") {
			        alert("Hệ thống không cho phép gửi mail tới nhà môi giới!");
			        $('#btSendMail').html("<a href=\"javascript:ContactAgentVp("+kind+","+ idStatistics+","+ isMBND+");\" class=\"LinkViewGallery\">Send</a>");
			    }
			    else {
			        StatisticsClick(kind, idStatistics, isMBND);
			        alert("Cám ơn! Mail của bạn đã được gửi!");
			        $('#btSendMail').html("<a href=\"javascript:ContactAgentVp("+kind+","+ idStatistics+","+ isMBND+");\" class=\"LinkViewGallery\">Send</a>");
			    }
			}
		); 
}

function UpdateListingList(mode,id){
	var url = pathClient+"Services/Misc.asmx/UpdateMyShortList";
	$.post(url, {mode: mode, id: id},
			function (data) {
			    if (mode == 0) {
			        alert("Đã thêm BĐS vào danh sách!");
			        $('#SaveThisProperty').html("<a href=\"javascript:UpdateListingList(1," + id + ");\" class=\"delProperty\" >Xóa khỏi danh sách ưa thích</a>");
			        $('#SaveThisProperty1').html("<a href=\"javascript:UpdateListingList(1," + id + ");\" class=\"delProperty\">Xóa khỏi danh sách ưa thích</a>");
			    } else {
			        alert("Đã xóa BĐS ra khỏi danh sách!");
			        $('#SaveThisProperty').html("<a href=\"javascript:UpdateListingList(0," + id + ");\" class=\"saveProperty\" alt=\"BĐS sẽ được lưu vào DS ưa thích để bạn có thể tham khảo sau, tuy nhiên BĐS chỉ được lưu tạm thời nếu bạn không login.\">Lưu BĐS vào danh sách</a>");
			        $('#SaveThisProperty1').html("<a href=\"javascript:UpdateListingList(0," + id + ");\" class=\"saveProperty\" alt=\"BĐS sẽ được lưu vào DS ưa thích để bạn có thể tham khảo sau, tuy nhiên BĐS chỉ được lưu tạm thời nếu bạn không login.\">Lưu BĐS vào danh sách</a>");
			    }
			    if (nvgUtils.getCookie('ShortList').split('=')[1] != "") {
			        nvgUtils.setCookie('ShortList', '', 1);
			    }
			     nvgData.DemSoBdsDaLuu();
			}
		);
}
function showSaveThis(id) {

    if (nvgUtils.getCookie('BDSfavorite').split('=')[1] != "") {
        var lst_Bds = trim(nvgUtils.getCookie('BDSfavorite').split('=')[1], ',');
        if (nvgUtils.CheckSplitValue(id, lst_Bds, ',')) {
            $('#SaveThisProperty').html("<a href=\"javascript:UpdateListingList(1," + id + ");\" class=\"delProperty\">Xóa khỏi danh sách ưa thích</a>");
            $('#SaveThisProperty1').html("<a href=\"javascript:UpdateListingList(1," + id + ");\" class=\"delProperty\">Xóa khỏi danh sách ưa thích</a>");
        }
        else {
            $('#SaveThisProperty').html("<a href=\"javascript:UpdateListingList(0," + id + ");\" class=\"saveProperty\" alt=\"BĐS sẽ được lưu vào DS ưa thích để bạn có thể tham khảo sau, tuy nhiên BĐS chỉ được lưu tạm thời nếu bạn không login.\">Lưu BĐS vào danh sách</a>");
            $('#SaveThisProperty1').html("<a href=\"javascript:UpdateListingList(0," + id + ");\" class=\"saveProperty\" alt=\"BĐS sẽ được lưu vào DS ưa thích để bạn có thể tham khảo sau, tuy nhiên BĐS chỉ được lưu tạm thời nếu bạn không login.\">Lưu BĐS vào danh sách</a>");
        }
    }
}
function PriceClick(mode){
	try{
		
		var vnd = parseFloat(document.getElementById("hPrcVnd").value);
		var SJC = parseFloat(document.getElementById("hPrcJsc").value);
		var usd = parseFloat(document.getElementById("hPrcUsd").value);
		var price = document.getElementById("hPrice").value;		
		if (price == "") {
			$("#dvPrice").html("");
			$("#dvHidePriceUnit").hide();
			return;
		}
		var type = document.getElementById("hUnitType").value;	
		
		var mText = "";
		var m2 = "";
		var fPrice = 0;
		var prc = 0;
		prc = parseFloat(price);
		fPrice = prc;
	
		var flag = false;
		//type=0&1 VND,4&5 usd,2&3 SJC
		$('.morePrice a').removeClass('current');

		switch(mode)
		{
		    case 1: 
		        {//Doi SJC, mode=1

		            $("#dvSJC").addClass("current");
		            switch (parseInt(type)) {
		                case 0: //Tu VND
		                case 1: //Tu VND
		                    {
		                        mText = "Lượng SJC";
		                        fPrice = prc * 1000 / SJC;
		                        fPrice = Math.round(fPrice * Math.pow(10, 2)) / Math.pow(10, 2);
		                        break;
		                    }
		                case 4: //Tu USD
		                case 5: //Tu USD
		                    {
		                        mText = "Lượng SJC";
		                        fPrice = (prc * usd) / (SJC * 1000);
		                        fPrice = Math.round(fPrice * Math.pow(10, 2)) / Math.pow(10, 2);
		                        break;
		                    }
		                default: //Tu SJC not change
		                    {
		                        mText = "Lượng SJC";
		                        fPrice = Math.round(fPrice * Math.pow(10, 2)) / Math.pow(10, 2);
		                        break;
		                    }
		            }
		            break;
		        }
			case 2:{//Doi USD, mod=2
			        $("#dvUSD").addClass("current");
				
				switch(parseInt(type)) {
					case 0://Tu VND
					case 1://Tu VND
					{
						mText = "USD";
						fPrice = prc*1000000/usd;
						if(parseInt(fPrice)>9999)
						{
							mText = "Ngàn USD";
							fPrice = fPrice/1000;
							flag = true;
						}
						if(parseInt(fPrice)>999 && flag==true)
						{
							mText = "Triệu USD";
							fPrice = fPrice/1000;
						}
						fPrice = Math.round(fPrice*Math.pow(10,2))/Math.pow(10,2);	
						break;
					}
					case 2://Tu SJC
					case 3:// Tu SJC
					{
						mText = "USD";
						fPrice = (prc*SJC*1000)/usd;
						if(parseInt(fPrice)>9999)
						{
							mText = "Ngàn USD";
							fPrice = fPrice/1000;
							flag = true;
						}
						if(parseInt(fPrice)>999 && flag==true)
						{
							mText = "Triệu USD";
							fPrice = fPrice/1000;
						}
						fPrice = Math.round(fPrice*Math.pow(10,2))/Math.pow(10,2);	
						break;
					}
					default://Tu USD not change
					{
						mText = "USD";
						fPrice = Math.round(fPrice*Math.pow(10,1))/Math.pow(10,1);	
						break;
					}
				}
			break;
			}
			default://Doi VND, mode=0
			{

			    $("#dvVND").addClass("current");
				
				switch(parseInt(type)) {
					case 2://Tu SJC
					case 3: // Tu SJC
					{
						mText = "Triệu";
						fPrice = prc*(SJC*1000)/1000000;
						if(parseInt(fPrice)>999)
						{
							mText = "Tỷ";
							fPrice = fPrice/1000;
						}
						fPrice = Math.round(fPrice*Math.pow(10,2))/Math.pow(10,2);	
						break;
					}
					case 4://Tu USD
					case 5: //Tu USD
					{	mText = "Triệu";	
						fPrice = prc*usd/1000000;
						fPrice = Math.round(fPrice*Math.pow(10,2))/Math.pow(10,2);	
						break;
					}
					default://Tu VND not Change
					{
						mText = "Triệu";	
						if(parseInt(fPrice)>999)
						{
							mText = "Tỷ";
							fPrice = fPrice/1000;
						}
						fPrice = Math.round(fPrice*Math.pow(10,2))/Math.pow(10,2);	
						break;
					}
				}
				break;
			}
		}
		
		if(fPrice!="" || fPrice!=null)
		{
			GetPrice= '~ '+fPrice+ ' '+mText;
		}
		if(parseInt(type)%2 == 0) m2 = '';//m2 = '/m<sup>2</sup>';
		{
			var tpl = "~ [%price%] [%unit%] [%m2%]";
			$("#dvPrice").html("~ " + fPrice+ " " +mText+ " " +m2);	
		}
	}catch(exp){}
}

function printClick(p){
	window.open(pathClient+'printbrochure.aspx?p='+p +'&price='+GetPrice,'_blank','scrollbars=yes,width=700');
}
function LoadLoan(){	
	var PUSD = parseFloat($("hPrice").value);
	var type = $("hUnitType").value;	
	var totalUSD = PUSD;
	var vnd = parseFloat($("hPrcVnd").value);
	var SJC = parseFloat($("hPrcJsc").value);
	var usd = parseFloat($("hPrcUsd").value);
	switch(parseInt(type)) 
	{
		case 0:
		case 1:{
			totalUSD = PUSD*1000000/usd;
			break;			
		}
		case 2:
		case 3:{
			totalUSD = PUSD*SJC/usd;
			break;
		}		
	}
	totalUSD = Math.round(totalUSD*Math.pow(10,4))/Math.pow(10,4);	
	window.open('Loan.aspx?p='+totalUSD,'_blank','scrollbars=yes,width=700');
}

/*========================
========== send property to friend================
========================*/
function SendPropertyToFriend()
{
	if($("#txtName").val()=="")
	{
		alert("Vui lòng nhập tên người gửi!");
		$("#txtName").focus();
		return false;
	}
	else if($("#txtEmailFrom").val()=="" || ($("#txtEmailFrom").val()!="" && !isEmail($("#txtEmailFrom").val())))
	{
		alert("Email người gửi rỗng hoặc không đúng định dạng!");
		$("#txtEmailFrom").focus();
		return false;	
	}
	else if($("#txtEmailTo").val()=="" || ($("#txtEmailTo").val()!="" && !isEmail($("#txtEmailTo").val())))
	{
		alert("Email người nhận rỗng hoặc không đúng định dạng!");
		$("#txtEmailTo").focus();
		return false;	
	}
	else if($("#txtMessage").val()=="")
	{
		alert("Vui lòng nhập nội dung!");
		$("#txtMessage").focus();
		return false;
	}
	ShowProccessButton('smtf_process','btnSendEmail',1);
	var _____url=pathClient+"services/SendToFriend.asmx/SendProperty";
	$.post(_____url, { id: $('#ctrContactAgentID_spPropertyListingID').val(), n: $('#txtName').val(), f: $('#txtEmailFrom').val(), t: $('#txtEmailTo').val(), c: encodeURI($('#txtMessage').val()) },
			function (data) {
			   
			    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
			        alert("Gửi thành công!");
			       // document.getElementById('sendEmailbox').style.display = 'none';
			        $('#sendEmailbox').hide();
			        $('.pDialog').hide();
			    } else {
			        alert("Gửi không thành công!");
					ShowProccessButton('smtf_process','btnSendEmail',2);
			    }

			}
		);
}

/*========================
==========end send property to friend================
========================*/

function View()
{
	if(document.getElementById("txt_Namsinh").value=="")
	{
		alert("Bạn phải nhập năm sinh!");
		document.getElementById("txt_Namsinh").focus();
		return false;
	}
	if(!isAllDigit(trim(document.getElementById("txt_Namsinh").value,' ')))
	{
		alert("Bạn nhập năm sinh chưa đúng!");
		document.getElementById("txt_Namsinh").focus();
		return false;
	}
	
	if(document.getElementById("select_Gioitinh").value=="")
	{
		alert("Bạn phải chọn giới tính!");
		document.getElementById("select_Gioitinh").focus();
		return false;
	}
	var namsinh="&namsinh="+document.getElementById("txt_Namsinh").value;
	var huong="&huong="+document.getElementById("select_huong").value;
	var gioitinh="&gioitinh="+document.getElementById("select_Gioitinh").value;
	path = document.getElementById('hdpath').value;
	document.getElementById('txtHint').innerHTML = "<div style='text-align:center'><IMG alt=''src="+ pathClientAjax + "images/loading6.gif></div>";
	var url = pathClientAjax+"handler/ViewDirectionHomeHandler.aspx?act=View"+namsinh+huong+gioitinh+"&d="+ (new Date()).getTime();
	
	$.get(url, 
		function(data) {
			document.getElementById('txtHint').innerHTML = data;	
		}
	);
}

function ViewDetail()
{
	if(document.getElementById("txt_Namsinh").value=="")
	{
		alert("Bạn phải nhập năm sinh!");
		document.getElementById("txt_Namsinh").focus();
		return false;
	}
	if(!isAllDigit(trim(document.getElementById("txt_Namsinh").value,' ')))
	{
		alert("Bạn nhập năm sinh chưa đúng!");
		document.getElementById("txt_Namsinh").focus();
		return false;
	}
	
	if(document.getElementById("select_Gioitinh").value=="")
	{
		alert("Bạn phải chọn giới tính!");
		document.getElementById("select_Gioitinh").focus();
		return false;
	}
//	var namsinh="&namsinh="+document.getElementById("txt_Namsinh").value;
//	var huong="&huong="+document.getElementById("select_huong").value;
//	var gioitinh="&gioitinh="+document.getElementById("select_Gioitinh").value;
	path = document.getElementById('hdpathImage').value;
	document.getElementById('txtHint').innerHTML = "<div align='center' style='padding-top:10px;'><IMG alt=''src="+ pathClientAjax + "images/loading6.gif></div>";
	var url = pathClientAjax + "services/ViewDirectionHomeHandler.asmx/ResultDetail";
	
	$.post(url, {namsinh: document.getElementById("txt_Namsinh").value,huong: document.getElementById("select_huong").value , gioitinh: document.getElementById("select_Gioitinh").value},
		function(data) {
		    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined)
            {
            	document.getElementById('txtHint').style.display = 'block';				
			    document.getElementById('txtHint').innerHTML = data.getElementsByTagName("string")[0].childNodes[0].nodeValue;
			    //document.getElementById('outerPhongThuyContainer').style.height='1050px';
			    //document.getElementById('overlayPhongThuy').style.height='2500px';	
            }		
		}
	);
}
function isDigit (c)
{	return ((c >= "0") && (c <= "9"))
}

function isAllDigit (s)
{   
  var i;
  if (isEmpty(s)) 
     if (isAllDigit.arguments.length == 1) return false;
     else return (isDigital.arguments[1] == true);
  for (i = 0; i < s.length; i++)
  {   
    var c = s.charAt(i);
    if (isDigit(c)==false)
    return false;
  }
  return true;
}
function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}

function ltrim(str, chars) {
    if (str != undefined && str != "" && str != null) {
        chars = chars || "\\s";
        return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
    }
    return str;
}

function rtrim(str, chars) {
    if (str != undefined && str != "" && str != null) {
        chars = chars || "\\s";
        return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
    }
    return str;
}

/*--------------------Detail--------------------*/
function ShowformXemHuong()
{
	document.getElementById('phongthuypopups').style.top='68%';	
	document.getElementById('txtHint').style.display = 'none';
	document.getElementById('phongthuypopups').style.height='160px';
	document.getElementById('phongthuypopups').style.display = 'block';
	document.getElementById("txt_Namsinh").focus();
}

function ShowPhongThuy() {
    $('.pDialog').hide();
    var url = pathClientAjax + "Services/ViewDirectionHomeHandler.asmx/ShowPhongThuy";
    $.post(url, {},
		function (data) {
		    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
		        $("#divTieuDePhongThuy").html("Xem phong thủy");		        
		        $("#divNoiDungPhongPhuy").html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
                $("#boxPhongThuy").centerInClient();
		        $('#boxPhongThuy').show();
		        document.getElementById("txt_Namsinh").focus();
		    }
		    else $('#boxPhongThuy').hide();
		}
	);
}


function KeyPressPhongThuy(e, type)
{
	var unicode=e.charCode? e.charCode : e.keyCode;	
	if (unicode == 13)
	{
		switch(type) {
		case "ViewDetail":
			ViewDetail();
			break;
		}
	}
}
function showSendContactAgentForm(proId)
{	
	$.post(pathClient + "Services/ViewDirectionHomeHandler.asmx/ShowContactAgentForm", {vPropertyID: proId},
 	    function(data){
 	        if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
 			    $('#login_box_popup_header').html("Liên hệ doanh nghiệp bất động sản");
 			    $('#contentlogin').html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
 			    $('#login_box').show();
 		    }
 		    else
 		    {
 			    $('#login_box').hide();
 		    }
 	    });
}
function SendContactAgentValidate()
{
	if(document.getElementById("txtName").value=="")
	{
		alert("Nhập tên người gửi");
		document.getElementById("txtName").focus();
		return false;
	}
	else if(document.getElementById("txtEmail").value=="" || (document.getElementById("txtEmail").value!="" && !validateEmailAddr("txtEmail")))
	{
		alert("Email người gửi không được nhập hoặc nhập không đúng");
		document.getElementById("txtEmail").focus();
		return false;	
	}
	else if(document.getElementById("txtPhone").value=="")
	{
		alert("Bạn phải nhập số điện thoại của bạn vào");
		document.getElementById("txtPhone").focus();
		return false;
	}
	else if(document.getElementById("txtPhone").value !="" && !CheckPhoneNumber(document.getElementById("txtPhone").value))
	{
		alert("Vui lòng nhập đúng số điện thoại. Số điện thoại phải có dạng như sau: 0893612666, 99999999");		
		document.getElementById("txtPhone").focus();
		return false;
	}
	else if(document.getElementById("txtMessage").value=="")
	{
			alert("Vui lòng nhập nội dung cần gửi!");
			document.getElementById("txtMessage").focus();
			return false;	
	}
	/*var sendername = "&sn="+encodeURI(document.getElementById("txtName").value);
	var senderEmail = "&se="+document.getElementById("txtEmail").value;
	var senderphone = "&sp="+document.getElementById("txtPhone").value;
	var sendermessage = "&sm="+encodeURI(document.getElementById("txtMessage").value);
	var sendproid = "&proid="+document.getElementById("txtproid").value;
	var act = "act=SendContactAgentForm;*/
	var param = {
	    sn:$("#txtName").val()
	    ,se:$("#txtEmail").val()			
	    ,sp:$("#txtPhone").val()
	    ,sm:encodeURI($("#txtMessage").val())
	    ,pid:$("#txtproid").val()
	    ,toList:$("#txtToList").val()
	    ,agentList:$("#txtAgentList").val()
	};
	$.post(pathClientAjax+"services/ViewDirectionHomeHandler.asmx/SendContactAgentForm", param,
 		function(data){
 		    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
 				alert("Bạn đã gửi thư thành công!");
 				$('#login_box').hide();
 			}
 			else
 			{
 				alert("Bạn đã gửi thư không thành công!");
 				//$('#login_box').hide();
 			}
 		});
}

function DisplaySttPi() {

}

function StatisticsClick(kind,idStatistics,isMBND) {
    var param = {
        kind : kind,
	    idStatistics:idStatistics,
	    isMBND : isMBND
    };
    $.post(pathClientAjax + "services/PropertyHandler.asmx/StatisticsClick", param);
}