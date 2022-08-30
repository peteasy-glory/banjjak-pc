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
					<div class="data-col-left">
						<div class="basic-data-card-group">
							<!-- 오늘의 미용 예약 -->
							<div class="basic-data-card reserve-today fluid"><!-- 20220519 수정 : fluid 클래스 추가 -->
								<div class="card-body">
									<div class="mini-reserve-calendar">
										<div class="mini-reserve-calendar-top">
											<button type="button" class="btn-mini-reserve-calendar-ui btn-month-prev"  id="btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
											<div class="mini-reserve-calendar-title">
												<button type="button" class="txt year-month"></button>
											</div>
											<button type="button" class="btn-mini-reserve-calendar-ui btn-month-next" id="btn-month-next"><span class="icon icon-calendar-next-small"></span></button>
											<!-- calendar-title-sort 클래스에 actived클래스 추가시 활성화 -->
											<div class="calendar-title-sort">
												<div class="simple-calendar-wrap">
													<div class="simple-calendar-top">
														<button type="button" class="btn-simple-calendar-ui btn-simple-calendar-prev" id="btn-simple-calendar-prev">이전</button>
														<div class="top-title" id="top-title"></div>
														<button type="button" class="btn-simple-calendar-ui btn-simple-calendar-next" id="btn-simple-calendar-next">다음</button>
													</div>
													<div class="simple-calendar-body">
														<div class="simple-calendar-month-group">
															<div class="simple-calendar-month-row">
																<!-- btn-simple-calendar-month-nav 클래스에 actived클래스 추가시 활성화 -->
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">1</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">2</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">3</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">4</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">5</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">6</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">7</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">8</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">9</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">10</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">11</button></div>
																<div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">12</button></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<div class="mini-reserve-calendar-data">
												<div class="mini-reserve-calendar-inner">
													<!--
													// calendar-month-header-col 클래스 정의
													//	sunday : 일요일
													//	saturday : 토요일

													// calendar-month-body-col 클래스 정의
													// before : 이전월
													// after : 다음월
													//	sunday : 일요일
													//	saturday : 토요일
													//	break :휴무
													//	holiday :공휴일
													// today : 오늘
													// current : 선택됨
													-->
													<div class="mini-calendar-month-wrap">
														<div class="mini-calendar-month-header">
															<div class="mini-calendar-month-header-row">
																<div class="mini-calendar-month-header-col sunday">일</div>
																<div class="mini-calendar-month-header-col">월</div>
																<div class="mini-calendar-month-header-col">화</div>
																<div class="mini-calendar-month-header-col">수</div>
																<div class="mini-calendar-month-header-col">목</div>
																<div class="mini-calendar-month-header-col">금</div>
																<div class="mini-calendar-month-header-col saturday">토</div>
															</div>
														</div>
														<div class="mini-calendar-month-body" id="mini-calendar-month-body">

														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>					
							<!-- //오늘의 미용 예약 -->
							<!-- 오늘의 예약 총 횟수 -->
							<div class="basic-data-card _reserve-total">
								<div class="card-header">
									<div class="card-header-title" id="day_today"></div>
								</div>
								<div class="card-body">
									<div class="total-text-group">
										<div class="total-text-cell"><div class="item-title">총 미용 예약</div><div class="item-value" id="day_total"></div></div>
										<div class="total-text-cell"><div class="item-title">예약 취소</div><div class="item-value" id="day_cancel"></div></div>
										<div class="total-text-cell"><div class="item-title">NO SHOW</div><div class="item-value" id="day_noshow"></div></div>
									</div>
								</div>
							</div>					
							<!-- //오늘의 예약 총 횟수 -->
							<!-- 빈시간 판매하기 -->
<!--							<div class="basic-data-card transparent">-->
<!--								<button type="button" class="btn btn-outline-purple btn-basic-full btn-box-shadow"><strong>빈시간 판매하기</strong></button>-->
<!--							</div>					-->
							<!-- //빈시간 판매하기 -->
						</div>					
					</div>
					<div class="data-col-middle">
						<div class="basic-data-card reserve-calendar-view">
							<div class="card-header">
								<!-- 캘린더 상단 -->
								<div class="reserve-calendar-top">
									<!--<div class="sort-left">
										<select>
											<option value="" selected>미용</option>
											<option value="">호텔</option>
											<option value="">유치원</option>
										</select>
									</div>-->
									<div class="reserve-calendar-select">
										<button type="button" class="btn-reserve-calendar-ui btn-month-prev" id="btn-schedule-prev"><span class="icon icon-calendar-prev-small"></span></button>
										<div class="reserve-calendar-title">
											<div class="txt" id="schedule_day"></div>
										</div>
										<button type="button" class="btn-reserve-calendar-ui btn-month-next" id="btn-schedule-next"><span class="icon icon-calendar-next-small"></span></button>
									</div>
									<div class="sort-right">
										<!-- actived클래스 추가시 활성화 -->
										<button type="button" onclick="location.href='./reserve_beauty_month.php';" class="btn-reserve-calendar-sort">월</button>
										<button type="button" class="btn-reserve-calendar-sort actived">주</button>
										<button type="button" onclick="location.href='./reserve_beauty_day.php';" class="btn-reserve-calendar-sort">일</button>
										<button type="button" class="btn-reserve-calendar-sort"><span class="icon icon-type-list-gray off"></span><span class="icon icon-type-list-white on"></span></button>
									</div>
								</div>
								<!-- //캘린더 상단 -->
							</div>
							<div class="card-body">	
								<!-- 캘린더 라벨 -->
								<div class="reserve-calendar-label">
									<div class="reserve-calendar-master">
										<div class="grid-layout btn-grid-group">
											<div class="grid-layout-inner" id="grid_layout_inner">
												<!-- btn-toggle-button 클래스에 actived클래스 추가시 활성화 -->

											</div>
										</div>
									</div>
								</div>
								<!-- //캘린더 라벨 -->							
								<!-- 캘린더 상세 -->
								<div>
									<div class="reserve-calendar-data">
										<div class="reserve-calendar-inner">
											<!--
											// calendar-month-header-col 클래스 정의
											//	sunday : 일요일
											//	saturday : 토요일

											// calendar-month-body-col 클래스 정의
											//	sunday : 일요일
											//	saturday : 토요일
											//	break : 휴무 및 예약금지
											//	holiday :공휴일
											// today : 오늘
											// calendar-drag-item-group : 드래그 가능한 영역
											// calendar-drag-item : 드래그 아이템
											-->
											<!--
											// calendar-week-time-item 상황별 클래스값
											// yellow : 앱-선결제
											// purple : 앱-매장결제
											// green : 매장예약
											// red : NoShow
											// gray : 승인대기
											-->
											<div class="calendar-week-wrap small" id="week_wrap">
												<div class="calendar-week-header">
													<div class="calendar-week-header-row" id="week_header_row">
														<div class="calendar-week-header-col time"></div>
														<div class="calendar-week-header-col calendar-week-header-col-add sunday"><div class="day week-date"></div><div class="th">(일)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add "><div class="day week-date"></div><div class="th">(월)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add"><div class="day week-date"></div><div class="th">(화)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add"><div class="day week-date"></div><div class="th">(수)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add"><div class="day week-date"></div><div class="th">(목)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add"><div class="day week-date"></div><div class="th">(금)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add"><div class="day week-date"></div><div class="th">(토)</div></div>
													</div>
												</div>
												<div class="calendar-week-body" id="day_body">

												</div>
											</div>
										</div>					
									</div>
								</div>
								<!-- //캘린더 상세 -->
								<!-- 캘린더 라벨 -->
								<div class="reserve-calendar-label">
									<div class="grid-layout reserve-calendar-label-group">
										<div class="grid-layout-inner">
											<div class="grid-layout-cell"><div class="reserve-calendar-label-items"><div class="reserve-calendar-label-state yellow"></div>앱-선결제</div></div>
											<div class="grid-layout-cell"><div class="reserve-calendar-label-items"><div class="reserve-calendar-label-state purple"></div>앱-매장결제</div></div>
											<div class="grid-layout-cell"><div class="reserve-calendar-label-items"><div class="reserve-calendar-label-state green"></div>매장예약</div></div>
											<div class="grid-layout-cell"><div class="reserve-calendar-label-items"><div class="reserve-calendar-label-state red"></div>NoShow</div></div>
										</div>
									</div>	
								</div>
								<!-- //캘린더 라벨 -->	
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
			<button type="button" class="btn-broswer-mode" onclick="darkMode();">
				<span class="off"><span class="icons"></span>다크 모드 보기</span>
				<span class="on"><span class="icons"></span>라이트 모드 보기</span>
			</button>
		</section>
		<!-- //contents -->
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->

<div class="reserve-calendar-tooltip">
	<div class="tooltip-inner">
		<div class="tooltip-date" id="tooltip_date"></div>
		<div class="tooltip-desc" id="tooltip_desc"></div>
	</div>
</div>

<article id="reserveCalendarPop4" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title"></h4>
                </div>
                <div class="pop-body type-3">
                    <div class="msg-txt"><span class="msg-text-date"></span><br><br>선택한 예약을<br>이 곳으로 변경합니다.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                    <button type="button" class="btn btn-confirm" onclick="location.reload();">예약변경취소</button>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="reserveCalendarPop2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title" id="pop2_worker"></h4>
                </div>
                <div class="pop-body type-3">
                    <div class="msg-txt"><span class="msg-txt-date" id="pop2_date"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span  class="msg-txt-time" id="pop2_time"></span></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block" onclick="pop.close(); reserve_prohibition_init().then(function(){reserve_prohibition_select()}); ">예약금지설정</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send" onclick="pop.close(); pop.open('reserveAcceptUser'); reserve_time_select()">예약접수</button>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="reserveCalendarPop3" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title">예약금지 설정</h4>
                </div>
                <div class="pop-body type-3">
                    <form name="form_time" id="form_time">
                        <input type="hidden" name="ph_type" value="notall">
                        <input type="hidden" name="ph_worker" value="">
                        <input type="hidden" name="ph_start_year" id="year" value="">
                        <input type="hidden" name="ph_start_month" id="month" value="">
                        <input type="hidden" name="ph_start_day" id="day" value="">



                        <div class="form-group">
                            <div class="form-group-cell">
                                <div class="form-group-item">
                                    <div class="form-item-label">시간</div>
                                    <div class="form-item-data type-2">
                                        <div class="form-datepicker-group">
                                            <div class="form-datepicker">
                                                <select name="ph_start_time" id="ph_start_time">
                                                </select>
                                            </div>
                                            <div class="form-unit">~</div>
                                            <div class="form-datepicker">
                                                <select name="ph_end_time" id="ph_end_time">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-holiday-submit" onclick="reserve_prohibition(artist_id)">저장</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>

        </div>
    </div>
</article>

<article id="reserveCalendarPop10" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title">설정된 예약금지를 해제하시겠습니까?</h4>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block-cancel" onclick="reserve_prohibition_delete()">예</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send" onclick="$('#reserveCalendarPop10').removeClass('actived');">아니요</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveAcceptUser" class="layer-pop-wrap">
    <input type="hidden" value="" id="customer_id">
    <input type="hidden" value="" id="pet_seq">
    <input type="hidden" value="" id="is_vat">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">예약 접수</h4>
                </div>
                <div class="pop-body">
                    <div class="reserve-accept-wrap">
                        <div class="wide-tab">
                            <div class="wide-tab-inner"  id="wide-tab-inner">
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
                                <!-- 검색결과 있을 때 -->
                                <div class="customer-card-list">
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
                                            <div class="item-info">검색 결과가 없습니다.</span></div>
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
                                                                    <div class="pet-breed-other"  id="breed_other_box" style="display:none">
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
                                                            <select class="inline-block" id="weight1">

                                                            </select>
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
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special4"><input type="checkbox" name="special" id="special3"><em>마운팅</em></label></div>

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
                                                                    <select id="reserve_time_year" class="reserve-time">
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="reserve_time_month" class="reserve-time">
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="reserve_time_date">
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
                                                                <select id="reserve_st_time">
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
                                            <div class="tab-cell hit actived"><button type="button" class="btn-tab-item" id="basic_service_btn"><span>기본 서비스</span></button></div>
                                            <div class="tab-cell"><button type="button" class="btn-tab-item" id="other_service_btn"><span>추가</span></button></div>
                                        </div>
                                    </div>
                                    <div class="basic-data-group vvsmall3 tab-data-group">
                                        <!-- tab-data-cell 클래스에 actived클래스 추가시 활성화-->
                                        <!-- 기본 서비스 -->
                                        <div class="tab-data-cell actived" id="basic_service">
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
                                                <div class="list-data"  id="service2_basic_service"></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_weight"></div>
                                            </div>
                                            <div class="service-selected-list-cell" id="service2_basic_hair_feature">
                                                <div class="list-data" ></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_hair_length"></div>
                                            </div>

                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_beauty"></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_hair_bath"></div>
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
                <div class="pop-footer line" id="reserve_footer" style="display:none;">
                    <div class="grid-layout btn-grid-group">
                        <div class="grid-layout-inner">
                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_1"><a href="#" class="btn btn-outline-purple"><strong>알림없이 등록</strong></a></div>
                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_2"><a href="#" class="btn btn-outline-purple"><strong>등록</strong></a></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
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

<script src="../static/js/Sortable.min.js"></script>

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>
<script src="../static/js/customer.js"></script>

<script>
    let artist_id = "<?=$artist_id?>";
    let session_id = "<?=session_id()?>"
    data_set(artist_id)

    $(document).ready(function(){

        gnb_init();
        prepend_data('consulting_count nick');
        set_image('front_image');
        calendar_change_month(artist_id);
        btn_month(artist_id);
        btn_month_simple();
        mini_calendar_init()
            .then(function(){
                _renderCalendar_mini(artist_id);
            })
        reload_list(artist_id);

        gnb_actived('gnb_reserve_wrap','gnb_beauty');
        btn_schedule(artist_id);
        reserve_toggle();
        reserve_regist_tab();
        setInputFilter(document.getElementById("reserve_cellphone"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })



        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type();
        customer_new_weight()
        reserve_merchandise_load_event(artist_id)
        reserve_regist_event(artist_id,session_id);
        reserve_time().then(function (){reserve_time_date()});
        reserve_time_init()


    })



$(function(){
	/*
	$( "#sortable" ).sortable({
		placeholder: "ui-state-highlight",
		cancel:''
    });
	$( "#sortable" ).disableSelection();
	*/

	//https://github.com/SortableJS/Sortable



	$(document).on('mouseenter mouseleave mousemove' , '.calendar-week-time-item' , function(e){
		var x = e.pageX;
		var y = e.pageY;

		/* 확장용 */
		if(e.type == 'mouseenter'){
			$(this).addClass('actived');
		}else if(e.type == 'mouseleave'){
			$(this).removeClass('actived');
		}
		/* 툴팁용 */
		var $tooltip = $('.reserve-calendar-tooltip');
		if(e.type == 'mouseenter'){
			$tooltip.addClass('actived');
		}else if(e.type == 'mouseleave'){
			$tooltip.removeClass('actived');
		}else if(e.type == 'mousemove'){
			$tooltip.css({'top' : y , 'left' : x});
		};
		

	});

});
</script>
</body>
</html>