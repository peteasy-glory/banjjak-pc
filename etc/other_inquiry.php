<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
include($_SERVER['DOCUMENT_ROOT']."/include/check_login_shop.php");

$artist_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";


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
								<h3 class="card-header-title">1:1 문의하기</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="chat-wrap">
										<div class="chat-scroller">
											<!-- 내용이 있을 때 -->
											<div class="chat-scroller-inner do_qna" style="display: none;">
												<!-- 날짜별 그룹 -->
												<div class="chat-day-group">
													<div class="chat-date"><div class="date">2021.09.03</div></div>
													<div class="chat-item-list">
														<!-- 본인일 경우 -->
														<div class="chat-item me">
															<div class="chat-data">
																<div class="chat-cate">[예약/결제] <strong>예약은 어떻게 하나요?</strong></div>
																<div class="chat-txt">예약하는 방법을 모르겠어요. 예약하는 방법을 알려주세요. 어떻게 하면 되나요</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //본인일 경우 -->
														<!-- 상대방일 경우 -->
														<div class="chat-item person">
															<div class="chat-data">
																<div class="chat-txt">안녕하세요. 고객님. 예약이 어려우셨다니 송구스럽습니다. 예약 버튼을 눌러주시고, 펫을 선택 후 서비스와 일정을 선택하시면 예약을 하실 수 있습니다.</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //상대방일 경우 -->
													</div>
												</div>
												<!-- //날짜별 그룹 -->
												<!-- 날짜별 그룹 -->
												<div class="chat-day-group">
													<div class="chat-date"><div class="date">2021.09.03</div></div>
													<div class="chat-item-list">
														<!-- 본인일 경우 -->
														<div class="chat-item me">
															<div class="chat-data">
																<div class="chat-cate">[예약/결제] <strong>예약은 어떻게 하나요?</strong></div>
																<div class="chat-txt">예약하는 방법을 모르겠어요. 예약하는 방법을 알려주세요. 어떻게 하면 되나요</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //본인일 경우 -->
														<!-- 본인일 경우 -->
														<div class="chat-item me">
															<div class="chat-data">
																<div class="chat-cate">[예약/결제] <strong>예약은 어떻게 하나요?</strong></div>
																<div class="chat-txt">예약하는 방법을 모르겠어요. 예약하는 방법을 알려주세요. 어떻게 하면 되나요</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //본인일 경우 -->
														<!-- 본인일 경우 -->
														<div class="chat-item me">
															<div class="chat-data">
																<div class="chat-cate">[예약/결제] <strong>예약은 어떻게 하나요?</strong></div>
																<div class="chat-txt">예약하는 방법을 모르겠어요. 예약하는 방법을 알려주세요. 어떻게 하면 되나요</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //본인일 경우 -->
														<!-- 상대방일 경우 -->
														<div class="chat-item person">
															<div class="chat-data">
																<div class="chat-txt">안녕하세요. 고객님. 예약이 어려우셨다니 송구스럽습니다. 예약 버튼을 눌러주시고, 펫을 선택 후 서비스와 일정을 선택하시면 예약을 하실 수 있습니다.</div>
															</div>
															<div class="chat-time">11:13<br>2021.08.25</div>
														</div>
														<!-- //상대방일 경우 -->
													</div>
												</div>
												<!-- //날짜별 그룹 -->
											</div>
											<!-- //내용이 있을 때 -->
											<!-- 내용이 없을 때 -->
											<div class="common-none-data none_qna" style="display: block;">
												<div class="none-inner">
													<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">문의 내역이 없습니다.</div>
												</div>
											</div>
											<!-- //내용이 없을 때 -->
										</div>
									</div>
								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">1:1 문의하기</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<form id="qnaForm" class="form-group">
                                        <input type="hidden" name="partner_id" value="<?=$artist_id?>">
										<div class="grid-layout margin-14-17">
											<div class="grid-layout-inner">
												<div class="grid-layout-cell grid-1">
													<div class="form-group-item">
														<div class="form-item-label">문의 유형</div>
														<div class="form-item-data type-3">
															<div class="form-check-group">
																<div class="form-check-inner">
																	<div class="check-cell"><label class="form-radiobox" for="inquiryType1"><input type="radio" id="inquiryType1" name="main_type" value="판매상품등록"><span class="form-check-icon"><em>판매상품등록</em></span></label></div>
																	<div class="check-cell"><label class="form-radiobox" for="inquiryType2"><input type="radio" id="inquiryType2" name="main_type" value="정산관련"><span class="form-check-icon"><em>정산관련</em></span></label></div>
																	<div class="check-cell"><label class="form-radiobox" for="inquiryType3"><input type="radio" id="inquiryType3" name="main_type" value="판매자신청"><span class="form-check-icon"><em>판매자신청</em></span></label></div>
																	<div class="check-cell"><label class="form-radiobox" for="inquiryType4"><input type="radio" id="inquiryType4" name="main_type" value="예약결제관련"><span class="form-check-icon"><em>예약결제관련</em></span></label></div>
																	<div class="check-cell"><label class="form-radiobox" for="inquiryType5"><input type="radio" id="inquiryType5" name="main_type" value="기타"><span class="form-check-icon"><em>기타</em></span></label></div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="grid-layout-cell grid-1">
													<div class="form-group-item">
														<div class="form-item-label">제목</div>
														<div class="form-item-data">
															<input type="text" name="title" class="form-control" placeholder="">
														</div>
													</div>
												</div>
												<div class="grid-layout-cell grid-1">
													<div class="form-group-item">
														<div class="form-item-label">문의 내용</div>
														<div class="form-item-data type-2">
															<textarea style="height:220px;" name="contents"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>		
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom" onclick="pop.open('save_pop');">문의 접수</a>
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
    <article id="save_pop" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">문의하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="save_ok();">문의하기</button>
                        <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/etc.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_etc_wrap','gnb_ask');
        get_qna(artist_id);
        console.log(etc_array)

        // 리스트 뿌려주기
        if(etc_array[0] != ''){
            var html = '';
            if(etc_array[0].length){
                var date = '';
                $.each(etc_array[0], function(i,v){
                    var req_date = (v.req_date).substr(0,10);
                    var req_time = (v.req_date).substr(11,5);
                    var is_date = '';
                    if(date == req_date){
                        is_date = '';
                    }else{
                        is_date = `<div class="chat-date"><div class="date">${req_date}</div></div>`;
                        date = req_date;
                    }
                    var ans_html = '';
                    if(v.ans_idx > 0){
                        var ans_date = (v.ans_date).substr(0,10);
                        var ans_time = (v.ans_date).substr(11,5);
                        ans_html = `
                            <div class="chat-item person">
                                <div class="chat-data">
                                    <div class="chat-txt">${v.ans_body}</div>
                                </div>
                                <div class="chat-time">${ans_time}<br>${ans_date}</div>
                            </div>
                        `;
                    }
                    html += `
                        <div class="chat-day-group">
                            ${is_date}
                            <div class="chat-item-list">
                                <!-- 본인일 경우 -->
                                <div class="chat-item me">
                                    <div class="chat-data">
                                        <div class="chat-cate">[${v.req_main_type}] <strong>${v.req_title}</strong></div>
                                        <div class="chat-txt">${v.req_body}</div>
                                    </div>
                                    <div class="chat-time">${req_time}<br>${req_date}</div>
                                </div>
                                <!-- //본인일 경우 -->
                                <!-- 상대방일 경우 -->
                                ${ans_html}
                                <!-- //상대방일 경우 -->
                            </div>
                        </div>
                    `;
                })
            }else{
                var v = etc_array[0];
                var date = '';
                var req_date = (v.req_date).substr(0,10);
                var req_time = (v.req_date).substr(11,5);
                var is_date = '';
                if(date == req_date){
                    is_date = '';
                }else{
                    is_date = `<div class="chat-date"><div class="date">${req_date}</div></div>`;
                    date = req_date;
                }
                var ans_html = '';
                if(v.ans_idx > 0){
                    var ans_date = (v.ans_date).substr(0,10);
                    var ans_time = (v.ans_date).substr(11,5);
                    ans_html = `
                            <div class="chat-item person">
                                <div class="chat-data">
                                    <div class="chat-txt">${v.ans_body}</div>
                                </div>
                                <div class="chat-time">${ans_time}<br>${ans_date}</div>
                            </div>
                        `;
                }
                html += `
                     <div class="chat-day-group">
                        ${is_date}
                        <div class="chat-item-list">
                            <!-- 본인일 경우 -->
                            <div class="chat-item me">
                                <div class="chat-data">
                                    <div class="chat-cate">[${v.req_main_type}] <strong>${v.req_title}</strong></div>
                                    <div class="chat-txt">${v.req_body}</div>
                                </div>
                                <div class="chat-time">${req_time}<br>${req_date}</div>
                            </div>
                            <!-- //본인일 경우 -->
                            <!-- 상대방일 경우 -->
                            ${ans_html}
                            <!-- //상대방일 경우 -->
                        </div>
                    </div>
                `;
            }
            $(".do_qna").css("display","block");
            $(".none_qna").css("display","none");
            $(".do_qna").html(html);
        }
    })

    // 저장하기
    function save_ok(){
        pop.close();
        var postData = decodeURIComponent($("#qnaForm").serialize());
        postData += '&mode=post_qna';
        console.log(postData);
        post_qna(postData);
    }
</script>
</body>
</html>