<input name="txtLoaiTin" id="txtLoaiTin" value="1" type="hidden" />
<input name="txtTT" id="txtTT" type="hidden" value='0' />
<input name="txtQuan" id="txtQuan" type="hidden" value='0' />
<input name="txtKV" id="txtKV" type="hidden" value='0' />
<div class="dv-boxsearch-r">
	<ul class="tabs1">
		<li id="sale" class="active">Bán</li>
		<li style="margin-left: 0px;" class="" id="buy">Mua</li>
		<li id="lease" class="">Cho Thuê</li>
		<li id="brokerage" class="">Cần thuê</li>
	</ul>
	<span class="clear"></span>
	<div class="content buy">
		<div class="in-tab">
			<p>
				<input name="ctl00$ContentPlaceHolder3$boxSearch1$txtTuKhoa" type="text" id="ContentPlaceHolder3_boxSearch1_txtTuKhoa" class="inputNewTimKiem" autocomplete="off" placeholder="Nhập địa điếm, vd: Mỹ đình, Topaz Garden" />
			</p>
			<div id="listTimKiem"
				style="position: absolute; display: none; margin-top: 38px;"></div>
			<div id="divHuongDan"
				style="position: absolute; display: none; margin-top: 38px;">
				<div class='tbLinksearch'>
					<div style="color: Red;">
						Hãy nhập địa điểm hoặc tên dự án mà bạn muốn tìm kiếm. <br /> <strong>Ví
							dụ:</strong> bạn muốn tìm dự án Royal City hãy gõ: royal city sau
						đó ân Enter
					</div>
				</div>
			</div>
			<p>
				<select name="ctl00$ContentPlaceHolder3$boxSearch1$cboLN"
					id="ContentPlaceHolder3_boxSearch1_cboLN" class="SelectGiaTien">
					<option value="9">Tất cả</option>
					<option value="2">Biệt thự, Đất biệt thự</option>
					<option value="1">Căn hộ chung cư</option>
					<option value="6">Nh&#224; Liền kề, Đất dự &#225;n</option>
					<option value="19">Đất dịch vụ, đền b&#249;</option>
					<option value="8">Đất thổ cư</option>
					<option value="16">Đất trang trại</option>
					<option value="17">Mặt bằng, Nh&#224; Xưởng</option>
					<option value="3">Nh&#224; cấp 4, Tập thể</option>
					<option value="10">Nh&#224; mặt phố</option>
					<option value="18">Nh&#224; trong ng&#245; dưới 3m</option>
					<option value="5">Nh&#224; trong ng&#245; tr&#234;n 3m</option>
					<option value="12">Ph&#242;ng trọ, nh&#224; trọ</option>
					<option value="13">Cửa h&#224;ng, Văn ph&#242;ng</option>
					<option value="20">Kh&#225;ch sạn, Nh&#224; h&#224;ng</option>
				</select>
			</p>
			<p>
				<select name="ctl00$ContentPlaceHolder3$boxSearch1$ddlCustomers"
					id="ContentPlaceHolder3_boxSearch1_ddlCustomers">
				</select>
			</p>
			<p>
				<select name="ctl00$ContentPlaceHolder3$boxSearch1$ddlOrders" id="ContentPlaceHolder3_boxSearch1_ddlOrders"></select>
			</p>
			<p>
				<select name="ctl00$ContentPlaceHolder3$boxSearch1$ddlProducts"
					id="ContentPlaceHolder3_boxSearch1_ddlProducts">
				</select>
			</p>
			<div>
				<input name="ctl00$ContentPlaceHolder3$boxSearch1$txtFromGiaTien"
					type="text" id="ContentPlaceHolder3_boxSearch1_txtFromGiaTien"
					class="inputGiaTien" placeholder="Giá Tiền Từ..." /> <select
					name="ctl00$ContentPlaceHolder3$boxSearch1$cboGK2"
					id="ContentPlaceHolder3_boxSearch1_cboGK2" class="SelectGiaTien">
					<option value="1">Trăm ngh&#236;n</option>
					<option selected="selected" value="10">Triệu</option>
					<option value="210">Ng&#224;n USD</option>
					<option value="440">C&#226;y</option>
					<option value="10000">Tỷ</option>
				</select>
			</div>
			<div>
				<input name="ctl00$ContentPlaceHolder3$boxSearch1$txtToGiaTien"
					type="text" id="ContentPlaceHolder3_boxSearch1_txtToGiaTien"
					class="inputGiaTien" placeholder="Đến..." /> <select
					name="ctl00$ContentPlaceHolder3$boxSearch1$cboKG"
					id="ContentPlaceHolder3_boxSearch1_cboKG" class="SelectGiaTien">
					<option value="1">Trăm ngh&#236;n</option>
					<option value="10">Triệu</option>
					<option value="210">Ng&#224;n USD</option>
					<option value="440">C&#226;y</option>
					<option selected="selected" value="10000">Tỷ</option>
				</select>
			</div>
			<div>
				<input name="ctl00$ContentPlaceHolder3$boxSearch1$txtFromDienTich"
					type="text" id="ContentPlaceHolder3_boxSearch1_txtFromDienTich"
					class="inputGiaTien" placeholder="Diện Tích Từ...(m2)" /> <input
					name="ctl00$ContentPlaceHolder3$boxSearch1$txtToDienTich"
					type="text" id="ContentPlaceHolder3_boxSearch1_txtToDienTich"
					class="inputGiaTien" placeholder="Đến...(m2)" /><label
					style="font-weight: bold;"> </label>
			</div>
			<div style="width: 50%; display: inline-block; float: left">
				<p>
					<input id="Button1" title="Tìm kiếm tất cả các bất động sản"
						type="button" value="Tìm Tất Cả"
						onclick="javascript: Button1_onclick(0, false);"
						class="ip-btl-search-1" />
				</p>
			</div>
			<div style="width: 50%; display: inline-block; float: left;">
				<p>
					<input id="Button2"
						title="Chỉ tìm những tin chính chủ bao gồm tin chưa xác thực"
						type="button" value="Tìm Chính Chủ"
						onclick="javascript: Button1_onclick(2, false);"
						class="ip-btl-search-1" />
				</p>
			</div>
			<p>
				<input id="Button5" onclick="javascript: Button1_onclick(0, true);"
					title="Chọn khu vực hoặc dự án bạn muốn mua và gửi yêu cầu cho chúng tôi"
					class="ip-btl-buy-datmua" type="button"
					value="ĐẶT MUA NHÀ ĐẤT TẠI ĐÂY" />
			</p>
			<p></p>
		</div>
	</div>
</div>