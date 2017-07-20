function Change_PropertyClass_RV(obj_id, state_value) {
    var url = pathClientAjax + "services/PropertyHandler.asmx/Change_PropertyClass";

    for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--)
        document.getElementById(obj_id).options[k] = null;

    $.post(url, { ProClassid: state_value },
		function (data) {
		    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
		    if (lcNodes.length > 0) {
		        try {
		            removeSelectbox(obj_id, "Select");
		            for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--) {
		                document.getElementById(obj_id).options[k] = null;
		            }
		            document.getElementById(obj_id).options[0] = new Option("Chọn", "");

		            for (var k = 0; k < lcNodes.length; k++) {
		                var option_value = lcNodes[k].childNodes[0];
		                var option_text = lcNodes[k].childNodes[1];
		                document.getElementById(obj_id).options[k + 1] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		            }
		            document.getElementById(obj_id).disabled = false;
		        } catch (exp) { }
		    }
		});
    Change_PropertyClass_LoaiGD($('#hdfCtlName').val() + "_select_loaigiaodich", state_value);
}

function Change_PropertyClass_LoaiGD(obj_id, s) {
    var url = pathClientAjax + "services/PropertyHandler.asmx/Change_PropertyClass_LoaiGD";
    for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--)
        document.getElementById(obj_id).options[k] = null;

    $.post(url, { ProClassid: s },
		function (data) {
		    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
		    if (lcNodes.length > 0) {
		        try {
		            removeSelectbox(obj_id, "Select");
		            for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--) {
		                document.getElementById(obj_id).options[k] = null;
		            }
		            document.getElementById(obj_id).options[0] = new Option("Chọn", "");

		            for (var k = 0; k < lcNodes.length; k++) {
		                var option_value = lcNodes[k].childNodes[0];
		                var option_text = lcNodes[k].childNodes[1];
		                document.getElementById(obj_id).options[k + 1] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		            }
		            document.getElementById(obj_id).disabled = false;
		        } catch (exp) { }
		    }
		});

}
function changeTinhThanh(_objSelectName, _id) {
    if (_id != "") {
        $.post(pathClientAjax + "services/StateGet.asmx/SuburbJson", { stateid: _id },
		function (data) {
		    var obj = data.lst;
		    var obj_select = document.getElementById(_objSelectName);
		    removeSelectbox(_objSelectName, "Chọn");
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

function ChangeSuburb_RV(obj_id, s) {
    if (s != "") {
        var url = pathClientAjax + "services/PropertyHandler.asmx/ChangeSuburb";
        for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--)
            document.getElementById(obj_id).options[k] = null;

        $.post(url, { id: s },
			function (data) {
			    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
			    if (lcNodes.length > 0) {
			        try {
			            removeSelectbox(obj_id, "Select");
			            for (var k = document.getElementById(obj_id).options.length - 1; k >= 0; k--) {
			                document.getElementById(obj_id).options[k] = null;
			            }
			            document.getElementById(obj_id).options[0] = new Option("Chọn", "");

			            for (var k = 0; k < lcNodes.length; k++) {
			                var option_value = lcNodes[k].childNodes[0];
			                var option_text = lcNodes[k].childNodes[1];
			                document.getElementById(obj_id).options[k + 1] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
			            }
			            document.getElementById(obj_id).disabled = false;
			        } catch (exp) { }
			    }
			});
     
    }
    else {
        removeSelectbox(obj_id, "Select");
        
    }
}

function Change_Estate_Suburb_RV(_objSelectName, s) {
    if (s != "") {
        var url = pathClientAjax + "services/PropertyHandler.asmx/GetEstateOnSuburb";
        for (var k = document.getElementById(_objSelectName).options.length - 1; k >= 0; k--)
            document.getElementById(_objSelectName).options[k] = null;

        $.post(url, { id: s },
			function (data) {
			    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
			    if (lcNodes.length > 0) {
			        try {
			            removeSelectbox(_objSelectName, "Select");
			            for (var k = document.getElementById(_objSelectName).options.length - 1; k >= 0; k--) {
			                document.getElementById(_objSelectName).options[k] = null;
			            }
			            document.getElementById(_objSelectName).options[0] = new Option("Chọn", "");

			            for (var k = 0; k < lcNodes.length; k++) {
			                var option_value = lcNodes[k].childNodes[0];
			                var option_text = lcNodes[k].childNodes[1];
			                document.getElementById(_objSelectName).options[k + 1] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
			            }
			            document.getElementById(_objSelectName).disabled = false;
			        } catch (exp) { }
			    }
			});
    }
    else {
        removeSelectbox(_objSelectName, "Select");
    }

}
function GetLatLng(type, id) {
    if (id != "") {
        var url = pathClientAjax + "services/MapHandler.asmx/getdefaultselect";
        $.post(url, { loai: type, id: id },
			function (data) {
			    var str = data.split('###');
			    var __lat = "";
			    var __lng = "";
			    var __lv = "";
			    __lat = str[0].split('!')[0].split(',')[0];
			    __lng = str[0].split('!')[0].split(',')[1];
			    __lv = str[0].split('!')[1];
			    if (__lat != "" && __lng != "" && __lv != "")
			        SetCenterMap(parseFloat(__lat), parseFloat(__lng), parseInt(__lv));
			}
		);
    }
}


function CheckPropertyRV() {
    if (document.getElementById($('#hdfCtlName').val() + "_txtTitle") != null) {
        if (document.getElementById($('#hdfCtlName').val() + "_txtTitle").value == "" || ((document.getElementById($('#hdfCtlName').val() + "_txtTitle").value).length > 100)
            || ((document.getElementById($('#hdfCtlName').val() + "_txtTitle").value).length < 10)
        ) {
            if (((document.getElementById($('#hdfCtlName').val() + "_txtTitle").value).length < 10))
                alert("Tiêu đề bạn quá ngắn!");
            else alert("Tiêu đề không được rỗng và không quá 100 ký tự!");
            document.getElementById($('#hdfCtlName').val() + "_txtTitle").focus();
            return false;
        }
    }
    if (document.getElementById("txtContent").value == "" || ((document.getElementById("txtContent").value).length > 2500)) {
        
            alert("Nội dung không được rỗng và không quá 2500 ký tự!");
            document.getElementById("txtContent").focus();
            return false;
    }
    if (document.getElementById($('#hdfCtlName').val() + "_select_LoaiBDS") != null) {
        if (document.getElementById($('#hdfCtlName').val() + "_select_LoaiBDS").value == "") {
            alert("Bạn phải chọn loại bất động sản!");
            document.getElementById($('#hdfCtlName').val() + "_select_LoaiBDS").focus();
            return false;
        }
    }
    if (document.getElementById($('#hdfCtlName').val() + "_select_loaigiaodich") != null) {
        if (document.getElementById($('#hdfCtlName').val() + "_select_loaigiaodich").value == "") {
            alert("Bạn phải chọn loại giao dịch!");
            document.getElementById($('#hdfCtlName').val() + "_select_loaigiaodich").focus();
            return false;
        }
    }
    if (document.getElementById($('#hdfCtlName').val() + "_txt_Dientich_Dat").value == "")
    {
        alert("Bạn phải nhập diện tích đất/DTSD!");
        document.getElementById($('#hdfCtlName').val() + "_txt_Dientich_Dat").focus();
        return false;
    }
    else if (!checkFloat(trim(document.getElementById($('#hdfCtlName').val() + "_txt_Dientich_Dat").value, ' ').replace(',', '.'))) {
        alert("Bạn phải nhập diện tích đất là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_Dientich_Dat").focus();
        return false;
    }

    if (!checkFloat(trim(document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").value, ' ').replace(',', '.'))) {
        alert("Bạn phải nhập tổng giá là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").focus();
        return false;
    }
    if (document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").value.length > 6) {
        if (!confirm("Bạn có chắc đã nhập đúng tổng giá? ")) return false;
        else return true;
    }

    if (!checkFloat(trim(document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").value, ' ').replace(',', '.'))) {
        alert("Bạn phải nhập tổng giá/m2 là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").focus();
        return false;
    }
    if ((document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").value != ''
	|| document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").value != '') && document.getElementById($('#hdfCtlName').val() + "_select_Loaitien").value == '') {
        alert("Bạn phải chọn loại tiền tệ!");
        document.getElementById($('#hdfCtlName').val() + "_select_Loaitien").focus();
        return false;
    }
    if (document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").value.length > 4) {
        if (!confirm("Bạn có chắc đã nhập đúng giá/m2? ")) return false;
        else return true;
    }

    if (!checkFloat(trim(document.getElementById($('#hdfCtlName').val() + "_txt_Duongrong").value, ' ').replace(',', '.'))) {
        alert("Bạn phải nhập kích thước đường trước nhà là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_Duongrong").focus();
        return false;
    }

    if (Trim(document.getElementById($('#hdfCtlName').val() + "_txt_Sophongngu").value).length > 0 && !isAllDigit(trim(document.getElementById($('#hdfCtlName').val() + "_txt_Sophongngu").value, ' '))) {
        alert("Phòng ngủ phải là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_Sophongngu").focus();
        return false;
    }
    if (Trim(document.getElementById($('#hdfCtlName').val() + "_txt_soWC").value).length > 0 && !isAllDigit(trim(document.getElementById($('#hdfCtlName').val() + "_txt_soWC").value, ' '))) {
        alert("Phòng tắm/WC phải là số!");
        document.getElementById($('#hdfCtlName').val() + "_txt_soWC").focus();
        return false;
    }


    //neu rong 1 trong 2 field: gia/giam2
    if (document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").value == "" && document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").value == "") {

        alert("Bạn phải nhập tổng giá hoặc giá/m2!");
        if (document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").value == "") document.getElementById($('#hdfCtlName').val() + "_txt_tonggia").focus();
        else document.getElementById($('#hdfCtlName').val() + "_txt_gia_metvuong").focus();
        return false;
    }    

    if (document.getElementById($('#hdfCtlName').val() + "_select_Tinh_Thanhpho") != null) {
        if (document.getElementById($('#hdfCtlName').val() + "_select_Tinh_Thanhpho").value == "") {
            alert("Bạn phải chọn Tỉnh/Thành phố!");
            document.getElementById($('#hdfCtlName').val() + "_select_Tinh_Thanhpho").focus();
            return false;
        }
    }
    if (document.getElementById($('#hdfCtlName').val() + "_select_Quan_huyen") != null) {
        if (document.getElementById($('#hdfCtlName').val() + "_select_Quan_huyen").value == "") {
            alert("Bạn phải chọn Quận/Huyện!");
            document.getElementById($('#hdfCtlName').val() + "_select_Quan_huyen").focus();
            return false;
        }
    }
    
    
    
    document.getElementById("dangxuly").style.display = 'block';
    document.getElementById("dangxuly").disabled = true;
    document.getElementById($('#hdfCtlName').val() + '_btnsubmit').style.display = 'none';
    
    return true;

}



function changeSelectRV(se, hd) {
    
    document.getElementById(hd).value = document.getElementById(se).value;    
}
function ChangeTypePrice(val) {
    if (document.getElementById($('#hdfCtlName').val() + '_select_Loaitien').value == "") {
        document.getElementById($('#hdfCtlName').val() + '_txt_tonggia').value = "";
        document.getElementById($('#hdfCtlName').val() + '_txt_gia_metvuong').value = "";
        document.getElementById('tg').innerHTML = "";
        document.getElementById('gm').innerHTML = "";
    }
    else {
        var temp = "";
        if (document.getElementById($('#hdfCtlName').val() + '_select_Loaitien').value == "1") temp = "Triệu"
        if (document.getElementById($('#hdfCtlName').val() + '_select_Loaitien').value == "3") temp = "SJC"
        if (document.getElementById($('#hdfCtlName').val() + '_select_Loaitien').value == "5") temp = "USD"
        document.getElementById('tg').innerHTML = document.getElementById('tg').innerHTML.replace("Triệu", temp).replace("SJC", temp).replace("USD", temp);
        document.getElementById('gm').innerHTML = document.getElementById('gm').innerHTML.replace("Triệu", temp).replace("SJC", temp).replace("USD", temp);
    }
}
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
function removeSelectboxEnable(objID, initText) {
    if (initText && initText.indexOf('*') != -1)
        initText = initText.replace('***', 'Chọn');
    var obj_select = document.getElementById(objID);
    for (var k = obj_select.options.length - 1; k >= 0; k--) {
        obj_select.options[k] = null;
    }
    if (initText != undefined || initText != null) {
        if (initText != '') obj_select.options[0] = new Option(initText, "");
    }
}


/*----------các function kich hoat tin----------*/
function KichHoatTin() {
    var eventType = $('#sltEventType').children('option:selected').val();
    if (eventType == '') {
        alert("Vui lòng chọn loại tin bạn muốn đăng.");
        $('#sltEventType').focus();
        return false;
    }
    if(eventType=='8')
    {
        SmsWarning();
        
        return false;
    }
    $('#btnKH').hide();
    $('#dangxuly').show();
    return true;
}
function ShowActiveWarning(tCheck) {
    var pars = {
        tCheck: tCheck
    };
    var url = pathClient + "services/PayEventHandler.asmx/ShowActiveWarning";
    $.post(url, pars,
			function (data) {
			    if (data != "") {
			        $('#login_box').html(data);
			        $('#login_box').width(500);
			        $('#login_box').css("top", "500px");
			        $('#login_box').css("left", "40%");
			        $('#login_box').addClass("signInNewDialog");
			        $('#login_box').show();
			       
			    }
			});
}
function SmsWarning() {
    var pars={			
			proid:$('#hd_PropertyId').val(),
			aid: $('#hd_agentMainID').val()	
		};
    var url = pathClient + "services/PayEventHandler.asmx/ShowSmsWarning";
    $.post(url, pars,
			function (data) {
			    if (data != "") {
			        $('#login_box').html(data);
			        $('#login_box').width(510);
			        $('#login_box').css("top", "200px");
			        $('#login_box').css("left", "40%");
			        $('#login_box').addClass("signInNewDialog");
			        $('#login_box').show();
			        $('#btnKichHoatNgay').attr("disabled", "disabled");
			    }
			});
}
function CloseSmsWarning(aid) {
    document.getElementById('login_box').style.display = 'none';
    $('.pDialog').hide();
    document.location.href = pathClient + "users/main.aspx?ctl=4&itm=2&aid="+aid;
    return false;
}
function LoaiTinChange() {
    var eventType = $('#sltEventType').children('option:selected').val();
    $('#btnKichHoatNgay').attr("disabled", true);
    $('#btnKichHoatNgay').val('Kích hoạt ngay');
    var str = '';
    switch (eventType) {
        case '6':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            GetAbsCost(eventType, 3);

            $('#hd_LoaiTin').val(eventType);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '7': //docquyen

            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);

            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            GetAbsCost(eventType, 2);
            $('#hd_LoaiTin').val(eventType);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '5':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
           
            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đen, nằm ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-chinh-chu.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            GetAbsCost(eventType, 1);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '3':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đỏ, nằm ưu tiên cao nhất trong kết quả tìm kiếm <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-vip.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '4':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu xanh, nằm ưu tiên trong kết quả tìm kiếm nằm trên các tin khác, sau tin VIP <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-hot.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '2':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
            
            newMaxDate.setDate(newMaxDate.getDate() + 7);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", false);
            $('#khuyenmai').show();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>600 VNĐ/Ngày</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đen, ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-thuong.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '1':
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
            newMaxDate.setDate(newMaxDate.getDate() + 60);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", true);
            $('#khuyenmai').hide();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>0</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin có vị trí thấp nhất trong kết quả tìm kiếm, nằm dưới các tin còn lại");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            $('#btnKichHoatNgay').attr("disabled", true);
            $('#btnKichHoatNgay').removeAttr('disabled');
            GetCheckFreeAllow();
            CalculateSubTotal();
            break;
        case '8': //tin sms
            var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
            var newMaxDate = new Date(sDate);
           // newMaxDate.setMonth(newMaxDate.getMonth() + 1);
            newMaxDate.setDate(newMaxDate.getDate() + 30);
            $('#txtEndDate').val(UTCDateTimeToVNDateTime(newMaxDate, '/'));
            $('#txtEndDate').attr("disabled", true);
            $('#khuyenmai').hide();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>0</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin của bạn <b>chưa được kích hoạt</b> lên online. Vui lòng dùng điện thoại kích hoạt tin sau khi đăng.");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            $('#btnKichHoatNgay').val('Kích hoạt sau');
            $('#btnKichHoatNgay').attr("disabled", true);
            $('#btnKichHoatNgay').removeAttr('disabled');
            CalculateSubTotal();
            break;
    }
    $('#resultPayment').html(str);
    $('#resultPayment').show();
}
function LoaiTinChangeGiaHan() {
    var eventType = $('#sltEventType').children('option:selected').val();
    $('#btnKichHoatNgay').attr("disabled", true);
    $('#btnKichHoatNgay').val('Gia hạn ngay');
    var str = '';
    switch (eventType) {
        case '6':
                                                
            $('#khuyenmai').show();
            //GetAbsCost(eventType, 3);

            $('#hd_LoaiTin').val(eventType);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '7': //docquyen

            
            $('#khuyenmai').show();
            //GetAbsCost(eventType, 2);
            $('#hd_LoaiTin').val(eventType);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '5':
            
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đen, nằm ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-chinh-chu.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
          //  GetAbsCost(eventType, 1);
            $('#hd_PackageTypeId').val(0);
            CalculateSubTotal();
            break;
        case '3':
            
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đỏ, nằm ưu tiên cao nhất trong kết quả tìm kiếm <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-vip.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
           // GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '4':
           
            $('#khuyenmai').show();
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu xanh, nằm ưu tiên trong kết quả tìm kiếm nằm trên các tin khác, sau tin VIP <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-hot.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
          //  GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '2':
            
            $('#khuyenmai').show();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>600 VNĐ/Ngày</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin có tiêu đề màu đen, ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreviewImg('tin-thuong.jpg')\" onmouseout=\"HidedivPreviewImg()\" src=\"" + pathClient + "/images/light.png\" />");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
          //  GetAbsCost(eventType);
            CalculateSubTotal();
            break;
        case '1':
           
            $('#khuyenmai').hide();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>0</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin có vị trí thấp nhất trong kết quả tìm kiếm, nằm dưới các tin còn lại");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            $('#btnKichHoatNgay').attr("disabled", true);
            $('#btnKichHoatNgay').removeAttr('disabled');
           // GetCheckFreeAllow();
            CalculateSubTotal();
            break;
        case '8': //tin sms
            
            $('#khuyenmai').hide();
            str = '<ul><li><i>Tiền theo giá gốc:</i><b>0</b></li><li><i>Tiền được giảm giá theo khuyến mãi tương ứng:</i><b>0</b></li><li><i>Tiền thực trả:</i><b>0</b></li></ul>';
            $('#vip_cofig_info_explain').html("Tin của bạn <b>chưa được kích hoạt</b> lên online. Vui lòng dùng điện thoại kích hoạt tin sau khi đăng.");
            $('#vip_cofig_info_explain').show();
            $('#hd_LoaiTin').val(eventType);
            $('#btnKichHoatNgay').val('Kích hoạt sau');
            $('#btnKichHoatNgay').attr("disabled", true);
            $('#btnKichHoatNgay').removeAttr('disabled');
            CalculateSubTotal();
            break;
    }
    $('#resultPayment').html(str);
    $('#resultPayment').show();
}

function GetAbsCost(ltin, t) {
    $('#resultPayment').html("");
    var url = pathClient + "services/PayEventHandler.asmx/ShowPayEventType";
    var pars = { loaiTin: ltin,
        endDate: $('#txtEndDate').val(),
        tCheck: t,
        aid: $('#hd_agentMainID').val()
    };
    $.post(url, pars,
                function (data) {
                    if (t == 1) {
                        if (data == "40") {
                            //alert("Tin chính chủ đủ tin. Bạn không thể đăng tin chính chủ vào thời điểm này vui lòng liên hệ chúng tôi qua hotline để biết thêm chi tiết.");
                            ShowActiveWarning(1);
                            $('#btnKichHoatNgay').attr("disabled", true);
                            return;
                        }
                        else {
                            $('#khuyenmai').hide();
                            $('#resultPayment').html(data);
                            $('#resultPayment').show();
                            $('#btnKichHoatNgay').attr("disabled", true);
                            $('#btnKichHoatNgay').removeAttr('disabled');
                        }
                    }
                    else if (t == 2) {
                        if (data == "0") {
                            //alert("Các ô đã đủ tin. Bạn không thể đăng tin nỗi bật đọc quyền vào thời điểm này vui lòng liên hệ chúng tôi qua hotline để biết thêm chi tiết.");
                            ShowActiveWarning(2);
                            $('#vip_cofig_info_explain').html("Các ô đã đủ tin. Bạn không thể đăng tin nỗi bật đọc quyền vào thời điểm này vui lòng liên hệ chúng tôi qua hotline để biết thêm chi tiết.");
                            $('#vip_cofig_info_explain').show();
                            $('#khuyenmai').hide();
                            $('#btnKichHoatNgay').attr("disabled", true);
                            return;
                        }
                        else {
                            $('#vip_cofig_info_explain').html("Tin của bạn ở ô thứ " + data.split("<-||->")[0] + " trong mục 'BĐS nỗi bật' trang chủ, nằm ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreview('" + data.split("<-||->")[0] + "')\" onmouseout=\"HidedivPreview('" + data.split("<-||->")[0] + "')\" src=\"" + pathClient + "/images/light.png\" />");
                            $('#vip_cofig_info_explain').show();
                            $('#hd_boxNumber').val(data.split("<-||->")[0]);
                            $('#resultPayment').html(data.split("<-||->")[1]);
                            $('#resultPayment').show();
                            $('#khuyenmai').hide();
                            $('#btnKichHoatNgay').attr("disabled", true);
                            $('#btnKichHoatNgay').removeAttr('disabled');
                        }

                    }
                    else if (t == 3) {
                        if (data == "0") {
                            //alert("Các ô đã đủ tin. Bạn không thể đăng tin nỗi bật chia sẽ vào thời điểm này vui lòng liên hệ chúng tôi qua hotline để biết thêm chi tiết.");
                            ShowActiveWarning(3);
                            $('#vip_cofig_info_explain').html("Các ô đã đủ tin. Bạn không thể đăng tin nỗi bật chia sẽ vào thời điểm này vui lòng liên hệ chúng tôi qua hotline để biết thêm chi tiết.");
                            $('#vip_cofig_info_explain').show();
                            $('#khuyenmai').hide();
                            $('#btnKichHoatNgay').attr("disabled", true);
                            return;
                        }
                        else {
                            $('#vip_cofig_info_explain').html("Tin của bạn ở ô thứ " + data.split("<-||->")[0] + " trong mục 'BĐS nỗi bật' trang chủ, nằm ưu tiên trong kết quả tìm kiếm, nằm dưới tin VIP, tin HOT <img width=\"24\" height=\"24\" alt=\"\" onmouseover=\"ShowdivPreview('" + data.split("<-||->")[0] + "')\" onmouseout=\"HidedivPreview('" + data.split("<-||->")[0] + "')\" src=\"" + pathClient + "/images/light.png\" />");
                            $('#vip_cofig_info_explain').show();
                            $('#hd_boxNumber').val(data.split("<-||->")[0]);
                            $('#resultPayment').html(data.split("<-||->")[1]);
                            $('#resultPayment').show();
                            $('#khuyenmai').hide();
                            $('#btnKichHoatNgay').attr("disabled", true);
                            $('#btnKichHoatNgay').removeAttr('disabled');
                        }
                    } else {
                        if (ltin == "4" || ltin == "3" || ltin == "2") {

                            $('#rdPromotion').html(data.split("<-||->")[0]);
                            $('#khuyenmai').show();
                            $('#resultPayment').html(data.split("<-||->")[1]);
                            $('#resultPayment').show();
                            $('#hd_PackageTypeId').val(data.split("<-||->")[2]);
                        } else {
                            $('#khuyenmai').hide();

                            $('#resultPayment').html(data);
                            $('#resultPayment').show();

                        }
                        $('#btnKichHoatNgay').attr("disabled", true);
                        $('#btnKichHoatNgay').removeAttr('disabled');
                    }
                });
}
function ChangePaymentResult() {
    $('#hd_PackageTypeId').val();
    $('#resultPayment').html("");
    var url = pathClient + "services/PayEventHandler.asmx/ChangeResultPayment";
    var pars = { loaiTin: $('#sltEventType').children('option:selected').val(),
        endDate: $('#txtEndDate').val(),
        pType: $('#hd_PackageTypeId').val(),
        aid: $('#hd_agentMainID').val()
    };
    $.post(url, pars,
                function (data) {
                    $('#resultPayment').html(data);
                    $('#resultPayment').show();
                });
            }
  
 function ChangePromotionResult() {
     $('#btnKichHoatNgay').attr("disabled", true);
     $('#resultPayment').html("");
    var url = pathClient + "services/PayEventHandler.asmx/ChangePromotionResult";
    var pars = { loaiTin: $('#sltEventType').children('option:selected').val(),
        endDate: $('#txtEndDate').val(),        
        aid: $('#hd_agentMainID').val(),
        startDate: $('#txtStartDate').val()
    };
    $.post(url, pars,
                function (data) {
                    $('#rdPromotion').html(data.split("<-||->")[0]);
                    $('#khuyenmai').show();
                    $('#resultPayment').html(data.split("<-||->")[1]);
                    $('#resultPayment').show();
                    $('#btnKichHoatNgay').attr("disabled", false);
                    $('#btnKichHoatNgay').removeAttr('disabled');
                    $('#hd_PackageTypeId').val($('#rdPromotion li input:radio[name=rdio]:checked').val());
                });
}
function ChangePromotion(tvalue) {
    $('#resultPayment').html("");
    $('#hd_PackageTypeId').val(tvalue);
    var url = pathClient + "services/PayEventHandler.asmx/ChangeResultPayment";
    var pars = { loaiTin: $('#sltEventType').children('option:selected').val(),
        endDate: $('#txtEndDate').val(),
        pType: tvalue,
        aid: $('#hd_agentMainID').val()
    };
    $.post(url, pars,
                function (data) {
                    $('#resultPayment').html(data);
                    $('#resultPayment').show();
                });
}
function GetCheckFreeAllow() {
    var url = pathClient + "services/PayEventHandler.asmx/GetCheckFreeAllow";
    var pars = { stid: $('#hd_StateID').val(),
                aid: $('#hd_agentID').val()
            };
            $.post(url, pars,
                function (data) {
                    if (data == "no") {
                        alert("Bạn đã hết được phép đăng tin miễn phí. Vui lòng nạp thêm tiền để kích hoạt tin.");
                        $('#btnKichHoatNgay').attr("disabled", true);
                    }
                });
}
function resetDate(date) {
    if ($('#txtEndDate').val().length == 0) {
        var tmpdate = new Date();
        tmpdate.setMonth(tmpdate.getMonth() + 1);
        $('#txtEndDate').val(UTCDateTimeToVNDateTime(tmpdate, '/'));
    }

    var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
    var eDate = new Date(VNDateTimeToUTCDateTime($('#txtEndDate').val(), '/'));

    var newMaxDate = new Date(sDate);
    var newMinDate = new Date(sDate);

    newMaxDate.setMonth(newMaxDate.getMonth() + 6);
    var newMaxStartDate = new Date(eDate);

    newMinDate.setDate(newMinDate.getDate() + date);
    newMaxStartDate.setDate(newMaxStartDate.getDate() - 7);

    if (newMaxStartDate < new Date()) {
        newMaxStartDate = new Date();
        eDate = newMinDate;
        $('#txtEndDate').val(UTCDateTimeToVNDateTime(eDate, '/'));
    }

    $("#txtEndDate").datepicker("option", "maxDate", newMaxDate);
    $("#txtEndDate").datepicker("option", "minDate", newMinDate);
}
function ResetEndDate() {
    if ($('#txtEndDate').val().length == 0) {
        var tmpdate = new Date();
        tmpdate.setMonth(tmpdate.getMonth() + 1);
        $('#txtEndDate').val(UTCDateTimeToVNDateTime(tmpdate, '/'));
    }

    var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/'));
    var eDate = new Date(VNDateTimeToUTCDateTime($('#txtEndDate').val(), '/')); 

    var newMaxDate = new Date(sDate);
    var newMinDate = new Date(sDate);

    newMaxDate.setMonth(newMaxDate.getMonth() + 6);
    var newMaxStartDate = new Date(eDate);

    newMinDate.setDate(newMinDate.getDate() + 7);
    newMaxStartDate.setDate(newMaxStartDate.getDate() - 7);

    if (newMaxStartDate < new Date()) {
        newMaxStartDate = new Date();
        eDate = newMinDate;
        $('#txtEndDate').val(UTCDateTimeToVNDateTime(eDate, '/'));
    }
    
    $("#txtEndDate").datepicker("option", "maxDate", newMaxDate);
    $("#txtEndDate").datepicker("option", "minDate", newMinDate);
}
function CalculateSubTotal() {
    var d = new Date();
    var hrs = d.getHours(); // => 9
    var min = d.getMinutes(); // =>  30
    var sec = d.getSeconds(); // => 51
    var t = hrs + ":" + min + ":" + sec;
    var sDate = new Date(VNDateTimeToUTCDateTime($('#txtStartDate').val(), '/') + " " + t);
    var eDate = new Date(VNDateTimeToUTCDateTime($('#txtEndDate').val() , '/') + " " + t);
    var newStartDate = new Date(sDate);
    var newEndDate = new Date(eDate);
    
    var tDate = 7;
    var ONE_DAY = 1000 * 60 * 60 * 24;
    // Convert both dates to milliseconds
    var date1_ms = newStartDate.getTime();
    var date2_ms = newEndDate.getTime();
    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);

    // Convert back to days and return
    var mtotalDays = Math.round(difference_ms / ONE_DAY);
    
    $('#mtotalDays').html(mtotalDays +" ngày");
    
}
function ShowdivPreview(ovb) {
    $('#ovb_' + ovb).addClass("active");
    $('#divPreview').show();
}
function HidedivPreview(ovb) {
    $('#ovb_' + ovb).removeClass("active");
    $('#divPreview').hide();
}
function ShowdivPreviewImg(ovb) {
    $('#divPreviewImg').html("<img width=\"450\" height=\"180\" alt=\"\" src=\"" + pathClient + "/images/" + ovb + "\" />");
    $('#divPreviewImg').show();
}
function HidedivPreviewImg() {
    $('#divPreviewImg').hide();
}

function autoCompleteStreet(text) {
    var sb = document.getElementById($('#hdfCtlName').val() + "_hd_Quan_huyen").value;
    if (text.length > 2 && sb !="") {
        var url = pathClientAjax + "services/PropertyHandler.asmx/GetStreetName";
        $.post(url, { txt: text, sb: sb },
        function (data) {
            if (data.length > 0) {
                $('#contentStreetQuickSearch').html("");
                var itemTpl = $.template("<li><a href=\"javascript:;\" onclick=\"$('#txtTenDuong').val('${name}');$('#divDropStreetName').hide();\"><b>${name}</b></a></li>");
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    $('#contentStreetQuickSearch').append(itemTpl, { name: item.s1 });
                }
                $("#divDropStreetName").show(); 
            }
            else {
                $("#divDropStreetName").hide();
            }
        }, 'json');
    }
}

