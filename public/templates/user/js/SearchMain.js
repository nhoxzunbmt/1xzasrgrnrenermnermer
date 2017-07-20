/************************************************************************/
/* khai bao bien                                                                     */
/************************************************************************/

//var document.getElementById('txtTranClassText').value="bán";
var strKieuBds = "";
//var document.getElementById('txtStateText').value="";
var strQuanHuyen = "";
var strQuanHuyenBanThue = "";
var strDienTich = "";
var strGia = "";
var strEstate = "";

var lstState = [];
var lstSuburb = [];
var lstGia = [];
var lstKieuBds = [];
var lstPropertyClass=[];
var lstLoaiDuAn = [];
var lstDuAn = [];
var lstPhuong = [];

var giaTuEn = "";
var giaToiEn = "";

function CheckLoadQuanHuyen() {
    if ($('#txtStateID').val() != "") {
        $('.hiddenDropBox').hide();
        $('#divListSuburb').toggle();
    }
    else {
        alert("Bạn phải chọn tỉnh/thành phố!");
        return false;
    }
}
function CheckLoadQuanHuyenBanThue() {
    if ($('#txtStateID').val() != "") {
        $('.hiddenDropBox').hide();
        $('#divListSuburbBan').toggle();
        $('#divSuburbBan input:checkbox').each(function () {
            if (nvgUtils.CheckSplitValue(this.value,$('#txtSuburb').val(), ',')) {
                this.checked = true;
            }
        });
    }
    else {
        alert("Bạn phải chọn tỉnh/thành phố!");
        return false;
    }
}
function CheckLoadEstate() {
    if ($('#txtStateID').val() != "") {
        if ($('#txtSuburb').val() != "") {
            $('.hiddenDropBox').hide();
            $('#divDropEstate').toggle();
            LoadEstateFST($('#txtStateID').val());
        }
        else {
            alert("Bạn phải chọn quận huyện!");
            return false;
        }
    }
    else {
        alert("Bạn phải chọn tỉnh/thành phố!");
        return false;
    }
}
function LoadTinhThanh() {
    var url = pathClientAjax + "handler/formsearchhandler.aspx?act=loadtt&d=" + (new Date()).getTime();
    $.post(url, {},
		function (data) {
		    //TaoList(data.lst, "divState", "txtStateID", "state");
		    TaoStateList(data.lst, "divState", "txtStateID", "state");
		}
	, 'json');
}
function LoadQuanHuyenBanThue(st, textTinhThanh_) {
    $('#divDropStateBan').hide();
    document.getElementById('txtStateText').value = textTinhThanh_;
    document.getElementById('txtSuburb').value = "";
    strQuanHuyenBanThue = "";
    ShowTextTopSelect('hrfSuburbBan', 'iptSuburbBan', strQuanHuyenBanThue);
    $('#txtStateID').val(st);
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadSuburb";
    $.post(url, { st: st },
		function (data) {
		    lstSuburb = data.lst;
		    TaoListMuti(data.lst, 'divSuburbBan', 'txtSuburb', "suburbBanThue");
		}
	, 'json');

    listEstateFolState = [];
}
function LoadQuanHuyen(st, textTinhThanh_) {
    $('#divDropState').hide();
    document.getElementById('txtStateText').value = textTinhThanh_;
    document.getElementById('txtSuburb').value = "";
    strQuanHuyen = "";
    //LoadEstateFST(st);
    $('#txtStateID').val(st);
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadSuburb";
    $.post(url, { st: st },
		function (data) {
		    lstSuburb = data.lst;
		    TaoListMuti(data.lst, 'divSuburb', 'txtSuburb', "suburb");
		}
	, 'json');

    listEstateFolState = [];
}
function LoadGia() {
    var tc = $('#txtTranClass').val();
    var pc = $('#txtProClass').val();
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadGiaFormSearch";
    $.post(url, { tc_: tc, pc_: pc },
		function (data) {
		    TaoList(data.lst, "divGia", "txtGia", "gia");
		}
	, 'json');
}
function SetGia(val_, txt_) {
    $('#txtGia').val(val_);
    $('#txtGiaTu').val("");
    $('#txtGiaDen').val("");
    $('#tg').html("");
    $('#td').html("");
    $('#divDropGia').hide();
    strGia = txt_;
}
function SetLGDVaLBDS() {
    if ($('#txtTranClass').val() == "sale") $('#rdoBan').attr("checked", "true");
    else if ($('#txtTranClass').val() == "rent") $('#rdoChoThue').attr("checked", "true");

    NvgFst.DefaultGiaTTDt();
    //LoadGia();
    LoadLoaiBDSFolTranClass2($('#txtTranClass').val());
    LoadQuanHuyen($('#txtStateID').val(), $('#txtStateText').val());

    //LoadEstateFST($('#txtStateID').val());
    //LoadDienTich();
}
function SetLGDVaLBDSIdx() {
    if ($('#txtTranClass').val() == "sale") $('#rdoBan').attr("checked", "true");
    else if ($('#txtTranClass').val() == "rent") $('#rdoChoThue').attr("checked", "true");
    else $('#rdoBan').attr('checked', 'true');
    LoadQuanHuyen($('#txtStateID').val(), $('#txtStateText').val());

    // fix bug
    // reset price = '' to fix error bind data when user click back button from browser
    $('#txtGiaTu').val("");
    $('#txtGiaDen').val("");
}
function LoadDienTich() {
    var url = pathClientAjax + "handler/formsearchhandler.aspx?act=loaddt&d=" + (new Date()).getTime();
    $.post(url, {},
		function (data) {
		    TaoList(data.lst, "divDienTich", "txtDienTich", "dientich");
		}
	, 'json');
}
function SetGia2() {
    strGia = $('#tg').html() + " - " + $('#td').html();
    
    giaTuEn = $('#tg').html().replace('Triệu', 'trieu').replace('Tỷ', 'ty').replace(" ","");
    giaToiEn = $('#td').html().replace('Triệu', 'trieu').replace('Tỷ', 'ty').replace(" ", "");
    // alert(giaTuEn)
        
    $('#divGia input:radio').removeAttr('checked');
    WriteTextCondition();
}
function LoadLoaiBDSFolTranClass(val_) {
    strKieuBds = "";
    document.getElementById('txtProClassText').value = "";
    document.getElementById('txtProClass').value = "";
    document.getElementById('txtPropertyType').value = "";
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadClasProFolTran";
    $.post(url, { tc: val_ },
		function (data) {
		    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
		        $('#divLoaiBDS').html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
		        $('#divLoaiKieuBDS input:checkbox').attr("disabled", "true");

		        listEstateFolState = [];
		        if ($('#txtSuburb').val() != "" && $('#txtStateID').val() != "") {
		            LoadEstateFST($('#txtStateID').val());
		        }
		    }
		}
	);
    LoadLoaiBDSFolTranClassUrl(val_);
}
function LoadLoaiBDSFolTranClass2(val_) {
    strKieuBds = "";
    var pc__ = document.getElementById('txtProClass').value;
    var pctxt__ = document.getElementById('txtProClassText').value;
    document.getElementById('txtProClassText').value = "";
    document.getElementById('txtProClass').value = "";
    document.getElementById('txtPropertyType').value = "";
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadClasProFolTran";
    $.post(url, { tc: val_ },
		function (data) {
		    if (data.getElementsByTagName("string")[0].childNodes[0] != undefined) {
		        $('#divLoaiBDS').html(data.getElementsByTagName("string")[0].childNodes[0].nodeValue);
		        document.getElementById('txtProClassText').value = pctxt__;
		        strKieuBds = "";
		        document.getElementById('txtProClass').value = pc__;
		        document.getElementById('txtPropertyType').value = "";
		        listEstateFolState = [];

		        WriteTextCondition();
		        //$('#rdoLoaiBds_'+pc__).attr("checked","true");
		    }
		}
	);
		LoadLoaiBDSFolTranClassUrl(val_);
}
function LoadLoaiBDSFolTranClassUrl(val_) {
    
    var url = pathClientAjax + "services/formsearchhandler.asmx/LoadClasProFolTranUrl";
    $.post(url, { tc: val_ },
		function (data) {
		    lstPropertyClass = data.lst;
		}, 'json'
	);
}
function ChonLoaiBDS(id, textLoaiBDS_, divID) {
    $('#divLoaiKieuBDS input:checkbox').removeAttr("checked");
    $('#divLoaiKieuBDS input:checkbox').attr("disabled", "true");
    $('#' + divID + ' input:checkbox').removeAttr("disabled");
    document.getElementById('txtProClassText').value = textLoaiBDS_;
    strKieuBds = "";
    document.getElementById('txtProClass').value = id;
    document.getElementById('txtPropertyType').value = "";

    $('#divLoaiBDS ul').hide();
    $('#' + divID).show();

    listEstateFolState = [];
    if ($('#txtSuburb').val() != "" && $('#txtStateID').val() != "") {
        LoadEstateFST($('#txtStateID').val());
    }

    WriteTextCondition();
}
function ChonLoaiBDSNew(id, textLoaiBDS_) {

    document.getElementById('txtProClassText').value = textLoaiBDS_;
    strKieuBds = "";
    document.getElementById('txtProClass').value = id;
    document.getElementById('txtPropertyType').value = "";
    listEstateFolState = [];
    LoadEstateFST($('#txtStateID').val());

    WriteTextCondition();
    $('#divLoaiKieuBDS').hide();
}
function ClearAllPT() {
    document.getElementById('txtPropertyType').value = "";
    $('#divLoaiKieuBDS input:checkbox').removeAttr("checked");
    $('#divLoaiKieuBDS input:radio').removeAttr("checked");
    $('#divLoaiKieuBDS input:checkbox').attr("disabled", "true");
    $('#txtProClass').val("");
    document.getElementById('txtProClassText').value = "";
    strKieuBds = "";
    WriteTextCondition();
}

function XoaQuanHuyen() {
    $('#divSuburb input:checkbox').removeAttr("checked");
    $('#txtSuburb').val("");
    strQuanHuyen = "";
    WriteTextCondition();
    $('#divListSuburb').hide();
}
function XoaQuanHuyenBanThue() {
    $('#divSuburbBan input:checkbox').removeAttr("checked");
    $('#txtSuburb').val("");
    ShowTextTopSelect('hrfSuburbBan', 'iptSuburbBan', "");
    $('#divListSuburbBan').hide();
}
function LoadLoaiBDS() {
    var url = pathClientAjax + "handler/formsearchhandler.aspx?act=loadlbds&d=" + (new Date()).getTime();
    $.post(url, {},
		function (data) {
		    TaoList(data.lst, "divLoaiBDS", "txtProClass", "loaibds");
		    $('#divLoaiBDS').show();
		}
	, 'json');
}
function LoadKieuBDS(id, textLoaiBDS_) {
    $('#divKieuBDS').show();

    document.getElementById('txtPropertyType').value = "";
    var url = pathClientAjax + "handler/formsearchhandler.aspx?act=loadkbds&d=" + (new Date()).getTime();
    $.post(url, { id: id },
		function (data) {

		    TaoListMuti(data.lst, "divKieuBDS", "txtPropertyType", "kieubds");
		    $('#divKieuBDS').show();
		}
	, 'json');
}
function SetTinhThanh() {
    $('#txtStateID').val("");
    $('#txtSuburb').val("");
    $('#iptState').hide();
    $('#hrfState').show();
    $('#divSuburb').html("");
    $('#txtStateText').val("");
}
//gan list state vao divid
function TaoStateListBanThue(lll, divid, hdf, key_) {
    // $('#' + divid).html("");
    if (lll != null && lll != "") {
        var tpl__ = "";
        var tplS__ = "";
        tpl__ = $.template("<li><a href=\"javascript:LoadQuanHuyenBanThue('${eValue}','${eName}');ShowTextTopSelect('hrfStateBan','iptStateBan','${eName}');\">${eName}</a></li>");
        tplS__ = $.template("<li><a href=\"javascript:LoadQuanHuyenBanThue('${eValue}','${eName}');ShowTextTopSelect('hrfStateBan','iptStateBan','${eName}');\"><span>${eName}</span></a></li>");
        $('#divStateNBT').append("<li class=\"header\">MIỀN BẮC</li>");
        $('#divStateMBT').append("<li class=\"header\">MIỀN TRUNG</li>");
        $('#divStateSBT').append("<li class=\"header\">MIỀN NAM</li>");
        for (var i = 0; i < lll.length; i++) {
            var eID = lll[i].s1;
            var eName = lll[i].s2;
            var eRegion = lll[i].s3;
            if (eRegion == "1") {

                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateNBT').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateNBT').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
            if (eRegion == "2") {
                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateMBT').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateMBT').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
            if (eRegion == "3") {
                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateSBT').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateSBT').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
        }
    }
}
//gan list state vao divid
function TaoStateList(lll, divid, hdf, key_) {
    // $('#' + divid).html("");
    if (lll != null && lll != "") {
        var tpl__ = "";
        var tplS__ = "";
        tpl__ = $.template("<li><a href=\"javascript:LoadQuanHuyen('${eValue}','${eName}');WriteTextCondition();\">${eName}</a></li>");
        tplS__ = $.template("<li><a href=\"javascript:LoadQuanHuyen('${eValue}','${eName}');WriteTextCondition();\"><span>${eName}</span></a></li>");
        $('#divStateN').append("<li class=\"header\">MIỀN BẮC</li>");
        $('#divStateM').append("<li class=\"header\">MIỀN TRUNG</li>");
        $('#divStateS').append("<li class=\"header\">MIỀN NAM</li>");
        for (var i = 0; i < lll.length; i++) {
            var eID = lll[i].s1;
            var eName = lll[i].s2;
            var eRegion = lll[i].s3;
            if (eRegion == "1") {

                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateN').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateN').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
            if (eRegion == "2") {
                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateM').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateM').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
            if (eRegion == "3") {
                if (nvgUtils.CheckSplitValue(eID, BigProvinces, ",")) {
                    $('#divStateS').append(tplS__, { eValue: eID, eName: eName, eHdf: hdf });
                }
                else {
                    $('#divStateS').append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
                }
            }
        }
    }
}
//gan list l vao divid
function TaoList(lll, divid, hdf, key_) {
    $('#' + divid).html("");
    if (lll != "" && lll != null) {
        var tpl__ = "";
        if (key_ == "state") {

            tpl__ = $.template("<li><a href=\"javascript:LoadQuanHuyen('${eValue}','${eName}');WriteTextCondition();\">${eName}</a></li>");
            $('#' + divid).append("<li ><a href=\"javascript:;\" onclick=\"SetTinhThanh();WriteTextCondition();\">Chọn tất cả</a></li>");
        }
        else if (key_ == "gia") {
            tpl__ = $.template("<li><a href=\"javascript:;\" onclick=\"javascript:SetGia('${eValue}','${eName}');WriteTextCondition();\"> ${eName}</a></li>");
            $('#' + divid).append("<li><a href=\"javascript:;\" onclick=\"SetGia('','');ShowTextTopSelect('hrfGia','iptGia','');\"\">Chọn tất cả</a></li>");
        }
        else if (key_ == "loaibds")
            tpl__ = $.template("<li><input type=\"radio\" name=\"rdoLoaiBDS\" value=\"${eValue}\" onclick=\"LoadKieuBDS(this.value,'${eName}');WriteTextCondition();\"> ${eName}</li>");
        else if (key_ == "dientich") {
            tpl__ = $.template("<li><a href=\"javascript:;\" onclick=\"SetDataDienTich('${eValue}','${eName}');WriteTextCondition();\"> ${eName}</a></li>");
            $('#' + divid).append("<li><a href=\"javascript:;\" onclick=\"SetDataDienTich('','');WriteTextCondition();\"\">Chọn tất cả</a></li>");
        }
        else if (key_ == "loaida") {
            tpl__ = $.template("<li><a href=\"javascript:;\" onclick=\"ShowTextTopSelectEst('hrfEstLoaiDuAn','iptEstLoaiDuAn','${eName}','txtEstLoaiDuAn','${eValue}','divDropLoaiDuAn');\">${eName}</a></li>");
            $('#' + divid).append("<li ><a href=\"javascript:;\" onclick=\"ShowTextTopSelectEst('hrfEstLoaiDuAn','iptEstLoaiDuAn','','txtEstLoaiDuAn','','divDropLoaiDuAn');\">Chọn tất cả</a></li>");
        }
        for (var i = 0; i < lll.length; i++) {
            var eID = lll[i].s1;
            var eName = lll[i].s2;

            $('#' + divid).append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
        }
    }
}
function TaoListMuti(lll, divid, hdf, key_) {
    $('#' + divid).html("");
    if (lll != "" && lll != null) {
        //<label for=\"cld_${eValue}\"> ${eName}</label>
        var tpl__ = "";
        if (key_ == "suburbBanThue")
            tpl__ = $.template("<li><a href=\"javascript:;\" ><input type=\"checkBox\" value=\"${eValue}\" title=\"${eName}\" onclick=\"SetTextSuburbBanThue();LoadEstateFST($('#txtStateID').val());WriteTextCondition();\" id=\"cld_${eValue}\" /> ${eName}</a></li>");
        if (key_ == "suburb")
            tpl__ = $.template("<li><a href=\"javascript:;\" ><input type=\"checkBox\" value=\"${eValue}\" title=\"${eName}\" onclick=\"SetTextSuburb();LoadEstateFST($('#txtStateID').val());WriteTextCondition();\" id=\"cld_${eValue}\" /> ${eName}</a></li>");
        if (key_ == "kieubds")
            tpl__ = $.template("<li><input type=\"checkBox\" value=\"${eValue}\" onclick=\"SetTextKieuBDS();WriteTextCondition();\"/> ${eName}</li>");

        for (var i = 0; i < lll.length; i++) {
            var eID = lll[i].s1;
            var eName = lll[i].s2;

            $('#' + divid).append(tpl__, { eValue: eID, eName: eName, eHdf: hdf });
        }
    }
}
function SetDataDienTich(val_, text_) {
    $('#txtDienTich').val(val_);
    strDienTich = text_;
    $('#txtGiaTu').val("");
    $('#txtGiaDen').val("");
    $('#divDropDienTich').hide();

}
function ChangeDienTich(divID, val_) {
    $('#divDienTich input:radio').removeAttr("checked");
    $('#' + divID).html(val_ + " m2");
    strDienTich = $('#dtt').html() + " - " + $('#dtd').html();
    WriteTextCondition();
}
function SetValueQH(hdf_, val_) {
    $('#' + hdf_).val(val_);
}
function getSuburb(id) {
    if (document.getElementById("chkSuburb" + id).checked == true)
        document.getElementById("txtSuburb").value += id + ",";
    else document.getElementById("txtSuburb").value = document.getElementById("txtSuburb").value.replace(id + ',', '');

}
function SetTextSuburbBanThue() {
    document.getElementById("txtSuburb").value = "";
    strQuanHuyenBanThue = "";
    // tao text quan huyen
    $('#divSuburbBan input:checkbox').each(function () {
        if (this.checked == true) {
            document.getElementById("txtSuburb").value += this.value + ",";
            strQuanHuyenBanThue += this.title + ", ";
        }
    });
    
    strQuanHuyenBanThue = strQuanHuyenBanThue.substring(0, strQuanHuyenBanThue.length - 2);
    // xoa cac gia tri cua estate
    ShowTextTopSelect("hrfSuburbBan", "iptSuburbBan", strQuanHuyenBanThue);
    //$('#txtEstate').val("");
    //strEstate = "";
}
function SetTextSuburb() {
    document.getElementById("txtSuburb").value = "";
    strQuanHuyen = "";
    // tao text quan huyen
    $('#divSuburb input:checkbox').each(function () {
        if (this.checked == true) {
            document.getElementById("txtSuburb").value += this.value + ",";
            strQuanHuyen += this.title + ", ";
        }
    });
    strQuanHuyen = strQuanHuyen.substring(0, strQuanHuyen.length - 2);
    // xoa cac gia tri cua estate
    ShowTextTopSelect("hrfEstate", "iptEstate", "");
    $('#txtEstate').val("");
    strEstate = "";
}
function getDataEstate() {
    document.getElementById("txtEstate").value = "";
    strEstate = "";
    // tao text quan huyen
    $('#divDropEstate input:checkbox').each(function () {
        if (this.checked == true) {
            document.getElementById("txtEstate").value += this.value + ",";
            strEstate += this.title + ", ";
        }
    });
    strEstate = strEstate.substring(0, strEstate.length - 2);
}
function SetTextKieuBDS(divID) {
    document.getElementById("txtPropertyType").value = "";
    strKieuBds = "";
    $('#' + divID + ' input:checkbox').each(function () {
        if (this.checked == true) {
            document.getElementById("txtPropertyType").value += this.value + ",";
            strKieuBds += this.title + ", ";
        }
    });
    strKieuBds = strKieuBds.substring(0, strKieuBds.length - 2);
    WriteTextCondition();
}
function WriteTextCondition() {
    var kqText = (strKieuBds != "" ? strKieuBds + " - " : (document.getElementById('txtProClassText').value != "" ? document.getElementById('txtProClassText').value + " - " : ""))
		 + (document.getElementById('txtTranClassText').value != "" ? document.getElementById('txtTranClassText').value + " - " : "")
		 + (document.getElementById('txtStateText').value != "" ? document.getElementById('txtStateText').value + " - " : "")
		 + (strQuanHuyen != "" ? strQuanHuyen + " - " : "")
		 + (strGia != "" ? strGia + " - " : "")
		 + (strDienTich != "" ? strDienTich + " - " : "")
		 + (strEstate != "" ? strEstate + " - " : "");

    if (strKieuBds != "" || document.getElementById('txtProClassText').value != "") {
        ShowTextTopSelect("hrfLoaiBDS", "iptLoaiBDS", strKieuBds != "" ? strKieuBds : (document.getElementById('txtProClassText').value != "" ? document.getElementById('txtProClassText').value : ""));
    }
    else {
        ShowTextTopSelect("hrfLoaiBDS", "iptLoaiBDS", "");

    }
    if (document.getElementById('txtStateText').value != "") {
        ShowTextTopSelect("hrfState", "iptState", (document.getElementById('txtStateText').value != "" ? document.getElementById('txtStateText').value : ""));
    }
    else {

        ShowTextTopSelect("hrfState", "iptState", "");

    }
    if (strQuanHuyen != "") {
        ShowTextTopSelect("hrfSuburb", "iptSuburb", (strQuanHuyen != "" ? strQuanHuyen : ""));
    }
    else {
        ShowTextTopSelect("hrfSuburb", "iptSuburb", "");
    }
    if (strGia != "") {
        ShowTextTopSelect("hrfGia", "iptGia", (strGia != "" ? strGia : ""));
    }
    else {
        ShowTextTopSelect("hrfGia", "iptGia", "");
    }
    if (strDienTich != "") ShowTextTopSelect("hrfDienTich", "iptDienTich", (strDienTich != "" ? strDienTich : ""));
    else ShowTextTopSelect("hrfDienTich", "iptDienTich", "");
    if (strEstate != "") ShowTextTopSelect("hrfEstate", "iptEstate", (strEstate != "" ? strEstate : ""));
    else ShowTextTopSelect("hrfEstate", "iptEstate", "");

    $('#divConditionTxt').html("Bạn đang tìm: " + kqText.substring(0, kqText.length - 2));
}

function ShowTextTopSelect(hrf, ipt, con) {
    if (con == "") {
        $('#' + ipt).hide();
        $('#' + hrf).show();
        $('#' + ipt).val("");
    }
    else {
        $('#' + hrf).hide();
        $('#' + ipt).show();
        $('#' + ipt).val(con);
    }
}

function GetPriceType(v, tt, proclass) {
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?act=LoadPrice&t=" + tt + "&proclass=" + proclass + "&vl=" + encodeURI(v) + "&d=" + (new Date()).getTime();
    $("#txtMinTyping").hide();
    $("#txtMaxTyping").hide();
    $("#cbMinPrice").show();
    $("#cbMaxPrice").show();
    for (var k = document.getElementById("cbMinPrice").options.length - 1; k >= 0; k--)
        document.getElementById("cbMinPrice").options[k] = null;
    for (var k = document.getElementById("cbMaxPrice").options.length - 1; k >= 0; k--)
        document.getElementById("cbMaxPrice").options[k] = null;
    document.getElementById("cbMinPrice").options[0] = new Option("Loading...", "");
    document.getElementById("cbMaxPrice").options[0] = new Option("Loading...", "");

    $.get(url,
		function (data) {
		    switch (v) {
		        case "SJC": $("#spPriceUnit").html("SJC"); $("#spPriceUnit1").html("SJC"); break;
		        case "USD": $("#spPriceUnit").html("USD"); $("#spPriceUnit1").html("USD"); break;
		        default: $("#spPriceUnit").html("VNĐ"); $("#spPriceUnit1").html("VNĐ"); break;
		    }

		    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
		    if (lcNodes.length > 0) {
		        try {
		            for (var k = document.getElementById("cbMinPrice").options.length - 1; k >= 0; k--)
		                document.getElementById("cbMinPrice").options[k] = null;
		            for (var k = document.getElementById("cbMaxPrice").options.length - 1; k >= 0; k--)
		                document.getElementById("cbMaxPrice").options[k] = null;
		            var cbMin = document.getElementById("cbMinPrice");
		            var cbMax = document.getElementById("cbMaxPrice");
		            for (var k = 0; k < lcNodes.length; k++) {
		                var option_value = lcNodes[k].childNodes[0];
		                var option_text = lcNodes[k].childNodes[1];
		                var optionsMax_length = cbMax.length;
		                var optionsMin_length = cbMin.length;
		                cbMin.options[optionsMin_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		                cbMax.options[optionsMax_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		            }
		        } catch (exp) { }
		    }
		}
	);


}
function mjChgValue(index, id) {
    $("#txtMaxTyping").val("0");
    if (document.getElementById(id.replace("Max", "Min")).options[index].value == "*" && id.indexOf("Price") > 0) {
        $("#txtMinTyping").show();
        $("#txtMaxTyping").show();

        // 		$("#spPriceUnit").html("(thousand <strike>P</strike>)");
        // 		$("#spPriceUnit1").html("(thousand <strike>P</strike>)");
        document.getElementById("divGroupButton").style.marginTop = "0px";

        $("#cbMinPrice").hide();
        $("#cbMaxPrice").hide();
        //Element.hide("trRowError");
        //$("txtMinTyping").readOnly = false;
        $("#txtMinTyping").val("");
        $("#txtMaxTyping").val("");
        document.getElementById("txtMinTyping").style.border = "1px solid green";
        document.getElementById("txtMaxTyping").style.border = "1px solid green";
    } else {
        // 		$("#spPriceUnit").html("<strike>P</strike>");
        // 		$("#spPriceUnit1").html("<strike>P</strike>");
        document.getElementById("divGroupButton").style.marginTop = "18px";
        $("#txtMinTyping").hide();
        $("#txtMaxTyping").hide();
        //Element.hide("trRowError");
        document.getElementById("txtMinTyping").style.border = "1px solid green";
        document.getElementById("txtMaxTyping").style.border = "1px solid green";
    }
    if ($("#cbMinPrice").val() != "*" && $("#cbMinPrice").val() != "NA") $("#txtMinTyping").val($("#cbMinPrice").val());
    else $("#txtMinTyping").val("0");
    var iCount = 0;
    var mLength = document.getElementById(id.replace("Max", "Min")).options.length;
    for (var k = mLength - 1; k >= 0; k--)
        document.getElementById(id).options[k] = null;
    for (var k = index; k < mLength; k++) {
        if (iCount == 0) {
            document.getElementById(id).options[iCount] = new Option(document.getElementById(id.replace("Max", "Min")).options[0].text, document.getElementById(id.replace("Max", "Min")).options[0].value);
        }
        else {
            document.getElementById(id).options[iCount] = new Option(document.getElementById(id.replace("Max", "Min")).options[k].text, document.getElementById(id.replace("Max", "Min")).options[k].value);
        }
        iCount++;
    }
    fSearchIsValid = true;
}

function FormSearchShowingTyping(value) {
    $("#txtMinTyping").val("0");
    if ($("#cbMinPrice").val() != "*" && $("#cbMinPrice").val() != "NA") $("#txtMinTyping").val($("#cbMinPrice").val());
    else $("#txtMinTyping").val("0");
    if ($("#cbMaxPrice").val() != "*" && $("#cbMaxPrice").val() != "NA") $("#txtMaxTyping").val($("#cbMaxPrice").val());
    else $("#txtMaxTyping").val("0");
    if (value == "*") {
        $("#txtMaxTyping").val("0");
        $("#txtMinTyping").show();
        $("#txtMaxTyping").show();
        // 			$("#spPriceUnit").html("(thousand <strike>P</strike>)");
        // 			$("#spPriceUnit1").html("(thousand <strike>P</strike>)");
        document.getElementById("divGroupButton").style.marginTop = "0px";
        $("#cbMinPrice").hide();
        $("#cbMaxPrice").hide();
        //$("txtMinTyping").readOnly = true;
        document.getElementById("txtMaxTyping").focus();
    } else {
        $("#txtMinTyping").hide();
        $("#txtMaxTyping").hide();
        // 			$("#spPriceUnit").html("<strike>P</strike>");
        // 			$("#spPriceUnit1").html("<strike>P</strike>");
        document.getElementById("divGroupButton").style.marginTop = "18px";
        //Element.hide("trRowError");			
    }
}
function GetPriceType1(v, tt, proclass) {

    var url = pathClientAjax + "handler/FormSearchHandler.aspx?act=LoadPrice&t=" + tt + "&proclass=" + proclass + "&vl=" + encodeURI(v) + "&d=" + (new Date()).getTime();
    Element.hide("txtMinTyping1");
    Element.hide("txtMaxTyping1");
    Element.show("cbMinPrice1");
    Element.show("cbMaxPrice1");
    for (var k = $("cbMinPrice1").options.length - 1; k >= 0; k--)
        $("cbMinPrice1").options[k] = null;
    for (var k = $("cbMaxPrice1").options.length - 1; k >= 0; k--)
        $("cbMaxPrice1").options[k] = null;
    $("cbMinPrice1").options[0] = new Option("Loading...", "");
    $("cbMaxPrice1").options[0] = new Option("Loading...", "");
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function (transport) {
            switch (v) {
                case "SJC": Element.setInnerHTML("spPriceUnit2", "SJC"); Element.setInnerHTML("spPriceUnit3", "SJC"); break;
                case "USD": Element.setInnerHTML("spPriceUnit2", "USD"); Element.setInnerHTML("spPriceUnit3", "USD"); break;
                default: Element.setInnerHTML("spPriceUnit2", "VNĐ"); Element.setInnerHTML("spPriceUnit3", "VNĐ"); break;
            }
            var lcObjXmlDoc = transport.responseXML;
            var lcNodes = lcObjXmlDoc.getElementsByTagName("*")[0].childNodes;
            if (lcNodes.length > 0) {
                try {
                    for (var k = $("cbMinPrice1").options.length - 1; k >= 0; k--)
                        $("cbMinPrice1").options[k] = null;
                    for (var k = $("cbMaxPrice1").options.length - 1; k >= 0; k--)
                        $("cbMaxPrice1").options[k] = null;
                    var cbMin = $("cbMinPrice1");
                    var cbMax = $("cbMaxPrice1");
                    for (var k = 0; k < lcNodes.length; k++) {
                        var option_value = lcNodes[k].childNodes[0];
                        var option_text = lcNodes[k].childNodes[1];
                        var optionsMax_length = cbMax.length;
                        var optionsMin_length = cbMin.length;
                        cbMin.options[optionsMin_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
                        cbMax.options[optionsMax_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
                    }
                } catch (exp) { }
            }
        },
        onFailure: function (e) {
            alert(e.responseText);
        }
    }
	);
}
function mjChgValue1(index, id) {
    if ($(id.replace("Max", "Min")).options[index].value == "*" && id.indexOf("Price") > 0) {
        Element.show("txtMinTyping1");
        Element.show("txtMaxTyping1");
        Element.hide("cbMinPrice1");
        Element.hide("cbMaxPrice1");
        //Element.hide("trRowError");
        //$("txtMinTyping").readOnly = false;
        $("txtMinTyping1").value = "";
        $("txtMaxTyping1").value = "";
        $("txtMinTyping1").style.border = "1px solid green";
        $("txtMaxTyping1").style.border = "1px solid green";
    } else {
        Element.hide("txtMinTyping1");
        Element.hide("txtMaxTyping1");
        //Element.hide("trRowError");
        $("txtMinTyping1").style.border = "1px solid green";
        $("txtMaxTyping1").style.border = "1px solid green";
    }
    if ($("cbMinPrice1").value != "*" && $("cbMinPrice1").value != "NA") $("txtMinTyping1").value = $("cbMinPrice1").value;
    else $("txtMinTyping1").value = "0";
    var iCount = 0;
    var mLength = $(id.replace("Max", "Min")).options.length;
    for (var k = mLength - 1; k >= 0; k--)
        $(id).options[k] = null;
    for (var k = index; k < mLength; k++) {
        if (iCount == 0) {
            $(id).options[iCount] = new Option($(id.replace("Max", "Min")).options[0].text, $(id.replace("Max", "Min")).options[0].value);
        }
        else {
            $(id).options[iCount] = new Option($(id.replace("Max", "Min")).options[k].text, $(id.replace("Max", "Min")).options[k].value);
        }
        iCount++;
    }
    fSearchIsValid = true;
}
function FormSearchShowingTyping1(value) {
    if ($("cbMinPrice1").value != "*" && $("cbMinPrice1").value != "NA") $("txtMinTyping1").value = $("cbMinPrice1").value;
    else $("txtMinTyping1").value = "0";
    if ($("cbMaxPrice1").value != "*" && $("cbMaxPrice1").value != "NA") $("txtMaxTyping1").value = $("cbMaxPrice1").value;
    else $("txtMaxTyping1").value = "0";
    if (value == "*") {
        $("txtMaxTyping1").value = "";
        Element.show("txtMinTyping1");
        Element.show("txtMaxTyping1");
        Element.hide("cbMinPrice1");
        Element.hide("cbMaxPrice1");
        //$("txtMinTyping").readOnly = true;
        $("txtMaxTyping1").focus();
    } else {
        Element.hide("txtMinTyping1");
        Element.hide("txtMaxTyping1");
        //Element.hide("trRowError");			
    }
}

function getSuburbAdvance(id, stateid) {
    if (document.getElementById("chkSuburb" + id).checked == true)
        document.getElementById("txtSuburb").value += id + ",";
    else document.getElementById("txtSuburb").value = document.getElementById("txtSuburb").value.replace(id + ',', '');
    if (trim(document.getElementById("txtSuburb").value, ",").indexOf(",") == -1 && document.getElementById("txtSuburb").value != "") {
        ChangeSuburb_forWard_Search(trim(document.getElementById("txtSuburb").value, ","), "sltPhuong");
        ChangeSuburb_forStreet_Search(trim(document.getElementById("txtSuburb").value, ","), "sltDuong");
    }
    else {
        removeSelectbox("sltPhuong", "");
        removeSelectbox("sltDuong", "");
    }
    LoadEstateFST(stateid);
}

var listEstateFolState = [];
function LoadEstateFST(stateid) {
    if (stateid == "") return;

    if (stateid != $('#txtStateID').val() || listEstateFolState.length == 0) {
        var url = pathClientAjax + "services/FormSearchHandler.asmx/LoadEstate";
        $.post(url, { suburb: $("#txtSuburb").val(), stateid: stateid, ttype: $('#txtTranClass').val(), ptype: $('#txtProClass').val() },
			function (data) {
			    listEstateFolState = data != "" ? data.lst : null;
			    TaoListEstateFst(listEstateFolState, 'divEstate');
			    lstDuAn = listEstateFolState;
			}, 'json'
		);
    }
    else {
        var l_ = [];
        var j = 0;
        for (var i = 0; i < listEstateFolState.length; i++) {
            var eID = listEstateFolState[i].s1;
            var eName = listEstateFolState[i].s2;
            var eSuburb = listEstateFolState[i].s3;
            var eCount = listEstateFolState[i].s4;
            if ($("#txtSuburb").val() != "") {
                if (CheckStringInListString(eSuburb, $("#txtSuburb").val())) {
                    l_[j] = listEstateFolState[i];
                    j++;
                }
            }
            else l_ = listEstateFolState;
        }
        TaoListEstateFst(l_, 'divEstate');
        lstDuAn = l_;
    }
}

function CheckStringInListString(s, sl) {
    var ar = sl.split(',');
    for (var i = 0; i < ar.length; i++) {
        if (s == ar[i]) return true;
    }
    return false;
}

//gan list l vao divid
function TaoListEstateFst(lll, divid) {
    $('#' + divid).html("");
    if (lll != "" && lll != null) {
        //  $('#' + divid).append("<li style=\"width:570px; border-bottom:1px solid #FFF2E4;margin-bottom:5px;\"><a href=\"javascript:;\" onclick=\"$('#divEstate input:checkbox').removeAttr('checked'); getDataEstate(); WriteTextCondition();\">Xóa tất cả</li>");
        var tpl__ = $.template("<li><a href=\"javascript:;\" onclick=\"getDataEstate();WriteTextCondition();\"><input type=\"checkbox\" ${checked} value=\"${eID}\" title=\"${eName}\" onclick=\"getDataEstate();WriteTextCondition();\" > ${eName} <span>(${eCount})</span></a></li>");
        for (var i = 0; i < lll.length; i++) {
            if (lll[i].s4 != "0") {
                var eID = lll[i].s1;
                var eName = lll[i].s2;
                var eSuburb = lll[i].s3;
                var eCount = lll[i].s4;
                var checked = '';
                if (CheckStringInListString(eID, $('#txtEstate').val())) {
                    checked = "checked='checked'";
                }

                $('#' + divid).append(tpl__, { inputId: i, eID: eID, eName: eName, eCount: eCount, checked: checked });
                if (i > 1 && (i + 1) % 3 == 0)
                    $('#' + divid).append("<li style=\"width:550px;\"></li>");
            }
        }
    }
}

function ChangeSuburb_forWard_Search(s, select_Phuong_xa) {
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?act=changesuburb&suburbid=" + s + "&d=" + (new Date()).getTime();
    removeSelectbox(select_Phuong_xa, "Loading...");

    $.get(url,
		function (data) {
		    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
		    if (lcNodes.length > 0) {
		        try {
		            var obj_select = document.getElementById(select_Phuong_xa); //"UcAddress1_cbo_Ward"
		            for (var i_ = obj_select.length - 1; i_ >= 0; i_--) {
		                obj_select.options[i_] = null;
		            }
		            for (var k = 0; k < lcNodes.length; k++) {
		                var options_length = obj_select.length;
		                var option_value = lcNodes[k].childNodes[0];
		                var option_text = lcNodes[k].childNodes[1];
		                if (k == 0)
		                    obj_select.options[options_length] = new Option("Chọn Phường/xã", "");
		                else
		                    obj_select.options[options_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		                document.getElementById(select_Phuong_xa).disabled = false;
		            }
		        } catch (e) {
		            //alert(e);					
		        }
		    }
		}
	);
}
function ChangeSuburb_forStreet_Search(s, sltStreet) {
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?act=Change_suburb_Street&suburbid=" + s + "&d=" + (new Date()).getTime();
    removeSelectbox(sltStreet, "Select");

    $.get(url,
		function (data) {
		    var lcNodes = data.getElementsByTagName("*")[0].childNodes;
		    if (lcNodes.length > 0) {
		        try {
		            var obj_select = document.getElementById(sltStreet); //UcAddress1_cbo_Estate
		            for (var i_ = obj_select.length - 1; i_ >= 0; i_--) {
		                obj_select.options[i_] = null;
		            }
		            for (var k = 0; k < lcNodes.length; k++) {
		                var options_length = obj_select.length;
		                var option_value = lcNodes[k].childNodes[0];
		                var option_text = lcNodes[k].childNodes[1];
		                while (option_text.childNodes[0].nodeValue.indexOf("|") != -1) {
		                    option_text.childNodes[0].nodeValue = option_text.childNodes[0].nodeValue.replace("|", "&");
		                }
		                if (k == 0)
		                    obj_select.options[options_length] = new Option("Chọn đường", "");
		                else
		                    obj_select.options[options_length] = new Option(option_text.childNodes[0].nodeValue, option_value.childNodes[0].nodeValue);
		                document.getElementById(sltStreet).disabled = false;
		            }
		        } catch (e) {
		            //alert(e);					
		        }
		    }
		}
	);
}


function getPropertyType(id) {
    if (document.getElementById("chkPropertyType" + id).checked == true)
        document.getElementById("txtPropertyType").value += id + ",";
    else document.getElementById("txtPropertyType").value = document.getElementById("txtPropertyType").value.replace(id + ',', '');
}
function getEstate(id) {
    if (document.getElementById("chkEstate" + id).checked == true)
        document.getElementById("txtEstate").value += id + ",";
    else document.getElementById("txtEstate").value = document.getElementById("txtEstate").value.replace(id + ',', '');
}

function getHuong(id) {
    if (document.getElementById("chkHuong" + id).checked == true)
        document.getElementById("txtHuong").value += id + ",";
    else document.getElementById("txtHuong").value = document.getElementById("txtHuong").value.replace(id + ',', '');
}
function ShowTTQT() {
    // 	document.getElementById('login_box_ttqt').style.width="710px";
    // 	$('#login_box_popup_header_ttqt').html("Please select provinces");	
    // 	document.getElementById('content_ttqt').style.padding="20px";
    // 	$('#login_box_ttqt').show();
    //$('.lightbox-enabled').lightbox({start:true,events:false});
    $('#lightbox-imageContainer').html($('#divSearchDefault').html());
    $('#lightbox-imageContainer,#lightbox,#lightbox-overlay').show();
    $('#lightbox-infoBox').hide();

    $('#lightbox-overlay-text-close,#lightbox-close-button,#lightbox-overlay').click(function () { $.Lightbox.finish(); });
    return false;
}
function ShowProperClass() {
    // 	document.getElementById('Proclass_box').style.width="500px";
    // 	$("#Proclass_box_popup_header").html("Chọn loại BĐS khác");
    // 	document.getElementById('content_Proclass').style.padding="20px";
    // 	$('#Proclass_box').show();
    $('#lightbox-imageContainer').html($('#Proclass_box').html());
    $('#lightbox-imageContainer,#lightbox,#lightbox-overlay').show();
    $('#lightbox-infoBox').hide();

    $('#lightbox-overlay-text-close,#lightbox-close-button,#lightbox-overlay').click(function () { $.Lightbox.finish(); });
    return false;
}
function login_box_close_ttqt(url) {
    $('#login_box_ttqt').hide();
    // 	if($("txtListStateIDQT2").value!=$("txtListStateIDQT1").value)
    // 		window.location=url;
}
function proclass_box_close() {
    $('#Proclass_box').hide();
}
function SaveCookieTTQT(stateid) {
    $('#login_box_ttqt').hide();
    var act = "act=savecookiettqt";
    var temp = "&ptype=" + $("#txtProClass").val();
    temp += "&ttype=" + $("#txtTranClass").val();
    temp += "&rg=" + $("#txtRegion").val();
    temp += "&searchtype=" + $("#txtSearchCat").val();
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?" + act + "&stateid=" + stateid + temp + "&d=" + (new Date()).getTime();
    $.get(url, {},
		function (data) {
		    if (data != "") window.location = data;
		});
}
function RemoveTtqt(stateid) {
    var act = "act=removecookiettqt";
    var temp = "&ptype=" + $("txtProClass").value;
    temp += "&ttype=" + $("txtTranClass").value;
    temp += "&rg=" + $("txtRegion").value;
    temp += "&searchtype=" + $("txtSearchCat").value;
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?" + act + "&stateid=" + stateid + temp + "&d=" + (new Date()).getTime();
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function (transport) {
            if (transport.responseText != "") {
                Element.setInnerHTML("listttqt", transport.responseText.split("<==>")[0]);
                if (stateid == $("txtStateID").value) {
                    Element.hide('login_box_ttqt');
                    window.location = transport.responseText.split("<==>")[1];
                }
            }
        },
        onFailure: function (e) {
            return false;
        }
    }
	);
}
function loadCookieTtqt(tranclass, proclass, stateid, rg) {
    var act = "act=loadttqt";
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?" + act + "&ttype=" + tranclass + "&ptype=" + proclass + "&rg=" + rg + "&d=" + (new Date()).getTime();
    $.get(url, {},
		function (transport) {
		    if (transport != "") {
		        $("#listttqt").html(transport.split("<==>")[0]);
		        $("#tabstate").html(transport.split("<==>")[2]);
		        var c = nvgUtils.getCookie('ttqtam');
		        if (c != null && c != "" && stateid != "23") {
		            document.getElementById('state' + c.split('_')[c.split('_').length - 2]).className = 'selected';
		            document.getElementById('txtStateID').value = c.split('_')[c.split('_').length - 2];
		        }
		        else {
		            document.getElementById('state' + stateid).className = 'selected';
		            document.getElementById('txtStateID').value = stateid;
		        }
		        if (tranclass == 'sale' && proclass == 'home')
		            document.getElementById('proclass1').className = 'title_searchcity selected';
		        if (tranclass == 'sale' && proclass == 'land')
		            document.getElementById('proclass2').className = 'title_searchcity selected';
		        if (tranclass == 'rent' && proclass == 'home')
		            document.getElementById('proclass3').className = 'title_searchcity selected';
		        if (tranclass == 'rent' && proclass == 'com')
		            document.getElementById('proclass4').className = 'title_searchcity selected';
		    }
		}
	);
}

function loadCookieTtqtAdvance(tranclass, proclass, stateid, rg) {
    var act = "act=loadttqtAdvance";
    var url = pathClientAjax + "handler/FormSearchHandler.aspx?" + act + "&ttype=" + tranclass + "&ptype=" + proclass + "&rg=" + rg + "&d=" + (new Date()).getTime();

    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function (transport) {
            if (transport.responseText != "") {
                Element.setInnerHTML("listttqt", transport.responseText.split("<==>")[0]);
                Element.setInnerHTML("tabstate", transport.responseText.split("<==>")[2]);
                document.getElementById('state' + stateid).className = 'selected';
                if (tranclass == 'sale' && proclass == 'home')
                    document.getElementById('proclass1').className = 'title_searchcity selected';
                if (tranclass == 'sale' && proclass == 'land')
                    document.getElementById('proclass2').className = 'title_searchcity selected';
                if (tranclass == 'rent' && proclass == 'home')
                    document.getElementById('proclass3').className = 'title_searchcity selected';
                if (tranclass == 'rent' && proclass == 'com')
                    document.getElementById('proclass4').className = 'title_searchcity selected';
            }
        },
        onFailure: function (e) {
            return false;
        }
    }
	);
}

function SetDataForSearchNrm() {
    var duan = "";
    if (document.getElementById("chkTimTrongDuAn").checked == true) {
        duan = "&cbEstate=*";
    }
    else if (document.getElementById("txtEstate").value != "")
        duan = "&cbEstate=" + trim(document.getElementById("txtEstate").value, ',');

    if (trim(document.getElementById("txtMinTyping").value, ' ') != "" && !checkFloat(trim(document.getElementById("txtMinTyping").value, ' ').replace(',', '.'))) {
        alert("Giá từ phải là kiểu số!");
        document.getElementById("txtMinTyping").focus();
        return false;
    }
    if (trim(document.getElementById("txtMaxTyping").value, ' ') != "" && !checkFloat(trim(document.getElementById("txtMaxTyping").value, ' ').replace(',', '.'))) {
        alert("Giá tới phải là kiểu số!");
        document.getElementById("txtMaxTyping").focus();
        return false;
    }

    var suburb = "";
    if (document.getElementById("txtSuburb").value != "")
        suburb = "&suburb=" + trim(document.getElementById("txtSuburb").value, ',');
    var propertyType = "";
    if (document.getElementById("txtPropertyType").value != "")
        propertyType = "&cbHomeClass=" + trim(document.getElementById("txtPropertyType").value, ',');
    // 	var huong="";
    // 	if(document.getElementById("txtHuong").value!="")
    // 		huong="&cbAspect="+trim(document.getElementById("txtHuong").value,',');

    var sOrder = "";
    var pricetype = "";
    if (document.getElementById("cbPriceType").value == "VND") {
        pricetype = "&cbPriceType=VND";
        sOrder = "&orderpricetype=1&orderby=prc";
    }
    else {
        pricetype = "&cbPriceType=" + document.getElementById("cbPriceType").value;
        if (document.getElementById("cbPriceType").value == "SJC")
            sOrder = "&orderpricetype=3&orderby=prc";
        else if (document.getElementById("cbPriceType").value == "USD")
            sOrder = "&orderpricetype=5&orderby=prc";
    }

    if (parseFloat(document.getElementById("txtMinTyping").value) != 0 &&
		parseFloat(document.getElementById("txtMinTyping").value) > parseFloat(document.getElementById("txtMaxTyping").value)) {
        alert("Giá từ phải nhỏ hơn giá tới!");
        document.getElementById("txtMinTyping").focus();
        return false;
    }

    var pricemin = "";
    if (document.getElementById("txtMinTyping").value != "")
        pricemin = "&cbMinPrice=" + document.getElementById("txtMinTyping").value;
    var pricemax = "";
    if (document.getElementById("txtMaxTyping").value != "")
        pricemax = "&cbMaxPrice=" + document.getElementById("txtMaxTyping").value;

    /*kiem tra neu ko co gia thi ko chuyen kieu tim kiem*/
    if (pricemin == "" || pricemax == "") sOrder = "";

    return (suburb + propertyType + duan + pricetype + pricemin + pricemax + sOrder);
}

function SubmitFormSearch() {
    var sDk = SetDataForSearchNrm();
    var proclass = $('txtProClass').val();
    var transclass = $('txtTranClass').val();
    var stateid = $('txtStateID').val();
    if (sDk == false) return false;

    if (proclass != 'com' && proclass != 'bus' && proclass != 'dev') {
        //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~res-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~'),10);
        window.location = pathClientAjax + "ressearch.aspx?pindex=1&tab=rv&tck=res-" + transclass + "-" + proclass + "&state=" + stateid + sDk;
    }
    else {
        //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~com-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~'),10);
        window.location = pathClientAjax + "comsearch.aspx?pindex=1&tab=rv&tck=com-" + transclass + "-" + proclass + "&state=" + stateid + sDk;
    }
}

function SetDataForSearchAdv() {
    var kwFormSearch = "";

    if (document.getElementById("txtTuKhoa").value != "" && document.getElementById("txtTuKhoa").value != "Tên quận huyện, dự án, mã BĐS") {
        if (isAllDigit(document.getElementById("txtTuKhoa").value))
            window.location = pathClient + document.getElementById("txtTuKhoa").value + ".aspx";
        else kwFormSearch = "&kw=" + nvgUtils.RemoveChar22(document.getElementById("txtTuKhoa").value);
    }

    var suburb = "";
    if (document.getElementById("txtSuburb").value != "")
        suburb = "&suburb=" + trim(document.getElementById("txtSuburb").value, ',');
    var propertyType = "";
    if (document.getElementById("txtPropertyType").value != "")
        propertyType = "&cbHomeClass=" + trim(document.getElementById("txtPropertyType").value, ',');

    // chi lam cho loai vnd
    var sOrder = "";
    var giaString = "";
    // format &cbMinPrice=500&cbMaxPrice=4000
    if (!checkFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) || !checkFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
        alert("Giá phải là kiểu số");
        $('#divDropGia').show();
        $('#txtGiaTu').focus();
        return false;
    }
    if ($('#txtGiaTu').val() != "" && $('#txtGiaDen').val() != "") {
        if (parseFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) >= parseFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
            alert("Giá từ phải nhỏ hơn giá đến");
            $('#divDropGia').show();
            $('#txtGiaTu').focus();
            return false;
        }

        sOrder = "&cbPriceType=VND&orderpricetype=1&orderby=prc";
        giaString = "&cbMinPrice=" + $('#txtGiaTu').val() + "&cbMaxPrice=" + $('#txtGiaDen').val();
    }
    else if ($('#txtGia').val() != "") {
        sOrder = "&cbPriceType=VND&orderpricetype=1&orderby=prc";
        giaString = "&cbMinPrice=" + $('#txtGia').val().split('-')[0] + "&cbMaxPrice=" + $('#txtGia').val().split('-')[1];
    }

    return (suburb + propertyType + giaString + sOrder + kwFormSearch);
}
function SubmitFormSearchAdvance() {
    var urlMota = "";
    if ($('#txtSuburb').val().split(',').length > 6) {
        alert("Bạn chọn quá nhiều quận/huyện, vui lòng chọn không quá 5");
        $('#divListSuburb').show();
        return false;
    }
    if ($('#txtEstate').val().split(',').length > 6) {
        alert("Bạn chọn quá nhiều loại BĐS, vui lòng chọn không quá 5");
        $('#divDropEstate').show();
        return false;
    }

    var suburb = "";
    //if (document.getElementById("txtSuburb").value != "") {
        suburb = "/d" + trim(document.getElementById("txtSuburb").value, ',');                    
    //}
    
    var propertyType = "";
//    if (document.getElementById("txtPropertyType").value != "")
//        propertyType = "/e" + trim(document.getElementById("txtPropertyType").value, ',');

    // chi lam cho loai vnd
    var sOrder = "";
    var giaString = "";
    // format &cbMinPrice=500&cbMaxPrice=4000
    if (!checkFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) || !checkFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
        alert("Giá phải là kiểu số");
        $('#divDropGia').show();
        $('#txtGiaTu').focus();
        return false;
    }
    if ($('#txtGiaTu').val() != "" && $('#txtGiaDen').val() != "") {
        if (parseFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) >= parseFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
            alert("Giá từ phải nhỏ hơn giá đến");
            $('#divDropGia').show();
            $('#txtGiaTu').focus();
            return false;
        }

        // sOrder = "/o-vnd/q1/r-ranking";
        sOrder = "/r-ranking";
        giaString = "/f" + $('#txtGiaTu').val() + "/g" + $('#txtGiaDen').val();
    }
    else if ($('#txtGia').val() != "") {
        sOrder = "/r-ranking";
        giaString = "/f" + $('#txtGia').val().split('-')[0] + "/g" + $('#txtGia').val().split('-')[1];
    }
    else {
        sOrder = "/r-ranking";
        giaString = "/f/g";
    }
    var strDienTich = "";
    if (!checkFloat(trim($('#txtDienTichTu').val(), ' ').replace(',', '.')) || !checkFloat(trim($('#txtDienTichDen').val(), ' ').replace(',', '.'))) {
        alert("Diện tích phải là kiểu số");
        $('#divDropDienTich').show();
        $('#txtDienTichTu').focus();
        return false;
    }
    if ($('#txtDienTichTu').val() != "" && $('#txtDienTichDen').val() != "") {
        if (parseFloat(trim($('#txtDienTichTu').val(), ' ').replace(',', '.')) >= parseFloat(trim($('#txtDienTichDen').val(), ' ').replace(',', '.'))) {
            alert("Diện tích từ phải nhỏ hơn đến");
            $('#divDropDienTich').show();
            $('#txtDienTichTu').focus();
            return false;
        }

        strDienTich = "/h" + $('#txtDienTichTu').val() + "/i" + $('#txtDienTichDen').val();
    }
    else if ($('#txtDienTich').val() != "") {
        strDienTich = "/h" + $('#txtDienTich').val().split('-')[0] + "/i" + $('#txtDienTich').val().split('-')[1];
    }
    else strDienTich = "/h/i";

    var strDuAn = "";
//    if ($('#txtEstate').val() != "")
//        strDuAn = "/k" + $('#txtEstate').val();

    var sDk = suburb + propertyType + giaString + strDienTich + strDuAn + sOrder;

    var proclass = $('#txtProClass').val();
    
    var transclass = $('#txtTranClass').val();
    var stateid = $('#txtStateID').val();
    var ss = "";
    
    if (transclass != "" && proclass != "") urlMota += transclass == "sale" ? "ban-" : "cho-thue-";
    else if (proclass == "") urlMota += transclass == "sale" ? "nha-dat-ban-" : "nha-dat-cho-thue-";
    
    if (proclass != "") {
         ss = getKhongDauFromJsonArray2(lstPropertyClass, proclass);
        if(ss!="")urlMota += ss + "-";
    }
    if (suburb != "") {        
        urlMota += getKhongDauFromJsonArray3List(lstSuburb, $("#txtSuburb").val());
    }
    if (stateid != "") {
         ss = getKhongDauFromJsonArray4(lstState, stateid);
        if(ss!="")urlMota += ss + "-";   
    }
    if ($('#txtGiaTu').val() != "" && $('#txtGiaDen').val() != "") {
         ss = getKhongDauFromJsonArray3(lstGia, $('#txtGiaTu').val() + "-" + $('#txtGiaDen').val());
         if (ss != "") urlMota += ss + "-";
         // kiem tra truong hop ng dung go vao, khong co trong du lieu co san
         else urlMota += giaTuEn + "-" + giaToiEn + "-";
    }
    else if ($('#txtGia').val() != "") {
         ss = getKhongDauFromJsonArray3(lstGia, $('#txtGia').val());
         if (ss != "") urlMota += ss + "-";        
    }    
    
    if (urlMota != "") urlMota = urlMota.substring(0, urlMota.length - 1);
    if (proclass != "") {
        if (proclass != 'com' && proclass != 'bus' && proclass != 'dev') {
            //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~res-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~')+phuong.replace('&','_').replace('=','~')+duong.replace('&','_').replace('=','~')+duan.replace('&','_').replace('=','~')+phaply.replace('&','_').replace('=','~')+dientichdat.replace('&','_').replace('=','~')+dtsd.replace('&','_').replace('=','~')+ktduong.replace('&','_').replace('=','~')+ktmattien.replace('&','_').replace('=','~')+spt.replace('&','_').replace('=','~')+spn.replace('&','_').replace('=','~')+garage.replace('&','_').replace('=','~'),10);
            window.location = pathClient + urlMota+"/a-rv/b-res-" + transclass + "-" + proclass + "/c" + stateid + sDk + "/?p=1";
        }
        else {
            //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~com-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~')+phuong.replace('&','_').replace('=','~')+duong.replace('&','_').replace('=','~')+duan.replace('&','_').replace('=','~')+phaply.replace('&','_').replace('=','~')+dientichdat.replace('&','_').replace('=','~')+dtsd.replace('&','_').replace('=','~')+ktduong.replace('&','_').replace('=','~')+ktmattien.replace('&','_').replace('=','~')+spt.replace('&','_').replace('=','~')+spn.replace('&','_').replace('=','~')+garage.replace('&','_').replace('=','~'),10);
            window.location = pathClient + urlMota + "/a-rv/b-com-" + transclass + "-" + proclass + "/c" + stateid + sDk + "/?p=1";
        }
    }
    else {
        stateid = "/c" + stateid;
        if (transclass != "") {
            window.location = pathClient + urlMota + "/a-rv/b-res-" + transclass + stateid + sDk + "/?p=1";
        }
//        else {
//            window.location = pathClient + urlMota + "/a-rv/b-" + stateid + sDk + "/?p=1";
//        }

    }
}
function SubmitFormSearchAdvanceOld() {
    if ($('#txtSuburb').val().split(',').length > 6) {
        alert("Bạn chọn quá nhiều quận/huyện, vui lòng chọn không quá 5");
        $('#divListSuburb').show();
        return false;
    }
    if ($('#txtEstate').val().split(',').length > 6) {
        alert("Bạn chọn quá nhiều loại BĐS, vui lòng chọn không quá 5");
        $('#divDropEstate').show();
        return false;
    }

    var suburb = "";
    if (document.getElementById("txtSuburb").value != "")
        suburb = "&suburb=" + trim(document.getElementById("txtSuburb").value, ',');
    var propertyType = "";
    if (document.getElementById("txtPropertyType").value != "")
        propertyType = "&cbHomeClass=" + trim(document.getElementById("txtPropertyType").value, ',');

    // chi lam cho loai vnd
    var sOrder = "";
    var giaString = "";
    // format &cbMinPrice=500&cbMaxPrice=4000
    if (!checkFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) || !checkFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
        alert("Giá phải là kiểu số");
        $('#divDropGia').show();
        $('#txtGiaTu').focus();
        return false;
    }
    if ($('#txtGiaTu').val() != "" && $('#txtGiaDen').val() != "") {
        if (parseFloat(trim($('#txtGiaTu').val(), ' ').replace(',', '.')) >= parseFloat(trim($('#txtGiaDen').val(), ' ').replace(',', '.'))) {
            alert("Giá từ phải nhỏ hơn giá đến");
            $('#divDropGia').show();
            $('#txtGiaTu').focus();
            return false;
        }

        sOrder = "&cbPriceType=VND&orderpricetype=1&orderby=ranking";
        giaString = "&cbMinPrice=" + $('#txtGiaTu').val() + "&cbMaxPrice=" + $('#txtGiaDen').val();
    }
    else if ($('#txtGia').val() != "") {
        sOrder = "&cbPriceType=VND&orderpricetype=1&orderby=ranking";
        giaString = "&cbMinPrice=" + $('#txtGia').val().split('-')[0] + "&cbMaxPrice=" + $('#txtGia').val().split('-')[1];
    }

    var strDienTich = "";
    if (!checkFloat(trim($('#txtDienTichTu').val(), ' ').replace(',', '.')) || !checkFloat(trim($('#txtDienTichDen').val(), ' ').replace(',', '.'))) {
        alert("Diện tích phải là kiểu số");
        $('#divDropDienTich').show();
        $('#txtDienTichTu').focus();
        return false;
    }
    if ($('#txtDienTichTu').val() != "" && $('#txtDienTichDen').val() != "") {
        if (parseFloat(trim($('#txtDienTichTu').val(), ' ').replace(',', '.')) >= parseFloat(trim($('#txtDienTichDen').val(), ' ').replace(',', '.'))) {
            alert("Diện tích từ phải nhỏ hơn đến");
            $('#divDropDienTich').show();
            $('#txtDienTichTu').focus();
            return false;
        }

        strDienTich = "&dtt=" + $('#txtDienTichTu').val() + "&dtd=" + $('#txtDienTichDen').val();
    }
    else if ($('#txtDienTich').val() != "") {
        strDienTich = "&dtt=" + $('#txtDienTich').val().split('-')[0] + "&dtd=" + $('#txtDienTich').val().split('-')[1];
    }

    var strDuAn = "";
    if ($('#txtEstate').val() != "")
        strDuAn = "&cbEstate=" + $('#txtEstate').val();

    var sDk = suburb + propertyType + giaString + strDienTich + strDuAn + sOrder;

    var proclass = $('#txtProClass').val();
    var transclass = $('#txtTranClass').val();
    var stateid = $('#txtStateID').val();

//    if (proclass == "") {
//        alert("Vui lòng chọn loại bất động sản!");
//        $('#divLoaiKieuBDS').show();
//        return false;
//    }
//    if (stateid == "") {
//        alert("Vui lòng chọn tỉnh thành phố!");
//        $('#divDropState').show();
//        return false;
//    }

    if (proclass != "") {
        if (proclass != 'com' && proclass != 'bus' && proclass != 'dev') {
            //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~res-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~')+phuong.replace('&','_').replace('=','~')+duong.replace('&','_').replace('=','~')+duan.replace('&','_').replace('=','~')+phaply.replace('&','_').replace('=','~')+dientichdat.replace('&','_').replace('=','~')+dtsd.replace('&','_').replace('=','~')+ktduong.replace('&','_').replace('=','~')+ktmattien.replace('&','_').replace('=','~')+spt.replace('&','_').replace('=','~')+spn.replace('&','_').replace('=','~')+garage.replace('&','_').replace('=','~'),10);
            window.location = pathClient + "ressearch.aspx?pindex=1&tab=rv&tck=res-" + transclass + "-" + proclass + "&state=" + stateid + sDk;
        }
        else {
            //nvgUtils.setCookie('SearchClicked',"SearchString=tab~rv_tck~com-"+transclass+"-"+proclass+"_state~"+stateid+suburb.replace('&','_').replace('=','~')+propertyType.replace('&','_').replace('=','~')+huong.replace('&','_').replace('=','~')+pricetype.replace('&','_').replace('=','~')+pricemin.replace('&','_').replace('=','~')+pricemax.replace('&','_').replace('=','~')+phuong.replace('&','_').replace('=','~')+duong.replace('&','_').replace('=','~')+duan.replace('&','_').replace('=','~')+phaply.replace('&','_').replace('=','~')+dientichdat.replace('&','_').replace('=','~')+dtsd.replace('&','_').replace('=','~')+ktduong.replace('&','_').replace('=','~')+ktmattien.replace('&','_').replace('=','~')+spt.replace('&','_').replace('=','~')+spn.replace('&','_').replace('=','~')+garage.replace('&','_').replace('=','~'),10);
            window.location = pathClient + "ressearch.aspx?pindex=1&tab=rv&tck=com-" + transclass + "-" + proclass + "&state=" + stateid + sDk;
        }
    }
    else {
        if (stateid != "") stateid = "&state=" + stateid;
        if (transclass != "") {
            window.location = pathClient + "ressearch.aspx?pindex=1&tab=rv&tck=res-" + transclass + stateid + sDk;
        }
        else {
            window.location = pathClient + "ressearch.aspx?pindex=1&tab=rv" + stateid + sDk;
        }
        
    }
}
/*
function trim(str, chars) {
return ltrim(rtrim(str, chars), chars);
}

function ltrim(str, chars) {
chars = chars || "\\s";
return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}

function rtrim(str, chars) {
chars = chars || "\\s";
return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
*/
function isDigit(c) {
    return ((c >= "0") && (c <= "9"))

}

function isAllDigit(s) {

    var i;

    if (isEmpty(s))

        if (isAllDigit.arguments.length == 1) return false;

        else return (isDigital.arguments[1] == true);

    for (i = 0; i < s.length; i++) {

        var c = s.charAt(i);

        if (isDigit(c) == false)

            return false;

    }

    return true;

}
function checkFloat(str) {

    var a, st;

    st = str;

    var numi = 0;

    for (var i = 0; i < st.length; i++) {

        if (st.charAt(i) < '0' || st.charAt(i) > '9') {

            if (st.charAt(i) != '.') {

                return false;

            }

            else {

                if (i == 0) return false;

                numi += 1;

            }

        } //End If

    }

    if (numi > 1) return false;

    return true;

}

function isEmpty(s) {

    return ((s == null) || (s.length == 0))

}
function removeSelectbox(objID, initText) {
    if (initText && initText.indexOf('*') != -1)
        initText = initText.replace('***', 'Select');
    var obj_select = document.getElementById(objID);
    obj_select.disabled = true;
    for (var k = obj_select.options.length - 1; k >= 0; k--) {
        obj_select.options[k] = null;
    }
    if (initText != undefined || initText != null) {
        if (initText != '') obj_select.options[0] = new Option(initText, "");
    }
}

function openAdv() {
    $('#li_normal_search').hide();
    //$('#li_normal_link').hide();
    $('#li_adv_search').show();
    $('#tbl_frm_adv').show();
}
function closeAdv() {
    $('#li_normal_search').show();
    //$('#li_normal_link').show();
    $('#li_adv_search').hide();
    $('#tbl_frm_adv').hide();
}

function checkLoadAdv() {
    if (document.location.href.indexOf('#') != -1) openAdv();
}
function toggleEstate() {
    if ($('#chkTimTrongDuAn').is(':checked')) {
        $('#FormSearch_cbDuAn :input').attr('disabled', true);
    } else {
        $('#FormSearch_cbDuAn :input').removeAttr('disabled');
    }
}
/*
*	cac ham load chung
*/

var NvgFst = {
    DefaultGiaTTDt: function () {
        var tc = $('#txtTranClass').val();
        var pc = $('#txtProClass').val();

        // ShowTextTopSelect("hrfLoaiBDS", "iptLoaiBDS", $('#txtProClassText').val())

        var url = pathClientAjax + "services/formsearchhandler.asmx/DefaultGiaTTDt";
        $.post(url, { tc_: tc, pc_: pc },
            function (data) {
                lstGia = data.gia.lst;
                lstState = data.tt.lst;
                lstLoaiDuAn = data.lest.lst;
                TaoStateListBanThue(data.tt.lst, "divStateBanThue", "txtStateID", "stateBanThue");
                TaoStateList(data.tt.lst, "divState", "txtStateID", "state");
                TaoList(data.dtich.lst, "divDienTich", "txtDienTich", "dientich");
                TaoList(data.gia.lst, "divGia", "txtGia", "gia");
                TaoList(data.lest.lst, "divLoaiDuAn", "txtEstLoaiDuAn", "loaida");
            }
	    , 'json');
    },
    ActiveTab: function (tab, classShow) {
        $('.nvgFst ul li').removeClass("current");
        $(tab).closest("li").addClass("current");
//        $(tab).parent("li").addClass("current");
        $('.nvgFst .contentSearch').hide();
        $(classShow).show();
        $('#txtStateID').val("");
        $('#txtStateText').val("");
        ShowTextTopSelect('hrfStateBan', 'iptStateBan', '');
    }
};
function autoCompleteDiaDiem(text) {
    if(text.length>1) {
        var url = pathClientAjax + "services/formsearchhandler.asmx/GetDiaDiem";
        $.post(url, { txt: text },
		function (data) {
		    if (data.length > 0) {
		        $('#contentQuickSearch').html("");
		        var itemTplState = $.template("<li><a href=\"javascript:;\" onclick=\"setQhTt(0,0,${tt},'${ttn}');\"><b>${ttn}</a></li>");
		        var itemTplAll = $.template("<li><a href=\"javascript:;\" onclick=\"setQhTt(${qh},'${qhn}',${tt},'${ttn}');\"><b>${qhn}</b>, ${ttn}</a></li>");
		        for (var i = 0; i < data.length; i++) {
		            var item = data[i];
		            if (item.s1 == 0) $('#contentQuickSearch').append(itemTplState, { tt: item.s3, ttn: item.s4 });
		            else $('#contentQuickSearch').append(itemTplAll, { qh: item.s1, qhn: item.s2, tt: item.s3, ttn: item.s4 });
		        }
		        $(".tabBan .typeInBox .Dialog_0.hidDialog").show();
		    }
		    else $(".tabBan .typeInBox .Dialog_0.hidDialog").hide();
		}
	, 'json');
}
else $('#contentQuickSearch').html("");
}

function autoCompleteDuAn(text) {
    if (text.length > 2) {
        var url = pathClientAjax + "services/formsearchhandler.asmx/GetDuAn";
        $.post(url, { txt: text },
		function (data) {
		    if (data.length > 0) {
		        $('#contentQuickSearchEst').html("");
		        var itemTpl = $.template("<li><a href=\"javascript:;\" onclick=\"$('#txtTenDuAn').val('${name}');$('.tabDuAn .typeInBox .Dialog_0.hidDialog').hide();\"><b>${name}</b>, ${quan}</a></li>");
		        for (var i = 0; i < data.length; i++) {
		            var item = data[i];
		            $('#contentQuickSearchEst').append(itemTpl, { name: item.s1, quan: item.s4 });
		        }
		        $(".tabDuAn .typeInBox .Dialog_0.hidDialog").show();
		    }
		    else $(".tabDuAn .typeInBox .Dialog_0.hidDialog").hide();
		}
	, 'json');
    }
}

function setQhTt(sbid, sbname, stid, stname) {
    $('#txtStateID').val("");
    $('#txtStateText').val("");
    $('#txtSuburb').val("");
    $("#txtText").val("Bạn tìm nhà đất bán ở đâu?");
    $("#txtTextThue").val("Bạn tìm nhà đất cho thuê ở đâu?");
    ShowTextTopSelect('hrfStateBan', 'iptStateBan', stname);
    LoadQuanHuyenBanThue(stid, stname); 
    if (sbid != 0) {
        $('#txtSuburb').val(sbid);
        if ($("#txtText").css("display") == 'block' || $("#txtText").css("display") == '' || $("#txtText").css("display") == 'inline')
            $("#txtText").val(sbname + ", " + stname);
        else $("#txtTextThue").val(sbname + ", " + stname);

        ShowTextTopSelect('hrfSuburbBan', 'iptSuburbBan', sbname);
        
    }
    else {
        if ($("#txtText").css("display") == 'block' || $("#txtText").css("display") == '' || $("#txtText").css("display") == 'inline')
            $("#txtText").val(stname);   
        else $("#txtTextThue").val(stname);
    }    
    
    $('#txtStateID').val(stid);
    $('#txtStateText').val(stname);
    $(".typeInBox .Dialog_0.hidDialog").hide();       
}

function SearchDuAnMain() {
        if ($('#txtSuburb').val().split(',').length > 6) {
            alert("Bạn chọn quá nhiều quận/huyện, vui lòng chọn không quá 5");
            $('#divListSuburb').show();
            return false;
        }
    //    alert($('#txtTenDuAn').val());
    
        window.location = pathClient + "estatelist.aspx?sstate=" + $('#txtStateID').val()
									+ "&ssuburb=" + $('#txtSuburb').val()
									+ "&catid=" + $('#txtEstLoaiDuAn').val()
									+ "&name=" + ($('#txtTenDuAn').val() == "Bạn muốn tìm dự án nào?" ? "" : $('#txtTenDuAn').val())
									+ "&pindex=1&mp=20";
    }
    function ShowTextTopSelectEst(hrf, ipt, con, hdfID, value_, divID) {
        if (con == "") {
            $('#' + ipt).hide();
            $('#' + hrf).show();
            $('#' + ipt).val("");
        }
        else {
            $('#' + hrf).hide();
            $('#' + ipt).show();
            $('#' + ipt).val(con);
        }
        $('#' + hdfID).val(value_);
        if (divID != null)
            $('#' + divID).hide();
    }