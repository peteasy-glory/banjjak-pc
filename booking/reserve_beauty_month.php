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
								<div class="card-header">
									<div class="card-header-title">오늘의 미용 예약<div class="card-header-label schedule_count"></div></div>
								</div>
								<div class="card-body">
									<!-- 내용이 있을 때 -->
									<div class="customer-card-list" id="month_today_reserve_list">


									</div>
									<!-- //내용이 있을 때 -->
									<!-- 내용이 없을 때 -->
									<div class="common-none-data type-2" id="common_none_data" style="display: none;">
										<div class="none-inner">
											<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
											<div class="item-info">오늘의 내용이 없습니다.</span></div>
										</div>
									</div>
									<!-- //내용이 없을 때 -->
								</div>
							</div>					
							<!-- //오늘의 미용 예약 -->
							<!-- 오늘의 예약 총 횟수 -->
							<div class="basic-data-card reserve-total">
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
										<button type="button" class="btn-reserve-calendar-ui btn-month-prev" id="btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
										<div class="reserve-calendar-title">
											<button type="button" class="txt" id="this_month"></button>
										</div>
										<button type="button" class="btn-reserve-calendar-ui btn-month-next" id="btn-month-next"><span class="icon icon-calendar-next-small"></span></button>
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
									<div class="sort-right">
										<!-- actived클래스 추가시 활성화 -->
										<button type="button" class="btn-reserve-calendar-sort actived">월</button>
										<button type="button" class="btn-reserve-calendar-sort">주</button>
										<button type="button" class="btn-reserve-calendar-sort">일</button>
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
												<div class="calendar-month-body" id="calendar_month_body">

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
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>
<script src="../static/js/Sortable.min.js"></script>
<script>


    data_set();
    window.onload = function(){

        gnb_init();
        prepend_data('consulting_count schedule_count nick');
        set_image('front_image');
        book_list().then(function(body){


            today_reserve_month();
            _renderCalendar_month().then(function(){
                month_reserve_cols(body).then(function (){

                    day_total_reserve()
                    month_holiday()

                });
            });



        });
        gnb_actived('gnb_reserve_wrap','gnb_beauty');
        btn_month_calendar()

    }

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

	$('.calendar-month-body-col').each(function(){
		if(!$(this).hasClass('break')){
			//휴무가 아닐 경우 드래그앤 드롭 가능 처리
			var sortable = Sortable.create($(this).find('.calendar-drag-item-group')[0] , {
				group : 'shared',
				delay : 0,
				delayOnTouchOnly : true,
				ghostClass: 'guide',
				draggable : '.calendar-drag-item',
				onStart : function(evt){
					//드래그 시작 
					console.log('drag start');
				},
				onEnd : function(evt){
					//드래그 끝
					console.log('drag end');
					//evt.to;    // 현재 아이템
					//evt.from;  // 이전 아이템
					//evt.oldIndex;  // 이전 인덱스값
					//evt.newIndex;  // 새로운 인덱스값
				},
				onUpdate : function(evt){
					console.log('update');
				},
				onUpdate : function(evt){
					console.log('onChange');
				},
				onRemove: function (/**Event*/evt) {
					console.log('remove');
				}
				
			});
		}
	});

});
</script>
</body>
</html>