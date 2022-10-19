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
                                <form action="/customer/customer_inquiry.php" id="search_form" method="get">
								<div class="basic-data-card transparent main-phone-group">
									<div class="main-phone">

										<div class="item-input"><input type="text" class="text-add" name="search"  id="search" placeholder="전화번호 또는 펫이름 입력"/></div>

										<button type="button" class="btn-main-phone" onclick="document.getElementById('search').value === '' ? pop.open('firstRequestMsg1','전화번호 또는 펫이름을 입력해주세요.'):document.getElementById('search_form').submit()">검색</button>

									</div>
								</div>
                                </form>
								<!-- //전화번호 검색 -->								
							</div>
							<div class="main-col-group main-banner">

								<div class="basic-swiper-banner">
									<div class="mall-wrap">
                                            <img src="https://partner.banjjakpet.com/images/partner_ban_04.png" onclick="window.open(`https://partner.banjjakpet.com/shop_mall?partner_pc=${artist_id}`,'_blank ','width=520,height=800,top=200,left=650')" id="mall_target" style="cursor: pointer" alt="">
                                    </div>
								</div>

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

<div id="popup_wrap">
    <div class="custom-modal-content">
        <div class="popup_img">
            <div class="swiper-container_front swiper-container">
                <div class="swiper-wrapper" id="popup-wraper">
                   <div class="swiper-slide">
                        <a href="javascript:location.href='/etc/other_notice_view.php?type=공지&title=예약금%20설정%20기능%20OPEN&date=2022-10-06&img=/pet/upload/sally@peteasy.kr/notice_photo_20221006163326.jpg&notice=';">
                            <img src="https://image.banjjakpet.com/images/event/deposit_pop.jpg" alt="" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="javascript:location.href='/etc/other_notice_view.php?type=업데이트&title=알리미%20기능%20오픈&date=2022-10-18&img=/pet/upload/sally@peteasy.kr/notice_photo_20221018175556.jpg&notice=';">
                            <img src="/static/images/allimi_notice.jpg" alt="" />
                        </a>
                    </div>
                    <!--                            <div class="swiper-slide">-->
                    <!--                                <a href="javascript:location.href='mypage_notice_view?notice_seq=';">-->
                    <!--                                    <img src="/images/banner/pop_recommendation_event.jpg" alt="" />-->
                    <!--                                </a>-->
                    <!--                            </div>-->

                </div>
                <!-- Add Arrows -->
                <div class="next"><i class="fa-solid fa-chevron-left"></i></div>
                <div class="prev"><i class="fa-solid fa-chevron-right"></i></div>
                <div class="swiper-pagination_front"></div>
            </div>
        </div>
    </div>
</div>

<article id="allimi_pop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data ">
                <div class="allimi-container">
                    <div class="allimi-wrap">

                        <div class="allimi-left-wrap">

                            <div class="allimi-title-box border-right">

                                <div class="allimi-title-box-2">
                                    <div class="allimi-title">
                                        알리미 작성
                                    </div>
                                    <div class="allimi-title-right" style="cursor: pointer" id="allimi_history_btn" onclick="allimi_open_history(this)">
                                        <img src="/static/images/icon/NoPath@2x.png" alt="">
                                        <span>히스토리</span>
                                    </div>
                                </div>
                            </div>


                            <div class="allimi-left-body">

                                <div class="allimi-left-body-left">

                                    <div class="allimi-body-title">

                                        <span>미용 알리미</span>

                                    </div>
                                    <div class="allimi-body-list">
                                        <div class="allimi-body-cell">
                                            <div class="allimi-body-cell-title">
                                                <strong>이용일</strong>
                                            </div>
                                            <div class="allimi-body-cell-value">
                                                <span id="allimi_date"></span>
                                            </div>
                                            <div class="allimi-body-cell-icon">
<!--                                                <img src="/static/images/icon/10_ic-24-calendar@2x.png" alt="">-->
                                            </div>
                                        </div>

                                        <div class="allimi-body-cell">
                                            <div class="allimi-body-cell-title">
                                                <strong>이용펫</strong>
                                            </div>
                                            <div class="allimi-body-cell-value" id="allimi_pet_list">

                                            </div>
                                        </div>

                                        <div class="allimi-body-cell">
                                            <div class="allimi-body-cell-title">
                                                <strong>미용사진</strong>
                                            </div>
                                        </div>

                                        <div class="allimi-body-cell">

                                            <div class="allimi-gallery-wrap" id="allimi_gallery_wrap">
                                                <div class="allimi-gallery-cell allimi-gallery-cell-icon" id="allimi_open_gallery" style="cursor:pointer;" onclick="allimi_open_gallery(this)">
                                                    <img src="/static/images/icon/photo_icon.png" alt="">
                                                    <span class="allimi-gallery-span">사진첨부</span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="allimi-left-body-right">
                                    <div class="allimi-check-container">
                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="attitude_btn">
                                                <strong>미용예절</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_attitude">

                                                <label class="allimi-form-one">

                                                        <input type="radio" name="attitude" value="1">
                                                        <em></em>
                                                        <span class="allimi-radio-span">아주 잘 했어요. 칭찬해 주세요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="attitude" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">좋아요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="attitude" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">힘들어해요.</span>
                                                </label>
                                                <label class="allimi-form-one" id="attitude_etc">
                                                    <input type="radio" name="attitude" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span">기타</span>

                                                </label>
                                                <textarea id="allimi_attitude_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>

                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="tangle_btn">
                                                <strong>엉킴(부위)</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_tangle">

                                                <label class="allimi-form-one">

                                                    <input type="checkbox" name="tangle" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">없어요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="tangle" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">얼굴</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="tangle" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">귀</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="tangle" value="4">
                                                    <em></em>
                                                    <span class="allimi-radio-span">겨드랑이</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="tangle" value="5">
                                                    <em></em>
                                                    <span class="allimi-radio-span">다리</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="tangle" value="6">
                                                    <em></em>
                                                    <span class="allimi-radio-span">꼬리</span>
                                                </label>
                                                <label class="allimi-form-one" id="tangle_etc">
                                                    <input type="checkbox" name="tangle" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span">기타</span>
                                                </label>

                                                <textarea id="allimi_tangle_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>

                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="bath_btn">
                                                <strong>목욕/드라이</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_bath">

                                                <label class="allimi-form-one">

                                                    <input type="radio" name="bath" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">잘해요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="bath" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">조금 싫어해요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="bath" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">거부감이 있어요.</span>
                                                </label>
                                                <label class="allimi-form-one" id="bath_etc">
                                                    <input type="radio" name="bath" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span" >기타</span>

                                                </label>
                                                <textarea id="allimi_bath_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>
                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="skin_btn">
                                                <strong>피부</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_skin">

                                                <label class="allimi-form-one">

                                                    <input type="checkbox" name="skin" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">깨끗해요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">피부염</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">각질</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="4">
                                                    <em></em>
                                                    <span class="allimi-radio-span">붉은기</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="5">
                                                    <em></em>
                                                    <span class="allimi-radio-span">습진</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="6">
                                                    <em></em>
                                                    <span class="allimi-radio-span">농피증</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="skin" value="7">
                                                    <em></em>
                                                    <span class="allimi-radio-span">알로페시아</span>
                                                </label>
                                                <label class="allimi-form-one" id="skin_etc">
                                                    <input type="checkbox" name="skin" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span" >기타</span>

                                                </label>
                                                <textarea id="allimi_skin_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="allimi-check-container" style="margin-left:20px; margin-right:20px;">
                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="condition_btn">
                                                <strong>컨디션</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_condition">

                                                <label class="allimi-form-one">

                                                    <input type="radio" name="condition" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">좋아요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="condition" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">긴장했어요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="radio" name="condition" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">피곤해 해요.</span>
                                                </label>
                                                <label class="allimi-form-one" id="condition_etc">
                                                    <input type="radio" name="condition" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span">기타</span>

                                                </label>
                                                <textarea id="allimi_condition_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>

                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="dislike_btn">
                                                <strong>싫어했던 부위</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_dislike">


                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">얼굴</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">귀</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">앞발</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="4">
                                                    <em></em>
                                                    <span class="allimi-radio-span">뒷발</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="5">
                                                    <em></em>
                                                    <span class="allimi-radio-span">발톱</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="dislike" value="6">
                                                    <em></em>
                                                    <span class="allimi-radio-span">꼬리</span>
                                                </label>
                                                <label class="allimi-form-one" id="dislike_etc">
                                                    <input type="checkbox" name="dislike" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span">기타</span>
                                                </label>

                                                <textarea id="allimi_dislike_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>

                                        <div class="allimi-check-wrap">
                                            <div class="allimi-check-title" id="self_btn">
                                                <strong>미용 후 전달사항</strong>
                                            </div>
                                            <div class="allimi-check-list flex-column" id="check_list_self">

                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="self" value="1">
                                                    <em></em>
                                                    <span class="allimi-radio-span">피부 자극으로 긁거나 핥을 수 있으니 주의해주세요.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="self" value="2">
                                                    <em></em>
                                                    <span class="allimi-radio-span">스트레스로 인하여 식욕 부진, 구토 및 설사 증상을 보일 수 있습니다.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="self" value="3">
                                                    <em></em>
                                                    <span class="allimi-radio-span">항문을 끌고 다니거나 꼬리를 감추는 증상을 보일 수 있습니다.</span>
                                                </label>
                                                <label class="allimi-form-one">
                                                    <input type="checkbox" name="self" value="4">
                                                    <em></em>
                                                    <span class="allimi-radio-span">이중모(포메,스피츠 등)의 경우 미용 후 알로페시아(클리퍼 증후군) 현상이 나타날 수 있습니다.</span>
                                                </label>
                                                <label class="allimi-form-one" id="self_etc">
                                                    <input type="checkbox" name="self" value="0">
                                                    <em></em>
                                                    <span class="allimi-radio-span">기타</span>
                                                </label>
                                                <textarea id="allimi_self_textarea" class="allimi-textarea" ></textarea>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div class="allimi-left-footer">
                                <div class="allimi-alert">&#8251; 알리미 전송 시 <span style="color:#ff4848">샵에 등록된 펫이름이 고객에게 <br> 발송되니</span> 부적절한 이름은 변경 후 발송해주세요. &#8251;</div>
                                <div class="allimi-footer-cell cell-border-purple" id="allimi_preview_btn" onclick="allimi_open_preview(this,'',true)">미리보기</div>
                                <div class="allimi-footer-cell" onclick="pop.close2('allimi_pop')">취소</div>
                                <div class="allimi-footer-cell cell-fill-purple" onclick="allimi_send()">보내기</div>


                           </div>




                        </div>
                        <div class="allimi-right-wrap">
                            <div class="allimi-title-box" style="justify-content: center">
                                <div class="allimi-title" id="allimi-right-title">

                                </div>
                            </div>
                            <div class="allimi-right-body-default" id="allimi_defalut">
                                <img src="/static/images/ic_dog00_b.png" alt="">
                            </div>
                            <div class="allimi-right-body-gallery" id="allimi_gallery">

                                    <div class="allimi-gallery-list" id="allimi_gallery_list">
                                        <div class="allimi-gallery-list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>

                                    </div>
                                    <div style="display:block;position:absolute;top:-150px;" id="allimi_imgupfile_wrap"><input type="file" accept="image/*" name="allimi_imgupfile" id="allimi_addimgfile"></div>


                                    <div class="allimi-gallery-footer">
                                        <div class="allimi-footer-cell cell-fill-purple" style="width:100%; margin-bottom:30px; margin-top:30px;" id="allimi_select_photo" onclick="allimi_select_photo(this,true)">사진 선택 완료</div>

                                        <span>이미지는 최대 25개까지 등록할 수 있습니다.</span>
                                        <span>gif,png,jpg,jpeg 형식의 이미지만 등록됩니다.</span>
                                    </div>
                            </div>
                            <div class="allimi-right-body-preview" id="allimi_preview">

                                <div class="allimi-preview-wrap">
                                    <div class="allimi-preview-title">
                                        <span class="allimi-preview-name" id="allimi_preview_name">

                                        </span>
                                        <span class="allimi-preview-date" id="allimi_preview_date">

                                        </span>
                                    </div>
                                    <div class="allimi-preview-gallery" id="allimi_preview_gallery">

                                        <div class="swiper-container allimi-swiper-container">
                                            <div class="swiper-wrapper" id="allimi-preview-swiper">

                                            </div>
                                            <div class="next allimi-next" id="allimi_next"><i class="left-arrow""></i></div>
                                            <div class="prev allimi-prev" id="allimi_prev"><i class="right-arrow"></i></div>
                                            <div class="swiper-pagination allimi-pagination"></div>
                                        </div>
                                    </div>

                                    <div class="allimi-preview-info">
                                        <div class="allimi-preview-info-title"><span style="font-size:16px; font-weight: 500;">미용 다이어리</span></div>

                                        <div class="allimi-preview-info-content">
                                            <ul>
                                                <li class="list-style-basic" id="allimi_preview_attitude_wrap"><strong>미용예절</strong><br><span id="allimi_preview_attitude"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_tangle_wrap"><strong>엉킴(부위)</strong><br><span id="allimi_preview_tangle"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_bath_wrap"><strong>목욕/드라이</strong><br><span id="allimi_preview_bath"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_skin_wrap"><strong>피부</strong><br><span id="allimi_preview_skin"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_condition_wrap"><strong>컨디션</strong><br><span id="allimi_preview_condition"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_dislike_wrap"><strong>싫어했던 부위</strong><br><span id="allimi_preview_dislike"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_self_wrap"><strong>미용 후 전달사항</strong><br><span id="allimi_preview_self" style="white-space: pre-line"></span></li>
                                                <li class="list-style-basic" id="allimi_preview_none"><strong>알림 내용이 없습니다.</strong></li>

                                            </ul>
                                        </div>

                                    </div>


                                    <div class="allimi-preview-info" style="margin-bottom:30px;">
                                        <div class="allimi-preview-info-title"><span style="font-size:16px; font-weight: 500;">샵 정보</span></div>

                                        <div class="allimi-preview-info-content" style="padding-left:20px;">

                                            <div class="allimi-preview-shop-title"><span id="allimi_preview_shop_title"></span></div>
                                            <div class="allimi-preview-shop-phone">연락처<span id="allimi_preview_shop_phone"></span></div>
                                            <div class="allimi-preview-shop-address">샵 위치<span id="allimi_preview_shop_address"></span></div>
                                            <div class="allimi-preview-shop-map" id="allimi_preview_shop_map"></div>
                                        </div>

                                    </div>
                                    <div class="blank-space"></div>
                                </div>

                            </div>

                            <div class="allimi-right-body-history" id="allimi_history">

                                <div class="allimi-history-wrap">

                                    <select class="allimi-body-title"  style="display:none;" id="allimi_history_select" onchange="allimi_history_change(this);">
                                    </select>

                                    <div class="allimi-history-list" id="allimi_history_list">

                                    </div>
                                    <div class="common-none-data"  style="display:none;" id="allimi_history_none">
                                        <div class="none-inner">
                                            <div class="item-visual"><img src="/static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                            <div class="item-info">발송된 알리미 내역이 없습니다.</div>
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
</article>

<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close2('reserveAcceptMsg1')">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- //wrap -->
<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=f2cf1f3b7e2ca88cb298196078ef550f&libraries=services"></script>

<script src="/static/js/common.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/booking.js"></script>
<script src="/static/js/customer.js"></script>
<script src="/static/js/imagesloaded.pkgd.min.js"></script>
<script src="/static/js/jquery-ui.min.js"></script>

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
        today_reserve(artist_id,true);
        set_image('front_image');
        prepend_data('consulting_count schedule_count new_review_count total_count nick');
        // stats();
        gnb_actived('gnb_home');
        break_time(artist_id);
        allimi_btn_event();

        get_part_time(artist_id);

        gallery.init()

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
                    console.log(body)

                    if(body.length > 0){


                    let open = body[0].open_time;
                    let close = body[0].close_time;
                    localStorage.setItem('open_close', `${open}/${close}`)
                    }
                }
            }
        })


    })



    let slide_length = document.querySelector("#popup-wraper").children.length-1;

    let random = Math.floor(Math.random()*10);

    while(random > slide_length){

        random = Math.floor(Math.random()*10);

    }



    let popup_swiper_1 = new Swiper('.swiper-container_front', {

        direction:'horizontal',
        slidesPerView:1,

        observer:true,
        observeParents:true,

        navigation:{
            nextEl:".prev",
            prevEl:".next",
        },
        watchOverflow:true,
        initialSlide:random


    });

    let popup_swiper = new Swiper('.allimi-swiper-container', {

        direction:'horizontal',
        slidesPerView:1,
        pagination:{
            el:".swiper-pagination",
            type:"fraction"
        },

        observer:true,
        observeParents:true,

        navigation:{
            nextEl:".prev",
            prevEl:".next",
        },
        watchOverflow:true,


    });

    document.getElementById('allimi-preview-swiper').addEventListener('mouseenter',function(){

        document.getElementById('allimi_prev').style.opacity = '0.6';
        document.getElementById('allimi_next').style.opacity = '0.6';
    })

    document.getElementById('allimi-preview-swiper').addEventListener('mouseleave',function(){

        document.getElementById('allimi_prev').style.opacity = '0';
        document.getElementById('allimi_next').style.opacity = '0';
    })

    document.getElementById('allimi_prev').addEventListener('mouseenter',function(){

        document.getElementById('allimi_prev').style.opacity = '0.6';
        document.getElementById('allimi_next').style.opacity = '0.6';
    })

    document.getElementById('allimi_next').addEventListener('mouseenter',function(){

        document.getElementById('allimi_prev').style.opacity = '0.6';
        document.getElementById('allimi_next').style.opacity = '0.6';
    })

    document.getElementById('allimi_next').addEventListener('mouseleave',function(){

        document.getElementById('allimi_prev').style.opacity = '0';
        document.getElementById('allimi_next').style.opacity = '0';
    })
    document.getElementById('allimi_prev').addEventListener('mouseleave',function(){

        document.getElementById('allimi_prev').style.opacity = '0';
        document.getElementById('allimi_next').style.opacity = '0';
    })


    function getCookie_popup(name) {
        var obj = name + "=";
        var x = 0;
        while (x <= document.cookie.length) {
            var y = (x + obj.length);
            if (document.cookie.substring(x, y) == obj) {
                if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                    endOfCookie = document.cookie.length;
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf(" ", x) + 1;
            if (x == 0)
                break;
        }
        return "";
    }
    function setCookie_popup(name, value, expiredays) {
        var todayDate = new Date();
        todayDate.setDate(todayDate.getDate() + expiredays);
        document.cookie = name + '=' + escape(value) + '; path=/; expires=' + todayDate.toGMTString() + '; SameSite=None; Secure';
    }

    $(document).ready(function(){

            if (getCookie_popup('guide_beauty_shop') != 'Y') {
                $("#popup_wrap").dialog({
                    modal: true,
                    title: "",
                    autoOpen: true,
                    //maxWidth: "96%",
                    //minHeight: Number($(window).height()) - 40,
                    //width: 'auto',
                    //height: 'auto',
                    autoSize: false,
                    resize: 'auto',
                    resizable: false,
                    draggable: false,
                    buttons: {
                        '닫기': function() {
                            // setCookie_popup('guide_beauty_shop ', 'Y', 1);
                            $(this).dialog("close");
                        },
                        "오늘 그만보기": function() {
                            // location.href = "mypage_notice_view?notice_seq=19";
                            setCookie_popup('guide_beauty_shop', 'Y', 1);
                            $(this).dialog("close");
                        }
                    },
                    open: function(event, ui) {
                        // swiper2.update();
                        $(event.target).parent().css('position', 'fixed'); // dialog fixed
                        $(event.target).parent().css('top', '50%'); // dialog fixed
                        $(event.target).parent().css('left', '50%'); // dialog fixed
                        $(event.target).parent().css('transform', 'translate(-50%, -50%)'); // dialog fixed
                        // $('.ui-dialog').position({ my: "center", at: "center", of: window });
                    },
                    close: function() {
                    }
                });
            }






    });




</script>
</body>
</html>