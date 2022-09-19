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
                                                            <img src="/static/images/loading.gif" alt="">
                                                        </div>
														<div class="mini-calendar-month-body"  id="mini-calendar-month-body">

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
										<button type="button" onclick="location.href='./reserve_beauty_week.php';" class="btn-reserve-calendar-sort">주</button>
										<button type="button" onclick="location.href='./reserve_beauty_day.php';" class="btn-reserve-calendar-sort">일</button>
										<button type="button" class="btn-reserve-calendar-sort actived"><span class="icon icon-type-list-gray off"></span><span class="icon icon-type-list-white on"></span></button>
									</div>
								</div>
								<!-- //캘린더 상단 -->
							</div>
							<div class="card-body">				
								<!-- 리스트형 -->
								<div>
									<div class="reserve-calendar-list">
                                        <div class="loading-container" id="list_schedule_loading" style="min-height: 300px;">
                                            <img src="/static/images/loading.gif" alt="">
                                        </div>
										<div class="reserve-calendar-list-inner" id="list_inner">


										</div>										
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
								<!-- //리스트형 -->		
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
<script>
    let artist_id = "<?=$artist_id?>";
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
        btn_month_simple()
        mini_calendar_init()
            .then(function(){
                _renderCalendar_mini(artist_id)


            })
        reload_list(artist_id)
        btn_schedule(artist_id)
        waiting(artist_id)



        gnb_actived('gnb_reserve_wrap','gnb_beauty');

        document.getElementById('gnb_reserve_wrap').setAttribute('onclick','location.href ="/booking/reserve_beauty_day.php"')
        document.getElementById('gnb_customer_wrap').setAttribute('onclick','location.href ="/customer/customer_inquiry.php"')
        document.getElementById('gnb_shop_wrap').setAttribute('onclick','location.href ="/shop/shop_gate_picture.php"')
        document.getElementById('gnb_detail_wrap').setAttribute('onclick','location.href ="/setting/set_schedule_list.php"')
        document.getElementById('gnb_stats_wrap').setAttribute('onclick','location.href ="/report/stats_sale_1.php"')
        document.getElementById('gnb_etc_wrap').setAttribute('onclick','location.href ="/etc/other_notice_list.php"')


    })







</script>
</body>
</html>