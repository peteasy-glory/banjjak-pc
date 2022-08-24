<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");


if($_SESSION['my_shop_flag'] == 1){
    ?>
    <script>
        location.href="/";
    </script>
    <?php
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
				<div class="main-wrap">
					<div class="main-row">
						<div class="main-col-1">
							<!-- 메인 대쉬보드 -->
							<div class="main-col-group main-dashboard">
								<div class="basic-data-card main-dashboard-group">
									<div class="info-list-wrap">
										<div class="list-cell"><a href="#"><div class="title"><div class="icon icon-dashboard-1"></div><div class="txt">상담대기</div></div><div class="value">3</div></a></div>
										<div class="list-cell"><a href="#"><div class="title"><div class="icon icon-dashboard-2"></div><div class="txt">오늘일정</div></div><div class="value">1</div></a></div>
										<div class="list-cell"><a href="#"><div class="title"><div class="icon icon-dashboard-3"></div><div class="txt">신규후기</div></div><div class="value">24</div></a></div>
										<div class="list-cell"><a href="#"><div class="title"><div class="icon icon-dashboard-4"></div><div class="txt">전체고객</div></div><div class="value">3,000</div></a></div>
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
																<button type="button" class="btn-main-reserve-calendar-ui btn-month-prev"><span class="icon icon-calendar-prev-small"></span></button>
																<div class="main-reserve-calendar-title">
																	<div class="txt">2022.04</div>
																</div>
																<button type="button" class="btn-main-reserve-calendar-ui btn-month-next"><span class="icon icon-calendar-next-small"></span></button>
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
																					<div class="main-calendar-month-header-col saturday">일</div>
																				</div>
																			</div>
																			<div class="main-calendar-month-body">
																				<div class="main-calendar-month-body-row">
																					<div class="main-calendar-month-body-col before sunday">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col before">
																						<div class="main-calendar-col-inner">											
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col before">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col break">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="main-calendar-month-body-row">
																					<div class="main-calendar-month-body-col sunday">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col today">
																						<div class="main-calendar-col-inner">											
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col break">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="main-calendar-month-body-row">
																					<div class="main-calendar-month-body-col sunday">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">											
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col break">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="main-calendar-month-body-row">
																					<div class="main-calendar-month-body-col sunday">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col break">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="main-calendar-month-body-row">
																					<div class="main-calendar-month-body-col sunday">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">											
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col">
																						<div class="main-calendar-col-inner">										
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col break after">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="main-calendar-month-body-col after">
																						<div class="main-calendar-col-inner">									
																							<div class="main-calendar-toggle-group">
																								<a href="javascript:;" class="main-calendar-day-value"><div class="number">8</div><div class="value">11</div></a>
																								<div class="main-calendar-toggle-data">
																									<div class="main-calendar-toggle-list">
																										<div class="list-cell"><div class="btn-list-nav total"><div class="title">22.09.12</div><div class="value">11건</div></div></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">미용</div><div class="value">5건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">유치원</div><div class="value">3건</div></a></div>
																										<div class="list-cell"><a href="#" class="btn-list-nav"><div class="title">호텔</div><div class="value">3건</div></a></div>
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
															</div>
														</div>
														<div class="main-reserve-stats">
															<div class="main-reserve-stats-inner">
																<div class="main-reserve-stats-header">
																	<div class="item-title">등록 현황 통계</div>
																	<div class="item-date">22.04.11 업데이트</div>
																</div>
																<div class="main-reserve-stats-body">
																	<!-- 내용이 있을 때
																	<div class="main-reserve-graph">
																		<div class="graph-cell">
																			<div class="graph-item yellow" style="width:75%">현금 <em>75%</em></div>
																			<div class="graph-item purple" style="width:25%">카드 <em>25%</em></div>
																		</div>
																		<div class="graph-cell">
																			<div class="graph-item yellow" style="width:65%">강아지 <em>65%</em></div>
																			<div class="graph-item purple" style="width:35%">고양이 <em>35%</em></div>
																		</div>
																		<div class="graph-cell">
																			<div class="graph-item yellow" style="width:30%">신규 <em>30%</em></div>
																			<div class="graph-item purple" style="width:70%">기존 <em>70%</em></div>
																		</div>
																	</div>
																	//내용이 있을 때 -->
																	<!-- 내용이 없을 때 -->
																	<div class="main-reserve-graph-none">등록 현황이 없습니다.</div>
																	<!-- //내용이 없을 때 -->
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="main-reserve-col">
													<div class="main-product-wrap basic-data-card-inner">
														<div class="card-header">
															<div class="wide-tab">
																<div class="wide-tab-inner">
																	<!-- 활성화시 actived클래스 추가 -->
																	<div class="tab-cell actived"><a href="#" class="btn-tab-item">전체</a></div>
																	<div class="tab-cell"><a href="#" class="btn-tab-item">미용</a></div>
																	<div class="tab-cell"><a href="#" class="btn-tab-item">호텔</a></div>
																	<div class="tab-cell"><a href="#" class="btn-tab-item">유치원</a></div>
																</div>
															</div>
														</div>
														<div class="card-body scroller">
															<!-- 내용이 있을 때
															<div class="main-reserve-list">
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
																<div class="main-reserve-list-cell">
																	<a href="#" class="customer-card-item transparent">
																		<div class="item-info-wrap">
																			<div class="item-thumb"><div class="user-thumb middle"></div></div>
																			<div class="item-data">
																				<div class="item-data-inner">
																					<div class="item-pet-name">이름입니다.<div class="label label-yellow middle"><strong>말티즈</strong></div></div>
																					<div class="item-phone">010-1234-5678</div>
																					<div class="item-option">
																						<div class="option-cell"><div class="icon icon-size-16 icon-time-purple"></div>오전 11:00 ~ 오후 12:00</div>
																						<div class="option-cell">줄리아</div>
																					</div>
																				</div>
																			</div>
																			<div class="item-state">
																				<div class="item-sort">
																					<div class="txt-1">미용</div>
																					<div class="txt-2">전체미용</div>
																				</div>
																			</div>
																		</div>
																	</a>
																</div>
															</div>
															//내용이 있을 때 -->
															<!-- 내용이 없을 때 -->
															<div class="reserve-after-none">
																<div class="item-desc">오늘은 확정된 예약일정이 없습니다.<br>빈 시간을 판매해보세요.</div>
																<div class="item-btn"><a href="#" class="btn-point-underline">빈 시간 판매 알아보기</a></div>
																<div class="item-btn-buy">						
																	<a href="#" class="btn btn-outline-gray">빈 시간 판매하기</a>
																</div>
															</div>
															<!-- //내용이 없을 때 -->
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
								<div class="basic-data-card transparent main-phone-group">
									<div class="main-phone">
										<div class="item-input"><input type="text" placeholder="전화번호 뒷자리 입력"/></div>
										<button type="button" class="btn-main-phone">검색</button>
									</div>
								</div>
								<!-- //전화번호 검색 -->
							</div>
							<div class="main-col-group main-banner">
								<!-- 메인 배너 -->
								<div class="basic-swiper-banner">
									<div class="swiper-data">
										<div class="swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide"><a href="#" class="btn-basic-swiper-banner-nav"><img src="../assets/images/main_banner.png" alt=""/></a></div>
												<div class="swiper-slide"><a href="#" class="btn-basic-swiper-banner-nav"><img src="../assets/images/main_banner.png" alt=""/></a></div>
												<div class="swiper-slide"><a href="#" class="btn-basic-swiper-banner-nav"><img src="../assets/images/main_banner.png" alt=""/></a></div>
											</div>
										</div>
									</div>
									<div class="swiper-pagination"></div>
								</div>
								<!-- //메인 배너 -->
							</div>
							<div class="main-col-group main-customer">
								<!-- 메인 상담 -->
								<div class="basic-data-card">
									<div class="basic-data-card-inner">
										<div class="card-header">
											<div class="card-header-title">이용 상담 관리<div class="card-header-label">5</div></div>
											<div class="card-header-ui"><a href="#" class="btn-card-header-more">더보기</a></div>
										</div>
										<div class="card-body scroller">
											<!-- 내용이 있을 때
											<div class="main-customer-list">
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
												<div class="main-customer-list-cell">
													<a href="#" class="customer-card-item transparent">
														<div class="item-info-wrap">
															<div class="item-data">
																<div class="item-data-inner">
																	<div class="item-name">김춘식<div class="pet-name">말티즈</div></div>
																	<div class="item-phone">010-1234-5678</div>
																	<div class="item-date">2022.04.12 오후 02:52</div>
																</div>
															</div>
															<div class="item-state">
																<div class="item-time">10시간 전</div>
															</div>
														</div>
													</a>
												</div>
											</div>
											//내용이 있을 때 -->
											<!-- 내용이 없을 때 -->
											<div class="common-none-data">
												<div class="none-inner">
													<div class="item-visual"><img src="../assets/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">등록된 상담내역이 없습니다.</span></div>
												</div>
											</div>
											<!--//내용이 없을 때 -->
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
											<div class="main-notice-cell"><a href="#" class="btn-main-notice-item"><div class="txt">내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다.</div><div class="date">2022.04.10</div></a></div>
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
			</section>
			<!-- //contents -->
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
</body>
</html>