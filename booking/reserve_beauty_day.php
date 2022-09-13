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
                                </div>
                                <div class="pay-card-body">
                                    <div class="pay-card-body-inner">
                                        <div class="pay-card-content-1">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">예약자 정보</h4>
                                                <div class="pay-noshow btn btn-red btn-small-size btn-round ">노쇼 등록</div>
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
                                                                    <div class="icon icon-grade-vip">

                                                                    </div>
                                                                    <div class="icon-grade-label">
                                                                        vip
                                                                    </div>
                                                                </div>
                                                                <div class="pay-flex-table-data-side">
                                                                    <button type="button" class="pay-grade-modify"></button>
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
                                                                <div class="pay-user-cellphone">
                                                                    010-5390-6571
                                                                </div>
                                                            </dlv>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-flex-table-cell">
                                                    <div class="pay-flex-table-item">
                                                        <div class="pay-flex-table-title">
                                                            <div class="pay-txt">보조 연락처</div>
                                                            <div class="call-edit">
                                                                <span>편집</span>
                                                            </div>
                                                        </div>
                                                        <div class="pay-flex-table-data">
                                                            <div class="pay-flex-table-data-inner">
                                                                <div class="pay-user-sub-cellphone">


                                                                    <div class="pay-user-sub-cellphone-name">테스트</div>
                                                                    <div class="pay-user-sub-cellphone-number">010-5390-6572</div>
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
                                                <textarea name="pay-customer-memo-text" cols="30" rows="10"></textarea>
                                                <button type="button" class="pay-customer-memo-save btn btn-outline-purple btn-middle-size btn-round">저장</button>
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
                                                            <img src="" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="pay-item-user-info">
                                                        <div class="pay-item-user-info-inner">
                                                            <div class="pay-pet-name">죠르디</div>
                                                            <div class="pay-pet-cate">말티즈</div>
                                                        </div>
                                                    </div>
                                                    <div class="pay-item-action">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-2">
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round">미용 갤러리</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-2">
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round">미용동의서 작성</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-1">
                                                                    <a href="#" class="btn btn-outline-purple btn-middle-size btn-round">펫 정보 수정</a>
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    남아
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    O
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    0.2kg
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    2년 8개월
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    안해요
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
                                                                <div class="pay-flex-table-data-inner">
                                                                    없음
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
                                                            <div class="pay-list-data">3회</div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">예방 접종</div>
                                                            <div class="pay-list-data">2차 이하</div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">특이사항</div>
                                                            <div class="pay-list-data">피부병</div>

                                                        </div>
                                                        <div class="pay-service-selected-group">
                                                            <div class="pay-list-title">기타</div>
                                                            <div class="pay-list-data">기타</div>

                                                       </div>
                                                    </div>

                                                </div>
                                                <div class="pay-special-memo">
                                                    <div class="pay-special-memo-title">
                                                        <div class="pay-txt">특이사항<span class="pay-sub-txt"> (고객에게는 노출되지 않습니다.)</span></div>
                                                    </div>
                                                    <textarea name="pay-special-memo-text" cols="30" rows="10"></textarea>
                                                    <button type="button" class="pay-special-memo-save btn btn-outline-purple btn-middle-size btn-round">저장</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="pay-card-content-3">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">이전 미용</h4>
                                            </div>
                                            <div class="pay-before-beauty-list">
                                                <div class="pay-before-beauty-item">
                                                    <span class="pay-before-beauty-memo">
                                                        2022.09.04 / / Kg / 0원
                                                    </span>
                                                    <a href="#" class="pay-before-beauty-detail">
                                                        <span class="pay-before-beauty-detail-memo">상세보기</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="5.207" height="9.414" viewBox="0 0 5.207 9.414">
                                                            <path data-name="Path" d="m-4 8 4-4-4-4" transform="translate(4.707 .707)" style="fill:none;stroke:#202020;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="pay-card-content-4">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">예약 내용</h4>
                                                <button type="button" class="btn-side btn btn-small-size btn-inline btn-border-radius-16 btn-bg-yellow">알림톡 발송 이력</button>
                                            </div>
                                            <div class="pay-text-list-wrap">
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        날짜
                                                    </div>
                                                    <div class="pay-item-data">
                                                        2022.09.11
                                                    </div>
                                                </div>
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        선생님
                                                    </div>
                                                    <div class="pay-item-data">실장</div>
                                                </div>
                                                <div class="pay-text-list-cell">
                                                    <div class="pay-text-list-title unit">
                                                        시간
                                                    </div>
                                                    <div class="pay-item-data">
                                                        <div class="pay-datepicker-group">
                                                            <div class="pay-form-datepicker">
                                                                <select name="pay_from_time" id="pay_from_time">
                                                                    <option>casd</option>
                                                                </select>
                                                            </div>
                                                            <div class="pay-form-unit">
                                                                ~
                                                            </div>
                                                            <div class="pay-form-datepicker">

                                                                <select name="pay_to_time" id="pay_to_time">
                                                                    <option>casd</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pay-basic-data-group">
                                                    <button type="button" class="only-change-time btn btn-outline-gray btn-middle-size btn-round">시간만 변경</button>
                                                </div>
                                                <div class="pay-form-bottom-info">
                                                    *시간 변경만 하는 경우 시간선택 후 눌러주세요.
                                                </div>

                                            </div>

                                            <div class="pay-basic-data-group-2">
                                                <div class="grid-layout btn-grid-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round">날짜/미용사 변경</button>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round">예약 취소</button>
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
                                                                <input type="radio" name="time1" class="timer" id="timer_0" value="y">
                                                                <em>10분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_0" value="y">
                                                                <em>15분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_0" value="y">
                                                                <em>20분전</em>
                                                            </label>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <label class="form-toggle-box block">
                                                                <input type="radio" name="time1" class="timer" id="timer_0" value="y">
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
                                                            <button type="button" class="btn btn-outline-gray btn-middle-size btn-round">예시보기</button>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round">발송</button>
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



<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/Sortable.min.js"></script>

<script src="../static/js/booking.js"></script>
<script src="../static/js/customer.js"></script>
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
        reserve_merchandise_load_event(artist_id)
        reserve_regist_event(artist_id,session_id);
        reserve_time().then(function (){reserve_time_date()});
        reserve_time_init()
        waiting(artist_id)
        setTimeout(function(){


            sessionStorage.removeItem('waiting');
        },300)

        new_exist_check(artist_id);



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