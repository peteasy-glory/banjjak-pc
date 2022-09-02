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
								<h3 class="card-header-title" id="customer_view_cellphone">010-1234-1234</h3>
								<div class="card-header-right">
									<a href="#" class="btn btn-small-size btn-outline-gray btn-basic-vsmall btn-inline">삭제</a>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">고객 정보</h4>
										</div>
										<div class="customer-view-user-info">
											<div class="customer-user-table" id="user-table">

											</div>
										</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">펫 정보</h4>
										</div>
										<div class="basic-data-group vvsmall">
											<div class="grid-layout btn-grid-group">
												<div class="grid-layout-inner">
													<!-- btn-toggle-button 클래스에 actived클래스 추가시 활성화 -->
													<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button actived">전체</button></div>
													<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button">몽이</button></div>
													<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button">까미</button></div>
													<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button">쫑이</button></div>
													<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button btn-toggle-basic"><span class="icon icon-plus-more-small"></span></button></div>
												</div>
											</div>
										</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">예약동물 정보</h4>
											<div class="con-title-btns">
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 갤러리</button></div>
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 동의서 작성</button></div>
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">호텔 동의서 작성</button></div>
											</div>
										</div>
										<div class="customer-view-pet-info detail-toggle-parents">
											<div class="item-thumb">
												<div class="user-thumb large"><!--<img src="../assets/images/user_thumb.png" alt="">--></div>
												<div class="item-thumb-ui"><a href="#" class="btn btn-outline-gray btn-vsmall-size btn-inline">펫 정보 수정</a></div>
											</div>
											<div class="item-user-data">
												<div class="grid-layout flex-table">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">이름</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		콩이
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">품종</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		포메라이언
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">성별</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		남아
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">무게</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		5.3kg
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">생일</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		2017.03.12 (5년 3개월)
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">중성화</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		O
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">중성화</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		O
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">미용경험</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">예방접종</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">입질</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">슬개골 탈구</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">특이사항</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">싫어하는 부위</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">기타</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		미기입
																	</div>																
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="item-action">
												<button type="button" class="btn-detail-toggle">펫 정보 자세히 보기</button>
											</div>
										</div>
										<div class="basic-data-group middle text-align-center">
											<a href="#" class="btn btn-purple btn-inline btn-basic-wide">즉시 예약</a>
										</div>
										<div class="form-bottom-info text-align-center"><strong>*[즉시예약]</strong>은 주간 스케줄에서만 사용 가능</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">특이사항</h4>
										</div>
										<div class="basic-data-group vvsmall2 note-toggle-group">
											<div class="grid-layout margin-5-17 note-toggle-list">
												<div class="grid-layout-inner">	
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2 note-toggle-cell">
														<div class="special-note">
															<div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div>
														</div>
													</div>
												</div>							
											</div>				
											<div class="note-toggle-ui">
												<button type="button" class="btn-note-toggle">더보기</button>
											</div>
										</div>															
									</div>
								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">이용내역</h3>
							</div>
							<div class="card-body">								
								<div>
									<table class="customer-table small">
										<colgroup>
											<col style="width:28%">
											<col style="width:22%">
											<col style="width:18%">
											<col style="width:16%">
											<col style="width:16%">
										</colgroup>
										<thead>
											<tr>
												<th rowspan="2">펫이름</th>
												<th rowspan="2">미용 일시</th>
												<th rowspan="2">내역</th>
												<th colspan="2">총 이용내역</th>
											</tr>
											<tr>
												<th>카드</th>
												<th>현금</th>
											</tr>
										</thead>
										<tbody>
											<!-- 하나의 아이템 -->
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2 actived">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<!-- actived클래스 추가시 활성화 -->
											<tr class="customer-table-view actived">
												<td colspan="5">
													<div class="flex-table">
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">예약일시</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		중형견미용
																	</div>																
																</div>
															</div>
														</div>
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">미용사</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		중형견미용
																	</div>																
																</div>
															</div>
														</div>
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">추가</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		X
																	</div>																
																</div>
															</div>
														</div>
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">취소일시</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		X
																	</div>																
																</div>
															</div>
														</div>
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">적립금</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		사용:0 누적:0
																	</div>																
																</div>
															</div>
														</div>
														<div class="flex-table-cell">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">결제방식</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner">
																		카드
																	</div>																
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											<!-- //하나의 아이템 -->
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
											<tr class="customer-table-cell">		
												<td>
													<!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
													<button type="button" class="customer-table-toggle type-2">
														<span class="toggle-title"><span class="ellipsis">타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다. 타이틀입니다.</span></span>																
													</button>
												</td>
												<td>
													<div class="customer-table-txt">2021.09.03</div>
													<div class="customer-table-txt">19:15:03</div>
												</td>
												<td>
													<div class="customer-table-txt">미용</div>
													<div class="customer-table-txt">가위컷</div>
												</td>
												<td>
													<div class="customer-table-txt">15,000원</div>
												</td>
												<td>
													<div class="customer-table-txt">0원</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
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
<script src="../static/js/customer.js"></script>

<script>

    let artist_id = "<?=$artist_id?>";
    // data_set(artist_id)


    $(document).ready(function(){

        get_navi(artist_id)
        gnb_init();
        set_image('front_image');
        //prepend_data('consulting_count nick');
        gnb_actived('gnb_customer_wrap','gnb_inquire_all');
        customer_view_(artist_id)

    })



</script>
</body>
</html>