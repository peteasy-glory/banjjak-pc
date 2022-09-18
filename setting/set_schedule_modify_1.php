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
					<div class="data-col-middle">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">일정관리</h3>
							</div>
							<form id="scheduleForm" class="card-body">
                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
								<div class="card-body-inner">
									<div class="set-schedule-wrap">										
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">기본 영업시간 설정</h4>
											</div>
											<div class="form-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">영업시간</div>
																<div class="form-item-data type-2">
																	<div class="form-datepicker-group">
																		<div class="form-datepicker">
																			<select name="start_time" class="start_time">
                                                                                <option value="08">오전 08:00</option>
																				<option value="09">오전 09:00</option>
																				<option value="10">오전 10:00</option>
                                                                                <option value="11">오전 11:00</option>
                                                                                <option value="12">오후 12:00</option>
                                                                                <option value="13">오후 01:00</option>
                                                                                <option value="14">오후 02:00</option>
                                                                                <option value="15">오후 03:00</option>
                                                                                <option value="16">오후 04:00</option>
                                                                                <option value="17">오후 05:00</option>
                                                                                <option value="18">오후 06:00</option>
                                                                                <option value="19">오후 07:00</option>
                                                                                <option value="20">오후 08:00</option>
                                                                                <option value="21">오후 09:00</option>
                                                                                <option value="22">오후 10:00</option>
                                                                                <option value="23">오후 11:00</option>
																			</select>
																		</div>
																		<div class="form-unit">~</div>
																		<div class="form-datepicker">
																			<select name="close_time" class="close_time">
                                                                                <option value="08">오전 08:00</option>
                                                                                <option value="09">오전 09:00</option>
                                                                                <option value="10">오전 10:00</option>
                                                                                <option value="11">오전 11:00</option>
                                                                                <option value="12">오후 12:00</option>
                                                                                <option value="13">오후 01:00</option>
                                                                                <option value="14">오후 02:00</option>
                                                                                <option value="15">오후 03:00</option>
                                                                                <option value="16">오후 04:00</option>
                                                                                <option value="17">오후 05:00</option>
                                                                                <option value="18">오후 06:00</option>
                                                                                <option value="19">오후 07:00</option>
                                                                                <option value="20">오후 08:00</option>
                                                                                <option value="21">오후 09:00</option>
                                                                                <option value="22">오후 10:00</option>
                                                                                <option value="23">오후 11:00</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">공휴일 휴무 설정</div>
																<div class="form-item-data type-2">
																	<div class="memo-item type-2">
																		<div class="flex align-items-center justify-content-space-between">
																			<div>
																				<div class="holiday_txt">*공휴일은 쉬어요.</div>
																			</div>
																			<div><label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" id="switch-toggle" name="is_work_holiday"><span class="bar"></span></label></div>
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
											<h6 class="con-title">휴게시간 설정</h6>
											<div class="basic-data-group vvsmall4">
												<div class="grid-layout toggle-button-group">
													<div class="grid-layout-inner break_time_wrap">
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">예약 스케줄 운영방식 선택</h4>
											</div>
											<div class="form-check-group">
												<div class="form-check-inner">
													<div class="check-cell"><label class="form-radiobox"><input type="radio" class="time_schedule" name="time_type" value="1"><span class="form-check-icon"><em>자유시간제</em></span></label></div>
													<div class="check-cell"><label class="form-radiobox"><input type="radio" class="time_schedule" name="time_type" value="2"><span class="form-check-icon"><em>타임제</em></span></label></div>
                                                    <input type="hidden" name="time_type_2_cnt" class="time_type_2_cnt" value="">
												</div>
											</div>
											<!-- 타임제 -->
											<div class="form-check-detail time_type_2_wrap" style="display:none;">
												<div class="basic-data-group">
													<div class="grid-layout basic">
														<div class="grid-layout-inner time_name_wrap">
														</div>
													</div>					
												</div>
												<div class="basic-data-group vvsmall3 line">
													<div>
														<div class="grid-layout toggle-button-group time_wrap">
														</div>
													</div>
												</div>
											</div>
											<!-- //타임제 -->
										</div>			
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">정기휴일 설정</h4>
											</div>
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell flex-auto" style="display: none;">
														<div class="grid-layout basic">
															<div class="grid-layout-inner">
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="1" name="week_type"><em>매주</em></label></div>
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="2" name="week_type"><em>1/3주</em></label></div>
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="3" name="week_type"><em>2/4주</em></label></div>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell flex-1">
														<div class="form-week-select">
															<div class="form-week-select-inner">
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="100000" class="mon"><em>월</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="10000" class="tue"><em>화</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="1000" class="wed"><em>수</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="100" class="thu"><em>목</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="10" class="fri"><em>금</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="1" class="sat"><em>토</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week[]" value="1000000" class="sun"><em>일</em></label></div>
															</div>
														</div>
													</div>
												</div>
											</div>											
										</div>			
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">임시휴일 설정</h4>
											</div>
											<div class="basic-data-group vvsmall">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<button type="button" class="btn btn-icons btn-outline-gray btn-basic-full" onclick="pop.open('holidaySet')"><span class="txt">사정이 있어서 쉬어요</span><span class="icon icon-share-middle-black"></span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="basic-data-group vvsmall4">
												<div class="grid-layout margin-5-17">
													<div class="grid-layout-inner vacation_wrap">
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
													</div>
												</div>
												<div class="form-bottom-info">휴가를 가거나 급한 사정이 있어서 쉴 때 이용하세요.<br>예약이 잡혀 있는데 쉬시려면 고객의 예약취소/변경이 먼저 등록되어야 합니다.</div>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom save_schedule">저장하기</a>
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

    <!-- 임시휴일 설정 팝업 -->
    <form id="holidaySet" class="layer-pop-wrap">
        <input type="hidden" name="partner_id" value="<?=$artist_id?>">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data data-pop-view large">
                    <div class="pop-header">
                        <h4 class="con-title">임시휴일 설정</h4>
                    </div>
                    <div class="pop-body" style="padding-top:4px;">
                        <div class="set-schedule-wrap">
                            <div class="reserve-calendar-wrap">
                                <!-- 캘린더 상단 -->
                                <div class="reserve-calendar-top">
                                    <div class="reserve-calendar-select">
                                        <button type="button" class="btn-reserve-calendar-ui btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
                                        <div class="reserve-calendar-title">
                                            <button type="button" class="txt">2021.11</button>
                                        </div>
                                        <button type="button" class="btn-reserve-calendar-ui btn-month-next"><span class="icon icon-calendar-next-small"></span></button>
                                        <!-- calendar-title-sort 클래스에 actived클래스 추가시 활성화 -->
                                        <div class="calendar-title-sort">
                                            <div class="simple-calendar-wrap">
                                                <div class="simple-calendar-top">
                                                    <button type="button" class="btn-simple-calendar-ui btn-simple-calendar-prev">이전</button>
                                                    <div class="top-title">2022</div>
                                                    <button type="button" class="btn-simple-calendar-ui btn-simple-calendar-next">다음</button>
                                                </div>
                                                <div class="simple-calendar-body">
                                                    <div class="simple-calendar-month-group">
                                                        <div class="simple-calendar-month-row">
                                                            <!-- btn-simple-calendar-month-nav 클래스에 actived클래스 추가시 활성화 -->
                                                            <div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">1</button></div>
                                                            <div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">2</button></div>
                                                            <div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav">3</button></div>
                                                            <div class="simple-calendar-month-col"><button type="button" class="btn-simple-calendar-month-nav actived">4</button></div>
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
                                </div>
                                <!-- //캘린더 상단 -->
                                <!-- 캘린더 상세 -->
                                <div>
                                    <div class="reserve-calendar-data">
                                        <div class="reserve-calendar-inner">
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
                                            <div class="calendar-month-wrap">
                                                <div class="calendar-month-header">
                                                    <div class="calendar-month-header-row">
                                                        <div class="calendar-month-header-col sunday">일</div>
                                                        <div class="calendar-month-header-col">월</div>
                                                        <div class="calendar-month-header-col">화</div>
                                                        <div class="calendar-month-header-col">수</div>
                                                        <div class="calendar-month-header-col">목</div>
                                                        <div class="calendar-month-header-col">금</div>
                                                        <div class="calendar-month-header-col saturday">토</div>
                                                    </div>
                                                </div>
                                                <div class="calendar-month-body">
                                                    <div class="calendar-month-body-row">
                                                        <div class="calendar-month-body-col before break sunday">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">28</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col before">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">29</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col before">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">30</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">1</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">2</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col break">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">3</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">4</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calendar-month-body-row">
                                                        <div class="calendar-month-body-col break sunday">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">5</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">6</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">7</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col today">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">8</div><div class="state"></div></div>
                                                                <div class="calendar-total-value">임휴2</div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">9</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col break">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">10</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">11</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calendar-month-body-row">
                                                        <div class="calendar-month-body-col break sunday">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">12</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col selected">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">13</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col selected">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">14</div><div class="state"></div></div>
                                                                <div class="calendar-total-value">임휴2</div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col selected">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">15</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">16</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col break">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">17</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">18</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calendar-month-body-row">
                                                        <div class="calendar-month-body-col break sunday">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">19</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">20</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">21</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">22</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">23</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col break">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">24</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">25</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="calendar-month-body-row">
                                                        <div class="calendar-month-body-col break sunday">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">26</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">27</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">28</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">29</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">30</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col break after">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">1</div><div class="state">정휴</div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-month-body-col after">
                                                            <div class="calendar-col-inner">
                                                                <div class="calendar-day-value"><div class="number">2</div><div class="state"></div></div>
                                                                <div class="calendar-total-value"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //캘린더 상세 -->
                            </div>
                            <div class="basic-data-group large">
                                <div class="con-title-group">
                                    <h4 class="con-title">타입 선택</h4>
                                </div>
                                <div class="form-check-group">
                                    <div class="form-check-inner">
                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" name="break_type" class="break_type" value="all" checked><span class="form-check-icon"><em>종일 쉬어요</em></span></label></div>
                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" name="break_type" class="break_type" value="notall"><span class="form-check-icon"><em>몇시간만 쉬어요</em></span></label></div>
                                    </div>
                                </div>
                                <!-- display:none 으로 기본 처리 -->
                                <!-- 종일 쉬어요 -->
                                <div class="basic-data-group vmiddle all_wrap" style="display:block;">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">기간</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="form-datepicker-group">
                                                            <div class="form-datepicker">
                                                                <select name="all_start" class="all_start">
                                                                    <?php
                                                                    $next_year = date('Y-m-d',strtotime('+1 year'));
                                                                    for($i=strtotime($next_year);$i>=strtotime(date('Y-m-d'));$i-=86400){
                                                                        ?>
                                                                        <option value="<?php echo date('Ymd',$i);?>0000" <?php echo (strtotime(date('Y-m-d'))==$i)?'selected':'';?>><?php echo date('Y.m.d',$i);?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-unit">~</div>
                                                            <div class="form-datepicker">
                                                                <select name="all_finish" class="all_finish">
                                                                    <?php
                                                                    $next_year = date('Y-m-d',strtotime('+1 year'));
                                                                    for($i=strtotime($next_year);$i>=strtotime(date('Y-m-d'));$i-=86400){
                                                                        ?>
                                                                        <option value="<?php echo date('Ymd',$i);?>0000" <?php echo (strtotime(date('Y-m-d'))==$i)?'selected':'';?>><?php echo date('Y.m.d',$i);?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //종일 쉬어요-->
                                <!-- 몇시간만 쉬어요 -->
                                <div class="basic-data-group vmiddle notall_wrap" style="display:none;">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">날짜</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout margin-12">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select name="notall_year" class="notall_year">
                                                                        <option value="2021">2021 년</option>
                                                                        <option value="2022">2022 년</option>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select name="notall_month" class="notall_month">
                                                                        <?php for($i=1;$i<=12;$i++){ ?>
                                                                            <option value="<?php echo ($i<10)? '0'.$i : $i;?>" <?php echo ($i==date('n'))?'selected':'';?> ><?php echo sprintf('%02d',$i);?> 월</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select name="notall_day" class="notall_day">
                                                                        <?php for($i=1;$i<=date('t');$i++){ ?>
                                                                            <option value="<?php echo ($i<10)? '0'.$i : $i;?>" <?php echo ($i==date('d'))?'selected':'';?> ><?php echo sprintf('%02d',$i);?> 일</option>
                                                                        <?php } ?>
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
                                                            <div class="form-datepicker auto" style="width:124px">
                                                                <select name="notall_st_time" class="notall_st_time">
                                                                    <?php
                                                                    for($i=strtotime('08:00');$i<=strtotime('23:00');$i+=1800){
                                                                        ?>
                                                                        <option value="<?php echo date('Hi',$i);?>"><?php echo (date('H',$i)>=12)?'오후':'오전';?> <?php echo date('g:i',$i);?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-unit">~</div>
                                                            <div class="form-datepicker auto" style="width:124px">
                                                                <select name="notall_fi_time" class="notall_fi_time">
                                                                    <?php
                                                                    for($i=strtotime('08:00');$i<=strtotime('23:00');$i+=1800){
                                                                        ?>
                                                                        <option value="<?php echo date('Hi',$i);?>"><?php echo (date('H',$i)>=12)?'오후':'오전';?> <?php echo date('g:i',$i);?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //몇시간만 쉬어요-->
                            </div>
                            <div class="basic-data-group vmiddle">
                                <div class="con-title-group">
                                    <h4 class="con-title">적용대상 미용사 선택</h4>
                                </div>
                                <div class="basic-data-group vsmall">
                                    <div class="grid-layout basic">
                                        <div class="grid-layout-inner modify_wrap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pop-footer">
                        <a href="#" class="btn btn-purple save_vacation"><strong>저장하기</strong></a>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </form>
    <!-- //임시휴일 설정 팝업 -->

    <article id="talkExam" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">예약 스케줄을 자유시간제로 변경합니다.</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm"  onclick="$('.time_type_2_wrap').css('display','none');pop.close();">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <article id="talkExam1" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">예약 스케줄을 타임제로 변경합니다.</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm"  onclick="$('.time_type_2_wrap').css('display','block');pop.close();">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <form id="delete_pop" class="layer-pop-wrap">
        <input type="hidden" name="idx" class="idx" value="">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">삭제하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="delete_ok();">삭제</button>
                        <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <article id="scheduleBackUrl" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt"></div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="location.href='set_schedule_list.php';">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap','gnb_schedule');
        get_open_close(artist_id); // 0
        break_time(artist_id); // 1
        time_type(artist_id); // 2
        part_time(artist_id); // 3
        regular_holiday(artist_id); // 4
        artist_vacation(artist_id); // 5
        get_artist_list(artist_id);
        console.log(setting_array);

        // 샵 오픈, 종료 시간
        $(".open_close").text(am_pm_check(fill_zero(setting_array[0].open_time))+":00 ~ "+am_pm_check(setting_array[0].close_time)+":00");
        var start_time = fill_zero(setting_array[0].open_time);
        var close_time = fill_zero(setting_array[0].close_time);
        $(".start_time").val(start_time);
        $(".close_time").val(close_time);

        // 공휴일 휴무 여부
        if(setting_array[0].is_work_on_holiday == false){
            $("#switch-toggle").prop("checked", true);
            $('#switch-toggle').val("0");
            $(".holiday_txt").text("*공휴일도 일해요");
        }else{
            $("#switch-toggle").prop("checked", false);
            $('#switch-toggle').val("1");
            $(".holiday_txt").text("*공휴일은 쉬어요");
        }

        // 휴게시간, 타임제 시간 리스트 출력
        var start_hour = setting_array[0].open_time;
        var close_hour = setting_array[0].close_time;
        var html = '';
        for(start_hour;start_hour<close_hour;start_hour++){
            html += `
                <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1[]" class="time_${fill_zero(start_hour)}00" value="${fill_zero(start_hour)}:00~${fill_zero(start_hour)}:30"><em>${am_pm_check(fill_zero(start_hour))}:00</em></label></div>
                <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1[]" class="time_${fill_zero(start_hour)}30" value="${fill_zero(start_hour)}:30~${fill_zero(start_hour+1)}:00"><em>${am_pm_check(fill_zero(start_hour))}:30</em></label></div>
            `;
        }
        $(".break_time_wrap").html(html);

        // 휴게시간
        if(setting_array[1] != '' && setting_array[1] != undefined){
            var break_array = setting_array[1].res_time_off;
            var html = '';
            $.each(break_array, function(i,v){
                var st_time = ".break_time_wrap .time_"+((v.time).split('~')[0]).replace(':','');
                $(st_time).prop("checked", true);
            });
        }

        // 자유시간제, 타임제
        $(".time_type_2_cnt").val(setting_array[6].length);
        var time_array = setting_array[6];
        var html = '';
        var html_2 = '';
        var html_modify = '';
        $.each(time_array,function(i, v){
            var name = (v.name == artist_id)? v.nick : v.name;
            var checked = (i == 0)? "checked" : "";
            var is_block = (i == 0)? "flex" : "none";
            html += `
                    <div class="grid-layout-cell flex-auto"><label class="form-toggle-box"><input type="radio" class="worker" value="${i}" name="worker" ${checked}><em>${name}</em></label></div>
                `;

            html_modify += `
                    <div class="grid-layout-cell flex-auto"><label class="form-toggle-box"><input type="checkbox" name="break_worker[]" value="${v.name}" ${checked}><em>${name}</em></label></div>
                `;

            start_hour = setting_array[0].open_time;
            close_hour = setting_array[0].close_time;
            var worker_idx = '';
            if(i < setting_array[3].length){
                worker_idx = setting_array[3][i].idx;
            }else{
                worker_idx = '0';
            }

            html_2 += `<div class="grid-layout-inner worker_time_wrap worker_${i}" style="display: ${is_block}">`;
            html_2 += `<input type="hidden" name="worker_${i}" value="${worker_idx}">`;
            html_2 += `<input type="hidden" name="worker_name_${i}" value="${v.name}">`;
            for(start_hour;start_hour<close_hour;start_hour++){
                html_2 += `
                        <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time2_${i}[]" class="time_${fill_zero(start_hour)}00" value="${fill_zero(start_hour)}:00~${fill_zero(start_hour)}:30"><em>${am_pm_check(fill_zero(start_hour))}:00</em></label></div>
                        <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time2_${i}[]" class="time_${fill_zero(start_hour)}30" value="${fill_zero(start_hour)}:30~${fill_zero(start_hour+1)}:00"><em>${am_pm_check(fill_zero(start_hour))}:30</em></label></div>
                    `;
            }
            html_2 += '</div>';
            $(".time_wrap").html(html_2);

            //$.each(v.res_time_off,function(index, value){
            // var st_time = ".time_wrap .worker_"+v.idx+" .time_"+((value.time).split('~')[0]).replace(':','');
            // $(st_time).prop("checked", true);
            //});
        });
        $(".time_name_wrap").html(html);
        $(".modify_wrap").html(html_modify);
        var t_type = setting_array[2].is_time_Type; // 1:자유시간제, 2:타임제
        if(t_type == '2'){
            $("input:radio[name='time_type']:radio[value='2']").prop('checked', true);
            $(".time_type_2_wrap").css("display","block");
        }else{
            $("input:radio[name='time_type']:radio[value='1']").prop('checked', true);
            $(".time_type_2_wrap").css("display","none");
        }

        // 정기휴일
        var holiday = setting_array[4];
        if(holiday.week_type == '1'){
            $("input:radio[name='week_type']:radio[value='1']").prop('checked', true);
        }else if(holiday.week_type == '2'){
            $("input:radio[name='week_type']:radio[value='2']").prop('checked', true);
        }else if(holiday.week_type == '3'){
            $("input:radio[name='week_type']:radio[value='3']").prop('checked', true);
        }
        if(holiday.is_work_mon == true){
            $(".mon").prop("checked", true);
        }
        if(holiday.is_work_tue == true){
            $(".tue").prop("checked", true);
        }
        if(holiday.is_work_wed == true){
            $(".wed").prop("checked", true);
        }
        if(holiday.is_work_thu == true){
            $(".thu").prop("checked", true);
        }
        if(holiday.is_work_fri == true){
            $(".fri").prop("checked", true);
        }
        if(holiday.is_work_sat == true){
            $(".sat").prop("checked", true);
        }
        if(holiday.is_work_sun == true){
            $(".sun").prop("checked", true);
        }

        // 임시휴무
        console.log(setting_array[5]);
        var vacation_array = setting_array[5];
        var html = '';
        $.each(vacation_array,function(i, v){
            var name = (v.worker == artist_id)? "실장" : v.worker;
            $.each(v.vacation,function(index, value){
                // 휴가 판단
                var vacation_time
                if(value.type == "all"){
                    vacation_time = (value.date_st).split(" ")[0] + " ~ " + (value.date_fi).split(" ")[0];
                }else{
                    vacation_time = `${am_pm_check2(value.date_st)} ~ ${am_pm_check_time((value.date_fi).split(" ")[1])}`;
                }
                html += `
                    <div class="grid-layout-cell grid-2">
                        <div class="memo-item modify">${vacation_time} (${name})<button type="button" class="btn-memo-del" onclick="delete_pop(${value.idx});"><span class="icon icon-close-small-black"></span></button></div>
                    </div>
                `;
            });

        });
        $(".vacation_wrap").html(html);

        // 타임제 미용사 선택 (순서때문에 checked 안되는 현상때문에 뒤로 따로 빼놓음)
        var time_array = setting_array[3];
        var html = '';
        var html_2 = '';
        $.each(time_array,function(i, v){
            $.each(v.res_time_off,function(index, value){
                var st_time = ".time_wrap .worker_"+i+" .time_"+((value.time).split('~')[0]).replace(':','');
                $(st_time).prop("checked", true);
            });
        });
    })

    // 공휴일 휴무설정 변경 이벤트
    $('#switch-toggle').on('click',function(){
        if($(this).is(':checked')==true){
            $('.holiday_txt').text('공휴일도 일해요');
            $('#switch-toggle').val("0");
        } else {
            $('.holiday_txt').text('공휴일은 쉬어요');
            $('#switch-toggle').val("1");
        }
    });

    // 시간제 선택
    $(document).on('click','.time_schedule',function(){
        if($(this).val() == 1){
            pop.open('talkExam');
        } else {
            pop.open('talkExam1');
        }
    });

    // 타임제에서 미용사 선택
    $(document).on("click", '.worker', function(){
        $(".worker_time_wrap").css("display","none");
        var class_name = ".worker_"+$(this).val();
        $(class_name).css("display","flex");
    })

    // 임시휴일성정 팝업 타입 선택
    $(document).on('click','.break_type',function(){
        if($(this).val() == 'all'){
            $('.notall_wrap').css('display','none');
            $('.all_wrap').css('display','block');
        } else {
            $('.all_wrap').css('display','none');
            $('.notall_wrap').css('display','block');
        }
    });

    // 임시휴일설정 저장하기
    $(document).on("click",".save_vacation",function(){
        //var break_worker = $("input:checkbox[name='break_worker']").val();
        var postData = decodeURIComponent($("#holidaySet").serialize());
        postData += '&mode=post_vacation';
        console.log(postData);
        post_vacation(postData);
    })

    // 일정관리 수정 저장하기
    $(document).on("click",".save_schedule",function(){
        var postData = decodeURIComponent($("#scheduleForm").serialize());
        postData += '&mode=put_schedule';
        console.log(postData);

        var artist_cnt = $(".time_type_2_cnt").val();
        // console.log($('input[name="time2"]:checked').val());
        if($('input[name="time_type"]:checked').val() == 2){
            for(var i=0; i<artist_cnt; i++){
                console.log($('input[name="time2_'+i+'[]"]:checked').length);
                if($('input[name="time2_'+i+'[]"]:checked').length < 2){
                    pop.open('firstRequestMsg1','최소 2개의 타임을 선택해주세요.');
                    return false;
                }
            }
        }

        put_schedule(postData);
    })

    // 임시휴무 삭제 팝업
    function delete_pop(idx){
        $("#delete_pop .idx").val(idx);
        pop.open('delete_pop');
    }

    // 임시휴무 삭제하기
    function delete_ok(){
        pop.close();
        var idx = $("#delete_pop .idx").val();
        del_vacation(idx);
    }

</script>
</body>
</html>