
function DelClick(id)
{
	if(confirm("Bạn có chắc xóa không?"))
	{
	    
	    var url = pathClientAjax + "Services/Alert.asmx/DeleteAlert";
		$.post(url,{vi:id},
 			function(data){
 				if(data!=""){
 					doLoadPropertyListing(1);
 				}
 			});
	}	
}
function ChangePublic(ispublic,id)
{
var act = "act=changepublic";
	act+="&ispublic="+ispublic;
	act+="&id="+id;
	var url = pathClientAjax+"handler/Alert.aspx?"+ act ;		
	$.get(url,
 		function(data){
 			if(data!=""){
 				doLoadPropertyListing(1);
 			}
 		});
}
function ChangeStatus(status,id)
{
	var act = "act=changestatus";
	act+="&status="+status;
	act+="&id="+id;
	var url = pathClientAjax+"handler/Alert.aspx?"+ act 	
	$.get(url,
 		function(data){
 			if(data!=""){
 				doLoadPropertyListing(1);
 			}
 		});
}
function DoiTanSuat(id, vl)
{
	if(confirm("Bạn có chắc đổi tần suất nhận thư báo không?"))
	{
		var act = "act=doitansuat";
		var url = pathClientAjax + "Services/Alert.asmx/DoiTanSuat"; 	
		$.post(url,{id:id,vl:vl},
 			function(data){
 				if(data!="0"){
 					alert("Thay đổi thành công");
 				}
 			});
 	}
}

function changeLoai(loai_,obj_id,value_){

    var url = pathClientAjax + "Services/Alert.asmx/LoadLoaiBds";	
	
	for (var k = document.getElementById(obj_id).options.length-1; k >= 0; k--)
		document.getElementById(obj_id).options[k] = null;
	
	$.get(url, {id:loai_},
		function(data){
			var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
			if(lcNodes.length > 0){						
				try{
					removeSelectbox(obj_id,"Chọn");
					for (var k = document.getElementById(obj_id).options.length-1; k >= 0; k--){
						document.getElementById(obj_id).options[k] = null;
					}
					var i = 0;
					document.getElementById(obj_id).options[i] = new Option("Chọn", "");
									
					for(var k = i; k < lcNodes.length + i; k++){
						var option_value = lcNodes[k-i].childNodes[0];
						var option_text  = lcNodes[k-i].childNodes[1];
						document.getElementById(obj_id).options[k] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
					}	
					document.getElementById(obj_id).disabled = false;	
					if(value_!='') 
					{	
						document.getElementById(obj_id).value=value_;
						GetProperty(value_);
						//Load_Estate();
						var _sbID=($("#cbSuburb").val()!=""&&$("#cbSuburb").val()!=null)?$("#cbSuburb").val():$("#txtSuburb").val();
						mjSignSuburb(_sbID,'cbSuburb');
					}
								
				}catch(exp){}
			}
	});
}

function changeTinhThanh(_objSelectName,_id,_subId) {   
	if(_id == "")
	{
		for (var k = document.getElementById("cbSuburb").options.length-1; k >= 0; k--)
			document.getElementById("cbSuburb").options[k] = null;
		return;
	}
$.post(pathClient + "Services/StateGet.asmx/SuburbJson?stateid=" + _id, {},
		function(data){				
			var obj = data.lst;
			var obj_select = document.getElementById(_objSelectName);
			removeSelectbox(_objSelectName,"Chọn");
			if(obj.length > 0){	
				for(var k = 0; k < obj.length; k++){
					var options_length = obj_select.length;
					var option_value = obj[k].s1;
					var option_text  = obj[k].s2;
					obj_select.options[options_length] = new Option(option_text,option_value);
				}
				obj_select.disabled = false;
				if(_subId!='') obj_select.value=_subId;
			}
			
		},'json');
			
};

function onChangeProperty(obj_id,v){	
	if (v == ""){
		for (var k = $("#"+obj_id).options.length-1; k >= 0; k--)
			$("#"+obj_id).options[k] = null;
		return;
	}	

	var url = pathClientAjax+"handler/Alert.aspx?act=cpr&t="+  v ;		
	$.get(url, {},
		function(data){
			var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
			if(lcNodes.length > 0){						
				try{
					removeSelectbox(obj_id,"Chọn");
					for (var k = document.getElementById(obj_id).options.length-1; k >= 0; k--){
						document.getElementById(obj_id).options[k] = null;
					}
					var i = 0;
					document.getElementById(obj_id).options[i] = new Option("Chọn", "");
									
					for(var k = i; k < lcNodes.length + i; k++){
						var option_value = lcNodes[k-i].childNodes[0];
						var option_text  = lcNodes[k-i].childNodes[1];
						document.getElementById(obj_id).options[k] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
					}	
					document.getElementById(obj_id).disabled = false;				
				}catch(exp){}
			}
	});
}

function removeSelectbox(objID,initText){
			if(initText && initText.indexOf('*') != -1)
				initText = initText.replace('***','Chọn');
			var obj_select = document.getElementById(objID);
			obj_select.disabled = true;
			for(var k = obj_select.options.length-1; k >=0 ; k--){
				obj_select.options[k] = null;
			}
			if (initText != undefined || initText != null) {
				if(initText!='')obj_select.options[0] = new Option(initText,"");
			}
		}
function GetPriceAlert(tt)
{
	var url = pathClientAjax+"Services/FormSearchHandler.asmx/LoadPriceAlert";
	$.get(url, {t:tt},
		function(data){
			var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
			if(lcNodes.length > 0){						
				try{
					removeSelectbox("cbMinPrice1","Chọn");
					removeSelectbox("cbMaxPrice1","Chọn");
					for (var k = document.getElementById("cbMinPrice1").options.length-1; k >= 0; k--){
						document.getElementById("cbMinPrice1").options[k] = null;
					}
					for (var k = document.getElementById("cbMaxPrice1").options.length-1; k >= 0; k--){
						document.getElementById("cbMaxPrice1").options[k] = null;
					}
					var i = 0;
					document.getElementById("cbMinPrice1").options[i] = new Option("Chọn", "");
					document.getElementById("cbMaxPrice1").options[i] = new Option("Chọn", "");
									
					for(var k = i; k < lcNodes.length + i; k++){
						var option_value = lcNodes[k-i].childNodes[0];
						var option_text  = lcNodes[k-i].childNodes[1];
						document.getElementById("cbMinPrice1").options[k] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
						document.getElementById("cbMaxPrice1").options[k] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
					}	
					document.getElementById("cbMinPrice1").disabled = false;
					document.getElementById("cbMaxPrice1").disabled = false;	
					if(document.getElementById("txtPriceMin").value!="")
						document.getElementById("cbMinPrice1").value=document.getElementById("txtPriceMin").value;
					if(document.getElementById("txtPriceMax").value!="")
						document.getElementById("cbMaxPrice1").value=document.getElementById("txtPriceMax").value;	
					
				}catch(exp){}
			}
	});
}
function GetProperty(id) {

    if (id == "1") {
        $('#txtDientichSD').val("");
        $("#" + $('#hdfCtl').val() + "_cbSpn").val("");
        $('#txtDientichSD').attr('disabled', true);
        $("#" + $('#hdfCtl').val() + "_cbSpn").attr('disabled', true);
    }
    else {
        $('#txtDientichSD').removeAttr('disabled');
        $("#" + $('#hdfCtl').val() + "_cbSpn").removeAttr('disabled');
    }

    var act = "?loai=" + id;
    act += "&listKieuBDS=" + $("#txtPropertyTypeAL").val();

    var url = pathClientAjax + "Services/Alert.asmx/LoadProtype"+act;
    $.get(url,
 		function (data) {
 		    if (data != "") {
 		        $('#listPropertyType').html(data);
 		    }
 		    else {
 		        $('#listPropertyType').html('');
 		    }
 		});
}

function Load_Estate()
{
	var _sbID=$("#cbSuburb").val()!=""?$("#cbSuburb").val():$("#txtSuburb").val();
	if(_sbID!="")
	{
		var url=pathClientAjax+"handler/Alert.aspx?act=loadEstate&suburbid="+_sbID;
		$.get(url, {},
			function(data){
				var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
				if(lcNodes.length > 0){						
					try{
						removeSelectbox("cbEstate","Chọn");
						var obj_select = document.getElementById("cbEstate");
						
						for(var i_=obj_select.length-1; i_>=0; i_--)
						{
							obj_select.options[i_] = null;
						}
						for(var k = 0; k < lcNodes.length; k++)
						{
							var options_length = obj_select.length;
							var option_value = lcNodes[k].childNodes[0];
							var option_text  = lcNodes[k].childNodes[1];
							while(option_text.childNodes[0].nodeValue.indexOf("|") !=-1)
							{
								option_text.childNodes[0].nodeValue = option_text.childNodes[0].nodeValue.replace("|","&");
							}
							if(k==0)
								obj_select.options[options_length] = new Option("Chọn","");						
							else	
								obj_select.options[options_length] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
						}
						document.getElementById("cbEstate").disabled = false;
						
					}catch(exp){}
				}
		});
	}
}

function mjGetMultiValue(objId){
	var v = "";
	if (document.getElementById(objId).options.length > 0) {
		for(var k = document.getElementById(objId).options.length-1; k >= 0; k--){
			if (document.getElementById(objId).options[k].selected) {
				v += document.getElementById(objId).options[k].value + ",";
			}			
		}
	}
	return v;
}
function submitAlert(){
	if($("#hdSoTin").val()>9)
	{
	    alert("Số tin phải nhỏ hơn 10, vui lòng xóa bớt!");
		return false;
	}
	if ($("#"+$('#hdfCtl').val()+"_cbState").val()=="") 
	{
		alert("Vui lòng chọn tỉnh thành!"); 
		return false;}
	if ($("#cbProClass").val()=="") 
	{
		alert("Vui lòng chọn loại BĐS!");
		$("#cbProClass").focus();
		return false;
	}
	if ($("#txtEmailThubao").val()=="") 
	{
		alert("Email không được rỗng!");
		$("#txtEmailThubao").focus();
		return false;
    }
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test($("#txtEmailThubao").val()) == false) {
        alert("Định dạng Email không đúng");
        return false;
    }		
	if($("#txtDientich").val()!=""&&!checkFloat($("#txtDientich").val()))
	{
		alert("Diện tích phải là kiểu số!");
		document.getElementById("txtDientich").focus();
		return false;
	}
	if($("#txtMinfront").val()!=""&&!checkFloat($("#txtMinfront").val()))
	{
		alert("Mặt tiền phải là kiểu số!");
		document.getElementById("txtMinfront").focus();
		return false;
	}
	/*
	if($("#txtDientichSD").val()!=""&&!checkFloat($("#txtDientichSD").val()))
	{
		alert("Diện tích sử dụng phải là kiểu số!");
		document.getElementById("txtDientichSD").focus();
		return false;
	}*/
	if($("#txtPriceMin").val()!=""&&!checkFloat($("#txtPriceMin").val()))
	{
		alert("Giá từ phải là kiểu số!");
		document.getElementById("txtPriceMin").focus();
		return false;
	}
	if($("#txtPriceMax").val()!=""&&!checkFloat($("#txtPriceMax").val()))
	{
		alert("Giá tới phải là kiểu số!");
		document.getElementById("txtPriceMax").focus();
		return false;
	}
	if(parseFloat($("#txtPriceMin").val())>=parseFloat($("#txtPriceMax").val()))
	{
		alert("Giá từ phải nhỏ hơn giá tới!");
		document.getElementById("txtPriceMin").focus();
		return false;
	}
	
	var tran__="10";
	if(document.getElementById("RadioGroup1_0").checked==true)
		tran__="1";
	var phuongthuc ="";
	if(document.getElementById("phuongthuc_0").checked==true)
		phuongthuc="0";
	else if(document.getElementById("phuongthuc_1").checked==true) phuongthuc="1";
	else if(document.getElementById("phuongthuc_2").checked==true) phuongthuc="2";
	
	/*
	var ppublic="";
	if(document.getElementById("chkPublic").checked==true)
		ppublic="1";
	else ppublic="0";
	*/
	/* merge suburb*/
	var lstSrb="";
	$('#lstSuburb input:checkbox').each( function ()	{
		if(this.checked) lstSrb+=this.value+"," ;		
	});
	$('#txtSuburb').val(lstSrb);
	var phapli="";
	$('.listbox_law input:checkbox').each( function ()	{
		if(this.checked) phapli+=this.value+"," ;
	});
	
	var dtqc="";
	if($('#rdoQuaMG').is(':checked'))
		dtqc="1";
	else if($('#rdoCChu').is(':checked')) dtqc="2";
	else if($('#rdoCa2').is(':checked')) dtqc="3";
	
	var param = {
		state:$("#"+$('#hdfCtl').val()+"_cbState").val()
		,suburb:lstSrb
		,pclass:$("#cbProClass").val()
		,tran:tran__
		,min:$("#txtPriceMin").val()
		,max:$("#txtPriceMax").val()
		, kieubds: $("#txtPropertyTypeAL").val()
		,huong:$("#txtHuong").val()
		/*,phuong:$("#cbPhuongXa").val()
		,duong:$("#cbDuong").val()*/
		,duan:$("#txtEstate").val()
		,phaply:phapli
		,dientich:$("#txtDientich").val()
		,mattien:$("#txtMinfront").val()
		,ktdtt:$("#txtKTDToiThieu").val()		
		/*,dientichSD:$("#txtDientichSD").val()
		,phongngu:$("#"+$('#hdfCtl').val()+"_cbSpn").val()*/
		,tenthubao:$("#txtTenThubao").val()
		/*,motakhac:$("#txtMoTaKhac").val()*/
		,phuongthuc:phuongthuc		
		/*,ppublic:ppublic*/
		,email:$('#txtEmailThubao').val()
		,dtqc:dtqc
		,himg:$('#chkImg').is(':checked')?$('#chkImg').val():""
	};

$('#dvAlert').html("Đang xử lí ....");
$('#btnLabel').text("Đang xử lí ....");
$('#btnSubmit').attr('disabled', 'disabled');
    
 	document.getElementById("btnSubmit").onclick=function (){;};
 	$.post(pathClient + "Services/Post.asmx/RegisteEmailReceiving", param,
 		function(data){
 			doLoadPropertyListing(1);
 			document.getElementById("btnSubmit").onclick = function () {
 			    
 				submitAlert();
 				
 			};
             ResetData();
             trackPageview('/muabannhadat.com.vn/thubao-bds-submit');
             alert("Đăng ký thành công");
             $('#btnLabel').text("Đăng ký nhận email");
             $('#btnSubmit').attr('disabled', '');
 		});
}

function ResetData()
{
	document.forms[0].reset();
 	$('#listPropertyType').html("");
 	$('#lstSuburb').html("");
 	$('#txtPropertyTypeAL').val("");
 	$('#txtHuong').val("");
 	$('#txtSuburb').val("");
 	$('#txtEstate').val("");
 	$("#"+$('#hdfCtl').val()+"_cbState").val("");
}

var listEstateFolStateEM=[];
/* xu li add va remove est*/
var listEstateFolSuburbEM=[];

function LoadEstate(stateid,divid)
{
	if(stateid!="")
	{

	    var url = pathClientAjax + "Services/UsrHandler.asmx/LoadEstateInMyAlert?suburb=" + $('#txtSuburb').val() + "&stateid=" + stateid + "&ttype=" + $('#txtSuburb').val() + "&ptype=" + $('#txtSuburb').val() + "&d=" + (new Date()).getTime();
		$('#'+divid).html("Đang tải dữ liệu ...");
		$.post(url, {},
			function(data) {
				listEstateFolStateEM = data!=""?data.lst:null;
				listEstateFolSuburbEM=listEstateFolStateEM;
				TaoListEstate(listEstateFolStateEM,divid,"");
			},'json'
		);
		
	}
	
}

function LoadEstateFollowSuburb(divid)
{
	var l_=[];
	var j=0;
	for(var i =0;i<listEstateFolStateEM.length;i++)
	{
		var eID=listEstateFolStateEM[i].s1;
		var eName=listEstateFolStateEM[i].s2;
		var eSuburb=listEstateFolStateEM[i].s3;
		var eCount=listEstateFolStateEM[i].s4;
		if($('#txtSuburb').val()!="")
		{
			if(NvgUsrFunction.CheckValueInString(eSuburb,$('#txtSuburb').val()))
			{
				l_[j]=listEstateFolStateEM[i];
				j++;
			}
		}
		else l_=listEstateFolStateEM;
	}		
	listEstateFolSuburbEM=l_;
	TaoListEstate(l_,divid,"");
}

//gan list l vao divid
function TaoListEstate(lll,divid,strChuoi)
{	
	$('#'+divid).html("");
	if(lll!=""&&lll!=null)
	{
	    var tpl__ = $.template('<li><input value="${eID}" type="checkbox" >&nbsp;&nbsp;<span id="maEst${eID}">${eName}</span></li>');		
		for(var i =0;i<lll.length;i++)
		{
			var eID=lll[i].s1;
			var eName=lll[i].s2;
			var eSuburb=lll[i].s3;
			if(strChuoi=="")
			{								
				$('#'+divid).append(tpl__,{eID:eID,eName:eName});
			}
			else 
			{
				if(!NvgUsrFunction.CheckValueInString(eID,strChuoi))
				{
					$('#'+divid).append(tpl__,{eID:eID,eName:eName});
				}
			}
			
		}
	}
}

//gan list l vao divid
function TaoItemEstate(item_,divid)
{				
	var tpl__=$.template('<li><input value="${eID}" type="checkbox" ><span id="maEst${eID}">${eName}</span></li>');		
			
	var eID=item_.s1;
	var eName=item_.s2;
	var eSuburb=item_.s3;
	
	$('#'+divid).append(tpl__,{eID:eID,eName:eName});
	
}

function ChangeSuburbGetEst(this_)
{
	var lstSub =$('#txtSuburb').val();
	if(this_.checked) lstSub+=this_.value + ",";
	else lstSub=lstSub.replace(this_.value+',','');
	$('#txtSuburb').val(lstSub);
	LoadEstateFollowSuburb('divLstEstate');
}


var _arrEstAdded_MA=[];
var strChuoiAdd_="";
function AddEstMA()
{
	var f= false;
	$('#divLstEstate input:checkbox').each(
		function () {
			if(this.checked) 
			{
				f=true;		
				// listEstateFolSuburbEM global variable
				// add data vao arr estate ng dung chon
				for(var i=0;i<listEstateFolSuburbEM.length;i++)
				{
					if(this.value==listEstateFolSuburbEM[i].s1)
					{
						_arrEstAdded_MA.push(listEstateFolSuburbEM[i]);
						strChuoiAdd_+=this.value+",";
					}					
				}
			}
		}
	);	
	if(f)
	{
		$('#txtEstate').val(strChuoiAdd_);
 		TaoListEstate(listEstateFolSuburbEM,'divLstEstate',strChuoiAdd_);
 		TaoListEstate(_arrEstAdded_MA,'divLstEstateAdded',"");
 		
 	}
}
function RemoveEstMA()
{
	var _arrEstRemovet_MA=[];
	var f= false;
	$('#divLstEstateAdded input:checkbox').each(
		function () {
			if(this.checked) 
			{
				f=true;
				strChuoiAdd_=strChuoiAdd_.replace(this.value+',','');
			}
			// gan lai array cuoi cung khi ng dung remove est
		}
	);
	if(f)
	{
		for(var i=0;i<_arrEstAdded_MA.length;i++)
		{
			if(NvgUsrFunction.CheckValueInString(_arrEstAdded_MA[i].s1,strChuoiAdd_))
			{
				_arrEstRemovet_MA.push(_arrEstAdded_MA[i]);
			}
		}
		$('#txtEstate').val(strChuoiAdd_);
		_arrEstAdded_MA=_arrEstRemovet_MA;
 		TaoListEstate(listEstateFolSuburbEM,'divLstEstate',strChuoiAdd_);
 		TaoListEstate(_arrEstAdded_MA,'divLstEstateAdded',"");		
 	}
}

function doLoadPropertyListing(pg){
	var form = $('#Form1');	
	form.disabled = !form.disabled;	
	$('#dvAlert').html("Đang xử lí ....");		
	
	var url = pathClientAjax+"Services/Alert.asmx/Init";	
	
	$.post(url,{},
 		function(data){
 			form.disabled = !form.disabled;
 			if(data!=""){
 				$('#dvAlert').html(data);
 			}
 			else
 			{
 				//$('#dvAlert').html('');
 				Signin();
 			}
 		});
}
function initForm(){	
	doLoadPropertyListing(1);
}
function checkFloat(str){

	var a, st;

	st= str;

	var numi=0;

	for (var i=0;i< st.length; i++){

		if (st.charAt(i) < '0' || st.charAt(i)>'9'){

			if (st.charAt(i) != '.') 

			{

				return false;

			} 

			else

			{

				if(i==0) return false;

				numi += 1;

			}

		}//End If
	}

	if(numi>1) return false;

	return true;

}
function getPropertyType(id)
{
	if(document.getElementById("chkPropertyType"+id).checked==true)
	    document.getElementById("txtPropertyTypeAL").value += id + ",";
	else document.getElementById("txtPropertyTypeAL").value = document.getElementById("txtPropertyTypeAL").value.replace(id + ',', '');
}

function getHuong(id)
{
	if(document.getElementById("chkHuong"+id).checked==true)
		document.getElementById("txtHuong").value+=id+",";
	else document.getElementById("txtHuong").value=document.getElementById("txtHuong").value.replace(id+',','');
}
function mjSignSuburb(v,select)
{
	if(v!="")
	{
		if(mjGetMultiValue(select).split(',').length>2)
		{
			removeSelectbox("cbPhuongXa","Chọn");		
			removeSelectbox("cbDuong","Chọn");
		}
		else
		{
			ChangeSuburb_forWard_Search(v,"cbPhuongXa");
			ChangeSuburb_forStreet_Search(v,"cbDuong");		
		}
	}
	else 
	{
		removeSelectbox("cbPhuongXa","Chọn");		
		removeSelectbox("cbDuong","Chọn");
	}
}
function ChangeSuburb_forWard_Search(s,obj_id)
{
	var url=pathClientAjax+"handler/propertyhandler.aspx?act=changesuburb&suburbid="+s+"&d="+(new Date()).getTime();
	$.get(url, {},
		function(data){
			var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
			if(lcNodes.length > 0){						
				try{
					removeSelectbox(obj_id,"Chọn");
					for (var k = document.getElementById(obj_id).options.length-1; k >= 0; k--){
						document.getElementById(obj_id).options[k] = null;
					}
					document.getElementById(obj_id).options[0] = new Option("Chọn", "");
									
					for(var k = 0; k < lcNodes.length ; k++){
						var option_value = lcNodes[k].childNodes[0];
						var option_text  = lcNodes[k].childNodes[1];
						document.getElementById(obj_id).options[k+1] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
					}	
					document.getElementById(obj_id).disabled = false;				
				}catch(exp){}
			}
	});
	
}
function ChangeSuburb_forStreet_Search(s,obj_id)
{
	var url=pathClientAjax+"handler/propertyhandler.aspx?act=Change_suburb_Street&suburbid="+s+"&d="+(new Date()).getTime();
	$.get(url, {},
		function(data){
			var lcNodes     = data.getElementsByTagName("*")[0].childNodes;		
			if(lcNodes.length > 0){						
				try{
					removeSelectbox(obj_id,"Chọn");
					for (var k = document.getElementById(obj_id).options.length-1; k >= 0; k--){
						document.getElementById(obj_id).options[k] = null;
					}
					document.getElementById(obj_id).options[0] = new Option("Chọn", "");
									
					for(var k = 0; k < lcNodes.length ; k++){
						var option_value = lcNodes[k].childNodes[0];
						var option_text  = lcNodes[k].childNodes[1];
						document.getElementById(obj_id).options[k+1] = new Option(option_text.childNodes[0].nodeValue,option_value.childNodes[0].nodeValue);
					}	
					document.getElementById(obj_id).disabled = false;				
				}catch(exp){}
			}
	});
}
function CancelPrice()
{
	$('#cbMinPrice1').show();
	$('#cbMaxPrice1').show();
	$('#txtPriceMin').hide();
	$('#txtPriceMax').hide();	
	$('#txtPriceMin').val("");
	$('#txtPriceMax').val("");
	$('#divTextGT').html("");
	$('#divTextGD').html("");
	
	$('#cbMinPrice1').val("NA");
	$('#cbMaxPrice1').val("NA");
}
function ChangePrice(txt)
{
	if(txt=="*")
	{
		$('#cbMinPrice1').hide();
		$('#cbMaxPrice1').hide();
		$('#txtPriceMin').show();
		$('#txtPriceMax').show();
		$('#imgRefreshPrice').show();		
		
		if($('#txtPriceMin').val()=="NA")$('#txtPriceMin').val("0");
		if($('#txtPriceMax').val()=="NA")$('#txtPriceMax').val("0");
	}
	else
	{
		if(txt!="NA")
		{		
			$('#txtPriceMin').val($('#cbMinPrice1').val());
			$('#txtPriceMax').val($('#cbMaxPrice1').val());
		}
		else 
		{
			$('#txtPriceMin').val("");
			$('#txtPriceMax').val("");
		}
	}
}



////// Email alert client //// 

function submitAlertClient()  // ham nay khac ham submitAlert la co act de vo postHandler phan biet co dang nhap hay ko.
{
   
    if ($("#" + $('#hdfCtl').val() + "_cbState").val() == "") {
        alert("Vui lòng chọn tỉnh thành!");
        return false;
    }
    if ($("#cbProClass").val() == "") {
        alert("Vui lòng chọn loại BĐS!");
        $("#cbProClass").focus();
        return false;
    }
    if ($("#txtEmailThubao").val() == "") {
        alert("Email không được rỗng!");
        $("#txtEmailThubao").focus();
        return false;
    }
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test($("#txtEmailThubao").val()) == false) {
        alert("Định dạng Email không đúng");
        return false
    }
    if ($("#txtDientich").val() != "" && !checkFloat($("#txtDientich").val())) {
        alert("Diện tích phải là kiểu số!");
        document.getElementById("txtDientich").focus();
        return false;
    }
    if ($("#txtMinfront").val() != "" && !checkFloat($("#txtMinfront").val())) {
        alert("Mặt tiền phải là kiểu số!");
        document.getElementById("txtMinfront").focus();
        return false;
    }
    /*
    if($("#txtDientichSD").val()!=""&&!checkFloat($("#txtDientichSD").val()))
    {
    alert("Diện tích sử dụng phải là kiểu số!");
    document.getElementById("txtDientichSD").focus();
    return false;
    }*/
    if ($("#txtPriceMin").val() != "" && !checkFloat($("#txtPriceMin").val())) {
        alert("Giá từ phải là kiểu số!");
        document.getElementById("txtPriceMin").focus();
        return false;
    }
    if ($("#txtPriceMax").val() != "" && !checkFloat($("#txtPriceMax").val())) {
        alert("Giá tới phải là kiểu số!");
        document.getElementById("txtPriceMax").focus();
        return false;
    }
    if (parseFloat($("#txtPriceMin").val()) >= parseFloat($("#txtPriceMax").val())) {
        alert("Giá từ phải nhỏ hơn giá tới!");
        document.getElementById("txtPriceMin").focus();
        return false;
    }

    var tran__ = "10";
    if (document.getElementById("RadioGroup1_0").checked == true)
        tran__ = "1";
    var phuongthuc = "";
    if (document.getElementById("phuongthuc_0").checked == true)
        phuongthuc = "0";
    else if (document.getElementById("phuongthuc_1").checked == true) phuongthuc = "1";
    else if (document.getElementById("phuongthuc_2").checked == true) phuongthuc = "2";

    /*
    var ppublic="";
    if(document.getElementById("chkPublic").checked==true)
    ppublic="1";
    else ppublic="0";
    */
    /* merge suburb*/
    var lstSrb = "";
    $('#lstSuburb input:checkbox').each(function () {
        if (this.checked) lstSrb += this.value + ",";
    });
    $('#txtSuburb').val(lstSrb);
    var phapli = "";
    $('.listbox_law input:checkbox').each(function () {
        if (this.checked) phapli += this.value + ",";
    });

    var dtqc = "";
    if ($('#rdoQuaMG').is(':checked'))
        dtqc = "1";
    else if ($('#rdoCChu').is(':checked')) dtqc = "2";
    else if ($('#rdoCa2').is(':checked')) dtqc = "3";

    var param = {
        state: $("#" + $('#hdfCtl').val() + "_cbState").val()
		, suburb: lstSrb
		, pclass: $("#cbProClass").val()
		, tran: tran__
		, min: $("#txtPriceMin").val()
		, max: $("#txtPriceMax").val()
		, kieubds: $("#txtPropertyTypeAL").val()
		, huong: $("#txtHuong").val()
        /*,phuong:$("#cbPhuongXa").val()
        ,duong:$("#cbDuong").val()*/
		, duan: $("#txtEstate").val()
		, phaply: phapli
		, dientich: $("#txtDientich").val()
		, mattien: $("#txtMinfront").val()
		, ktdtt: $("#txtKTDToiThieu").val()
        /*,dientichSD:$("#txtDientichSD").val()
        ,phongngu:$("#"+$('#hdfCtl').val()+"_cbSpn").val()*/
		, tenthubao: $("#txtTenThubao").val()
        /*,motakhac:$("#txtMoTaKhac").val()*/
		, phuongthuc: phuongthuc
        /*,ppublic:ppublic*/
		, email: $('#txtEmailThubao').val()
		, dtqc: dtqc
		, himg: $('#chkImg').is(':checked') ? $('#chkImg').val() : ""
        , act: "EmailAlertClient"
    };

    //$('#dvAlert').html("Đang xử lí ....");
    document.getElementById("btnSubmit").onclick = function () { ; };
    $.post(pathClientAjax + "handler/Post.aspx?", param,
 		function (data) { 		    
 		    document.getElementById("btnSubmit").onclick = function () {
 		        submitAlertClient(); 		        
 		    };
 		    ResetData();
 		    trackPageview('/muabannhadat.com.vn/thubao-bds-submit');
 		    alert("Đăng ký thành công");
 		});

}
function LoadEstateFollowEstateId(divid, lstId, stateid) {

    if (stateid != "") {
        var lstKetQua = [];
        var url = pathClientAjax + "Services/UsrHandler.asmx/LoadEstateInMyAlert?suburb=" + $('#txtSuburb').val() + "&stateid=" + stateid + "&ttype=" + $('#txtSuburb').val() + "&ptype=" + $('#txtSuburb').val() + "&d=" + (new Date()).getTime();
        $('#' + divid).html("Đang tải dữ liệu ...");
        $.post(url, {},
			function (data) {
			    lstKetQua = data != "" ? data.lst : null;
			    // load du an theo chuoi Id			   
			    var l_ = [];
			    var j = 0;
			    for (var i = 0; i < lstKetQua.length; i++) {
			        var eID = lstKetQua[i].s1;
			        var eName = lstKetQua[i].s2;
			        var eSuburb = lstKetQua[i].s3;
			        var eCount = lstKetQua[i].s4;			        
			        if (lstId != "") {			          
			            if (nvgUtils.CheckSplitValue(eID, lstId, ',')) {
			                l_[j] = lstKetQua[i];
			                j++;
			            }
			        }
			    }
			    if (l_.length > 0) {			        
			        TaoListEstate(l_, divid, "");
			    }
                //
			}, 'json'
		);
    }        
}


