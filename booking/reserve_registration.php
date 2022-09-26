<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
include($_SERVER['DOCUMENT_ROOT']."/include/check_login_shop.php");

$artist_flag = (isset($_SESSION['artist_flag'])) ? $_SESSION['artist_flag'] : "";

if ($artist_flag == 1) {
    $artist_id = (isset($_SESSION['shop_user_id'])) ? $_SESSION['shop_user_id'] : "";
} else {
    $artist_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
}


$search = ($_POST['search'] && $_POST['search'] !== "") ? $_POST['search']:"";




?>
<body>        

<!-- wrap -->
<div id="wrap">
	<!-- header -->
	<header id="header"></header>
	<!-- //header -->
	<!-- gnb -->
	<nav id="gnb"></nav>
	<!-- //gnb -->
    <!-- container -->
    <section id="container">     
		<!-- contents -->
		<section id="contents">
			<!-- view -->
			<div class="view">
				<div class="data-row">
					<div class="data-col-middle">
						<div class="basic-data-card">
							<div class="card-header">
                                <div class="sort-tab big toggle-button-cell" style="padding-left:38px;">
                                    <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="beauty" checked=""><em><span>미용</span></em></label>
                                    <!--                                                        <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="hotel"><em><span>호텔</span></em></label>-->
                                    <!--                                                        <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="kinder"><em><span>유치원</span></em></label>-->

                                </div>
								<h3 class="card-header-title">예약 접수</h3>
                                <input type="hidden" name="is_vat" id="is_vat" value="">
							</div>
							<div class="card-body">
								<div class="card-body-inner">

                                    <div class="reserve-accept-wrap">
                                        <div class="wide-tab">
                                            <div class="wide-tab-inner" id="wide-tab-inner">
                                                <!-- 활성화시 actived클래스 추가 -->
                                                <div class="tab-cell actived" id="exist_btn"><a href="#" class="btn-tab-item">기존 고객 예약</a></div>
                                                <div class="tab-cell" id="new_btn"><a href="#" class="btn-tab-item">신규 고객 예약</a></div>
                                            </div>
                                        </div>
                                        <div id="exist_user">
                                            <div class="basic-data-group vmiddle" style="margin-top:28px !important">
                                                <div class="basic-single-data">
                                                    <div class="form-btns">
                                                        <input type="text" id="reserve_search" placeholder="전화번호 및 펫이름 입력">
                                                        <button type="button" id="reserve_search_btn" onclick="reserve_search_fam(artist_id)" class="btn-data-send btn-data-search"><span class="icon icon-size-24 icon-page-search">검색</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group large">
                                                <div class="loading-container" id="customer_inquiry_loading" style="height:300px;">
                                                    <img src="/static/images/loading.gif" alt="">
                                                </div>
                                                <!-- 검색결과 있을 때 -->
                                                <div class="customer-card-list" id="search_phone_data">
                                                    <div class="grid-layout margin-8-12">
                                                        <div class="grid-layout-inner" id="reserve_inner">

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- //검색결과 있을 때 -->
                                                <!-- 검색결과 없을 때 -->
                                                <div style="display:block;" id="common_none_data">
                                                    <div class="common-none-data">
                                                        <div class="none-inner">
                                                            <div class="item-info">검색 결과가 없습니다.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- //검색결과 없을 때 -->
                                            </div>
                                        </div>

                                        <div id="new_user" style="display:none;">
                                            <div class="basic-data-group middle" style="margin-top:32px !important;">
                                                <div class="form-group">
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-1">
                                                                <div class="form-group-item">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">전화번호</div>
                                                                        <div class="form-item-data">
                                                                            <input type="text" maxlength="15" id="reserve_cellphone" class="form-control" value="">
                                                                            <div class="form-input-info">'-' 없이 숫자만 입력</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group middle" id="select_pet" style="display: none;">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">펫 선택</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout basic">
                                                            <div class="grid-layout-inner" id="select_pet_list">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">펫 정보<p class="title-need font-color-red">*필수사항만 입력해도 예약등록 가능</p></h4>
                                                </div>
                                                <div class="form-group">
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-1">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label"><em class="need">*</em>펫 이름</div>
                                                                    <div class="form-item-data">
                                                                        <input type="text" class="form-control" value="" id="reserve_name" placeholder="펫 이름 입력">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-1">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label"><em class="need">*</em>품종</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="pet-breed-select-wrap">
                                                                            <div class="pet-breed-select">
                                                                                <div class="breed-select">
                                                                                    <label class="form-toggle-box" for="breed1"><input type="radio" name="breed" class="load-pet-type" value="dog" id="breed1"><em><span>강아지</span></em></label>
                                                                                    <label class="form-toggle-box" for="breed2"><input type="radio" name="breed" class="load-pet-type" value="cat" id="breed2"><em><span>고양이</span></em></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pet-breed-sort">
                                                                                <div style="display:block">
                                                                                    <select id="breed_select">
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                    <div class="pet-breed-other" id="breed_other_box" style="display:none">
                                                                                        <input type="text" placeholder="입력" id="breed_other" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">생일</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout margin-12">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="birthday_year" class="birthday">

                                                                                        </select>
                                                                                </div>
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="birthday_month" class="birthday">

                                                                                    </select>
                                                                                </div>
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="birthday_date">

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">성별 선택</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender1"><input type="radio" name="gender" value="남아" id="gender1"><em>남아</em></label></div>
                                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender2"><input type="radio" name="gender" value="여아" id="gender2"><em>여아</em></label></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">중성화</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize1"><input type="radio" name="neutralize" value="0" id="neutralize1"><em>X</em></label></div>
                                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize2"><input type="radio" name="neutralize" value="1" id="neutralize2"><em>O</em></label></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label"><em class="need">*</em>몸무게</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="form-flex">
                                                                            <select class="inline-block" id="weight1"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option></select>
                                                                            <div class="form-unit-point">.</div>
                                                                            <select class="inline-block" id="weight2">
                                                                                <option value="0">0</option>
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                                <option value="6">6</option>
                                                                                <option value="7">7</option>
                                                                                <option value="8">8</option>
                                                                                <option value="9">9</option>
                                                                            </select>
                                                                            <div class="form-unit-label">kg</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">미용 경험</div>
                                                                    <div class="form-item-data type-2">
                                                                        <select id="beauty_exp">
                                                                            <option value="0">선택</option>
                                                                            <option value="없음">없음</option>
                                                                            <option value="1회">1회</option>
                                                                            <option value="2회">2회</option>
                                                                            <option value="3회 이상">3회 이상</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">예방 접종</div>
                                                                    <div class="form-item-data type-2">
                                                                        <select id="vaccination">
                                                                            <option value="0">선택</option>
                                                                            <option value="2차 이하">2차 이하</option>
                                                                            <option value="3차">3차 완료</option>
                                                                            <option value="4차">4차 완료</option>
                                                                            <option value="5차">5차 완료</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">입질</div>
                                                                    <div class="form-item-data type-2">
                                                                        <select id="bite">
                                                                            <option value="0">선택</option>
                                                                            <option value="안해요">안해요</option>
                                                                            <option value="해요">해요</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">슬개골 탈구</div>
                                                                    <div class="form-item-data type-2">
                                                                        <select id="luxation">
                                                                            <option value="0">선택</option>
                                                                            <option value="없음">없음</option>
                                                                            <option value="1기">1기</option>
                                                                            <option value="2기">2기</option>
                                                                            <option value="3기">3기</option>
                                                                            <option value="4기">4기</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-1">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">특이사항</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special1"><input type="checkbox" name="special" id="special1"><em>피부병</em></label></div>
                                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special2"><input type="checkbox" name="special" id="special2"><em>심장질환</em></label></div>
                                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special3"><input type="checkbox" name="special" id="special3"><em>마킹</em></label></div>
                                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special4"><input type="checkbox" name="special" id="special4"><em>마운팅</em></label></div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="grid-layout-cell grid-1">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">선생님</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner" id="worker_inner">


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">예약 시간</h4>
                                                </div>
                                                <div class="form-group">
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">날짜</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout margin-12">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="reserve_time_year" class="reserve-time" onchange="document.getElementById('reserveCalendarPop2').setAttribute('data-year',this.value)">

                                                                                    </select>
                                                                                </div>
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="reserve_time_month" class="reserve-time" onchange="document.getElementById('reserveCalendarPop2').setAttribute('data-month',fill_zero(parseInt(this.value)-1))">

                                                                                    </select>
                                                                                </div>
                                                                                <div class="grid-layout-cell grid-3">
                                                                                    <select id="reserve_time_date" onchange="document.getElementById('reserveCalendarPop2').setAttribute('data-date',this.value)">
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">시간</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="form-datepicker-group">
                                                                            <div class="form-datepicker">
                                                                                <select id="reserve_st_time" onchange="document.getElementById('reserveCalendarPop2').setAttribute('data-hour',this.value.split(':')[0]); document.getElementById('reserveCalendarPop2').setAttribute('data-minutes',this.value.split(':')[1]);">

                                                                                </select>
                                                                            </div>
                                                                            <div class="form-unit">~</div>
                                                                            <div class="form-datepicker">
                                                                                <select id="reserve_fi_time">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group" id="service" style="display:none;">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">예약 서비스 및 추가 특이사항 입력</h4>
                                                </div>
                                                <div class="form-group">
                                                    <div class="wide-tab">
                                                        <div class="wide-tab-inner" id="wide-tab-inner2">
                                                            <!-- 활성화시 actived클래스 추가 -->
                                                            <div class="tab-cell actived"><button type="button" class="btn-tab-item" id="basic_service_btn"><span>기본 서비스</span></button></div>
                                                            <div class="tab-cell"><button type="button" class="btn-tab-item" id="other_service_btn"><span>추가</span></button></div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vvsmall3 tab-data-group">
                                                        <!-- tab-data-cell 클래스에 actived클래스 추가시 활성화-->
                                                        <!-- 기본 서비스 -->
                                                        <div class="tab-data-cell  actived" id="basic_service">
                                                            <div class="grid-layout basic">
                                                                <div class="grid-layout-inner" id="basic_service_inner">




                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- //기본 서비스 -->
                                                        <!-- 추가 -->
                                                        <div class="tab-data-cell" id="other_service">
                                                            <div class="grid-layout basic">
                                                                <div class="grid-layout-inner" id="other_service_inner">





                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- //추가 -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="basic-data-group vmiddle" id="service2" style="display:none;">
                                                <div class="service-selected-wrap">
                                                    <div class="service-selected-group">
                                                        <h5 class="con-title">서비스 선택 내역</h5>
                                                        <div class="service-selected-list" id="service2_basic_list">
                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_size"></div>
                                                            </div>
                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_service"></div>
                                                            </div>
                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_weight"></div>
                                                            </div>
                                                            <div class="service-selected-list-cell" id="service2_basic_hair_feature">
                                                                <div class="list-data"></div>
                                                            </div>
                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_hair_length"></div>
                                                            </div>

                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_beauty"></div>
                                                            </div>
                                                            <div class="service-selected-list-cell">
                                                                <div class="list-data" id="service2_basic_hair_bath"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="service-selected-group add">
                                                        <h5 class="con-title">추가 선택 내역</h5>
                                                        <div class="service-selected-list" id="service2_other_list">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
                                <div class="pop-footer line reserve_registration_footer" id="reserve_footer" style="display: none;">
                                    <div class="grid-layout btn-grid-group">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_1"><a href="#" class="btn btn-outline-purple"><strong>알림없이 등록</strong></a></div>
                                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_2"><a href="#" class="btn btn-outline-purple"><strong>등록</strong></a></div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<article id="reserveCalendarPop11" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">미용 예약 하루 전 알림은 발송 하시겠습니까?</div>
                </div>
                <div class="pop-footer" id="notice_check">
                    <button type="button" class="btn btn-confirm btn-reserv-block" onclick="reserve_regist(artist_id,session_id,true);">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send" onclick="reserve_regist(artist_id,session_id,false);">미발송</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveCalendarPop2" class="layer-pop-wrap" data-name="" data-month="01" data-date="01" data-year="2022" data-hour="9" data-minutes="00">




</article>
<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close(); pop.close('reserveCalendarPop11')">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>
<script src="/static/js/common.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/customer.js"></script>
<script src="/static/js/booking.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    let session_id = "<?=session_id()?>"

    $(document).ready(function(){
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            $("#gnb_home").css("display","none");
            $("#gnb_shop_wrap").css("display","none");
            $("#gnb_detail_wrap").css("display","none");
            $("#gnb_stats_wrap").css("display","none");
        }
        get_navi(artist_id);
        gnb_init();
        set_image('front_image');
        ////prepend_data('consult_count nickname');
        //search_fam('<?//=$search?>//',artist_id);
        input_enter('reserve_search','reserve_search_btn');
        gnb_actived('gnb_reserve_wrap','gnb_reserve')
        localStorage.removeItem('noshow_cnt');
        localStorage.removeItem('customer_select');
        localStorage.removeItem('sub_cellphone');
        wide_tab();
        wide_tab_2();
        reserve_toggle();
        reserve_regist_event(artist_id,session_id);
        customer_pet_type()
        reserve_merchandise_load_event(artist_id);
        reserve_regist_tab();
        reserve_time().then(function (){reserve_time_date().then(function(){

            for(let i=0; i<document.getElementById('reserve_time_month').options.length; i++){

                if(document.getElementById('reserve_time_month').options[i].value === fill_zero(new Date().getMonth()+1)){

                    document.getElementById('reserve_time_month').options[i].selected = true;
                }
            }

            for(let i=0; i<document.getElementById('reserve_time_date').options.length; i++){

                if(document.getElementById('reserve_time_date').options[i].value == fill_zero(new Date().getDate())){

                    document.getElementById('reserve_time_date').options[i].selected = true;
                }
            }
        });




        });
        get_worker(artist_id);
        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        reserve_time_init();
        new_exist_check(artist_id);





    })



</script>
</body>
</html>
