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

if($artist_flag == 1){
    ?>
    <script>
        location.href="/booking/reserve_beauty_month.php";
    </script>
    <?php
}

?>
<article id="splash" class="splash-wrap">

    <div class="splash">
        <img src="/static/images/splash.gif" alt="" style="max-width:230px;max-height: 170px">
    </div>
</article>
<script>
    if(sessionStorage.getItem('splash') === null || sessionStorage.getItem('splash') === undefined || sessionStorage.getItem('splash') !== '1'){
        document.getElementById('splash').style.display = 'block'
    }
</script>
<body>

<!-- wrap -->
<div id="wrap" style="display: none";>
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
				<div class="main-wrap">
					<div class="main-row">
						<div class="main-col-1">
							<!-- 메인 대쉬보드 -->
							<div class="main-col-group main-dashboard">
								<div class="basic-data-card main-dashboard-group">
									<div class="info-list-wrap">
										<div class="list-cell"><a href="/booking/reserve_advice_view.php"><div class="title"><div class="icon icon-dashboard-1"></div><div class="txt">상담대기</div></div><div class="value consulting_count"></div></a></div>
										<div class="list-cell"><a href="/booking/reserve_beauty_day.php" onclick="localStorage.setItem('day_select',`${new Date().getFullYear()}.${fill_zero(new Date().getMonth()+1)}.${fill_zero(new Date().getDate())}`)"><div class="title"><div class="icon icon-dashboard-2"></div><div class="txt">오늘일정</div></div><div class="value schedule_count"></div></a></div>
										<div class="list-cell"><a href="/shop/shop_review_list.php"><div class="title"><div class="icon icon-dashboard-3"></div><div class="txt">신규후기</div></div><div class="value new_review_count"></div></a></div>
										<div class="list-cell"><a href="/customer/customer_all_inquiry1.php"><div class="title"><div class="icon icon-dashboard-4"></div><div class="txt">전체고객</div></div><div class="value total_count"></div></a></div>
									</div>
								</div>
							</div>
							<!-- //메인 대쉬보드 -->
							<!-- 오늘의 예약 -->
							<div class="main-col-group main-reserve">
								<div class="basic-data-card">
									<div class="basic-data-card-inner">
										<div class="card-body">
											<div class="main-reserve-group">
												<div class="main-reserve-col">
													<div class="main-calendar-stats-group">
														<div class="main-reserve-calendar">
															<div class="main-reserve-calendar-top">

																<button type="button" class="btn-main-reserve-calendar-ui btn-month-prev" id="btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
																<div class="main-reserve-calendar-title">
																	<div class="txt year-month"></div>
																</div>
																<button type="button" class="btn-main-reserve-calendar-ui btn-month-next"  id="btn-month-next"><span class="icon icon-calendar-next-small"></span></button>
															</div>
															<div>
																<div class="main-reserve-calendar-data">
																	<div class="main-reserve-calendar-inner">
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
																		<div class="main-calendar-month-wrap">

																			<div class="main-calendar-month-header">
																				<div class="main-calendar-month-header-row">
																					<div class="main-calendar-month-header-col sunday">일</div>
																					<div class="main-calendar-month-header-col">월</div>
																					<div class="main-calendar-month-header-col">화</div>
																					<div class="main-calendar-month-header-col">수</div>
																					<div class="main-calendar-month-header-col">목</div>
																					<div class="main-calendar-month-header-col">금</div>
																					<div class="main-calendar-month-header-col saturday">토</div>
																				</div>
																			</div>
                                                                            <div class="loading-container" id="home_main_calendar_loading">
                                                                                <img src="/static/images/loading.gif" alt="">
                                                                            </div>
																			<div class="main-calendar-month-body" id="main-calendar-month-body">






																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="main-reserve-stats">
															<div class="main-reserve-stats-inner">
																<div class="main-reserve-stats-header">
																	<div class="item-title">등록 현황 통계</div>
																	<div class="item-date" id="item_date"> 업데이트</div>
																</div>
																<div class="main-reserve-stats-body">
																	<!-- 내용이 있을 때 -->
																	<div class="main-reserve-graph">

																	</div>
																	<!-- //내용이 있을 때 -->
																	<!-- 내용이 없을 때-->
																	<div class="main-reserve-graph-none" id="main_reserve_graph_none">등록 현황이 없습니다.</div>
																	<!--내용이 없을 때 -->
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="main-reserve-col">
													<div class="main-product-wrap basic-data-card-inner">
														<div class="card-header">
															<div class="wide-tab">
																<div class="wide-tab-inner" id="wide-tab-inner">
																	<!-- 활성화시 actived클래스 추가 -->
																	<div class="tab-cell actived"><a href="#" class="btn-tab-item">전체</a></div>
																	<div class="tab-cell"><a href="#" class="btn-tab-item">미용</a></div>
																</div>
															</div>
														</div>
														<div class="card-body scroller">
															<!-- 내용이 있을 때 -->
															<div class="main-reserve-list" id="main_reserve_list">

															</div>
															<!-- //내용이 있을 때 -->
															<!-- 내용이 없을 때 -->
															<div class="reserve-after-none" id="reserve_after_none">
																<div class="item-desc">오늘은 확정된 예약일정이 없습니다.
<!--                                                                    <br>빈 시간을 판매해보세요.-->
                                                                </div>
<!--																<div class="item-btn"><a href="#" class="btn-point-underline">빈 시간 판매 알아보기</a></div>-->
<!--																<div class="item-btn-buy">-->
<!--																	<a href="#" class="btn btn-outline-gray">빈 시간 판매하기</a>-->
<!--																</div>-->
															</div>
															<!--//내용이 없을 때 -->
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- //오늘의 예약 -->
						</div>
						<div class="main-col-2">
							<div class="main-col-group main-side-1">
								<!-- 전화번호 검색 -->
                                <form action="../customer/customer_inquiry.php" id="search_form" method="post">
								<div class="basic-data-card transparent main-phone-group">
									<div class="main-phone">

										<div class="item-input"><input type="text" name="search" id="search" placeholder="전화번호 또는 펫이름 입력"/></div>

										<button type="button" class="btn-main-phone" onclick="document.getElementById('search').value === '' ? pop.open('firstRequestMsg1','전화번호 또는 펫이름을 입력해주세요.'):document.getElementById('search_form').submit()">검색</button>

									</div>
								</div>
                                </form>
								<!-- //전화번호 검색 -->								
							</div>
<!--							<div class="main-col-group main-banner">-->
								<!-- 메인 배너 -->
<!--								<div class="basic-swiper-banner">-->
<!--									<div class="swiper-data">-->
<!--										<div class="swiper-container">-->
<!--											<div class="swiper-wrapper">-->
<!--												<div class="swiper-slide"><a href="#" class="btn-basic-swiper-banner-nav"><img src="../../static/images/main_banner.png" alt=""/></a></div>-->
<!---->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="swiper-pagination"></div>-->
<!--								</div>-->
								<!-- //메인 배너 -->
<!--							</div>-->
							<div class="main-col-group main-customer">
								<!-- 메인 상담 -->
								<div class="basic-data-card">
									<div class="basic-data-card-inner">
										<div class="card-header" style="height: 55px !important;">
											<div class="card-header-title">이용 상담 관리<div class="card-header-label consulting_count"></div></div>
											<div class="card-header-ui"><a href="/booking/reserve_advice_view.php" class="btn-card-header-more">더보기</a></div>
										</div>
										<div class="card-body scroller">
											<!-- 내용이 있을 때 -->
											<div class="main-customer-list">

											</div>
											<!-- //내용이 있을 때 -->
											<!-- 내용이 없을 때 -->
											<div class="common-none-data" id="consulting_none_data">
												<div class="none-inner">
													<div class="item-visual"><img src="../../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">등록된 상담내역이 없습니다.</span></div>
												</div>
											</div>
											<!-- 내용이 없을 때 -->
										</div>
									</div>
								</div>
								<!-- //메인 상담 -->
							</div>
							<div class="main-col-group main-notice-group">
								<!-- 메인 공지사항 -->
								<div class="basic-data-card">
									<div class="main-notice">
										<div class="main-notice-title">공지</div>
										<div class="main-notice-list">
										</div>
									</div>
								</div>
								<!-- //메인 공지사항 -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- //view -->
			<!-- footer -->
			<footer id="footer"></footer>
			<!-- //footer -->
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

<script>

    let session_id = "<?=session_id()?>";
    let artist_id = "<?=$artist_id?>";




    $(document).ready(function(){

        data_set(artist_id).then(function(){



        })

        gnb_init();
        _renderCalendar(artist_id);
        btn_month(artist_id)
        consulting();
        update();
        wide_tab();
        notice();
        today_reserve();
        set_image('front_image');
        prepend_data('consulting_count schedule_count new_review_count total_count nick');
        stats();
        gnb_actived('gnb_home');
        break_time(artist_id);

        $.ajax({

            url: '/data/pc_ajax.php',
            type: 'post',
            data: {
                mode: 'open_close',
                login_id: artist_id,

            },
            success: function (res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    let open = body[0].open_time;
                    let close = body[0].close_time;
                    localStorage.setItem('open_close', `${open}/${close}`)
                }
            }
        })


    })










</script>
</body>
</html>