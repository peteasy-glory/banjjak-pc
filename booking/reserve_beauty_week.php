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
                        <div class="main-col-group main-side-1" style="margin-bottom:20px;">
                            <!-- 전화번호 검색 -->
                            <form action="/customer/customer_inquiry.php" id="search_form" method="get">
                                <div class="basic-data-card transparent main-phone-group">
                                    <div class="main-phone">

                                        <div class="item-input"><input type="text" class="text-add" name="search" id="search" placeholder="전화번호 또는 펫이름 입력"></div>

                                        <button type="button" class="btn-main-phone" onclick="document.getElementById('search').value === '' ? pop.open('firstRequestMsg1','전화번호 또는 펫이름을 입력해주세요.'):document.getElementById('search_form').submit()">검색</button>

                                    </div>
                                </div>
                            </form>
                            <!-- //전화번호 검색 -->
                        </div>

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
                                                        <div class="loading-container" id="week_mini_calendar_loading">
                                                            <img src="/static/images/loading.gif" alt="">
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
										<div class="total-text-cell"><div class="item-title">미용 예약</div><div class="item-value" id="day_total"></div></div>
                                        <div class="total-text-cell"><div class="item-title">NO SHOW</div><div class="item-value" id="day_noshow"></div></div>
                                        <div class="total-text-cell"><div class="item-title">예약 취소</div><div class="item-value" id="day_cancel"></div></div>
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
                                        <button type="button" onclick="localStorage.setItem('day_select',`${new Date().getFullYear()}.${fill_zero(new Date().getMonth()+1)}.${fill_zero(new Date().getDate())}`); location.href='./reserve_beauty_day.php' " class="btn-reserve-calendar-sort" style="font-size:15px;">오늘</button>
										<button type="button" onclick="location.href='./reserve_beauty_month.php';" class="btn-reserve-calendar-sort">월</button>
										<button type="button" class="btn-reserve-calendar-sort actived">주</button>
										<button type="button" onclick="location.href='./reserve_beauty_day.php';" class="btn-reserve-calendar-sort">일</button>
										<button type="button" onclick="location.href='./reserve_beauty_list.php';"class="btn-reserve-calendar-sort"><span class="icon icon-type-list-gray off"></span><span class="icon icon-type-list-white on"></span></button>
									</div>
								</div>
								<!-- //캘린더 상단 -->
							</div>
                            <div class="loading-container" id="week_schedule_loading">
                                <img src="/static/images/loading.gif" alt="">
                            </div>
							<div class="card-body" id="week_schedule_card_body">
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
														<div class="calendar-week-header-col calendar-week-header-col-add sunday" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="0">(일)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add " style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="1">(월)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="2">(화)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="3">(수)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="4">(목)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="5">(금)</div></div>
														<div class="calendar-week-header-col calendar-week-header-col-add" style="cursor: pointer" onclick="localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${this.children[0].innerText}`); location.href='/booking/reserve_beauty_day.php'"><div class="day week-date"></div><div class="th week-day-check" data-day="6">(토)</div></div>
													</div>
												</div>
                                                <div class="loading-container" id="week_mini_calendar_loading">
                                                    <img src="/static/images/loading.gif" alt="">
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
                        <article id="pay_management" class="pay_management">

                            <div class="shortcut-wrap" id="shortcutWrap" style="display: flex; opacity: 1;">
                                <a href="#pay_card_header" class=""><img src="/static/images/icon-page-top.png" alt="" id="shortcut1" style="display: block;"></a>
                                <a href="#scroll_target"><img src="/static/images/icon-reserve.png" alt="" "></a>
                                <a href="#sticky-tab-group-target"><img src="/static/images/icon-pay.png" alt="" "></a>

                            </div>

                            <div class="pay-data-card">
                                <div class="pay-card-header" id="pay_card_header">
                                    <div class="pay-card-header-title">작업/결제 관리</div>
                                    <div class="pay-close-btn" id="pay_close_btn" onclick="pay_management_toggle(true)">></div>
                                </div>
                                <div class="pay-card-body">
                                    <div class="loading-container" id="pay_management_loading">
                                        <img src="/static/images/loading.gif" alt="">
                                    </div>
                                    <div class="pay-card-body-inner" id="pay_card_body_inner">



                                        <div class="pay-card-content-2">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">예약동물 정보</h4>
                                            </div>
                                            <div class="pay-customer-pet-group">
                                                <div class="pay-customer-view-pet-picture">
                                                    <div class="pay-item-thumb">
                                                        <div class="user-thumb large" id="pay_thumb">
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
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round" id="pay_beauty_gal_btn" onclick="beauty_gallery_get(this,artist_id).then(function(pet_seq){ beauty_gallery_add(artist_id,pet_seq)})">미용 갤러리</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-2" id="beauty_agree_view">
                                                                    <a href="#" class="btn btn-outline-gray btn-middle-size btn-round">미용동의서</a>
                                                                </div>
                                                                <div class="grid-layout-cell grid-1">
                                                                    <a href="#" class="btn btn-outline-purple btn-middle-size btn-round"  id="modify_pet" onclick="pay_management_modify_pet(this).then(function(body){ pay_management_modify_pet_(body)});">펫 정보 수정</a>
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
                                                                    <button type="button" class="pay-grade-modify" id="pay_grade_btn"  onclick="pay_get_grade(this,artist_id)"></button>
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
                                        <div class="pay-card-content-3-2 is_approve">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">이전 특이사항</h4>
                                            </div>
                                            <div class="pay-before-beauty-list" id="pay_before_special_list">

                                            </div>

                                            <button type="button" class="pay-btn-detail-toggle-3" style=" margin:0 auto; margin-top:16px; margin-bottom:20px;">
                                                이전 특이사항 더보기
                                            </button>
                                            <div class="pay-before-beauty-list" id="pay_before_special_list_more" style="display: none;">

                                            </div>


                                        </div>
                                        <div class="pay-card-content-3 is_approve">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">이전 미용</h4>
                                            </div>
                                            <div class="pay-before-beauty-list" id="pay_before_beauty_list">

                                            </div>
                                            <button type="button" class="pay-btn-detail-toggle-2" style=" margin:0 auto; margin-top:16px; margin-bottom:20px;">
                                                이전 미용 더보기
                                            </button>
                                            <div class="pay-before-beauty-list" id="pay_before_beauty_list_more" style="display: none;">

                                            </div>

                                        </div>
                                        <div class="pay-card-content-4 is_approve" id="scroll_target">
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
                                        <div class="pay-card-content-5 is_approve">
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
                                                            <button type="button" class="btn btn-outline-purple btn-middle-size btn-round" id="allim_send_btn" onclick="allim_talk_send_change_time(this)">발송</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sticky-tab-group is_approve" id="sticky-tab-group-target">
                                            <div class="pay-card-content-6">
                                                <div class="pay-card-body-title">
                                                    <h4 class="con-title">결제 정보</h4>
                                                </div>
                                            </div>
                                            <div class="wide-tab pay-wide-tab">
                                                <div class="wide-tab-inner" id="wide-tab-inner3">
                                                    <div class="tab-cell actived">
                                                        <button type="button" class="btn-tab-item btn-tab-item-add"  onclick="target_event(this)" id="payment_basic_service_btn">
                                                            <span>
                                                                기본 서비스
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item btn-tab-item-add" onclick="target_event(this)" id="payment_other_service_btn">
                                                            <span>
                                                                추가
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item btn-tab-item-add" onclick="target_event(this)" id="payment_other2_service_btn">
                                                            <span>
                                                                쿠폰상품
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="tab-cell">
                                                        <button type="button" class="btn-tab-item btn-tab-item-add" onclick="target_event(this)" id="payment_other3_service_btn">
                                                            <span>
                                                                제품
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="basic-data-group vmiddle tab-data-group is_approve">
                                            <input type="hidden" value="" id="customer_id">
                                            <input type="hidden" value="" id="pet_seq">
                                            <input type="hidden" value="" id="is_vat">
                                            <!-- tab-data-cell 클래스에 actived클래스 추가시 활성화-->
                                            <!-- 기본 서비스 -->
                                            <div class="tab-data-cell basic_service actived" id="payment_basic_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="payment_basic_service_inner">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-data-cell basic_service actived" id="payment_basic_service_cat">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="payment_basic_service_inner_cat">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //기본 서비스 -->
                                            <!-- 추가 -->
                                            <div class="tab-data-cell basic_service" id="payment_other_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="payment_other_service_inner">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-data-cell basic_service" id="payment_other_service_cat">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="payment_other_service_inner_cat">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //추가 -->
                                            <!-- 쿠폰상품 -->
                                            <div class="tab-data-cell basic_service" id="other2_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="other2_service_inner">

                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item" id="c_coupon">
                                                                <div class="form-item-label display_flex_ju_center font-size-12">쿠폰상품</div>

                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2" >
                                                            <div class="form-group-item" id="f_coupon">
                                                                <div class="form-item-label display_flex_ju_center font-size-12">정액상품</div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //쿠폰상품 -->
                                            <!-- 제품 -->
                                            <div class="tab-data-cell basic_service" id="other3_service">
                                                <div class="grid-layout basic">
                                                    <div class="grid-layout-inner" id="other3_service_inner">
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label font-size-12 display_flex_ju_center">용품</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_1">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label font-size-12 display_flex_ju_center">간식</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label font-size-12 display_flex_ju_center">사료</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_3">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-4">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label font-size-12 display_flex_ju_center">기타</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="toggle-button-group vertical" id="etc_product_list_4">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pay-product-save-btn-wrap sticky-bottom" style="position:sticky; bottom:40px; margin-bottom:50px;">


                                                <button type="button" class="sticky-bottom-inner pay-product-save btn btn-outline-purple btn-middle-size btn-round" id="sticky-bottom" onclick="pay_management_product_change(this)">변경</button>
                                            </div>

                                            <div class="pay-basic-data-group-2  basic-data-group vvsmall2" id="receipt">
                                                <div class="user-receipt-item user-receipt-item-add">
                                                    <div class="receipt-buy-detail">
                                                        <div class="item-data-list" id="service_list">

                                                        </div>

                                                    </div>
                                                    <div class="receipt-buy-detail total-price" style="border-top: 1px solid #f4f4f4; margin-top: 12px; padding-top: 12px;">
                                                        <div class="item-data-list" id="price_list">
                                                            <div class="list-cell">
                                                                <div class="list-title"><strong>합산 금액</strong></div>
                                                                <div class="list-value"><strong id="total_price"></strong></div>
                                                            </div>

                                                            <div class="list-cell" id="is_vat_list" style="display: none;">
                                                                <div class="list-title"><strong>부가세 10%</strong></div>
                                                                <div class="list-value"><strong id="vat"></strong></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="receipt-buy-detail result-price">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title font-color-purple"><strong>총 결제 합산 금액</strong></div>
                                                                <div class="list-value font-color-purple"><strong id="real_total_price" value="0"></strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pay-card-content-6-1 is_approve" id="pet_shop_coupon" style="display: none;">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">보유 쿠폰</h4>
                                            </div>

                                            <div class="user-receipt-wrap">


                                                <div class="form-group user-receipt-item pay-user-receipt">
                                                    <div class="form-group-cell small">
                                                        <div class="form-group-item">
                                                            <div class="form-item-label">쿠폰 명</div>
                                                            <div class="form-item-data type-2">
                                                                <div class="form-control-btns">
                                                                    <select name="coupon_name" id="coupon_name" onchange="user_coupon_change()">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-cell small">
                                                        <div class="grid-layout basic">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-60">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">보유</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="form-control-btns">
                                                                                <select name="coupon_balance" id="coupon_balance">
                                                                                    <option value="">선택</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-40">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">차감</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="form-control-btns">
                                                                                <select name="use_coupon" id="use_coupon">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-cell small">
                                                        <button type="button" class="btn btn-outline-purple btn-middle-size btn-round use-coupon" id="coupon_use" onclick="coupon_use(this);">적용</button>
                                                        <div class="form-bottom-info font-color-purple font-weight-500 text-align-right">적용 후 남은 쿠폰 : <span id="remind_coupon">0</span></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>



                                        <div class="pay-card-content-7 is_approve">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">단골 고객 할인</h4>
                                            </div>

                                            <div class="user-receipt-wrap">


                                                <div class="user-receipt-item pay-user-receipt"><div class="regular-user-confirm ">
                                                        <div class="info" style="font-size:13px !important;">*원하시는 할인방법을 선택하신 후 적용을 누르세요.</div>
                                                        <div class="regular-user-confirm-select">
                                                            <div class="regular-user-confirm-input">
                                                                <div class="item-check"><label class="form-radiobox">
                                                                        <input type="radio" id="discount_1_btn" name="discount_radio">


                                                                        <span class="form-check-icon"><em>퍼센트할인</em></span></label></div>
                                                                <div class="item-data">
                                                                    <select id="discount_1">

                                                                    </select>

                                                                    <div class="unit">%</div>
                                                                </div>
                                                            </div>
                                                            <div class="regular-user-confirm-input">
                                                                <div class="item-check"><label class="form-radiobox">
                                                                        <input type="radio" id="discount_2_btn" name="discount_radio" class="discount_radio" value="won_type"><span class="form-check-icon"><em>금액할인</em></span></label></div>
                                                                <div class="item-data">
                                                                    <select id="discount_2">
                                                                    </select>
                                                                    <div class="unit">원</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-bottom-info font-color-purple font-weight-500 text-align-right">할인금액 :
                                                        <span id="discount_price" class="discount_price" value="0"> </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="pay-card-content-8 is_approve" id="pet_shop_reserves" style="display: none">
                                            <div class="pay-card-body-title">
                                                <h4 class="con-title">펫샵 적립금
                                                    <button type="button" class="btn-data-helper" onclick="pop.open('reservePayManagementMsg8')">도움말</button>                                                </h4>
                                            </div>

                                            <div class="user-receipt-wrap">
                                                <div class="user-receipt-item">
                                                    <div class="receipt-buy-detail result-price">
                                                        <div class="item-data-list">
                                                            <div class="list-cell">
                                                                <div class="list-title"><strong>현 적립금</strong></div>
                                                                <div class="list-value"><strong class="now_reserves" id="cur_reserve">0원</strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vsmall line">
                                                        <div class="form-group">
                                                            <div class="form-group-cell">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">사용적립금</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="form-point-input">
                                                                            <input type="text" name="use_reserves" id="use_reserves" value="" class="" placeholder="">
                                                                            <div class="char">원</div>
                                                                            <button type="button" class="btn btn-outline-gray btn-round btn-inline all-use-reserve" onclick="document.getElementById('use_reserves').value = document.querySelector('.now_reserves').getAttribute('value')" data-price="">전액 사용</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vvsmall3">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-1">
                                                                    <button type="button" class="btn btn-outline-purple btn-middle-size btn-round  reserve-save-btn" data-cid="" data-tid="" data-phone="" data-seq="" data-service="" data-aid="" onclick="reserves_set()">적용</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--                                                    <div class="form-bottom-info font-color-purple font-weight-500 " style="text-align:right; font-size:13px !important;">이 예약 건에 대한 적립금이 아직 지급되지 않았습니다.</div>-->

                                                </div>


                                            </div>
                                        </div>


                                        <div class="user-receipt-wrap is_approve">


                                            <div class="user-receipt-item pay-user-receipt" style="border: 1px solid #6840B1 !important;">
                                                <div class="receipt-buy-detail total-price">
                                                    <div class="item-data-list">
                                                        <div class="list-cell">
                                                            <div class="list-title"><strong>할인금액</strong></div>
                                                            <div class="list-value"><strong>(-)<span id="total_discount_price" class="discount_price" value="0">0</span></strong></div>
                                                        </div>
                                                        <div class="list-cell">
                                                            <div class="list-title"><strong>적립금사용</strong></div>
                                                            <div class="list-value"><strong>(-)<span id="total_reserves_use" class="reserves_use" value="0">0</span></strong></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="receipt-buy-detail result-price">
                                                    <div class="item-data-list">
                                                        <div class="list-cell">
                                                            <div class="list-title font-color-purple"><strong>최종 결제액</strong></div>
                                                            <div class="list-value font-color-red"><strong id="last_price"></strong></div>
                                                            <input type="hidden" name="total_pay_price" id="total_pay_price" value="0" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group vmiddle">
                                                    <div class="form-change-wrap">
                                                        <div class="form-change-item">
                                                            <div class="form-change-label"><strong>카드</strong> (단위:원)</div>
                                                            <div class="form-change-data"><input type="text" name="last_card" id="last_card" value="0">
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-data-change" onclick="data_change()">전환하기</button>
                                                        <div class="form-change-item">
                                                            <div class="form-change-label"><strong>현금</strong> (단위:원)</div>
                                                            <div class="form-change-data"><input type="text" name="last_cash" id="last_cash" value="0"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="basic-data-group vsmall">
                                                    <button type="button" class="btn btn-outline-purple btn-middle-size btn-round save-final-price" data-payment_idx="" id="cardcash-btn" onclick="cardcash(this)">적용</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pay-complete-wrap is_approve">
                                            <div class="con-title-group" style="background:none !important;">
                                                <h4 class="con-title">결제완료 처리</h4>
                                                <label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" id="pay_confirm" data-seq="" onclick="reserve_confirm(this)"><span class="bar"></span></label>
                                            </div>
                                            <div>
                                                <span id="confirm_dt"></span>
                                            </div>
                                        </div>
                                        <div class="basic-data-group vmiddle is_approve2">
                                            <div class="user-receipt-item bg-fffbed">
                                                <div class="con-title-group bg-fffbed">
                                                    <h5 class="con-title">예약 서비스 내역</h5>
                                                </div>
                                                <div class="receipt-buy-detail">
                                                    <div class="item-data-list" id="appr_service_list">

                                                    </div>

                                                </div>

                                                <div class="receipt-buy-detail total-price ">
                                                    <div class="item-data-list" id="appr_service_sum">
                                                        <div class="list-cell">
                                                            <div class="list-title"><strong>합산 금액</strong></div>
                                                            <div class="list-value"><strong id="appr_sum"></strong></div>
                                                        </div>
                                                        <div class="list-cell" id="appr_vat_list" style="display:none;">
                                                            <div class="list-title"><strong>부가세 10%</strong></div>
                                                            <div class="list-value"><strong id="appr_vat"></strong></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="receipt-buy-detail result-price">
                                                    <div class="item-data-list">
                                                        <div class="list-cell">
                                                            <div class="list-title font-color-purple"><strong>총 결제 합산 금액</strong></div>
                                                            <div class="list-value font-color-purple"><strong id="appr_last_price"></strong></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group vvsmall2 is_approve2">
                                            <div class="user-receipt-item bg-fffbed">
                                                <div class="con-title-group bg-fffbed">
                                                    <h5 class="con-title">예약 내용</h5>
                                                    <!--<button type="button" class="btn-side btn btn-outline-purple btn-msmall-size btn-inline btn-border-radius-16">알림톡 발송 이력</button>-->
                                                </div>
                                                <div class="text-list-wrap type-2">
                                                    <div class="text-list-cell"><div class="item-title unit">날짜</div><div class="item-data" id="appr_date"></div></div>
                                                    <div class="text-list-cell"><div class="item-title unit">선생님</div><div class="item-data" id="appr_worker"></div></div>
                                                    <div class="text-list-cell"><div class="item-title unit">시간</div><div class="item-data" id="appr_time"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-bottom is_approve2" style="margin-top:30px; margin-bottom:30px;">
                                            <div class="grid-layout btn-grid-group">
                                                <div class="grid-layout-inner">
                                                    <div class="grid-layout-cell grid-2"><button type="button" class="btn btn-outline-purple btn-middle-size btn-round apporval-reserve" onclick="set_approve(this,true)">예약 확정</button></div>
                                                    <div class="grid-layout-cell grid-2"><button type="button" class="btn btn-outline-purple btn-middle-size btn-round apporval-reserve" onclick="set_approve(this,false)">예약신청 취소</button></div>
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

<div class="reserve-calendar-tooltip">
	<div class="tooltip-inner">
		<div class="tooltip-date" id="tooltip-date-text"></div>
		<div class="tooltip-desc" id="tooltip-desc-text"></div>
	</div>
</div>

<article id="reserveCalendarPop4" class="layer-pop-wrap">
    <input type="hidden" name="log_seq">
    <input type="hidden" name="log_worker">
    <input type="hidden" name="log_year">
    <input type="hidden" name="log_month">
    <input type="hidden" name="log_date">
    <input type="hidden" name="log_start_time">
    <input type="hidden" name="log_end_time">
    <input type="hidden" name="log_cellphone">
    <input type="hidden" name="log_pet_name">
    <input type="hidden" name="log_a_year">
    <input type="hidden" name="log_a_month">
    <input type="hidden" name="log_a_date">
    <input type="hidden" name="log_a_start_hour">
    <input type="hidden" name="log_a_start_min">


    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title"></h4>
                </div>
                <div class="pop-body type-3">
                    <div class="msg-txt"><span class="msg-text-date"></span><br><br>선택한 예약을<br>이 곳으로 변경합니다.</div>
                </div>
                <div style="display:flex; justify-content: center; align-items: center; margin-bottom:20px;">
                    예약변경알림발송
                    <input type="radio" name="log_msg_send" style="vertical-align: baseline; accent-color: #6840b1; " value="Y" checked> 발송
                    <input type="radio" name="log_msg_send" style="vertical-align: baseline; accent-color: #6840b1;" value="N"> 미발송
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
<article id="reserveCalendarPop100" class="layer-pop-wrap" style="z-index: 100000;">
        <input type="hidden" name="d_partner_id" id="d_partner_id" value="">
        <input type="hidden" name="d_worker" id="d_worker" value="">
        <input type="hidden" name="d_customer_id" id="d_customer_id" value="">
        <input type="hidden" name="d_cellphone" id="d_cellphone" value="">
        <input type="hidden" name="d_pet_seq" id="d_pet_seq" value="">
        <input type="hidden" name="d_animal" id="d_animal" value="">
        <input type="hidden" name="d_pet_type" id="d_pet_type" value="">
        <input type="hidden" name="d_pet_name" id="d_pet_name" value="">

        <input type="hidden" name="d_pet_year" id="d_pet_year" value="">
        <input type="hidden" name="d_pet_month" id="d_pet_month" value="">
        <input type="hidden" name="d_pet_day" id="d_pet_day" value="">
        <input type="hidden" name="d_gender" id="d_gender" value="">
        <input type="hidden" name="d_neutral" id="d_neutral" value="0">
        <input type="hidden" name="d_weight" id="d_weight" value="">
        <input type="hidden" name="d_beauty_exp" id="d_beauty_exp" value="0">
        <input type="hidden" name="d_vaccination" id="d_vaccination" value="0">
        <input type="hidden" name="d_luxation" id="d_luxation" value="0">
        <input type="hidden" name="d_bite" id="d_bite" value="0">
        <input type="hidden" name="d_dermatosis" id="d_dermatosis" value="0">
        <input type="hidden" name="d_heart_trouble" id="d_heart_trouble" value="0">
        <input type="hidden" name="d_marking" id="d_marking" value="0">
        <input type="hidden" name="d_mounting" id="d_mounting" value="0">
        <input type="hidden" name="d_year" id="d_year" value="">
        <input type="hidden" name="d_month" id="d_month" value="">
        <input type="hidden" name="d_day" id="d_day" value="">
        <input type="hidden" name="d_hour" id="d_hour" value="">
        <input type="hidden" name="d_min" id="d_min" value="">
        <input type="hidden" name="d_session_id" id="d_session_id" value="">
        <input type="hidden" name="d_order_id" id="d_order_id" value="">
        <input type="hidden" name="d_local_price" id="d_local_price" value="">
        <input type="hidden" name="d_pay_type" id="d_pay_type" value="">
        <input type="hidden" name="d_pay_status" id="d_pay_status" value="">
        <input type="hidden" name="d_to_hour" id="d_to_hour" value="">
        <input type="hidden" name="d_to_min" id="d_to_min" value="">
        <input type="hidden" name="d_use_coupon_yn" id="d_use_coupon_yn" value="">
        <input type="hidden" name="d_is_vat" id="d_is_vat" value="">
        <input type="hidden" name="d_product" id="d_product" value="">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-header">
                        <h4 class="con-title" id="direct_title"></h4>
                    </div>
                    <div class="pop-body type-3">
                        <div class="msg-txt"><span id="thisDate1"></span>&nbsp;&nbsp;&nbsp;&nbsp; <span id="thisTime1"></span><br><br><span id="pet_n"></span></div>
                        <div>
                            <br>
                            예약접수알림
                            <input type="radio" name="msg_send" value="Y" checked> 발송
                            <input type="radio" name="msg_send" value="N"> 미발송
                        </div>
                        <div>
                            <br>
                            미용 하루전 알림
                            <input type="radio" name="msg_send1" value="Y" checked> 발송
                            <input type="radio" name="msg_send1" value="N"> 미발송
                        </div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="direct_reserve_regist()";pop.close();">즉시예약접수</button>
                    </div>
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
                    <button type="button" class="btn btn-confirm btn-reserv-block change-cls" id="change_cls" onclick="set_change_time(true,this)">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send change-cls" onclick="set_change_time(false,this);">미발송</button>
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

<article id="reservePayManagementMsg8" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data middle">
                <div class="pop-body">
                    <div class="msg-title">펫샵적립금 적립시점 안내</div>
                    <div class="msg-txt">해당 미용종료시간 10분이 지나면 자동으로 직접 설정하신 기준에 따라 자동 적립됩니다.<br>(설정방법: <strong>상세설정 > 적립금설정</strong>)</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reservePayManagementMsg4" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">단골 고객 할인이 적용되었습니다.<br>최종 결제액을 확인해주세요.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                </div>
            </div>

        </div>
    </div>
</article>


<article id="reservePayManagementMsg5" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">적립금이 적용되었습니다.<br>최종 결제액을 확인해주세요.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>
<div class="gallery-pop-wrap">
    <div class="gallery-pop-inner">
        <div class="gallery-pop-data" id="ga-da">
            <div class="gallery-pop-slider" id="ga-sl" style="width:100%;height:100%;">
                <div class="swiper-container" id="sw-con">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-item">
                                <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                                <img src="" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-page"></div>
                <button type="button" class="btn-swiper-slider-prev"></button>
                <button type="button" class="btn-swiper-slider-next"></button>
            </div>
            <div class="gallery-pop-ui" id="ga-btn">
                <button type="button" class="btn-gallery-pop-nav btn-gallery-mode" onclick="gallery.viewModeChange(this);">
                    <span class="icon icon-size-24 icon-viewall-white off"></span>
                    <span class="icon icon-size-24 icon-viewmax-white on"></span>
                </button>
                <button type="button" class="btn-gallery-pop-nav" onclick="gallery.close();"><span class="icon icon-size-24 icon-close-white"></span></button>
            </div>
        </div>
        <div class="gallery-thumb-data">
            <div class="gallery-thumb-list">
                <button type="button" class="btn-gallery-thumb-nav">
                    <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                    <img src="" alt="">
                </button>
            </div>
        </div>
    </div>
</div>

<script src="../static/js/Sortable.min.js"></script>

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>
<script src="../static/js/customer.js"></script>
<script src="/static/js/imagesloaded.pkgd.min.js"></script>

<script src="/static/js/shop.js"></script>
<script src="/static/js/signature_pad.umd.js"></script>
<script src="/static/js/jquery-ui.min.js"></script>

<script>
    let artist_id = "<?=$artist_id?>";
    let session_id = "<?=session_id()?>"
    // data_set(artist_id)

    $(document).ready(function(){
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            $("#gnb_home").css("display","none");
            $("#gnb_shop_wrap").css("display","none");
            $("#gnb_detail_wrap").css("display","none");
            $("#gnb_stats_wrap").css("display","none");
        }
        get_navi(artist_id)
        gnb_init();
        calendar_change_month(artist_id);
        btn_month(artist_id);
        btn_month_simple();
        mini_calendar_init()
            .then(function(){
                _renderCalendar_mini(artist_id,session_id);
            })

        gnb_actived('gnb_reserve_wrap','gnb_beauty');
        btn_schedule(artist_id);
        reserve_toggle();
        reserve_regist_tab();
        setInputFilter(document.getElementById("reserve_cellphone"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })


        input_enter('reserve_search','reserve_search_btn');
        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type();
        customer_new_weight()
        modify_new_birthday().then(function(){ modify_new_birthday_date()})
        modify_pet_type();
        modify_new_weight()
        reserve_merchandise_load_event(artist_id)
        reserve_regist_event(artist_id,session_id);
        reserve_time().then(function (){reserve_time_date()});
        reserve_time_init();

        waiting(artist_id)

        new_exist_check(artist_id);
        agree_birthday().then(function(){ agree_birthday_date()})
        agree_pet_type(artist_id);

        agree_view_birthday().then(function(){ agree_view_birthday_date()})
        agree_view_pet_type(artist_id);

        for(let i=0; i<=100;i++){

            document.getElementById('discount_1').innerHTML +=`<option value="${i}">${i}</option>`
        }


        for(let i=0; i<=50000; i+=100){

            document.getElementById('discount_2').innerHTML += `<option value="${i}">${i}</option>`
        }

        management_service_1(artist_id,'dog').then(function(body){


            management_total_price();



            management_service_2(body).then(function(base_svc){


                management_service_3(base_svc).then(function(){

                    management_service_4()
                })
            })


        })

        management_service_1(artist_id,'cat').then(function(body){
            management_service_2(body).then(function(){
            })
        })



        document.getElementById('pay_management').addEventListener("scroll",onScroll);


        window.addEventListener('beforeunload',function(){

            sessionStorage.removeItem('direct_pet_seq');
            sessionStorage.removeItem('direct');
            sessionStorage.removeItem('direct_cellphone');
            sessionStorage.removeItem('direct_new');
        })



        gallery.init()





    })

    let wrapper = document.getElementById('signature_pad');
    let clear_btn = document.getElementById('signature_clear');

    let canvas = document.getElementById('cview');

    let signature_pad = new SignaturePad(canvas,{

        backgroundColor:'rgb(255,255,255)'
    })
    window.addEventListener('beforeunload',function(){

        $.ajaxQ.abortAll();
    })

    canvas.width = canvas.parentElement.offsetWidth-2;
    canvas.height=canvas.parentElement.offsetHeight-2;


    clear_btn.addEventListener("click", function (event) {
        signature_pad.clear();
    });

    document.querySelector('.pay-btn-detail-toggle').addEventListener('click',function(){

        if(document.querySelector('.pay-service-selected-wrap').style.display === 'none'){
            document.querySelector('.pay-btn-detail-toggle').classList.add('actived');
            document.querySelector('.pay-service-selected-wrap').style.display = 'block';
        }else{
            document.querySelector('.pay-btn-detail-toggle').classList.remove('actived')
            document.querySelector('.pay-service-selected-wrap').style.display = 'none';
        }


    })

    document.querySelector('.pay-btn-detail-toggle-2').addEventListener('click',function(){

        if(document.querySelector('#pay_before_beauty_list_more').style.display === 'none'){
            document.querySelector('.pay-btn-detail-toggle-2').classList.add('actived');
            document.querySelector('#pay_before_beauty_list_more').style.display = 'block';
        }else{
            document.querySelector('.pay-btn-detail-toggle-2').classList.remove('actived')
            document.querySelector('#pay_before_beauty_list_more').style.display = 'none';
        }


    })

    document.querySelector('.pay-btn-detail-toggle-3').addEventListener('click',function(){

        if(document.querySelector('#pay_before_special_list_more').style.display === 'none'){
            document.querySelector('.pay-btn-detail-toggle-3').classList.add('actived');
            document.querySelector('#pay_before_special_list_more').style.display = 'block';
        }else{
            document.querySelector('.pay-btn-detail-toggle-3').classList.remove('actived')
            document.querySelector('#pay_before_special_list_more').style.display = 'none';
        }


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
        var tooltip = $('.reserve-calendar-tooltip');
        var idx = $(this).data('payment_idx');
        /* 확장용 */
        if(e.type == 'mouseenter'){
            $(this).addClass('actived');
            if(parseInt($(this).attr('data-height')) <4){
                $(this).attr('style',`height:${$(this).children()[0].offsetHeight}px; ${localStorage.getItem('change_check') === "1" ? 'border:red dotted' : ''}`)
            }
            $.ajax({
                url: '../data/pc_ajax.php',
                data: {
                    mode: "get_tooltip",
                    payment_idx: idx,
                },
                type: 'POST',
                success: function (res) {
                    //
                    let response = JSON.parse(res);
                    //////console.log(response);
                    let head = response.data.head;
                    let body = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {

                        if(body && body.length>0){
                            var memo = '';
                            $.each(body, function(index,value){
                                // memo += value.booking_date+'</br>';
                                // memo += value.memo+'</br></br>';
                                document.getElementById("tooltip-date-text").innerHTML = "특이 사항";
                                document.getElementById("tooltip-desc-text").innerHTML = value.booking_date +'</br>'+ value.memo + '</br></br>';
                                tooltip.addClass('actived');
                            })
                            // memo_array.push(memo);
                        }else{
                            // memo_array.push('')
                            tooltip.removeClass('actived');
                        }

                    }
                }
            })

        }else if(e.type == 'mouseleave'){
            $(this).removeClass('actived');

            tooltip.removeClass('actived');
            $(this).attr('style',`height: calc(100% * ${$(this).attr('data-height')}); ${localStorage.getItem('change_check') === "1" ? 'border:red dotted' : ''}`)
        }else if(e.type == 'mousemove'){
            tooltip.css({'top' : y , 'left' : x});
		}

	});

});
</script>
</body>
</html>