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
									<div class="mini-reserve-calendar" >
										<div class="mini-reserve-calendar-top">
											<button type="button" class="btn-mini-reserve-calendar-ui btn-month-prev" id="btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
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
							<div class="basic-data-card transparent">
								<button type="button" class="btn btn-outline-purple btn-basic-full btn-box-shadow"><strong>빈시간 판매하기</strong></button>
							</div>					
							<!-- //빈시간 판매하기 -->
						</div>					
					</div>
					<div class="data-col-middle">
						<div class="basic-data-card reserve-calendar-view">
							<div class="card-header">
								<!-- 캘린더 상단 -->
								<div class="reserve-calendar-top">
<!--									<div class="sort-left">-->
<!--										<select>-->
<!--											<option value="" selected>미용</option>-->
<!--											<option value="">호텔</option>-->
<!--											<option value="">유치원</option>-->
<!--										</select>-->
<!--									</div>-->
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
										<button type="button" onclick="location.href='./reserve_beauty_week.php';" class="btn-reserve-calendar-sort">주</button>
										<button type="button" class="btn-reserve-calendar-sort actived">일</button>
										<button type="button" class="btn-reserve-calendar-sort"><span class="icon icon-type-list-gray off"></span><span class="icon icon-type-list-white on"></span></button>
									</div>
								</div>
								<!-- //캘린더 상단 -->
							</div>
							<div class="card-body">								
								<!-- 캘린더 상세 -->
								<div>
									<div class="reserve-calendar-data">
										<div class="reserve-calendar-inner">
											<!--
											// calendar-month-header-col 클래스 정의
											// calendar-month-body-col 클래스 정의
											//	break : 휴무 및 예약금지
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
											<div class="calendar-day-wrap small">
												<div class="calendar-day-header">
													<div class="calendar-day-header-row" id="day_header_row">
														<div class="calendar-day-header-col time"></div>
													</div>
												</div>
												<div class="calendar-day-body" id="day_body">


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
		<div class="tooltip-date">22.09.12</div>
		<div class="tooltip-desc">내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. </div>
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
                    <button type="button" class="btn btn-confirm btn-reserv-send" onclick="pop.close(); pop.open('reserveAcceptUser');">예약접수</button>
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
                                                            <input type="text" class="form-control" value="">
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
                                                        <input type="text" class="form-control" value="잭" placeholder="펫 이름 입력">
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
                                                                    <label class="form-toggle-box" for="breed1"><input type="radio" name="breed" id="breed1"><em><span>강아지</span></em></label>
                                                                    <label class="form-toggle-box" for="breed2"><input type="radio" name="breed" id="breed2"><em><span>고양이</span></em></label>
                                                                </div>
                                                            </div>
                                                            <div class="pet-breed-sort">
                                                                <!-- 강아지 -->
                                                                <div style="display:block">
                                                                    <select>
                                                                        <option value="">말티즈</option>
                                                                    </select>
                                                                    <div class="pet-breed-other"  style="display:block">
                                                                        <input type="text" placeholder="입력" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <!-- //강아지 -->
                                                                <!-- 고양이 -->
                                                                <div style="display:none">
                                                                    <select>
                                                                        <option value="">고양이</option>
                                                                    </select>
                                                                    <div class="pet-breed-other"  style="display:block">
                                                                        <input type="text" placeholder="입력" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <!-- //고양이 -->
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
                                                                    <select>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select>
                                                                        <option value="">02 월</option>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select>
                                                                        <option value="">02 일</option>
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
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender1"><input type="radio" name="gender" id="gender1"><em>남아</em></label></div>
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender2"><input type="radio" name="gender" id="gender2"><em>여아</em></label></div>
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
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize1"><input type="radio" name="neutralize" id="neutralize1"><em>X</em></label></div>
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize2"><input type="radio" name="neutralize" id="neutralize2"><em>O</em></label></div>
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
                                                            <select class="inline-block">
                                                                <option value="">0</option>
                                                                <option value="">0</option>
                                                                <option value="">0</option>
                                                                <option value="">0</option>
                                                            </select>
                                                            <div class="form-unit-point">.</div>
                                                            <select class="inline-block">
                                                                <option value="">0</option>
                                                                <option value="">0</option>
                                                                <option value="">0</option>
                                                                <option value="">0</option>
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
                                                        <select>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">예방 접종</div>
                                                    <div class="form-item-data type-2">
                                                        <select>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">입질</div>
                                                    <div class="form-item-data type-2">
                                                        <select>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">슬개골 탈구</div>
                                                    <div class="form-item-data type-2">
                                                        <select>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
                                                            <option value="">2회</option>
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
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special3"><input type="checkbox" name="special" id="special3"><em>마운팅</em></label></div>
                                                                <div class="grid-layout-cell grid-1">
                                                                    <textarea style="height:60px;"></textarea>
                                                                </div>
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
                                                                    <select>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                        <option value="">2021 년</option>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select>
                                                                        <option value="">02 월</option>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select>
                                                                        <option value="">02 일</option>
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
                                                                <select>
                                                                    <option value="">오전 11:30</option>
                                                                    <option value="">오전 11:30</option>
                                                                    <option value="">오전 11:30</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-unit">~</div>
                                                            <div class="form-datepicker">
                                                                <select>
                                                                    <option value="">오후 11:30</option>
                                                                    <option value="">오후 11:30</option>
                                                                    <option value="">오후 11:30</option>
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
                            <div class="basic-data-group" id="service">
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
                                                <div class="grid-layout-inner">
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">크기 선택</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="size"><em>소형견 미용</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="size"><em>중형견 미용</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="size"><em>대형견 미용</em></label></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">서비스</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>선택 안함</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>목욕</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>부분 미용</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>전체 미용</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>스포팅</em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box large"><input type="radio" name="s1"><em>가위</em></label></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">무게</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" name="s2"><em><span>선택 안함</span></em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" name="s2"><em><span>~4Kg</span><strong>20,000원</strong></em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" name="s2"><em><span>~6Kg</span><strong>20,000원</strong></em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" name="s2"><em><span>~8Kg</span><strong>20,000원</strong></em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" name="s2"><em><span>~10Kg</span><strong>20,000원</strong></em></label></div>
                                                                    <div class="toggle-button-cell">
                                                                        <div class="form-toggle-options">
                                                                            <input type="checkbox" name="options1">
                                                                            <div class="form-toggle-options-data">
                                                                                <div class="options-labels"><span>옵션 선택 형</span><strong>3,500원</strong></div>
                                                                                <div class="form-amount-input">
                                                                                    <button type="button" class="btn-form-amount-minus">감소</button>
                                                                                    <div class="form-amount-info">
                                                                                        <input type="number" readonly="" value="1" class="form-amount-val">
                                                                                    </div>
                                                                                    <button type="button" class="btn-form-amount-plus">증가</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">털특징</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large" for="hair1"><input type="checkbox" name="hair" id="hair1"><em><span>장모_목욕</span><strong>+5,000원</strong></em></label></div>
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large" for="hair2"><input type="checkbox" name="hair" id="hair2"><em><span>이중모_목욕</span><strong>+5,000원</strong></em></label></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">미용털길이</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large" for="hairBeauty1"><input type="checkbox" name="hairBeauty" id="hairBeauty1"><em><span>선택안함</span><strong>0원</strong></em></label></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //기본 서비스 -->
                                        <!-- 추가 -->
                                        <div class="tab-data-cell" id="other_service">
                                            <div class="grid-layout basic">
                                                <div class="grid-layout-inner">
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">얼굴컷</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f1"><em><span>기본얼굴컷</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f1"><em><span>브로콜리컷</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f1"><em><span>하이바컷</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f1"><em><span>곰돌이컷</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">다리</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f2"><em><span>발톱</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f2"><em><span>장화</span><strong>+1,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f2"><em><span>방울</span><strong>+15,000원</strong></em></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">스파</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f3"><em><span>스파1</span><strong>+6,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f3"><em><span>스파2</span><strong>+9,000원</strong></em></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">염색</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f4"><em><span>부분염색</span><strong>+10,000원</strong></em></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell grid-5">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">기타</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="toggle-button-group vertical">
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f5"><em><span>기장추가1</span><strong>+5,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f5"><em><span>기장추가2</span><strong>+10,000원</strong></em></label>
                                                                    </div>
                                                                    <div class="toggle-button-cell">
                                                                        <label class="form-toggle-box form-toggle-price middle"><input type="checkbox" name="f5"><em><span>기장추가3</span><strong>+15,000원</strong></em></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //추가 -->
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group vmiddle">
                                <div class="service-selected-wrap">
                                    <div class="service-selected-group">
                                        <h5 class="con-title">서비스 선택 내역</h5>
                                        <div class="service-selected-list">
                                            <div class="service-selected-list-cell">
                                                <div class="list-data">소형견 미용</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data">목욕 30분</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data">~10.1Kg</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data">이중모_목욕</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="service-selected-group add">
                                        <h5 class="con-title">추가 선택 내역</h5>
                                        <div class="service-selected-list">
                                            <div class="service-selected-list-cell">
                                                <div class="list-title">얼굴컷</div>
                                                <div class="list-data">+ 곰돌이컷</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-title">다리</div>
                                                <div class="list-data">+ 발톱/방울</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-title">스파</div>
                                                <div class="list-data">+ 스파 40분</div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-title">염색</div>
                                                <div class="list-data">+ 부분 염색</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/Sortable.min.js"></script>

<script src="../static/js/booking.js"></script>
<script>

    let artist_id = "<?=$artist_id?>";

    data_set(artist_id)


    $(document).ready(function(){


        gnb_init();
        wide_tab();
        wide_tab_2();
        prepend_data('consulting_count nick');
        set_image('front_image');
        calendar_change_month(artist_id);
        btn_month(artist_id);
        btn_month_simple()
        mini_calendar_init()
            .then(function(){
                _renderCalendar_mini(artist_id)


            })
        reload_list(artist_id)

        input_enter('reserve_search','reserve_search_btn');
        gnb_actived('gnb_reserve_wrap','gnb_beauty');
        btn_schedule(artist_id);
        reserve_toggle();



    })





</script>
<script>
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

	});

});
</script>
</body>
</html>