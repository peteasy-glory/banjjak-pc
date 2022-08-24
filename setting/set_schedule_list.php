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
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-schedule-wrap">
										<div class="wide-tab">
											<div class="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell actived"><a href="#" class="btn-tab-item">미용</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item">호텔</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item">유치원</a></div>
											</div>
										</div>
										<!-- 내용이 있을 경우 -->
										<div class="basic-data-group vmiddle">
											<div class="con-title-group">
												<h4 class="con-title">영업시간</h4>
											</div>
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h6 class="con-title">기본영업시간</h6>
														</div>
														<div class="msg-select-group">
															<div class="msg-item read">
																<div class="item-value open_close"></div>
															</div>
															<div class="msg-item read">
																<div class="item-value">공휴일은 쉬어요</div>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h6 class="con-title">휴게시간</h6>
														</div>
														<div class="msg-select-group">
															<div class="msg-item read">
																<div class="item-value">오전 09:00 ~ 오후 06:00</div>
															</div>
															<div class="msg-item read">
																<div class="item-value">오전 09:00 ~ 오후 06:00</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h4 class="con-title">예약스케줄 운영시간</h4>
														</div>
														<div class="con-title-group">
															<h6 class="con-title">타임제</h6>
														</div>
														<div class="msg-select-group">
															<div class="msg-item read">
																<div class="item-value">오전 09:00 ~ 오후 06:00</div>
															</div>
															<div class="msg-item read">
																<div class="item-value">오전 09:00 ~ 오후 06:00</div>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h4 class="con-title">정기휴무</h4>
														</div>
														<div class="con-title-group">
															<h6 class="con-title">요일</h6>
														</div>
														<div class="form-week-select">
															<div class="form-week-select-inner">
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled checked><em>월</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>화</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>수</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>목</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>금</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>토</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" disabled><em>일</em></label></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">임시휴무</h4>
											</div>
											<div class="flex-table read w-90">
												<div class="flex-table-cell">
													<div class="flex-table-item">
														<div class="flex-table-title"><div class="txt">실장</div></div>
														<div class="flex-table-data">
															<div class="flex-table-data-inner">
																2021.10.04 ~ 2021.10.04
															</div>														
														</div>
													</div>
												</div>
												<div class="flex-table-cell">
													<div class="flex-table-item">
														<div class="flex-table-title"><div class="txt">이름이 길경우 줄바꿈 됩니다</div></div>
														<div class="flex-table-data">
															<div class="flex-table-data-inner">
																2021.10.04 / 오후 02:00 ~ 오후 03:00
															</div>														
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- //내용이 있을 경우 -->
										<!-- 내용이 없을 경우 -->
										<div class="basic-data-group vmiddle text-align-center">
											<a href="#" class="btn btn-purple btn-basic-wide"><strong>영업시간 등록하기</strong></a>
											<div class="common-none-data">
												<div class="none-inner">
													<div class="item-visual"><img src="../assets/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">영업시간이 등록되지 않았습니다.</div>
													<div class="item-desc text-align-center">미용, 호텔, 유치원/놀이터의 각 서비스 유형에 맞춰 영업시간을 설정할 수 있습니다.<br>영업시간 내 휴식 및 점심간은 휴게시간으로 간편하게 설정하세요.</div>
												</div>
											</div>
										</div>
										<!-- //내용이 없을 경우 -->
									</div>
								</div>
							</div>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom">수정하기</a>								
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
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        //get_navi(artist_id);
        get_open_close(artist_id);
        //data_set(artist_id);
    })
</script>
</body>
</html>