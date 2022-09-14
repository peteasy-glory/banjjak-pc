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
<body >

<!-- wrap -->
<div id="wrap">

    <!-- header -->
	<header id="header"></header>
	<!-- //header -->
	<!-- gnb -->
	<nav id="gnb" class="hide"></nav>
	<!-- //gnb -->
    <!-- container -->
    <section id="container" class="hide">

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
                                                        <div class="loading-container" id="day_mini_calendar_loading" >
                                                            <div class="mexican-wave"></div>
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
					<div class="data-col-middle" style="flex-direction: row">
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
										<button type="button" onclick="location.href='./reserve_beauty_list.php';" class="btn-reserve-calendar-sort"><span class="icon icon-type-list-gray off"></span><span class="icon icon-type-list-white on"></span></button>
									</div>
								</div>
								<!-- //캘린더 상단 -->
							</div>
							<div class="card-body">

								<!-- 캘린더 상세 -->
								<div>
									<div class="reserve-calendar-data">
                                        <div class="loading-container" id="day_schedule_loading" style="height:648px">
                                            <div class="mexican-wave"></div>
                                        </div>
										<div class="reserve-calendar-inner" id="reserve_calendar_inner_day" style="height:648px;">
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
                        <article id="pay_management" class="pay_management">
                            <div class="pay-data-card">
                                <div class="pay-card-header">
                                    <div class="pay-card-header-title">작업/결제 관리</div>
                                    <div class="pay-close-btn" id="pay_close_btn" onclick="pay_management_toggle(true)">></div>
                                </div>
                                <div class="pay-card-body">
                                    <div class="pay-card-body-inner">
                                        <div class="pay-card-content-1">
                                            <div class="pay-card-body-title" id="pay_noshow">
                                                <h4 class="con-title">예약자 정보</h4>

                                                <div style="width:120px;" id="noshow_count">

                                                </div>
                                            </div>
                                            <div class="pay-flex-table">
                                                <div class="pay-flex-table-cell">
                                                    <div class="pay-flex-table-item">
                                                        <div class="pay-flex-table-title">
                                                            <dlv class="pay-txt">등급</dlv>
                                                        </div>
                                                        <div class="pay-flex-table-data">
                                                            <div class="pay-flex-table-data-inner">
                                                                <div class="pay-user-grade-item">
                                                                    <div class="icon" id="pay_customer_grade">

                                                                    </div>

                                                                    <div class="icon-grade-label" id="pay_customer_grade_name">

                                                                    </div>
                                                                </div>
                                                                <div class="pay-flex-table-data-side">
                                                                    <button type="button" class="pay-grade-modify" onclick="pop.open('memberGradeAddPop')"></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-flex-table-cell">
                                                    <div class="pay-flex-table-item">
                                                        <div class="pay-flex-table-title">
                                                            <div class="pay-txt">연락처</div>
                                                        </div>
                                                        <div class="pay-flex-table-data">
                                                            <dlv class="pay-flex-table-data-inner">
                                                                <div class="pay-user-cellphone" id="pay_main_phone">

                                                                </div>
                                                            </dlv>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-flex-table-cell">
                                                    <div class="pay-flex-table-item">
                                                        <div class="pay-flex-table-title">
                                                            <div class="pay-txt">보조 연락처</div>
                                                            <div class="call-edit"  onclick="pop.open('numberAddPop')">
                                                                <span>편집</span>
                                                            </div>
                                                        </div>
                                                        <div class="pay-flex-table-data">
                                                            <div class="pay-flex-table-data-inner">
                                                                <div class="pay-user-sub-cellphone" id="pay_sub_phone">


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pay-customer-memo">
                                                <div class="pay-customer-memo-title">
                                                    <div class="pay-txt">견주관련 메모<span class="pay-sub-txt"> (고객에게는 노출되지 않습니다.)</span></div>
                                                </div>
                                                <textarea name="pay-customer-memo-text" id="pay_customer_memo_text" cols="30" rows="10"></textarea>
                                                <button type="button" class="pay-customer-memo-save btn btn-outline-purple btn-middle-size btn-round" onclick="customer_memo()">저장</button>
                                            </div>
                                        </div>

                                        <div class="pay-card-content-2">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">예약동물 정보</h4>
                                            </div>
                                            <div class="pay-customer-pet-group">
                                                <div class="pay-customer-view-pet-picture">
                                                    <div class="pay-item-thumb">
                                                        <div class="user-thumb large">
                                                            <img src="" id="beauty_img_target" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="pay-item-user-info">
                                                        <div class="pay-item-user-info-inner">
                                                            <div class="pay-pet-name" id="pay_pet_name"></div>
                                                            <div class="pay-pet-cate" id="pay_pet_cate"></div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-item-action">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-2">
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round" onclick="pop.open('reserveBeautyGalleryPop')">미용 갤러리</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-2" id="beauty_agree_view">
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round">미용동의서</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-1">
                                                                    <a href="#" class="btn btn-outline-purple btn-middle-size btn-round"  onclick="pop.open('petModifyPop');" id="modify_pet">펫 정보 수정</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-pet-info">
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    성별
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_gender">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    중성화
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_neutral">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    무게
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_weight">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    나이
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_pet_year">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    입질
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_bite">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-flex-table-cell">
                                                        <div class="pay-flex-table-item">
                                                            <div class="pay-flex-table-title">
                                                                <div class="pay-txt">
                                                                    슬개골 탈구
                                                                </div>
                                                            </div>
                                                            <div class="pay-flex-table-data">
                                                                <div class="pay-flex-table-data-inner" id="pay_luxation">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-customer-view-pet-detail">
                                                    <button type="button" class="pay-btn-detail-toggle">
                                                        펫 정보 자세히 보기
                                                    </button>
                                                    <div class="pay-service-selected-wrap">
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">미용 경험</div>
                                                            <div class="pay-list-data" id="pay_beauty_exp"></div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">예방 접종</div>
                                                            <div class="pay-list-data" id="pay_vaccination"></div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">특이사항</div>
                                                            <div class="pay-list-data" id="pay_special"></div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">기타</div>
                                                            <div class="pay-list-data" id="pay_etc"></div>

                                                       </div>
                                                    </div>

                                                </div>
                                                <div class="pay-special-memo">
                                                    <div class="pay-special-memo-title">
                                                        <div class="pay-txt">특이사항<span class="pay-sub-txt"> (고객에게는 노출되지 않습니다.)</span></div>
                                                    </div>
                                                    <textarea name="pay-special-memo-text" id="pay_special_memo_text" cols="30" rows="10"></textarea>
                                                    <button type="button" class="pay-special-memo-save btn btn-outline-purple btn-middle-size btn-round" onclick="payment_memo()">저장</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="pay-card-content-3">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">이전 미용</h4>
                                            </div>
                                            <div class="pay-before-beauty-list" id="pay_before_beauty_list">

                                            </div>

                                        </div>
                                        <div class="pay-card-content-4">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">예약 내용</h4>
                                                <button type="button" class="btn-side btn btn-small-size btn-inline btn-border-radius-16 btn-bg-yellow" id="pay_allim_btn">알림톡 발송 이력</button>
                                            </div>
                                            <div class="pay-text-list-wrap">
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        날짜
                                                    </div>
                                                    <div class="pay-item-data" id="day_book_target">
                                                    </div>
                                                </div>
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        선생님
                                                    </div>
                                                    <div class="pay-item-data" id="day_book_target_worker"></div>
                                                </div>
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        시간
                                                    </div>
                                                    <div class="pay-item-data">
                                                        <div class="pay-datepicker-group">
                                                            <div class="pay-form-datepicker">
                                                                <select id="start_time">
                                                                </select>
                                                            </div>
                                                            <div class="pay-form-unit">
                                                                ~
                                                            </div>
                                                            <div class="pay-form-datepicker">

                                                                <select id="end_time">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-basic-data-group">
                                                    <button type="button" class="only-change-time btn btn-outline-gray btn-middle-size btn-round" onclick="check_time();">시간만 변경</button>
                                                </div>
                                                <div class="pay-form-bottom-info">
                                                    *시간 변경만 하는 경우 시간선택 후 눌러주세요.
                                                </div>

                                            </div>

                                            <div class="pay-basic-data-group-2">
                                                <div class="grid-layout btn-grid-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round" id="change_check_worker_btn" onclick="pop.open('reservePayManagementMsg1')">날짜/미용사 변경</button>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round" onclick="pop.open('reserveCancel')">예약 취소</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="pay-card-content-5">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">미용 종료 알림 발송</h4>
                                            </div>
                                            <div class="pay-beauty-notice">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_0" value="y">
                                                                <em>지금종료</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_1" value="y">
                                                                <em>10분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_2" value="y">
                                                                <em>15분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_3" value="y">
                                                                <em>20분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_4" value="y">
                                                                <em>30분전</em>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pay-form-bottom-info-2">*시간 선택 후 발송을 누르면 견주에게 즉시알림이 발송됩니다.</div>
                                            <div class="pay-basic-data-group-2">
                                                <div class="grid-layout btn-grid-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-gray btn-middle-size btn-round" onclick="pop.open('talkExam')">예시보기</button>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round" id="allim_send_btn" onclick="allim_talk_send(this)">발송</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sticky-tab-group">
                                            <div class="pay-card-content-6">
                                                <div class="pay-card-body-title">
                                                    <h4 class="con-title">결제 정보</h4>
                                                </div>
                                            </div>
                                            <div class="wide-tab pay-wide-tab">
                                                <div class="wide-tab-inner" id="wide-tab-inner3">
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item" id="tab1">
                                                            <span>
                                                                기본 서비스
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item" id="tab2">
                                                            <span>
                                                                추가
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item" id="tab3">
                                                            <span>
                                                                쿠폰상품
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item" id="tab4">
                                                            <span>
                                                                제품
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="basic-data-group vmiddle tab-data-group">
                                            <input type="hidden" value="" id="customer_id">
                                            <input type="hidden" value="" id="pet_seq">
                                            <input type="hidden" value="" id="is_vat">
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
                                            <!-- 쿠폰상품 -->
                                            <div class="tab-data-cell" id="other2_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="other2_service_inner">

                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item" id="c_coupon">
                                                                <div class="form-item-label">쿠폰상품</div>

                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2" >
                                                            <div class="form-group-item" id="f_coupon">
                                                                <div class="form-item-label">정액상품</div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //쿠폰상품 -->
                                            <!-- 제품 -->
                                            <div class="tab-data-cell" id="other3_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="other3_service_inner">
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">용품</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_1">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">간식</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">사료</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_3">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">기타</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_4">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pay-product-save-btn-wrap">


                                                <button type="button" class="pay-product-save btn btn-outline-purple btn-middle-size btn-round">변경</button>
                                            </div>

                                            <div class="pay-basic-data-group-2  basic-data-group vvsmall2" id="receipt">
                                                <div class="user-receipt-item user-receipt-item-add">
                                                    <div class="receipt-buy-detail">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title">
                                                                </div>
                                                                <div class="list-value">0원</div>
                                                            </div>
                                                            <div class="list-cell">
                                                                <div class="list-title"></div>
                                                                <div class="list-value">0원</div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="receipt-buy-detail total-price" style="border-top: 1px solid #f4f4f4; margin-top: 12px; padding-top: 12px;">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title"><strong>합산 금액</strong></div>
                                                                <div class="list-value"><strong>0원</strong></div>
                                                            </div>
                                                            <div class="list-cell">
                                                                <div class="list-title"><strong>부가세 10%</strong></div>
                                                                <div class="list-value"><strong>0원</strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="receipt-buy-detail result-price">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title font-color-purple"><strong>예상 금액</strong></div>
                                                                <div class="list-value font-color-purple"><strong><span id="total_pay_money">0</span>원</strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="pay-card-content-7">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">단골 고객 할인</h4>
                                            </div>

                                            <div class="user-receipt-wrap">


                                                <div class="user-receipt-item pay-user-receipt"><div class="regular-user-confirm ">
                                                        <div class="info" style="font-size:13px !important;">*원하시는 할인방법을 선택하신 후 적용을 누르세요.</div>
                                                        <div class="regular-user-confirm-select">
                                                            <div class="regular-user-confirm-input">
                                                                <div class="item-check"><label class="form-radiobox">
                                                                        <input type="radio" id="percent_radio" name="discount_radio">
                                                                        <span class="form-check-icon"><em>퍼센트할인</em></span></label></div>
                                                                <div class="item-data">
                                                                    <select id="percent_type" class="select_type">
                                                                        <option value=""></option>
                                                                        <option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option>                                        </select>
                                                                    <div class="unit">%</div>
                                                                </div>
                                                            </div>
                                                            <div class="regular-user-confirm-input">
                                                                <div class="item-check"><label class="form-radiobox">
                                                                        <input type="radio" id="won_radio" name="discount_radio" class="discount_radio" value="won_type"><span class="form-check-icon"><em>금액할인</em></span></label></div>
                                                                <div class="item-data">
                                                                    <select id="won_type" class="select_type">
                                                                        <option value=""></option>
                                                                        <option value="0">0</option><option value="100">100</option><option value="200">200</option><option value="300">300</option><option value="400">400</option><option value="500">500</option><option value="600">600</option><option value="700">700</option><option value="800">800</option><option value="900">900</option><option value="1000">1000</option><option value="1100">1100</option><option value="1200">1200</option><option value="1300">1300</option><option value="1400">1400</option><option value="1500">1500</option><option value="1600">1600</option><option value="1700">1700</option><option value="1800">1800</option><option value="1900">1900</option><option value="2000">2000</option><option value="2100">2100</option><option value="2200">2200</option><option value="2300">2300</option><option value="2400">2400</option><option value="2500">2500</option><option value="2600">2600</option><option value="2700">2700</option><option value="2800">2800</option><option value="2900">2900</option><option value="3000">3000</option><option value="3100">3100</option><option value="3200">3200</option><option value="3300">3300</option><option value="3400">3400</option><option value="3500">3500</option><option value="3600">3600</option><option value="3700">3700</option><option value="3800">3800</option><option value="3900">3900</option><option value="4000">4000</option><option value="4100">4100</option><option value="4200">4200</option><option value="4300">4300</option><option value="4400">4400</option><option value="4500">4500</option><option value="4600">4600</option><option value="4700">4700</option><option value="4800">4800</option><option value="4900">4900</option><option value="5000">5000</option><option value="5100">5100</option><option value="5200">5200</option><option value="5300">5300</option><option value="5400">5400</option><option value="5500">5500</option><option value="5600">5600</option><option value="5700">5700</option><option value="5800">5800</option><option value="5900">5900</option><option value="6000">6000</option><option value="6100">6100</option><option value="6200">6200</option><option value="6300">6300</option><option value="6400">6400</option><option value="6500">6500</option><option value="6600">6600</option><option value="6700">6700</option><option value="6800">6800</option><option value="6900">6900</option><option value="7000">7000</option><option value="7100">7100</option><option value="7200">7200</option><option value="7300">7300</option><option value="7400">7400</option><option value="7500">7500</option><option value="7600">7600</option><option value="7700">7700</option><option value="7800">7800</option><option value="7900">7900</option><option value="8000">8000</option><option value="8100">8100</option><option value="8200">8200</option><option value="8300">8300</option><option value="8400">8400</option><option value="8500">8500</option><option value="8600">8600</option><option value="8700">8700</option><option value="8800">8800</option><option value="8900">8900</option><option value="9000">9000</option><option value="9100">9100</option><option value="9200">9200</option><option value="9300">9300</option><option value="9400">9400</option><option value="9500">9500</option><option value="9600">9600</option><option value="9700">9700</option><option value="9800">9800</option><option value="9900">9900</option><option value="10000">10000</option><option value="10100">10100</option><option value="10200">10200</option><option value="10300">10300</option><option value="10400">10400</option><option value="10500">10500</option><option value="10600">10600</option><option value="10700">10700</option><option value="10800">10800</option><option value="10900">10900</option><option value="11000">11000</option><option value="11100">11100</option><option value="11200">11200</option><option value="11300">11300</option><option value="11400">11400</option><option value="11500">11500</option><option value="11600">11600</option><option value="11700">11700</option><option value="11800">11800</option><option value="11900">11900</option><option value="12000">12000</option><option value="12100">12100</option><option value="12200">12200</option><option value="12300">12300</option><option value="12400">12400</option><option value="12500">12500</option><option value="12600">12600</option><option value="12700">12700</option><option value="12800">12800</option><option value="12900">12900</option><option value="13000">13000</option><option value="13100">13100</option><option value="13200">13200</option><option value="13300">13300</option><option value="13400">13400</option><option value="13500">13500</option><option value="13600">13600</option><option value="13700">13700</option><option value="13800">13800</option><option value="13900">13900</option><option value="14000">14000</option><option value="14100">14100</option><option value="14200">14200</option><option value="14300">14300</option><option value="14400">14400</option><option value="14500">14500</option><option value="14600">14600</option><option value="14700">14700</option><option value="14800">14800</option><option value="14900">14900</option><option value="15000">15000</option><option value="15100">15100</option><option value="15200">15200</option><option value="15300">15300</option><option value="15400">15400</option><option value="15500">15500</option><option value="15600">15600</option><option value="15700">15700</option><option value="15800">15800</option><option value="15900">15900</option><option value="16000">16000</option><option value="16100">16100</option><option value="16200">16200</option><option value="16300">16300</option><option value="16400">16400</option><option value="16500">16500</option><option value="16600">16600</option><option value="16700">16700</option><option value="16800">16800</option><option value="16900">16900</option><option value="17000">17000</option><option value="17100">17100</option><option value="17200">17200</option><option value="17300">17300</option><option value="17400">17400</option><option value="17500">17500</option><option value="17600">17600</option><option value="17700">17700</option><option value="17800">17800</option><option value="17900">17900</option><option value="18000">18000</option><option value="18100">18100</option><option value="18200">18200</option><option value="18300">18300</option><option value="18400">18400</option><option value="18500">18500</option><option value="18600">18600</option><option value="18700">18700</option><option value="18800">18800</option><option value="18900">18900</option><option value="19000">19000</option><option value="19100">19100</option><option value="19200">19200</option><option value="19300">19300</option><option value="19400">19400</option><option value="19500">19500</option><option value="19600">19600</option><option value="19700">19700</option><option value="19800">19800</option><option value="19900">19900</option><option value="20000">20000</option><option value="20100">20100</option><option value="20200">20200</option><option value="20300">20300</option><option value="20400">20400</option><option value="20500">20500</option><option value="20600">20600</option><option value="20700">20700</option><option value="20800">20800</option><option value="20900">20900</option><option value="21000">21000</option><option value="21100">21100</option><option value="21200">21200</option><option value="21300">21300</option><option value="21400">21400</option><option value="21500">21500</option><option value="21600">21600</option><option value="21700">21700</option><option value="21800">21800</option><option value="21900">21900</option><option value="22000">22000</option><option value="22100">22100</option><option value="22200">22200</option><option value="22300">22300</option><option value="22400">22400</option><option value="22500">22500</option><option value="22600">22600</option><option value="22700">22700</option><option value="22800">22800</option><option value="22900">22900</option><option value="23000">23000</option><option value="23100">23100</option><option value="23200">23200</option><option value="23300">23300</option><option value="23400">23400</option><option value="23500">23500</option><option value="23600">23600</option><option value="23700">23700</option><option value="23800">23800</option><option value="23900">23900</option><option value="24000">24000</option><option value="24100">24100</option><option value="24200">24200</option><option value="24300">24300</option><option value="24400">24400</option><option value="24500">24500</option><option value="24600">24600</option><option value="24700">24700</option><option value="24800">24800</option><option value="24900">24900</option><option value="25000">25000</option><option value="25100">25100</option><option value="25200">25200</option><option value="25300">25300</option><option value="25400">25400</option><option value="25500">25500</option><option value="25600">25600</option><option value="25700">25700</option><option value="25800">25800</option><option value="25900">25900</option><option value="26000">26000</option><option value="26100">26100</option><option value="26200">26200</option><option value="26300">26300</option><option value="26400">26400</option><option value="26500">26500</option><option value="26600">26600</option><option value="26700">26700</option><option value="26800">26800</option><option value="26900">26900</option><option value="27000">27000</option><option value="27100">27100</option><option value="27200">27200</option><option value="27300">27300</option><option value="27400">27400</option><option value="27500">27500</option><option value="27600">27600</option><option value="27700">27700</option><option value="27800">27800</option><option value="27900">27900</option><option value="28000">28000</option><option value="28100">28100</option><option value="28200">28200</option><option value="28300">28300</option><option value="28400">28400</option><option value="28500">28500</option><option value="28600">28600</option><option value="28700">28700</option><option value="28800">28800</option><option value="28900">28900</option><option value="29000">29000</option><option value="29100">29100</option><option value="29200">29200</option><option value="29300">29300</option><option value="29400">29400</option><option value="29500">29500</option><option value="29600">29600</option><option value="29700">29700</option><option value="29800">29800</option><option value="29900">29900</option><option value="30000">30000</option><option value="30100">30100</option><option value="30200">30200</option><option value="30300">30300</option><option value="30400">30400</option><option value="30500">30500</option><option value="30600">30600</option><option value="30700">30700</option><option value="30800">30800</option><option value="30900">30900</option><option value="31000">31000</option><option value="31100">31100</option><option value="31200">31200</option><option value="31300">31300</option><option value="31400">31400</option><option value="31500">31500</option><option value="31600">31600</option><option value="31700">31700</option><option value="31800">31800</option><option value="31900">31900</option><option value="32000">32000</option><option value="32100">32100</option><option value="32200">32200</option><option value="32300">32300</option><option value="32400">32400</option><option value="32500">32500</option><option value="32600">32600</option><option value="32700">32700</option><option value="32800">32800</option><option value="32900">32900</option><option value="33000">33000</option><option value="33100">33100</option><option value="33200">33200</option><option value="33300">33300</option><option value="33400">33400</option><option value="33500">33500</option><option value="33600">33600</option><option value="33700">33700</option><option value="33800">33800</option><option value="33900">33900</option><option value="34000">34000</option><option value="34100">34100</option><option value="34200">34200</option><option value="34300">34300</option><option value="34400">34400</option><option value="34500">34500</option><option value="34600">34600</option><option value="34700">34700</option><option value="34800">34800</option><option value="34900">34900</option><option value="35000">35000</option><option value="35100">35100</option><option value="35200">35200</option><option value="35300">35300</option><option value="35400">35400</option><option value="35500">35500</option><option value="35600">35600</option><option value="35700">35700</option><option value="35800">35800</option><option value="35900">35900</option><option value="36000">36000</option><option value="36100">36100</option><option value="36200">36200</option><option value="36300">36300</option><option value="36400">36400</option><option value="36500">36500</option><option value="36600">36600</option><option value="36700">36700</option><option value="36800">36800</option><option value="36900">36900</option><option value="37000">37000</option><option value="37100">37100</option><option value="37200">37200</option><option value="37300">37300</option><option value="37400">37400</option><option value="37500">37500</option><option value="37600">37600</option><option value="37700">37700</option><option value="37800">37800</option><option value="37900">37900</option><option value="38000">38000</option><option value="38100">38100</option><option value="38200">38200</option><option value="38300">38300</option><option value="38400">38400</option><option value="38500">38500</option><option value="38600">38600</option><option value="38700">38700</option><option value="38800">38800</option><option value="38900">38900</option><option value="39000">39000</option><option value="39100">39100</option><option value="39200">39200</option><option value="39300">39300</option><option value="39400">39400</option><option value="39500">39500</option><option value="39600">39600</option><option value="39700">39700</option><option value="39800">39800</option><option value="39900">39900</option><option value="40000">40000</option><option value="40100">40100</option><option value="40200">40200</option><option value="40300">40300</option><option value="40400">40400</option><option value="40500">40500</option><option value="40600">40600</option><option value="40700">40700</option><option value="40800">40800</option><option value="40900">40900</option><option value="41000">41000</option><option value="41100">41100</option><option value="41200">41200</option><option value="41300">41300</option><option value="41400">41400</option><option value="41500">41500</option><option value="41600">41600</option><option value="41700">41700</option><option value="41800">41800</option><option value="41900">41900</option><option value="42000">42000</option><option value="42100">42100</option><option value="42200">42200</option><option value="42300">42300</option><option value="42400">42400</option><option value="42500">42500</option><option value="42600">42600</option><option value="42700">42700</option><option value="42800">42800</option><option value="42900">42900</option><option value="43000">43000</option><option value="43100">43100</option><option value="43200">43200</option><option value="43300">43300</option><option value="43400">43400</option><option value="43500">43500</option><option value="43600">43600</option><option value="43700">43700</option><option value="43800">43800</option><option value="43900">43900</option><option value="44000">44000</option><option value="44100">44100</option><option value="44200">44200</option><option value="44300">44300</option><option value="44400">44400</option><option value="44500">44500</option><option value="44600">44600</option><option value="44700">44700</option><option value="44800">44800</option><option value="44900">44900</option><option value="45000">45000</option><option value="45100">45100</option><option value="45200">45200</option><option value="45300">45300</option><option value="45400">45400</option><option value="45500">45500</option><option value="45600">45600</option><option value="45700">45700</option><option value="45800">45800</option><option value="45900">45900</option><option value="46000">46000</option><option value="46100">46100</option><option value="46200">46200</option><option value="46300">46300</option><option value="46400">46400</option><option value="46500">46500</option><option value="46600">46600</option><option value="46700">46700</option><option value="46800">46800</option><option value="46900">46900</option><option value="47000">47000</option><option value="47100">47100</option><option value="47200">47200</option><option value="47300">47300</option><option value="47400">47400</option><option value="47500">47500</option><option value="47600">47600</option><option value="47700">47700</option><option value="47800">47800</option><option value="47900">47900</option><option value="48000">48000</option><option value="48100">48100</option><option value="48200">48200</option><option value="48300">48300</option><option value="48400">48400</option><option value="48500">48500</option><option value="48600">48600</option><option value="48700">48700</option><option value="48800">48800</option><option value="48900">48900</option><option value="49000">49000</option><option value="49100">49100</option><option value="49200">49200</option><option value="49300">49300</option><option value="49400">49400</option><option value="49500">49500</option><option value="49600">49600</option><option value="49700">49700</option><option value="49800">49800</option><option value="49900">49900</option><option value="50000">50000</option>                                        </select>
                                                                    <div class="unit">원</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vsmall">
                                                        <button type="button" class="btn btn-outline-purple btn-middle-size btn-round set_update_discount_btn" data-seq="601033">적용</button>
                                                    </div>
                                                    <div class="form-bottom-info font-color-purple font-weight-500 text-align-right">할인금액 : <span id="discount_price">
                                            0                                </span>원</div></div>
                                            </div>




                                            <div class="user-receipt-wrap">


                                                <div class="user-receipt-item pay-user-receipt" style="border: 1px solid #6840B1 !important;">
                                                    <div class="receipt-buy-detail total-price">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title"><strong>할인금액</strong></div>
                                                                <div class="list-value"><strong>(-)<span id="total_discount_price">0</span>원</strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="receipt-buy-detail result-price">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title font-color-purple"><strong>최종 결제액</strong></div>
                                                                <div class="list-value font-color-red"><strong id="total_pay_price_disp">
                                                                        0                                            원</strong></div>
                                                                <input type="hidden" name="total_pay_price" id="total_pay_price" value="0" size="3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vmiddle">
                                                        <div class="form-change-wrap">
                                                            <div class="form-change-item">
                                                                <div class="form-change-label"><strong>카드</strong> (단위:원)</div>
                                                                <div class="form-change-data"><input type="text" name="use_card" id="use_card" value="">
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn-data-change">전환하기</button>
                                                            <div class="form-change-item">
                                                                <div class="form-change-label"><strong>현금</strong> (단위:원)</div>
                                                                <div class="form-change-data"><input type="text" name="use_cash" id="use_cash" value="0"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="basic-data-group vsmall">
                                                        <button type="button" class="btn btn-outline-purple btn-middle-size btn-round save-final-price" data-seq="601033">적용</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pay-complete-wrap">
                                                <div class="con-title-group" style="background:none !important;">
                                                    <h4 class="con-title">결제완료 처리</h4>
                                                    <label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" id="pay_confirm" value="1" data-seq="601033"><span class="bar"></span></label>
                                                </div>
                                                <div>
                                                    <span id="confirm_dt"></span>
                                                </div>
                                            </div>

                                        </div>






                                    </div>
                                </div>


                            </div>
                        </article>
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

<article id="reserveCalendarPop4" class="layer-pop-wrap">
    <input type="hidden" name="log_seq">
    <input type="hidden" name="log_worker">
    <input type="hidden" name="log_year">
    <input type="hidden" name="log_month">
    <input type="hidden" name="log_date">
    <input type="hidden" name="log_start_time">
    <input type="hidden" name="log_end_time">

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
                    <button type="button" class="btn btn-confirm" onclick="pop.close(); reserve_change_time();">확인</button>
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
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special4"><input type="checkbox" name="special" id="special4"><em>마운팅</em></label></div>

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
                                            <div class="tab-cell"><button type="button" class="btn-tab-item" id="basic_service_btn"><span>기본 서비스</span></button></div>
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
                <button type="button" class="btn-pop-close" onclick="pop.close(); reserve_pop_init(artist_id);">닫기</button>
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
<article id="reserveAcceptMsg2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg2_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<div class="reserve-calendar-tooltip">
    <div class="tooltip-inner">
        <div class="tooltip-date" id="tooltip-date-text"></div>
        <div class="tooltip-desc" id="tooltip-desc-text"></div>
    </div>
</div>


<article id="approveOnly" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">승인대기중인 예약 <span id="a_cnt">0</span>건 </div>
                    <div class="msg-txt">대기리스트를 확인해주세요.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block" id="close-approve-only" onclick="pop.close();">닫기</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send" onclick="location.href='/booking/reserve_waiting.php';">지금확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="noshow" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">해당 예약정보를 노쇼로 등록을 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cf" onclick="set_noshow(artist_id); location.reload();">확인</button>
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>

                </div>
            </div>

        </div>
    </div>
</article>

<article id="cancel_noshow" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">해당 노쇼를 취소 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cf" onclick="cancel_noshow(); location.reload();">확인</button>
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>

                </div>
            </div>

        </div>
    </div>
</article>


<article id="memberGradeAddPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title">회원등급 부여</h4>
                </div>
                <div class="pop-body">
                    <div class="msg-txt" id="memberGrageMsg"></div>
                    <div class="form-group">
                        <div class="form-group-item">
                            <select id="memberGradeSelect">
                            </select>
                            <div class="form-input-info">선택 후 저장하시면 반영됩니다.</div>
                        </div>
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" id="set_grade_btn">저장</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="numberAddPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view">
                <div class="pop-header">
                    <h4 class="con-title">전화번호 추가</h4>
                </div>
                <div class="pop-body">
                    <div class="phone-add-wrap">
                        <div class="phone-add-list" id="phone_add_list">

                            <!-- 입력 불가시 phone-add-input 클래스에 disabled 클래스 추가 및 input태그에 disabled속성 추가 -->

                        </div>
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-purple" onclick="add_sub_phone(artist_id,true)"><strong>등록하기</strong></button>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>
<article id="reserveAcceptMsg4" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg4_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm " onclick="delete_sub_phone()">확인</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveBeautyGalleryPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">미용 갤러리</h4>
                </div>
                <div class="pop-body">
                    <div class="reserve-beauty-gallery">
                        <div class="shop-gate-picture-select">
                            <div class="list-inner img_wrap" id="beauty_gal_wrap">
                                <div class="list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>
                                <div style="display:block;position:absolute;top:-50px;"><input type="file" accept="image/*" name="imgupfile" id="addimgfile"></div>

                            </div>
                        </div>
                        <div class="picture-add-info">이미지는 최대 25개까지 등록할 수 있습니다.<br>gif, png, jpg, jpeg 형식의 절차 이미지만 등록됩니다.</div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="beautyAgreeWritePop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title" id="beauty_agree_title">미용 동의서 작성</h4>
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">고객 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">고객명</div>
                                            <div class="form-item-data">
                                                <input type="text" maxlength="10" id="agree_name" class="form-control" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">연락처</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="15" id="agree_cellphone" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">품종</div>
                                            <div class="form-item-data type-2">
                                                <div class="pet-breed-select-wrap">
                                                    <div class="pet-breed-select">
                                                        <div class="breed-select">
                                                            <label class="form-toggle-box" for="agree_breed1"><input type="radio" name="agree_breed" class="agree_load-pet-type" value="dog" id="agree_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="agree_breed2"><input type="radio" name="agree_breed" class="agree_load-pet-type" value="cat" id="agree_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="agree_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="agree_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력" id="agree_breed_other" class="form-control">
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
                                                            <select id="agree_birthday_year" class="agree_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_birthday_month" class="agree_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_birthday_date">

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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_gender1"><input type="radio" name="agree_gender" value="남아" id="agree_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_gender2"><input type="radio" name="agree_gender" value="여아" id="agree_gender2"><em>여아</em></label></div>
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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_neutralize1"><input type="radio" name="agree_neutralize" value="0" id="agree_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_neutralize2"><input type="radio" name="agree_neutralize" value="1" id="agree_neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="agree_vaccination">
                                                    <option value="0">선택</option>
                                                    <option value="2차 이하">2차 이하</option>
                                                    <option value="3차">3차 완료</option>
                                                    <option value="4차">4차 완료</option>
                                                    <option value="5차">5차 완료</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">질병기록</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease1"><input type="checkbox" name="disease" id="disease1"><em>없음</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease2"><input type="checkbox" name="disease" id="disease2"><em>심장 질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease3"><input type="checkbox" name="disease" id="disease3"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease4"><input type="checkbox" name="disease" id="disease4" onclick="disease_etc()"><em>기타</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <select id="agree_luxation">
                                                                <option value="0">슬개골탈구</option>
                                                                <option value="없음">없음</option>
                                                                <option value="1기">1기</option>
                                                                <option value="2기">2기</option>
                                                                <option value="3기">3기</option>
                                                                <option value="4기">4기</option>
                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px; display:none;" id="disease_textarea" placeholder="입력"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">특이사항</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special1"><input type="checkbox" name="agree_special" id="agree_special1"><em>입질</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special2"><input type="checkbox" name="agree_special" id="agree_special2"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special3"><input type="checkbox" name="agree_special" id="agree_special3"><em>마운팅</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px;" placeholder="입력" id="special_textarea"></textarea>
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
                    <div class="basic-data-group customer-view-agree">
                        <div class="con-title-group">
                            <h4 class="con-title">미용동의서 상세내용</h4>
                        </div>
                        <div class="customer-view-agree-info" id="agree_info"> </div>
                        <div class="pay-card-group">
                            <div class="pay-card-cell all"><label class="form-checkbox"><input type="checkbox" id="beauty_agree_all_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em><strong>모두 동의</strong></em></span></label></div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" id="beauty_agree_1_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em>미용 동의서</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            1. 백내장, 치주염, 관절염, 당뇨병, 심장질환 등과 같이 노령견에서 흔히 발생하는 질병은 미용 시에 노령견(묘)에게 쇼크 및 스트레스의 원인이 될 수 있으며, 증상이 심각할 경우 사망까지 이를 수 있습니다.
                                            <br><br>
                                            2. 노령견(묘)이나, 예민한 견(묘)의 경우 미용 시 받는 스트레스가 더 심할 수 있습니다. 또한, 미용 및 목욕 시 평소보다 오래 서 있게 되어, 관절에 무리가 올 수 있으며, 이런 경우 미용 후에 일시적으로 다리를 절 수 있습니다.
                                            <br><br>
                                            3. 당일 반려견(묘)의 컨디션이 좋지 않거나, 구토, 설사, 감기 증상이 있을 경우, 미용 후에 증상이 더 심해질 수 있으므로 미용을 미루시는 것이 좋습니다.
                                            <br><br>
                                            4. 목욕 시 적절한 물 온도 유지 및 수압 체크를 하여도 노령견(묘)은 신경계 및 심장혈관 상태가 비교적 약하여, 심장마비로 인한 쇼크 사망사고가 발생할 수도 있습니다.
                                            <br><br>
                                            5. 반려견(묘)의 질병에 대해 사전에 고지하지 않은 경우, 그 질병에 대해 책임지지 않습니다.
                                            <br><br>
                                            6. 미용 전 보이지 않던 피부 질환이 미용 후 노출되어 긁거나 핥아 2차 감염이 발생할 수 있습니다. 미용 전 피부 상태를 잘 확인하시고 주의해주세요.
                                            <br><br>
                                            7. 엉킴이 있는 경우 미용 전 이미 피부가 상해 있는 경우가 많으며, 빗질 혹은 클리핑 시 피부가 붉어지기도 합니다. 최대한 주의하나 이 과정에서 상처가 발생할 수 있음을 미리 고지 드립니다.
                                            <br><br>
                                            8. 미용 전 고지 되지 않은 사항에 의해 일어난 사고는 펫샵에서 책임지지 않습니다.
                                            <br><br>
                                            9. 미용 거부가 심각하거나, 질병적 문제가 있는 경우 미용이 중단될 수 있습니다.
                                            <br><br>
                                            10. 미용 중 엉킴, 길이 등에 대한 추가비용이 발생할 수 있습니다.
                                            <br><br>
                                            11. 반려견(묘) 미용 시 발생할 수 있는 사고를 미용을 요청한 보호자는 인지 하였으며, 이와 관련하여 해당 견(묘)에게 발생하는 사고에 대해 미용을 요청한 보호자는 추후 이의 제기를 하지 않음에 동의합니다.
                                            <br><br>
                                            12. 이 미용 동의서는 작성일 이후부터 차후 미용을 이용하시는 모든 기간에 동일하게 적용됨을 확인합니다.

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" id="beauty_agree_2_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em>개인정보 수집 및 허용</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            개인정보수집/이용/제공 동의서
                                            <br><br>
                                            [개인정보 보호법] 제15조 및 제17조에 따라 아래의 내용으로 개인정보를 수집, 이용 및 제공하는데 동의합니다.
                                            <br><br>
                                            □ 개인정보의 수집 및 이용에 관한 사항
                                            <br><br>
                                            - 수집하는 개인정보 항목 : 이름, 전화번호, 펫정보(품종,몸무게,성별 등 펫 특이사항)과 그 外 미용동의서 기재 내용 일체
                                            <br><br>
                                            - 개인정보의 이용 목적 : 수집된 개인정보를 선택한 펫샵에서 미용작업에 대한 상호(보호자-펫샵)동의를 위해 사용하며, 목적 외의 용도로는 사용하지 않습니다.
                                            <br><br>
                                            □ 개인정보의 보관 및 이용 기간
                                            <br><br>
                                            - 수집, 이용 및 제공목적이 달성될 때 까지, 달성이후 [개인정보 보호법] 제21조에 따라 폐기처리합니다

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customer-view-agree-date">
                            <div class="item-date" id="agree_date"></div>
                            <div class="item-name" id="agree_name2"></div>
                        </div>
                    </div>
                    <div class="basic-data-group small" id="signature_pad">
                        <div class="con-title-group">
                            <h4 class="con-title">서명</h4>
                            <span data-action="clear" id="signature_clear" style="cursor:pointer">서명 지우기</span>
                        </div>
                        <div class="user-sign-wrap" id="user_sign_wrap">
                            <canvas id="cview"></canvas>
                        </div>
                    </div>
                </div>
                <div class="pop-footer type-2" id="beauty_agree_footer">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->

                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>




<article id="beautyAgreeViewPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title" id="beauty_agree_title">미용 동의서 보기</h4>
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">고객 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">고객명</div>
                                            <div class="form-item-data">
                                                <input type="text" maxlength="10" id="agree_view_name" readonly class="form-control" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">연락처</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="15" readonly id="agree_view_cellphone" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">품종</div>
                                            <div class="form-item-data type-2">
                                                <div class="pet-breed-select-wrap">
                                                    <div class="pet-breed-select">
                                                        <div class="breed-select">
                                                            <label class="form-toggle-box" for="agree_view_breed1"><input type="radio" name="agree_view_breed" class="agree_view_load-pet-type" value="dog" id="agree_view_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="agree_view_breed2"><input type="radio"  name="agree_view_breed" class="agree_view_load-pet-type" value="cat" id="agree_view_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="agree_view_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="agree_view_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력"  disabled id="agree_view_breed_other" class="form-control">
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
                                                            <select id="agree_view_birthday_year" onclick="return false;" class="agree_view_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_view_birthday_month" onclick="return false;"class="agree_view_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_view_birthday_date" onclick="return false;">

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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_gender1"><input type="radio" name="agree_view_gender" onclick="return false;"  value="남아" id="agree_view_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_gender2"><input type="radio" name="agree_view_gender" onclick="return false;"  value="여아" id="agree_view_gender2"><em>여아</em></label></div>
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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_neutralize1"><input type="radio" onclick="return false;" name="agree_view_neutralize" value="0" id="agree_view_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_neutralize2"><input type="radio" onclick="return false;" name="agree_view_neutralize" value="1" id="agree_view_neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="agree_view_vaccination" onclick="return false;">
                                                    <option value="0">선택</option>
                                                    <option value="2차 이하">2차 이하</option>
                                                    <option value="3차">3차 완료</option>
                                                    <option value="4차">4차 완료</option>
                                                    <option value="5차">5차 완료</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">질병기록</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease1"><input type="checkbox"  onclick="return false;" name="agree_view_disease" id="agree_view_disease1"><em>없음</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease2"><input type="checkbox" onclick="return false;" name="agree_view_disease" id="agree_view_disease2"><em>심장 질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease3"><input type="checkbox"  onclick="return false;" name="agree_view_disease" id="agree_view_disease3"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease4"><input type="checkbox" onclick="return false;" name="agree_view_disease" id="agree_view_disease4"><em>기타</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <select id="agree_view_luxation" onclick="return false;">
                                                                <option value="0">슬개골탈구</option>
                                                                <option value="없음">없음</option>
                                                                <option value="1기">1기</option>
                                                                <option value="2기">2기</option>
                                                                <option value="3기">3기</option>
                                                                <option value="4기">4기</option>
                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px; display:none;" id="agree_view_disease_textarea" placeholder="입력" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">특이사항</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special1"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special1"><em>입질</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special2"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special2"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special3"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special3"><em>마운팅</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px;" placeholder="입력" id="agree_view_special_textarea" readonly></textarea>
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
                    <div class="basic-data-group customer-view-agree">
                        <div class="con-title-group">
                            <h4 class="con-title">미용동의서 상세내용</h4>
                        </div>
                        <div class="customer-view-agree-info" id="agree_view_info"> </div>
                        <div class="pay-card-group">
                            <div class="pay-card-cell all"><label class="form-checkbox"><input type="checkbox"  checked disabled name="payCard"><span class="form-check-icon"><em><strong>모두 동의</strong></em></span></label></div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" checked disabled name="payCard"><span class="form-check-icon"><em>미용 동의서</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            1. 백내장, 치주염, 관절염, 당뇨병, 심장질환 등과 같이 노령견에서 흔히 발생하는 질병은 미용 시에 노령견(묘)에게 쇼크 및 스트레스의 원인이 될 수 있으며, 증상이 심각할 경우 사망까지 이를 수 있습니다.
                                            <br><br>
                                            2. 노령견(묘)이나, 예민한 견(묘)의 경우 미용 시 받는 스트레스가 더 심할 수 있습니다. 또한, 미용 및 목욕 시 평소보다 오래 서 있게 되어, 관절에 무리가 올 수 있으며, 이런 경우 미용 후에 일시적으로 다리를 절 수 있습니다.
                                            <br><br>
                                            3. 당일 반려견(묘)의 컨디션이 좋지 않거나, 구토, 설사, 감기 증상이 있을 경우, 미용 후에 증상이 더 심해질 수 있으므로 미용을 미루시는 것이 좋습니다.
                                            <br><br>
                                            4. 목욕 시 적절한 물 온도 유지 및 수압 체크를 하여도 노령견(묘)은 신경계 및 심장혈관 상태가 비교적 약하여, 심장마비로 인한 쇼크 사망사고가 발생할 수도 있습니다.
                                            <br><br>
                                            5. 반려견(묘)의 질병에 대해 사전에 고지하지 않은 경우, 그 질병에 대해 책임지지 않습니다.
                                            <br><br>
                                            6. 미용 전 보이지 않던 피부 질환이 미용 후 노출되어 긁거나 핥아 2차 감염이 발생할 수 있습니다. 미용 전 피부 상태를 잘 확인하시고 주의해주세요.
                                            <br><br>
                                            7. 엉킴이 있는 경우 미용 전 이미 피부가 상해 있는 경우가 많으며, 빗질 혹은 클리핑 시 피부가 붉어지기도 합니다. 최대한 주의하나 이 과정에서 상처가 발생할 수 있음을 미리 고지 드립니다.
                                            <br><br>
                                            8. 미용 전 고지 되지 않은 사항에 의해 일어난 사고는 펫샵에서 책임지지 않습니다.
                                            <br><br>
                                            9. 미용 거부가 심각하거나, 질병적 문제가 있는 경우 미용이 중단될 수 있습니다.
                                            <br><br>
                                            10. 미용 중 엉킴, 길이 등에 대한 추가비용이 발생할 수 있습니다.
                                            <br><br>
                                            11. 반려견(묘) 미용 시 발생할 수 있는 사고를 미용을 요청한 보호자는 인지 하였으며, 이와 관련하여 해당 견(묘)에게 발생하는 사고에 대해 미용을 요청한 보호자는 추후 이의 제기를 하지 않음에 동의합니다.
                                            <br><br>
                                            12. 이 미용 동의서는 작성일 이후부터 차후 미용을 이용하시는 모든 기간에 동일하게 적용됨을 확인합니다.

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox"  checked disabled name="payCard"><span class="form-check-icon"><em>개인정보 수집 및 허용</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            개인정보수집/이용/제공 동의서
                                            <br><br>
                                            [개인정보 보호법] 제15조 및 제17조에 따라 아래의 내용으로 개인정보를 수집, 이용 및 제공하는데 동의합니다.
                                            <br><br>
                                            □ 개인정보의 수집 및 이용에 관한 사항
                                            <br><br>
                                            - 수집하는 개인정보 항목 : 이름, 전화번호, 펫정보(품종,몸무게,성별 등 펫 특이사항)과 그 外 미용동의서 기재 내용 일체
                                            <br><br>
                                            - 개인정보의 이용 목적 : 수집된 개인정보를 선택한 펫샵에서 미용작업에 대한 상호(보호자-펫샵)동의를 위해 사용하며, 목적 외의 용도로는 사용하지 않습니다.
                                            <br><br>
                                            □ 개인정보의 보관 및 이용 기간
                                            <br><br>
                                            - 수집, 이용 및 제공목적이 달성될 때 까지, 달성이후 [개인정보 보호법] 제21조에 따라 폐기처리합니다

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customer-view-agree-date">
                            <div class="item-date" id="agree_view_date"></div>
                            <div class="item-name" id="agree_view_name2"></div>
                        </div>
                    </div>
                    <div class="basic-data-group small" id="signature_pad">
                        <div class="con-title-group">
                            <h4 class="con-title">서명</h4>
                        </div>
                        <div class="user-sign-wrap" id="user_sign_wrap">
                            <img src="" alt="" id="user_sign_img">
                        </div>
                    </div>
                </div>
                <div class="pop-footer type-2" id="beauty_agree_footer">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->

                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="petModifyPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">펫 정보 수정하기</h4>
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>펫 이름</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="20" id="modify_customer_name" placeholder="펫 이름 입력">
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
                                                            <label class="form-toggle-box" for="modify_breed1"><input type="radio" name="modify_breed" class="modify_load-pet-type" value="dog" id="modify_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="modify_breed2"><input type="radio" name="modify_breed" class="modify_load-pet-type" value="cat" id="modify_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="modify_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="modify_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력" id="modify_breed_other" class="form-control">
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
                                                            <select id="modify_birthday_year" class="modify_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="modify_birthday_month" class="modify_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="modify_birthday_date">

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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_gender1"><input type="radio" name="modify_gender" value="남아" id="modify_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_gender2"><input type="radio" name="modify_gender" value="여아" id="modify_gender2"><em>여아</em></label></div>
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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_neutralize1"><input type="radio" name="modify_neutralize" value="0" id="modify_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_neutralize2"><input type="radio" name="modify_neutralize" value="1" id="modify_neutralize2"><em>O</em></label></div>
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
                                                    <select class="inline-block" id="modify_weight1">

                                                    </select>
                                                    <div class="form-unit-point">.</div>
                                                    <select class="inline-block" id="modify_weight2">
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
                                                <select id="modify_beauty_exp">
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
                                                <select id="modify_vaccination">
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
                                                <select id="modify_bite">
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
                                                <select id="modify_luxation">
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
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_special1"><input type="checkbox" name="modify_special" id="modify_special1"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_special2"><input type="checkbox" name="modify_special" id="modify_special2"><em>심장질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_special3"><input type="checkbox" name="modify_special" id="modify_special3"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_special4"><input type="checkbox" name="modify_special" id="modify_special4"><em>마운팅</em></label></div>
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
                <div class="pop-footer type-2">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                    <a href="#" class="btn-page-bottom" id="modify_pet_info_btn">저장</a>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="only_change_time" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">예약시간을 변경 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cf" onclick="pop.open('reserveChange'); ">확인</button>
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>

                </div>
            </div>

        </div>
    </div>
</article>

<article id="reserveChange" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">예약변경 알림톡을 발송 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block change-cls" id="change_cls" onclick="set_change_time(true)">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send change-cls" onclick="set_change_time(false);">미발송</button>
                </div>
            </div>
        </div>
    </div>
</article>


<article id="reservePayManagementMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data middle">
                <div class="pop-body">
                    <div class="msg-title">날짜/ 미용사 변경</div>
                    <div class="msg-txt">1. 변경을 위해 주간 스케줄로 이동합니다.<br>현재 페이지에서 저장하지 않은 정보는 분실될 수 있으니 변경전에 확인해주세요.<br><br>2. 변경을 완료하기 전에 다른 페이지로 이동하면 오류가 발생할 수 있으니 주의해주세요.<br><br>변경하시겠습니까?<br><br>[주의] 주간 스케줄표에서만 변경 가능합니다!</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" id="change_check_btn" onclick="change_check()">변경</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveCancel" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">예약취소 알림톡을 발송 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block cancel-cls" onclick="reserve_cancel(true) pop.close();">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send cancel-cls" onclick="reserve_cancel(false); pop.close();">미발송</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="customerAlarmInquiryPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">알림톡 발송이력 조회</h4>
                </div>
                <div class="pop-body">
                    <div class="customer-alarm-inquiry">
                        <div class="basic-data-group">
                            <div class="board-sort-wrap">
                                <div class="left">
                                    <div class="form-datepicker-group">
                                        <div class="form-datepicker"><input type="text" class="datepicker-start" value="<?php echo date('Y-m-d', strtotime(DATE('Y-m-d')."-1 days"));?>"></div>
                                        <div class="form-unit">~</div>
                                        <div class="form-datepicker"><input type="text" class="datepicker-end" value="<?php echo DATE('Y-m-d'); ?>"></div>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="board-sort-btns">
                                        <button type="button" class="btn-data-refresh">초기화</button>
                                        <a href="#" class="btn btn-purple btn-inline btn-basic-small pop_inquiry">조회</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basic-data-group vvsmall3">
                            <div class="con-title-group">
                                <input type="hidden" id="allim_cellphone_val" class="allim_cellphone_val" value="">
                                <h5 class="con-title"><span id="allim_cellphone"></span> 고객님의 발송이력 조회입니다.</h5>
                            </div>
                            <div>
                                <!-- 검색결과 있을 때 -->
                                <div class="customer-alarm-result do_allim">
                                    <table class="customer-table">
                                        <colgroup>
                                            <col style="width:20%">
                                            <col style="width:15%">
                                            <col style="width:46%">
                                            <col style="width:19%">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th>발송시간</th>
                                            <th>구분</th>
                                            <th>내용</th>
                                            <th>결과</th>
                                        </tr>
                                        </thead>
                                        <tbody id="allim_table">
                                        <tr>
                                            <td class="">2021.12.25<br>13:25</td>
                                            <td class="">예약등록</td>
                                            <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                            <td class="">알림톡 발송</td>
                                        </tr>
                                        <tr>
                                            <td class="">2021.12.25<br>13:25</td>
                                            <td class="">예약등록</td>
                                            <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                            <td class="">알림톡 발송</td>
                                        </tr>
                                        <tr>
                                            <td class="">2021.12.25<br>13:25</td>
                                            <td class="">예약등록</td>
                                            <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                            <td class="">알림톡 발송</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- //검색결과 있을 때 -->
                                <!-- 검색결과 없을 때 -->
                                <div class="list-none-data none_allim">검색 결과가 없습니다.</div>
                                <!-- //검색결과 없을 때 -->
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="talkExam" class="layer-pop-wrap" style="z-index: 100000;">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">
                        <img src="/static/images/exam_talk.jpg" alt="미용 종료 알림 발송톡 예시 입니다.">
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                </div>
            </div>

        </div>
    </div>
</article>

<script src="/static/js/common.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/Sortable.min.js"></script>
<script src="/static/js/shop.js"></script>
<script src="/static/js/signature_pad.umd.js"></script>
<script src="/static/js/jquery-ui.min.js"></script>

<script src="/static/js/booking.js"></script>
<script src="/static/js/customer.js"></script>
<script>

    let artist_id = "<?=$artist_id?>";
    let session_id = "<?=session_id()?>"

    // data_set(artist_id)


    $(document).ready(function(){

        get_navi(artist_id)

        gnb_init();
        wide_tab();
        wide_tab_2();
        wide_tab_3();
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
        reserve_regist_tab();
        setInputFilter(document.getElementById("reserve_cellphone"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })



        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type();
        customer_new_weight()
        modify_new_birthday().then(function(){ modify_new_birthday_date()})
        modify_pet_type();
        modify_new_weight()
        reserve_merchandise_load_event(artist_id)
        reserve_regist_event(artist_id,session_id);
        reserve_time().then(function (){reserve_time_date()});
        reserve_time_init()
        waiting(artist_id)
        setTimeout(function(){


            sessionStorage.removeItem('waiting');
        },300)

        new_exist_check(artist_id);
        agree_birthday().then(function(){ agree_birthday_date()})
        agree_pet_type(artist_id);

        agree_view_birthday().then(function(){ agree_view_birthday_date()})
        agree_view_pet_type(artist_id);



    })

    let wrapper = document.getElementById('signature_pad');
    let clear_btn = document.getElementById('signature_clear');

    let canvas = document.getElementById('cview');

    let signature_pad = new SignaturePad(canvas,{

        backgroundColor:'rgb(255,255,255)'
    })

    canvas.width = canvas.parentElement.offsetWidth-2;
    canvas.height=canvas.parentElement.offsetHeight-2;


    clear_btn.addEventListener("click", function (event) {
        signature_pad.clear();
    });



    $(".datepicker-start").datepicker({
        showOn: "both",
        buttonImage: "../static/images/icon/icon-datepicker_black.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',//포맷 설정
        prevText: '이전 달',//이전 버튼
        nextText: '다음 달', //다음달 버튼
        monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],//월 설정
        monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'], //월 설정
        dayNames: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesShort: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesMin: ['일','월','화','수','목','금','토'], //주 타이틀 설정
        minDate: new Date('2021-06-05'),
        showMonthAfterYear: true, // 년도가 앞으로 설정
        yearSuffix: '.', //년도 뒤 블릿 설정
        changeMonth: false, //월 선택 불가
        changeYear: false, //년 선택 불가
        showOtherMonths:true, //이전 , 다음 달 일수 활성화
    });

    $(".datepicker-end").datepicker({
        showOn: "both",
        buttonImage: "../static/images/icon/icon-datepicker_black.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',//포맷 설정
        prevText: '이전 달',//이전 버튼
        nextText: '다음 달', //다음달 버튼
        monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],//월 설정
        monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'], //월 설정
        dayNames: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesShort: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesMin: ['일','월','화','수','목','금','토'], //주 타이틀 설정
        minDate: new Date('2021-06-05'),
        showMonthAfterYear: true, // 년도가 앞으로 설정
        yearSuffix: '.', //년도 뒤 블릿 설정
        changeMonth: false, //월 선택 불가
        changeYear: false, //년 선택 불가
        showOtherMonths:true, //이전 , 다음 달 일수 활성화
    });



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


    document.querySelector('.pay-btn-detail-toggle').addEventListener('click',function(){

        if(document.querySelector('.pay-service-selected-wrap').style.display === 'none'){
            document.querySelector('.pay-btn-detail-toggle').classList.add('actived');
            document.querySelector('.pay-service-selected-wrap').style.display = 'block';
        }else{
            document.querySelector('.pay-btn-detail-toggle').classList.remove('actived')
            document.querySelector('.pay-service-selected-wrap').style.display = 'none';
        }


    })

    $(document).on('mouseenter mouseleave mousemove' , '.calendar-week-time-item' , function(e){
        //console.log($(this).data('payment_idx'));
		var x = e.pageX;
		var y = e.pageY;
        var tooltip = $('.reserve-calendar-tooltip');
        var idx = $(this).data('tooltip_idx');
        let height;

		/* 확장용 */
		if(e.type == 'mouseenter'){
			$(this).addClass('actived');
            if(parseInt($(this).attr('data-height')) <4){
                $(this).attr('style',`height:${$(this).children()[0].offsetHeight}px`)
            }

            if(memo_array[idx] == ''){
                return;
            }
            tooltip.addClass('actived');
            document.getElementById("tooltip-date-text").innerHTML = "특이 사항";
            document.getElementById("tooltip-desc-text").innerHTML = memo_array[idx];
		}else if(e.type == 'mouseleave'){
			$(this).removeClass('actived');
            tooltip.removeClass('actived');
            $(this).attr('style',`height: calc(100% * ${$(this).attr('data-height')})`)
		}else if(e.type == 'mousemove'){
            tooltip.css({'top' : y , 'left' : x});
        }

	});

});
</script>
</body>
</html>