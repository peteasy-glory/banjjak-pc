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
					<div class="data-col-middle">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">작업 / 결제관리</h3>
								<div class="card-header-right">
									<div class="label label-outline-purple large round"><em>승인대기</em></div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="wide-tab">
										<div class="wide-tab-inner">
											<!-- 활성화시 actived클래스 추가 -->
											<div class="tab-cell actived"><a href="#" class="btn-tab-item">작업 관리</a></div>
											<div class="tab-cell"><a href="#" class="btn-tab-item">결제 관리</a></div>
										</div>
									</div>
									<div class="basic-data-group vsmall">
										<div class="con-title-group">
											<h4 class="con-title">예약자 정보</h4>
										</div>
										<div class="customer-view-user-info">
											<div class="customer-user-table">
												<div class="customer-user-table-row">
													<div class="customer-user-table-title"><div class="table-title">아이디</div></div>
													<div class="customer-user-table-data">
														<div class="table-data">
															<div class="table-user-name">																
																boong_232321
																<div class="user-grade-item">
																	<div class="icon icon-grade-vip"></div>
																	<div class="icon-grade-label">VIP</div>
																</div>
															</div>															
														</div>																												
													</div>
													<div class="customer-user-info-ui">
														<div class="label label-outline-pink">NO SHOW 1회</div>
													</div>
												</div>
												<div class="customer-user-table-row">
													<div class="customer-user-table-title"><div class="table-title">연락처</div></div>
													<div class="customer-user-table-data">
														<div class="table-data">
															<div class="customer-user-phone-wrap read">
																<div class="item-main-phone"><div class="value">010-1234-1234</div></div>
																<div class="item-sub-phone"><div class="value">010-1234-1234</div><div class="value">010-1234-1234</div><div class="value">010-1234-1234</div></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="basic-data-group">
										<div class="con-title-group">
											<h4 class="con-title">예약동물 정보</h4>
											<div class="con-title-btns">
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 갤러리</button></div>
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 동의서 작성</button></div>
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
										<div class="basic-data-group middle">
											<div class="form-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">특이사항</div>
																<div class="form-item-data type-2">
																	<div class="form-textarea-btns">
																		<textarea style="height:60px;" placeholder="입력"></textarea>
																		<button type="button" class="btn btn-outline-gray">저장</button>
																	</div>
																	<div class="form-input-info">(고객에게는 노출되지 않습니다.)</div>		
																</div>
															</div>
														</div>	
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">견주관련 메모</div>
																<div class="form-item-data type-2">
																	<div class="form-textarea-btns">
																		<textarea style="height:60px;" placeholder="입력"></textarea>
																		<button type="button" class="btn btn-outline-gray">저장</button>
																	</div>
																	<div class="form-input-info">(고객에게는 노출되지 않습니다.)</div>		
																</div>
															</div>
														</div>	
													</div>	
												</div>	
											</div>	
										</div>	
									</div>
									<div class="basic-data-group">
										<div class="wide-tab card">
											<div class="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell actived"><a href="#" class="btn-tab-item">미용</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item">호텔</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item">유치원</a></div>
											</div>
										</div>
										<div class="basic-data-group vvsmall3">
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">	
													<div class="grid-layout-cell grid-2">
														<div class="note-toggle-group">
															<div class="con-title-group">
																<!--
																<h4 class="con-title"><a href="#" class="btn-con-title"><div>이전 특이사항</div><div class="icon icon-btn-more-black"></div></a></h4>
																-->
																<h4 class="con-title">이전 특이사항</h4>
															</div>
															<div class="memo-item-list note-toggle-list">
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
																<div class="memo-item note-toggle-cell"><div class="note-desc"><em>2021.12.23</em><div class="txt">너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다. 너무 이쁜 포메입니다.</div></div></div>
															</div>		
															<div class="note-toggle-ui">
																<button type="button" class="btn-note-toggle">더보기</button>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2">
														<div class="note-toggle-group">
															<div class="con-title-group">
																<!--
																<h4 class="con-title"><a href="#" class="btn-con-title"><div>이전 이용내역</div><div class="icon icon-btn-more-black"></div></a></h4>
																-->
																<h4 class="con-title">이전 이용내역</h4>
															</div>
															<div class="memo-item-list note-toggle-list">
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
																<div class="memo-item note-toggle-cell">2021.11.28 / 잭 / 위생+목욕 / 5Kg / 0원<div class="memo-link"><a href="#" class="btn-memo-link">상세보기<div class="icon icon-arrow-right-small"></div></a></div></div>
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
								</div>
							</div>
							<div class="card-footer line">
								<div class="grid-layout btn-grid-group">
									<div class="grid-layout-inner">
										<div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-purple"><strong>예약 확정</strong></a></div>
										<div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-purple"><strong>예약신청 취소</strong></a></div>
									</div>
								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">예약 정보</h3>								
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-data-group">
										<div class="user-receipt-item">
											<div class="con-title-group">
												<h5 class="con-title">예약 내용</h5>
												<button type="button" class="btn-side btn btn-outline-purple btn-round-full btn-vsmall-size">알림톡 발송 이력</button>
											</div>
											<div class="text-list-wrap type-2">
												<div class="text-list-cell"><div class="item-title unit">날짜</div><div class="item-data">2020.10.10</div></div>
												<div class="text-list-cell"><div class="item-title unit">선생님</div><div class="item-data">크리스티아누</div></div>
												<div class="text-list-cell">
													<div class="item-title unit align-self-center">시간</div>
													<div class="item-data">
														<div class="form-datepicker-group">
															<div class="form-datepicker">
																<select>
																	<option value="">오전 11:30</option>
																	<option value="">오전 11:30</option>
																	<option value="">오전 11:30</option>
																</select>
															</div>
															<div class="form-unit">~</div>
															<div class="form-datepicker">
																<select>
																	<option value="">오후 11:30</option>
																	<option value="">오후 11:30</option>
																	<option value="">오후 11:30</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="basic-data-group vsmall"><button type="button" class="btn btn-outline-gray btn-basic-full">시간만 변경</button></div>
											<div class="form-bottom-info"><span>*시간 변경만 하는 경우 시간선택 후 변경을 눌러주세요.</span></div>
										</div>
										<div class="basic-data-group small">
											<div class="grid-layout btn-grid-group">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2"><button type="button" class="btn btn-purple">날짜/미용사 변경</button></div>
													<div class="grid-layout-cell grid-2"><button type="button" class="btn btn-outline-purple">예약 취소</button></div>
												</div>
											</div>
										</div>
									</div>
									<div class="basic-data-group">
										<div class="con-title-group">
											<h4 class="con-title">미용 종료 알림 발송</h4>
										</div>
										<div class="basic-data-group vvsmall">
											<div class="grid-layout basic">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-4"><label class="form-toggle-box block"><input type="radio" name="time1"><em>지금종료</em></label></div>
													<div class="grid-layout-cell grid-4"><label class="form-toggle-box block"><input type="radio" name="time1"><em>10분전</em></label></div>
													<div class="grid-layout-cell grid-4"><label class="form-toggle-box block"><input type="radio" name="time1"><em>15분전</em></label></div>
													<div class="grid-layout-cell grid-4"><label class="form-toggle-box block"><input type="radio" name="time1"><em>20분전</em></label></div>
													<div class="grid-layout-cell grid-4"><label class="form-toggle-box block"><input type="radio" name="time1"><em>30분전</em></label></div>
												</div>
											</div>
										</div>
										<div class="form-bottom-info">*시간 선택 후 발송을 누르면 견주에게 즉시알림이 발송됩니다.</div>
										<div class="basic-data-group vmiddle">
											<div class="grid-layout btn-grid-group">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2"><button type="button" class="btn btn-outline-gray">예시보기</button></div>
													<div class="grid-layout-cell grid-2"><button type="button" class="btn btn-outline-purple">발송</button></div>
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
			<!-- //view -->
		</section>
		<!-- //contents -->
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/pc_script.js"></script>
<script>
    $(document).ready(function(){

        gnb_init();
        prepend_data('consulting_count nick');
        set_image('front_image');



    })

        


</script>
</body>
</html>