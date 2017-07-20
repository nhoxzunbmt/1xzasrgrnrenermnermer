function showCredit(proid,agentid)
{
	// var act="?act=ShowFormCredit";
//	act+="&agentid="+agentid;
//	act+="&proid="+proid;
	//act+= "&d="+(new Date()).getTime();
	var url = pathClient + "services/PayEventHandler.asmx/ShowFormCredit";
	$('#divWating').show();
	$.post(url, {agentid: agentid, proid: proid},
		function(data) {
			$('#divWating').hide();
			if(data=="Nodata") alert("Chưa có dữ liệu!");
			else if(data!="")
			{
			    $('#login_box').html(data);
			    $('#login_box').css("top", "100px");
			    $('#login_box').css("left", "25%");
			    $('#login_box').css("position", "fixed");
			    $('#login_box').removeClass("PopupBox");
			    
				$('#login_box').show();
			}
			else alert("Chưa có dữ liệu!");
				//window.location=pathClientAjax;
		}
	);
}
function changeTinhThanh(_objSelectName, _id) {
    if (_id != "") {
        $.post(pathClient + "services/StateGet.asmx/SuburbJson", { stateid: _id }, 
		function (data) {
		    var obj = data.lst;
		    var obj_select = document.getElementById(_objSelectName);
		    removeSelectbox(_objSelectName, "Chọn quận huyện");
		    if (obj.length > 0) {
		        for (var k = 0; k < obj.length; k++) {
		            var options_length = obj_select.length;
		            var option_value = obj[k].s1;
		            var option_text = obj[k].s2;
		            obj_select.options[options_length] = new Option(option_text, option_value);
		        }
		        obj_select.disabled = false;
		    }

		}, 'json');
    }
    else removeSelectbox(_objSelectName, "Chọn");

};
function removeSelectbox(objID, initText) {
    if (initText && initText.indexOf('*') != -1)
        initText = initText.replace('***', 'Chọn');
    var obj_select = document.getElementById(objID);
    obj_select.disabled = true;
    for (var k = obj_select.options.length - 1; k >= 0; k--) {
        obj_select.options[k] = null;
    }
    if (initText != undefined || initText != null) {
        if (initText != '') obj_select.options[0] = new Option(initText, "");
    }
}
 var DataNoteTopAgent= "";
    function ShowNoteTopAgent () {
       
        if (DataNoteTopAgent != "") {
            $('#popupTopAgentVip').html(DataNoteTopAgent);
            $('#popupTopAgentVip').show();
            $('#popupTopAgentVip').centerInClient();
          
        }
        else {
            var act = "act=spopuptausr";
            var url = pathClient + "handler/handler.aspx?" + act;
            $.post(url, {},
			function (data) {
			    if (data != "0") {
			        $('#popupTopAgentVip').html(data);
			        $('#popupTopAgentVip').show();
			        $('#popupTopAgentVip').centerInClient();
			        DataNoteTopAgent = data;
			        
			    }
			   
			});
        }
}
var vBdsAlrtMes = "";

function SetTopAgentVip(proid, agentid, paytype, StatusPayEvent, dateEnd_, lstHaveFee_, peid_, stt_) {
    if (vBdsAlrtMes != "" && stt_ != "0") {
        alert(vBdsAlrtMes);
        return false;
    }
    var text = "Bạn có chắc set VIP BĐS này?";
    if (stt_ == "0") text = "Bạn có muốn tin này ngừng đăng Vip?";
    if (confirm(text)) {
        var act = "?act=settopagent";
        var url = pathClient + "handler/PayEventHandler.aspx" + act;
        var pars = {
            agentid: agentid,
            proid: proid,
            paytype: paytype,
            StatusPayEvent: StatusPayEvent,
            dateend: dateEnd_,
            lsthfee: lstHaveFee_,
            peid: peid_,
            piold: "",
             stt: stt_,
             AgentDefault: $.cookie("AgentDefault"),
             LoginType: $.cookie("LoginType"),
             OfficeID: $.cookie("OfficeID")
         }
        $('#divWating').show();
        $.post(url, pars,
		    function (data) {
		        $('#divWating').hide();
		        if (data == "OK") {
		            alert("Thay đổi thành công");
		            LoadListAsdGuest($("#hCurrentPage").val(), type);
		            vBdsAlrtMes = "";
		        }
		        else {
		            if (data != "NoPoint") {
		                vBdsAlrtMes = data;
		                alert(data);
		            }
		            else alert("Bạn không đủ điểm để kích hoạt tin này!");
		        }
		    }
	    );
    }
}
function GiaHanThemNgay(dtmNgayKT, peid, piID, piStt)
{
	if(confirm("Bạn có chắc gia hạn thêm ngày?"))
	{
		var act="?act=giahanthemngay";		
		var url = pathClient+"handler/PayEventHandler.aspx"+act;
		$('#divWating').show();
		$.post(url, {peid:peid, dte:dtmNgayKT, songay:30, pi:piID, pistt:piStt},
			function(data) {
				$('#divWating').hide();
				if(data=="Nodata") alert("Chưa có dữ liệu!");
				else if(data!="")
				{
					if(data.split("<==>")[0]=="" && data.split("<==>")[1]=="" && data.split("<==>")[2]=="")
					{
						alert("Error!");
						return ;
					}
					$('#dtmNgayKT_'+piID).html(data.split("<==>")[0]);
					if(data.split("<==>")[1]!="")
						$('#spStt_'+piID).html(data.split("<==>")[1]);
					$('#giaHan_'+piID).html(data.split("<==>")[2]);
				}
				else
					window.location=pathClientAjax;
			}
		);
	}
}
function showFormPayEventLm(proid, agentid, chinhChu) {
    /* add style when user login*/
    document.getElementById('login_box').style.position = 'fixed';


    var pars = {
        agentid: agentid,
        proid: proid,
        chinhChu: chinhChu
    };

    var url = pathClient + "services/PayEventHandler.asmx/ShowFormPayEventLm";
    $('#divWating').show();
    $.post(url, pars,
			function (data) {
			    $('#divWating').hide();
			    if (data != "") {
			        $('#login_box').html(data);
			        $('#login_box').width(540);
			        $('#login_box').css("top", "50px");
			        $('#login_box').css("left", "29%");
			        $('#login_box').addClass("PopupBox");

			        if ($('#hdfExpireMem').val() == "") {
			            $('#boxwarning').show();
			            $('#ScoreProduct').hide();
			        }
			        //			        if (paytype == 7) {
			        //			            $('#pNoteSms').hide();
			        //			            $('#pNoteHetHan').hide();
			        //			            $('#h5Title').hide();
			        //			        }
			        /*$('#login_box').centerInClient();*/
			        $('#login_box').show();
			    }
			    else
			        window.location = pathClient;
			}
		);

}
function ShowFormPayEvent(proid, agentid, chinhChu,idstate)
{	
	/* add style when user login*/
	document.getElementById('login_box').style.position='fixed';
	

		var pars={
			agentid:agentid,
			proid:proid,
			chinhChu: chinhChu,
			idstate: idstate						
		};

        var url = pathClient + "services/PayEventHandler.asmx/ShowFormPayEvent";	
		$('#divWating').show();
		$.post(url, pars,
			function (data) {
			    $('#divWating').hide();
			    if (data != "") {
			        $('#login_box').html(data);
			        $('#login_box').width(540);
			        $('#login_box').css("top", "50px");
			        $('#login_box').css("left", "29%");
			        $('#login_box').addClass("PopupBox");

			        if ($('#hdfExpireMem').val() == "") {
			            $('#boxwarning').show();
			            $('#ScoreProduct').hide();			            
			        }
//			        if (paytype == 7) {
//			            $('#pNoteSms').hide();
//			            $('#pNoteHetHan').hide();
//			            $('#h5Title').hide();
//			        }
			        /*$('#login_box').centerInClient();*/
			        $('#login_box').show();
			    }
			    else
			        window.location = pathClient;
			}
		);
		
}
function ShowFormPayEventActiveOther(proid,agentid,paytype,StatusPayEvent,dateEnd_, lstHaveFee_, peid_, peOther_)
{	
//	var act="?act=sfpeao";
	var pars={
		agentid:agentid,
		proid:proid,
		paytype:paytype,
		StatusPayEvent:StatusPayEvent,
		dateend:dateEnd_,
		lsthfee:lstHaveFee_,
		peid:peid_,
		peo:peOther_
	};

	var url = pathClient + "services/PayEventHandler.asmx/ShowFormPayEventActiveOther";	
	$('#divWating').show();
	$.post(url, pars,
		function(data) {
			$('#divWating').hide();
			if(data!="") {
			    $('#login_box').width(540);
			    $('#login_box').css("top", "100px");
			    $('#login_box').css("left", "29%");
			    $('#login_box').addClass("PopupBox");
			    /*$('#login_box').centerInClient();*/
			    $('#login_box').html(data);
			    if ($('#hdfExpireMem').val() == "") {
			        $('#boxwarning').show();
			        $('#ScoreProduct').hide();
			    }
			    $('#login_box').show();
			}
			else
				window.location=pathClientAjax;
		}
	);
}
function PayEventOther(proid,agentid,paytype,StatusPayEvent,dateEnd_,lstHaveFee_, peid_, peOther_)
{
	
		var act="?act=peother";
		var pars={
			agentid:agentid,
			proid:proid,
			paytype:paytype,
			StatusPayEvent:StatusPayEvent,
			dateend:dateEnd_,
			lsthfee:lstHaveFee_,
			peid:peid_,
			peo:peOther_,
            AgentDefault: $.cookie("AgentDefault"),
             LoginType: $.cookie("LoginType"),
             OfficeID: $.cookie("OfficeID")
		};	

		$('#btnPayEvent').html("<div class=\"fake_btn_dark_lolite\"><a onclick=\"return false;\" rel=\"nofollow\"><div>Đang xử lý...</div></a></div>");
		var url = pathClient+"handler/PayEventHandler.aspx"+act;	
		$.post(url, pars,
			function(data) {
				if(data=="*")
				{
				/* lam binh thuong*/
				    //ShowFormPayEvent(proid,agentid,paytype,StatusPayEvent,dateEnd_,lstHaveFee_, peid_, "");					
				    LoadListAsdGuest($("#hCurrentPage").val(), type);
				    $('#login_box').hide();
				}
				else {
					$('#pNoteHetHan').show();
					$('#boxwarning').show();
					$('#ScoreProduct').hide();
					$('#divTitleEvent').hide();
					$('#pNoteSms').hide();
					$('#divTitleEventExpire').show();
					$('#btnPayEvent').hide();
				}
			}
		);

}
function ReAsignAgent(proid,agentid,paytype,StatusPayEvent)
{
	var act="?act=reasignagent";	
	var url = pathClient+"handler/PayEventHandler.aspx"+act;	
	$.post(url, {proid:proid,aid:agentid,paytype:paytype,sttpe:StatusPayEvent,laid:$('#lstaid').val()},
		function(data) {
			if(data!="")
			{
			    LoadListAsdGuest($("#hCurrentPage").val(), type);
 				$('#login_box').hide();
			}
			else
				window.location=pathClientAjax;
		}
	);
}
function SetAgent(aid)
{
	var objj= $('#lstaid');			
	if($('#chkUsrAgent_'+aid).is(':checked'))
	{		
		objj.val(objj.val()+aid+",");
	}
	else objj.val(objj.val().replace(aid+',',''));
}
function SetAgentDLH(aid)
{
	$('#lstaid').val(aid);
}
function PayEvent(proid, agentid, groupPayEventId, act) {
    var act = "?act=" + act;  // GiaHanTin hoac LamMoiTin;
    var pars = {
        agentid: agentid,
        proid: proid,
        grouppayeventid: groupPayEventId,
        AgentDefault: $.cookie("AgentDefault"),
        LoginType: $.cookie("LoginType"),
        OfficeID: $.cookie("OfficeID")
    };


    $('#btnPayEvent').html("<div class=\"fake_btn_dark_lolite\"><a onclick=\"return false;\" rel=\"nofollow\"><div>Đang xử lý...</div></a></div>");
    var url = pathClient + "handler/PayEventHandler.aspx" + act;
    $.post(url, pars,
		function (data) {
		    var res = data.split("#");
		    if (res[0] != "*") {
		        //alert(data);
		        $('#pNoteHetHan').show();
		        $('#boxwarning').show();
		        $('#ScoreProduct').hide();
		        $('#divTitleEvent').hide();
		        $('#pNoteSms').hide();
		        $('#divTitleEventExpire').show();
		        /*$('#btnPayEvent').html("<div id=\"login_btn\" class=\"fake_btn_dark_lolite\" onclick=\"PayEvent("+proid+","+agentid+","+paytype+",'"+StatusPayEvent+"','"+dateEnd_+"','"+peid_+"');\"><a rel=\"nofollow\" onclick=\"return false;\"><div>Đồng ý</div></a></div><a rel=\"nofollow\" href=\"javascript:void(0)\" onclick=\"document.getElementById('login_box').style.display='none'; return false;\" class=\"fake_btn_off\"><div>Hủy bỏ</div></a>");*/
		        $('#btnPayEvent').hide();

		    }
		    else {
		        DosendMailInsertion(false, res[2], res[3]);
		        LoadListAsdGuest($("#hCurrentPage").val(), type);
		        $('#login_box').hide();
		    }
		}
	);
}
function PayEventLm(proid,agentid,groupPayEventId)
{
	var act="?act=LamMoiTin";
	var pars={
		agentid:agentid,
		proid:proid,
		grouppayeventid: groupPayEventId,		
        AgentDefault: $.cookie("AgentDefault"),
            LoginType: $.cookie("LoginType"),
            OfficeID: $.cookie("OfficeID")
	};
		

	$('#btnPayEvent').html("<div class=\"fake_btn_dark_lolite\"><a onclick=\"return false;\" rel=\"nofollow\"><div>Đang xử lý...</div></a></div>");
	var url = pathClient+"handler/PayEventHandler.aspx"+act;
	$.post(url, pars,
		function (data) {
			var res = data.split("#");
			if (res[0] != "*") {			        
			    //alert(data);
			    $('#pNoteHetHan').show();
			    $('#boxwarning').show();
			    $('#ScoreProduct').hide();
			    $('#divTitleEvent').hide();
			    $('#pNoteSms').hide();
			    $('#divTitleEventExpire').show();
			    /*$('#btnPayEvent').html("<div id=\"login_btn\" class=\"fake_btn_dark_lolite\" onclick=\"PayEvent("+proid+","+agentid+","+paytype+",'"+StatusPayEvent+"','"+dateEnd_+"','"+peid_+"');\"><a rel=\"nofollow\" onclick=\"return false;\"><div>Đồng ý</div></a></div><a rel=\"nofollow\" href=\"javascript:void(0)\" onclick=\"document.getElementById('login_box').style.display='none'; return false;\" class=\"fake_btn_off\"><div>Hủy bỏ</div></a>");*/
			    $('#btnPayEvent').hide();

			}
			else {			    
			    DosendMailInsertion(false, res[2], res[3]);
			    LoadListAsdGuest($("#hCurrentPage").val(), type);
			    $('#login_box').hide();
			}
		}
	);
}

//function DosendMailPayEvent(point, name, pid) {
//    var url = pathClient + "services/usrhandler.asmx/DoSendMail";
//    $.post(url, {point: point, name: name, pid: pid},
//        function(data) {
//        });
//}

function ShowCoworker(proid, aid,paytype,StatusPayEvent)
{	
	var url = pathClientAjax + "services/PayEventHandler.asmx/ShowCoworker";	
	$('#divWating').show();
	$.post(url, { pid_: proid, aid_: aid, paytype_: paytype, sttpayevent_: StatusPayEvent, mid: $.cookie("OfficeID") },
		function(data) {
			$('#divWating').hide();
			if(data!="")
			{
				$('#showCoworkerLst').html(data);
				$('#showCoworkerLst').show();
				
			}
			else
				window.location=pathClientAjax;
		}
	);
}
function SubmitEditTitle(proid)
{
	var act="?act=SubmitEditTitle";	
	var url = pathClient+"handler/PayEventHandler.aspx"+act;	
	$.post(url, {proid:proid,title:$("#txtTitle").val()},
		function(data) {
			if(data!="")
			{
				$('#login_box').hide();
				alert("Hiệu chỉnh thành công!");
				LoadListAsdGuest($("#hCurrentPage").val(), type);
				//window.location=$("#hdlinkUrl").val();
			}
			else
				alert("Hiệu chỉnh không thành công!");
		}
	);
}
function ShowfromEditTitle(proid)
{
	var act="?act=ShowFormEditTitle";
	
	var url = pathClientAjax+"handler/PayEventHandler.aspx"+act;	
	$('#divWating').show();
	$.post(url, { proid: proid },
		function (data) {
		    $('#divWating').hide();
		    if (data != "") {
		        $('#login_box').html(data);
		        $('#login_box').show();
		    }
		    else
		        window.location = pathClientAjax;
		}
	);
}
var type="";
function LoadListProForPayEvent(spage,t)
{
	type=t;
	document.getElementById('dvPaging').style.display='block';
	document.getElementById('txtHint').innerHTML = "<div style='text-align:center'><IMG alt=''src="+ pathClientAjax + "Images/loading.gif></div>";
	var url = pathClientAjax+"handler/Misc.aspx?act=ListProPayEvent&AgentID="+$("#hdAgentID").val()+"&t="+t+"&pg="+spage;	
	$.get(url, 
		function(data) {
			$('#txtHint').html(data.split("<-||->")[0]);
			var tps = (parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()) - parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))>0?((parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))+1):parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()));
			if(tps<$("#hCurrentPage").val())
				$("#hCurrentPage").val()=1;
			nvgPaging.mjDrawLbPageNew(tps, $("#hCurrentPage").val(), "dvPaging","gotoPageListProForPayEvent");	
		}
	);
	
}
function gotoPageListProForPayEvent(numberpage)
{			
	pg = numberpage;
	LoadListProForPayEvent(numberpage,type);
}
function changeSelectedValue(se, hd) {
    
    document.getElementById(hd).value = document.getElementById(se).value;    
}

function LoadListAsdGuest(spage,t)
{
// 	if(document.getElementById("hdDTTimBDS").value!="1")
// 	{
	//document.getElementById('dvPaging').style.display='block';
	type=t;
	var id_="",stt_="",lbds_="",lgd_="",lt_="",ltk_="",fd_="",td_="", tt="", qh="";
	var this_= $('#hdfCtl').val();
	
	if($('#txtMa').val()!="" && $('#txtMa').val()!="Nhập ID") id_=$('#txtMa').val();
	if($('#'+this_+'_sltStatus').val()!="") t=$('#'+this_+'_sltStatus').val();
	if($('#'+this_+'_sltProClass').val()!="") lbds_=$('#'+this_+'_sltProClass').val();
	if($('#'+this_+'_sltTranClass').val()!="") lgd_=$('#'+this_+'_sltTranClass').val();
	if($('#'+this_+'_sltTypeBDS').val()!="") lt_=$('#'+this_+'_sltTypeBDS').val(); 
	//if($('#'+this_+'_sltAgent')!=null && $('#'+this_+'_sltAgent').val()!="") ltk_=$('#'+this_+'_sltAgent').val();
	ltk_=$('#hdAgentID').val();
	if($('#UCFromDate').val()!="") fd_=$('#UCFromDate').val();
	if ($('#UCToDate').val() != "") td_ = $('#UCToDate').val();

	if ($('#' + this_ + '_sltTinhThanh').val() != "") tt = $('#' + this_ + '_sltTinhThanh').val();
	if ($('#sltQuanHuyen').val() != "") qh = $('#sltQuanHuyen').val();
	
	document.getElementById('txtHint').innerHTML = "Đang tải dữ liệu ....";
	var pars={
		/*AgentID:$("#hdAgentID").val(),*/
		AgentID:ltk_,
		t:t,
		pg:spage,
		rpp: $("#hdfRecordCount").val(),
		agt:$("#hdListBdsType").val(),
		//dieu kien tim kiem
		id:id_,	
		lbds:lbds_,
		lgd:lgd_,
		lt:lt_,
		ltk:ltk_,
		fd:fd_,
		td:td_,
	    tt: tt,
	    qh: qh,
	    pathClient: pathClient,
	    v: ''
	};
//	$('#dvPaging').html("");
	var url = pathClient + "services/Misc.asmx/LoadListBdsUser";
	$.post(url, pars,
		function(data) {
			var arrSotin = data.split("<-||->")[1];
			if(arrSotin.split('_')[0]!="")
				$('#spStt0').html(arrSotin.split('_')[0]);
			if(arrSotin.split('_')[1]!="")
				$('#spStt5').html(arrSotin.split('_')[1]);
			if(arrSotin.split('_')[2]!="")
			    $('#spStt6').html(arrSotin.split('_')[2]);
			if (arrSotin.split('_')[3] != "")
			    $('#spStt8').html(arrSotin.split('_')[3]);
			
			$('#txtHint').html(data.split("<-||->")[0]);
			var tps = (parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()) - parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))>0?((parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))+1):parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()));			
			if(tps<$("#hCurrentPage").val())
				$("#hCurrentPage").val(1);
			nvgPaging.DrawPageListBdsUsers(tps, $("#hCurrentPage").val(), "dvPaging","gotoPageListAsdGuest");	
		}
	);
// 	}
// 	else
// 		LoadListAsdGuest_DTTimBDS(1);
	
}
function ChangDelete(id,cat)
{
	if(!confirm("Bạn có chắc chắn muốn xóa bất động sản này không?")) return false;
	var url = pathClient+"handler/Misc.aspx?act=changdelete&id="+id;	
	$.get(url, 
		function(data) {
		    LoadListAsdGuest($("#hCurrentPage").val(), cat);
		}
	);
}
function LoadListAsdGuest_DTTimBDS(spage)
{
	document.getElementById("hdDTTimBDS").value='';
	document.getElementById("RBTimBDS").checked=true;
	document.getElementById("RBtinRV").checked=false;
	document.getElementById('dvPaging').style.display='none';
	document.getElementById('dvPagingDTTimBDS').style.display='block';
	path = document.getElementById('hdPath').value;
	document.getElementById('txtHint').innerHTML = "<div style='text-align:center'><IMG alt=''src="+ path + "/Images/loading6.gif></div>";

	var url = pathClientAjax+"handler/Misc.aspx?act=ListAsdGuestDTTimBDS&AgentID="+$("#hdAgentID").val()+"&pg="+spage;	
	$.get(url, 
			function(data) {
				$('#txtHint').html(data.split("<-||->")[0]);
				var tps = (parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()) - parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))>0?((parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val())))+1):parseInt(parseInt($("#hTotalRows").val())/parseInt($("#hdfRecordCount").val()));
				if(tps<$("#hCurrentPage").val())
					$("#hCurrentPage").val(1);
				nvgPaging.mjDrawLbPageNew(tps, $("#hCurrentPage").val(), "dvPaging","gotoPageListAsdGuest");	
			}
		);
		
	
}
function ChangeStatus(proid,status)
{
	var tpl = "<span id='calarea' style='color: red;'>[%text%]</span> | <a  style='color: red;' href='javascript:void(0)' onclick='Delete([%proid%])'>[%del%]</a>"; 
	if(status==0)
	{
		if(!confirm("Bạn có chắc dừng đăng tin này không?")) return;
		else
		{
			var url = pathClientAjax+"handler/Misc.aspx?act=unactive&proid="+proid+"&status="+status;	
			$.get(url, 
				function(data) {
					$('#changstatus'+proid).html("<span id='calarea' style='color: red;'>Stopped posting</span> | <a  style='color: red;' href='javascript:void(0)' onclick='XoaBDS("+proid+",7)'>Xóa</a>"); 
				}
			);
		}
	}
	if(status !=0)
	{
		alert("Bạn không có quyền chuyển trạng thái tin đang đăng!");
	}
}
/* doi stt =7 */
function XoaBDS(proid,status, type)
{	
	var _mes="xóa";
	if(status=="2") _mes="ngừng đăng";
	if(!confirm("Bạn có chắc "+_mes+"  tin này không?")) return;
	else
	{
		var url = pathClient+"handler/PayEventHandler.aspx?act=xoabds";
		$.post(url, {proid: proid, status:status},
			function(data) {
			    LoadListAsdGuest($("#hCurrentPage").val(), type);
			}
		);
	}	
}
function gotoPageListAsdGuest(numberpage)
{			
	pg = numberpage;
	LoadListAsdGuest(numberpage,type);
}
function ChangeRecordPerPage(totalPage_)
{
	$("#hdfRecordCount").val(totalPage_);
	LoadListAsdGuest(1,type);
}

function DosendMailInsertion(isInsertion, name, pid) {
    var url = pathClient + "services/usrhandler.asmx/DoSendMailInsertion";
    $.post(url, {isInsertion : isInsertion, name: name, pid: pid },
        function (data) {
        });
}