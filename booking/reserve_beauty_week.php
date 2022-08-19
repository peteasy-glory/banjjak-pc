<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");


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

<script src="../static/js/Sortable.min.js"></script>

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>
<script>

    data_set();
    window.onload = function(){

        gnb_init();
        prepend_data('consulting_count nick');
        set_image('front_image');
        calendar_change_month();
        btn_month();
        btn_month_simple();
        mini_calendar_init()
            .then(function(){
                _renderCalendar_mini();
            })
        reload_list();

        gnb_actived('gnb_reserve_wrap','gnb_beauty');
        btn_schedule();

    }

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