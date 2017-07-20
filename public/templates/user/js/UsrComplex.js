
var NvgHelpToolTipDesc=[
	{desc:'Tiền không là gì nhưng không có tiền thì chả làm được gì'},
	{desc:'Tin này sẽ được gia hạn thêm 1, Tin này sẽ được gia hạn thêm 1, Tin này sẽ được gia hạn thêm 1'	},
	{desc:'Cái đẹp đánh xẹp cái nết!'	},
	{desc:'Bốc xăm trúng thưởng'}
];
var NvgPayEvenTipDesc={
	giahantin:'Gia hạn tin',
	lammoitin:'Tin được làm mới ngày đăng và không thay đổi ngày hết hạn, tính từ ngày kích hoạt. ',
	kichhoattin:'Tin sẽ thay đổi trạng thái từ “Chưa kích hoạt” thành “Đang giao dịch” tính từ ngày kích hoạt đến ngày hết hạn mà bạn chọn.',
	hieuchinhtin:'(Không trừ tiền) Được phép thay đổi thông tin về BĐS ngoại trừ: Loại BĐS, Loại giao dịch, Tỉnh/TP, Quận/Huyện. ',
	todamtin:'Tin sẽ được tô màu, nổi bật hơn các tin khác trong kết quả tìm kiếm trong vòng 30 ngày, tính từ ngày kích hoạt. ',
	suatieude:'(-1 tin) Tiêu đề sẽ được thay đổi sau khi hiệu chỉnh. ',
	ngungdang:'Tin sẽ ngừng giao dịch',
	xoa:'Tin sẽ bị xóa khỏi danh sách',
	doilienhe:'Cho phép thay đổi phần liên hệ của tin.',
	diemdadung:'Xem số tin đã dùng của BĐS này',
	dangtinvip:'Tin được xuất hiện ở cột bên phải trên trang chủ, trang tìm kiếm cùng khu vực và trang chi tiết BĐS cùng khu vực trong vòng 7 ngày.',
	topagentvip: 'Đăng BĐS này thành VIP',
	ngungdangtopagent: 'Ngừng đăng VIP BĐS này',
	notetopagent: "Muốn đăng VIP, cần mua gói TOP AGENT",
	note1topagent: "Muốn đăng VIP, cần kích hoạt BĐS này"
};

var NvgUsrVariable={
	TimeOutShowSpeed:20000,
	TimeOutHideSpeed:7000	
};

var NvgUsrFunction = {
    GetRndTt: function () {
        var _length = NvgHelpToolTipDesc.length;
        var _rnd = Math.floor(Math.random() * _length);
        $('#divShowTipContent').html(NvgHelpToolTipDesc[_rnd].desc);
        $('#divShowTipHelp').attr("style", "bottom:0px; right:0px;position:fixed");
        setTimeout("NvgUsrFunction.GetRndTt()", NvgUsrVariable.TimeOutShowSpeed);
        setTimeout("NvgUsrFunction.CloseTips()", NvgUsrVariable.TimeOutHideSpeed);
    },
    CloseTips: function () {
        $('#divShowTipHelp').hide();
    },
    SetToggleMenu: function (val_) {
        $('#ulMenu' + val_).toggle();
        /* xai cookie ToggleMenu*/
        var cko_ = nvgUtils.getCookie("ToggleMenu");
        if (!this.CheckValueInString(val_, cko_)) {
            cko_ += val_ + ",";
        }
        else {
            cko_ = this.RemoveValueInString(val_, cko_);
        }
        nvgUtils.setCookie("ToggleMenu", cko_, 10);
    },
    CheckValueInString: function (val_, string_) {
        var arr_ = string_.split(',');
        for (var i = 0; i < arr_.length; i++) {
            if (arr_[i] != "" && arr_[i] == val_) return true;
        }
        return false;
    },
    RemoveValueInString: function (val_, string_) {
        var res_ = "";
        var arr_ = string_.split(',');
        for (var i = 0; i < arr_.length; i++) {
            if (arr_[i] != "" && arr_[i] != val_) res_ += arr_[i] + ",";
        }
        return res_;
    },
    CheckValueInArr: function (val_, arr_) {
        for (var i = 0; i < arr_.length; i++) {
            if (arr_[i] != "" && arr_[i] == val_) return true;
        }
        return false;
    },
    RemoveValueInArr: function (val_, arr_) {
        var res_ = "";
        for (var i = 0; i < arr_.length; i++) {
            if (arr_[i] != "" && arr_[i] != val_) res_ += arr_[i] + ",";
        }
        return res_;
    },
    ShowUti: function (pid, lut, tgo) {
        var act = "act=getutis";
        $('#divWating').show();
        $.post(pathClientAjax + "Users/UsrHandler.aspx?" + act + "&d=" + (new Date()).getTime(),
			{ pid: pid, lut: lut, tgo: tgo },
 				function (data) {
 				    $('#login_box').html(data);
 				    $('#login_box').show();
 				    $('#divWating').hide();
 				});
    },
    ShowTotalUti: function (lstuti) {
        var act = "act=getttutis";
        $('#divWating').show();
        $.post(pathClientAjax + "Users/UsrHandler.aspx?" + act + "&d=" + (new Date()).getTime(),
			{ lut: lstuti },
 				function (data) {
 				    $('#login_box').html(data);
 				    $('#login_box').show();
 				    $('#divWating').hide();
 				});
    },
    CloseLoginBox: function () {
        $('#login_box').hide();
    },
    TongHopDiemTK: function () {
        var gname = "";
        if (nvgUtils.getCookie('LoginType') != null && nvgUtils.getCookie('LoginType') != "office") gname = convertTounicode(nvgUtils.getCookie('GuestName'));
        else gname = $('#' + $('#hdfCtlID').val() + '_sltAgent option:selected').text();
        // var act = "act=thdtk";
        var pars = {
            pid_: $('#txtBDS').val(),
            df_: $('#txtTuNgay').val(),
            dt_: $('#txtDenNgay').val(),
            aid_: $('#' + $('#hdfCtlID').val() + '_sltAgent').val(),
            an_: gname,
            v: $('#sltNoiDangTin').val()
        };
        $('#kqRes').html("Đang tải dữ liệu ... ");
        $.post(pathClient + "services/UsrHandler.asmx/TongHopDiemTK",
			pars,
 			function (data) {
 			    if (data != "0") {
 			        if ($('#txtTuNgay').val() != "" && $('#txtDenNgay').val() != "") {
 			            $('#h3TitleChiTiet').html("Chi tiết tài khoản " + gname + " trong vòng từ " + $('#txtTuNgay').val() + " đến " + $('#txtDenNgay').val());
 			        }
 			        else {
 			            $('#h3TitleChiTiet').html("Chi tiết tài khoản " + gname + " trong vòng 10 ngày qua");
 			        }
 			        $('#kqRes').html(data);
 			    }
 			    else {
 			        $('#h3TitleChiTiet').html("Chi tiết tài khoản trong vòng 10 ngày qua");
 			        $('#kqRes').html("Chưa có dữ liệu");
 			    }
 			});
    },
    ThongKeBDSChung: function () {
        // var act = "act=tkbdsc";
        var pars = {
            st_: $('#' + $('#hdfCtl').val() + '_sltState').val(),
            sb_: $('#sltSuburb').val(),
            df_: $('#txtTuNgay').val(),
            dt_: $('#txtDenNgay').val(),
            v: $('#sltNoiDangTin').val()
        };
        $('#divTkBds').html("Đang tải dữ liệu ... ");
        $.post(pathClient + "services/UsrHandler.asmx/ThongKeBDSChung",
			pars,
 			function (data) {
 			    if (data != "0") {
 			        var s1 = data.split('<-->')[0];
 			        var s2 = data.split('<-->')[1];

 			        $('#divGhiDieuKien').html(s1);
 			        $('#divTkBds').html(s2);
 			    }
 			    else {
 			        $('#divGhiDieuKien').html("");
 			        $('#divTkBds').html("Chưa có dữ liệu");
 			    }
 			});
    },
    ThongKeDuAnCuaMem: function () {
        // var act = "act=tkdacm";
        var pars = {
            df_: $('#txtTuNgay').val(),
            dt_: $('#txtDenNgay').val()
        };
        $('#divThongKeDa').html("Đang tải dữ liệu ... ");
        $.post(pathClient + "services/UsrHandler.asmx/ThongKeDuAn",
			pars,
 			function (data) {
 			    if (data != "0")
 			        $('#divThongKeDa').html(data);
 			    else $('#divThongKeDa').html("Chưa có dữ liệu");
 			});
    },
    ThongKeLoadListBDS: function (strLoaiNha, strLoaiGD, strTong, pt, pc, tc, stt) {
        // var act = "act=tkllbds";
        var pars = {
            st_: $('#' + $('#hdfCtl').val() + '_sltState').val(),
            sb_: $('#sltSuburb').val(),
            df_: $('#txtTuNgay').val(),
            dt_: $('#txtDenNgay').val(),
            ln_: strLoaiNha,
            lgd_: strLoaiGD,
            total_: strTong,
            pt_: pt,
            pc_: pc,
            tc_: tc,
            stt_: stt,
            pathClient: pathClient,
            v: $('#sltNoiDangTin').val()
        };
        $('#divDesStaResult').html("Đang tải dữ liệu ... ");
        $.post(pathClient + "services/UsrHandler.asmx/ThongKeLoadListBDS",
			pars,   // post , de dấu values
 			function (data) {
 			    if (data != "0")
 			        $('#divDesStaResult').html(data);
 			    else $('#divDesStaResult').html("Chưa có dữ liệu");
 			});
    },
    ChangeState: function (_objSelectName, _id) {
        if (_id != "") {
            $.post(pathClient + "handler/StateGet.aspx?suburb=json&stateid=" + _id, {},
			function (data) {
			    var obj = data.lst;
			    var obj_select = document.getElementById(_objSelectName);

			    if (obj.length > 0) {
			        var tpl__ = $.template('<li><input type="checkbox" value="${eID}"> <span>${eName}</span></li>');
			        $('#' + _objSelectName).html("");
			        for (var k = 0; k < obj.length; k++) {
			            var options_length = obj_select.length;
			            var option_value = obj[k].s1;
			            var option_text = obj[k].s2;

			            $('#' + _objSelectName).append(tpl__, { eID: option_value, eName: option_text });
			        }
			    }
			}, 'json');
        }
        else $('#' + _objSelectName).html("Chưa có dữ liệu");
    },
    ChangeStateSetEstate: function (_objSelectName, _id) {
        if (_id != "") {
            $.post(pathClientAjax + "Services/StateGet.asmx/SuburbJson", { stateid: _id },
			function (data) {
			    var obj = data.lst;
			    var obj_select = document.getElementById(_objSelectName);

			    if (obj.length > 0) {
			        var tpl__ = $.template('<li><input type="checkbox" value="${eID}" onclick="ChangeSuburbGetEst(this);"> <span>${eName}</span></li>');
			        $('#' + _objSelectName).html("");
			        for (var k = 0; k < obj.length; k++) {
			            var options_length = obj_select.length;
			            var option_value = obj[k].s1;
			            var option_text = obj[k].s2;

			            $('#' + _objSelectName).append(tpl__, { eID: option_value, eName: option_text });
			        }
			    }
			}, 'json');
        }
        else $('#' + _objSelectName).html("Chưa có dữ liệu");
    },
    ChangeStateSetEstateAndSuburb: function (_objSelectName, _id, _listSrb) {
        if (_id != "") {
            $.post(pathClient + "handler/StateGet.aspx?suburb=json&stateid=" + _id, {},
			function (data) {
			    var obj = data.lst;
			    var obj_select = document.getElementById(_objSelectName);

			    if (obj.length > 0) {
			        var tpl__ = $.template('<li><input type="checkbox" value="${eID}" onclick="ChangeSuburbGetEst(this);"> <span>${eName}</span></li>');
			        $('#' + _objSelectName).html("");
			        for (var k = 0; k < obj.length; k++) {
			            var options_length = obj_select.length;
			            var option_value = obj[k].s1;
			            var option_text = obj[k].s2;

			            $('#' + _objSelectName).append(tpl__, { eID: option_value, eName: option_text });
			        }

			        if (_listSrb != "") {
			            $('#lstSuburb input:checkbox').each(function () {
			                if (nvgUtils.CheckSplitValue(this.value, _listSrb, ','))
			                    this.checked = true;

			            });
			        }
			    }
			}, 'json');
        }
        else $('#' + _objSelectName).html("Chưa có dữ liệu");
    },
    InsSrbDBHD: function () {
        var act = "act=inssrbdbhd";
        var lstSrb = "";
        var flag = false;

        var srbDef = ($('#hdfTotalSrb') != null && $('#hdfTotalSrb').val() != undefined) ? $('#hdfTotalSrb').val() : "";
        $(':checkbox').each(function () {
            if (this.checked && !NvgUsrFunction.CheckValueInString(this.value, srbDef)) {
                lstSrb += this.value + ",";
                flag = true;
            }
        });
        if (!flag) {
            alert("Bạn chưa chọn địa bàn hoạt động hoặc nơi này đã có rồi!");
            $('#ulLstSuburb input:checkbox').removeAttr('checked');

            return;
        }

        var pars = {
            srb: $('#' + $('#hdfCtlDbhd').val() + '_sltState').val() + "_" + lstSrb
        };

        $('#divDongY').html("Đang xử lý...");
        $('#hrfDongY').click = function () { ; };

        $.post(pathClient + "Users/UsrHandler.aspx?" + act + "&d=" + (new Date()).getTime(),
			pars,
 			function (data) {
 			    if (data != "0")
 			        $('#ulLstKhuVucDK').html(data);
 			    else $('#ulLstKhuVucDK').html("Chưa có dữ liệu");
 			    $('#divDongY').html("Đồng ý");
 			    $('#hrfDongY').click = function () {
 			        this.LstDBHD();
 			    };
 			    $('#ulLstSuburb input:checkbox').removeAttr('checked');
 			});
    },
    LstDBHD: function () {
        $.post(pathClientAjax + "Users/UsrHandler.aspx?act=lstdbhd&d=" + (new Date()).getTime(),
			{},
 			function (data) {
 			    if (data != "0")
 			        $('#ulLstKhuVucDK').html(data);
 			    else $('#ulLstKhuVucDK').html("Chưa có dữ liệu");
 			});
    },
    DeleteDBHD: function (id_) {
        if (confirm("Bạn có chắc xóa ko?")) {
            $.post(pathClientAjax + "Users/UsrHandler.aspx?act=dltdbhd&d=" + (new Date()).getTime(),
				{ id: id_ },
 				function (data) {
 				    if (data != "0")
 				        $('#ulLstKhuVucDK').html(data);
 				    else $('#ulLstKhuVucDK').html("Chưa có dữ liệu");
 				});
        }
    },
    NapCard: function () {
        var this_ = $('#hdfCtl').val();
        var _loaiThe = $('#' + this_ + '_sltLoaiThe');
        if (_loaiThe.val() == "") {
            alert("Vui lòng nhập loại thẻ!");
            _loaiThe.focus();
            return false;
        }
        if (_loaiThe.val() != "MGC" && $('#txtSerial').val() == "") {
            alert("Vui lòng nhập serial của thẻ!");
            $('#txtSerial').focus();
            return false;
        }

        if ($('#txtMaThe').val() == "") {
            alert("Vui lòng nhập mã thẻ!");
            $('#txtMaThe').focus();
            return false;
        }
        if ($('#txtPhoneNumber').val() == "") {
            alert("Vui lòng nhập số điện thoại!");
            $('#txtPhoneNumber').focus();
            return false;
        }
        if ($('#txtNote').val() == "Nhập nội dung...") {
            $('#txtNote').val('');
            return false;
        }

        document.getElementById('hrfSubmit').onclick = function () { return false; };
        $('#hrfSubmit').html("<div>Đang xử lí ...</div>");

        var aid = $.cookie("GAgentID") == null ? "" : $.cookie("GAgentID");
        var memId = $.cookie("OfficeID") == null ? "" : $.cookie("OfficeID");
        var userName = $.cookie("UserName") == null ? "" : $.cookie("UserName");
        var note = document.getElementById('txtNote').value;
        var phoneNumber = document.getElementById('txtPhoneNumber').value;

        $.post(pathClient + "handler/UsrHandler.aspx?act=napcard&d=" + (new Date()).getTime(),
		    { ma: $('#txtMaThe').val(), sr: $('#txtSerial').val(), ncc: _loaiThe.val(), aid: aid,
		        usrn: userName,
		        memId: memId,
		        note: note,
		        phoneNumber: phoneNumber
		    },
 		    function (data) {
 		        alert(data);
 		        NvgUsrFunction.XoaNapCard();
 		        $('#hrfSubmit').html("<div>Nạp thẻ</div>");
 		        document.getElementById('hrfSubmit').onclick = function () { NvgUsrFunction.NapCard(); };
 		    });
    },
    XoaNapCard: function () {
        $('#' + $('#hdfCtl').val() + '_sltLoaiThe').val("");
        $('#txtMaThe').val("");
        $('#txtSerial').val("");
		$('#txtPhoneNumber').val("");
		$('#txtNote').val("");
    },
    ChangeLoaiThe: function () {
        var _loaiThe = $('#' + $('#hdfCtl').val() + '_sltLoaiThe');
        if (_loaiThe.val() != "MGC") {
            $('#liSerial').show();
        }
        else {
            $('#liSerial').hide();
            $('#txtSerial').val("");
        }
    },
    TangDiemLikeFB: function (userFbId) {
        var type = "1";
        if ($('#type_2').is("checked")) type = "2";
        if ($('#type_3').is("checked")) type = "3";

        if ($('#txtName').val() == "") {
            alert("Vui lòng nhập nick FaceBook!");
            $('#txtName').focus();
            return false;
        }
        if ($('#txtMes').val() == "" || $('#txtMes').val() == "Lý do bạn thích chúng tôi") {
            //alert("Vui lòng nhập nội dung!");
            $('#txtMes').val("");
            // return false;
        }
        $.post(pathClient + "Users/UsrHandler.aspx?act=trianlike&d=" + (new Date()).getTime(),
		    { n: userFbId, mes: $('#txtMes').val(), type: type },
 		    function (data) {
 		        alert(data);
 		    });
    }
    ,
    KiemTraTrungDienThoai: function (inputPhone, type, hdfDtDd, hdfDtBan, txtDtdd, txtDtBan) {

        var idUC = $("#hdfCtlName").val() + "_";
        if (inputPhone != "") {
            var dtbanOld = $("#" + idUC + hdfDtBan).val();
            var ddold = $("#" + idUC + hdfDtDd).val();
            if (type == "ban" && inputPhone == dtbanOld)
                return true;
            else if (type == "dd" && inputPhone == ddold)
                return true;
            else {

                var act = "act=KiemTraTrungDienThoai";
                act += "&inputPhone=" + inputPhone;

                $.get(pathClient + "Users/UsrHandler.aspx", act + "&d=" + (new Date()).getTime(),
 			    function (data) {
 			        if (data != "") {
 			            if (type == "ban") {
 			                alert("Điện thoại bàn của bạn đã có người dùng");
 			                $("#" + idUC + txtDtBan).val(dtbanOld);
 			                return false;
 			            }
 			            else if (type == "dd") {
 			                alert("Điện thoại di động của bạn đã có người dùng");
 			                $("#" + idUC + txtDtdd).val(ddold);
 			                return false;
 			            }
 			        }

 			    });
            }
        }
    },
    DeleteImageGuest: function (gid) {
        if (confirm("Bạn có chắc xóa hình này không?")) {
            $.post(pathClient + "handler/UsrHandler.aspx?act=delimggst&gid="+gid,
                function (data) {
                    if (data == "ok") {
                        $('#txtPhoto').attr("src", pathClient + "images/users/logotext.jpg");
                        $('#' + $('#hdfCtl').val() + '_hrfDelImg').hide();
                        $('#' + $('#hdfCtl').val() + '_hIfl').val("");
                    }
                });
        }
    },
    CheckAllAcc: function (checkall, divChuaCbx) {
        var idUc = $("#hdfCtlName").val() + "_";
        if (checkall.checked) {
            $('#' + idUc + divChuaCbx + " input:checkbox").attr("checked", true);
        }
        else $('#' + idUc + divChuaCbx + " input:checkbox").removeAttr("checked");
    },
    KiemTraChuoiSo: function (so) {
        for (var i = 0; i < so.length; i++) {
            if ((so.charAt(i) >= '0' && so.charAt(i) <= '9')) { }
            else return false;
        }
        return true;
    },
    CheckSplitPoint: function () {
        var strError = "";
        var idUc = $("#hdfCtlName").val() + "_";

        var ids = "";
        $('#' + idUc + "cbxListAccount input:checkbox").each(function () {
            if (this.checked) ids += this.value + ",";
        });

        if (ids == "") {
            strError += "Vui lòng chọn tài khoản! <br>";
        }
        if ($('#' + idUc + "tbxPoint").val() == "") {
            strError += "Vui lòng ghi số tiền! <br>";
            $('#' + idUc + "tbxPoint").focus();
        }
        var point = parseInt($('#' + idUc + "tbxPoint").val());
        var total = parseInt($('#' + idUc + "lblTotalPoint").html().replace(/,/g,''));

        if (!NvgUsrFunction.KiemTraChuoiSo($('#' + idUc + "tbxPoint").val())) {
            strError += "Số tiền phải lả kiểu số! <br>";
            $('#' + idUc + "tbxPoint").focus();
        }
        if (point > total) {
            strError += "Số tiền phải nhỏ hơn tổng số tiền! <br>";
            $('#' + idUc + "tbxPoint").focus();
        }

        if (point * (ids.split(",").length - 1) > total) {
            strError += "Tổng số tiền của các user bạn chọn phải nhỏ hơn tổng số tiền! <br>";
            $('#' + idUc + "tbxPoint").focus();
        }

        if (strError != "") {
            $("#divError").html(strError);
            return false;
        }
        $('#btnSetPoint').attr("disabled", true);

        var GAgentID = $.cookie("GAgentID") == null ? "" : $.cookie("GAgentID");
        var OfficeID = $.cookie("OfficeID") == null ? "" : $.cookie("OfficeID");

        $.post(pathClient + "handler/UsrHandler.aspx?act=setpoint",
            { acset: ids, pnt: point,
                GAgentID: GAgentID,
                OfficeID: OfficeID
            },
            function (data) {
                if (data != "") {
                    $("#divError").html("");
                    $('#' + idUc + "lblTotalPoint").html(data.split('-')[0]);
                    $('#' + idUc + "cbxListAccount input:checkbox").removeAttr("checked");
                    $('#' + idUc + "tbxPoint").val("");
                    NvgUsrFunction.GetListAgentPoint();
                    $('#btnSetPoint').removeAttr("disabled");
                    alert("Cấp tiền thành công. Tổng số tiền cấp là " + data.split('-')[1] + " đồng");
                }
                else {
                    if (confirm('Không thể cộng tiền cho vài nhân viên, bạn có muốn cộng lại cho những nhân viên này?')) {
                        $.post(pathClient + "handler/UsrHandler.aspx?act=setpoint",
                            { acset: data, pnt: point, GAgentID: GAgentID,
                                OfficeID: OfficeID
                            },
                            function (dataa) {
                                if (dataa != "") {
                                    $("#divError").html("");
                                    $('#' + idUc + "lblTotalPoint").html(data.split('-')[0]);
                                    $('#' + idUc + "cbxListAccount input:checkbox").removeAttr("checked");
                                    $('#' + idUc + "tbxPoint").val("");
                                    NvgUsrFunction.GetListAgentPoint();
                                    $('#btnSetPoint').removeAttr("disabled");
									var alertString = "Cấp tiền thành công. Tổng số tiền cấp là " + data.split('-')[1] + " đồng";
                                    alert(alertString);
                                }
                            });
                    }
                }
            });

        return true;
    },
    GetListAgentPoint: function () {
        $('#divList').html("Đang tải dữ liệu ......");
        var mId = $.cookie('OfficeID') == null ? "" : $.cookie('OfficeID');
        $.post(pathClient + "services/UsrHandler.asmx/ListPointAgent", { mId: mId },
            function (data) {
                if (data != "") {
                    $("#divList").html(data);
                }
            });
    },
    DeleteSetPoint: function (id, point, packagelistingId) {
        var idUc = $('#hdfCtlName').val() + "_";
        var total = parseInt($('#' + idUc + "lblTotalPoint").html());
        if (confirm("Bạn có chắc lấy lại tiền của tài khoản này không?")) {
            $('#divList').html("");
            var agDefault = $.cookie("AgentDefault") == null ? "" : $.cookie("AgentDefault");
            var LoginType = $.cookie("LoginType") == null ? "" : $.cookie("LoginType");
            var OfficeID = $.cookie("OfficeID") == null ? "" : $.cookie("OfficeID");
            $.post(pathClient + "handler/UsrHandler.aspx?act=delsetpoint", { id: id, pnt: point, packid: packagelistingId,
                AgentDefault: agDefault,
                LoginType: LoginType,
                OfficeID: OfficeID
            },
            function (data) {
                if (data != "") {
                    $('#' + idUc + "lblTotalPoint").html(data);
                   // NvgUsrFunction.GetListAgentPoint();
                }
            });
        }
    },
    ReturnSetPoint: function (id, point, packagelistingId) {
        var idUc = $('#hdfCtlName').val() + "_";
        if (confirm("Bạn có chắc trả lại tiền cho tài khoản chính không?")) {
            var agDefault = $.cookie("AgentDefault") == null ? "" : $.cookie("AgentDefault");
            var LoginType = $.cookie("LoginType") == null ? "" : $.cookie("LoginType");
            var OfficeID = $.cookie("OfficeID") == null ? "" : $.cookie("OfficeID");
            $.post(pathClient + "handler/UsrHandler.aspx?act=delsetpoint", { id: id, pnt: point, packid: packagelistingId,
                AgentDefault: agDefault,
                LoginType: LoginType,
                OfficeID: OfficeID
            },
            function (data) {
                if (data == "True") {
                    $('#' + idUc + "lblPoint").html("0");
                    $('#' + idUc + "hypPoint").hide();
                }
            });
        }
    }
};

function updateClicking() {
    //var act = "act=updateClickedCounting";
    //var param = "&adsId=" + adsId + "&adsName=" + encodeURI(adsName) + "&companyName=" + encodeURI(companyName);

    $.get(pathClientAjax + "services/AdsHandler.asmx/UpdateClickedCounting",
                     function (data) {
                     });
}
function showViewProperty(proid) {
    // var act="?act=ShowFormCredit";
    //	act+="&agentid="+agentid;
    //	act+="&proid="+proid;
    //act+= "&d="+(new Date()).getTime();
    var url = pathClientAjax + "services/UsrHandler.asmx/ShowViewProperty";
    $('#divWating').show();
    var dt = "", df = "";
    if ($('#UCFromDateView').val() != undefined && $('#UCToDateView').val() != undefined) {
        df = $('#UCFromDateView').val();
        dt = $('#UCToDateView').val();
    }

    $.post(url, { pid: proid, pathClient: pathClient, df: df, dt: dt },
		function (data) {
		    $('#divWating').hide();		    
		    
		        $('#login_box').html(data);
		        $('#login_box').css("top", "100px");
		        $('#login_box').css("width", "510px");
		        $('#login_box').css("left", "25%");
		        $('#login_box').css("position", "fixed");
		        $('#login_box').removeClass("PopupBox");
		        $('#login_box').show();		    
		}
	);
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}