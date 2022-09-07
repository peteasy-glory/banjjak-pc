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
				<div class="basic-data-group">
					<div class="data-row">
						<div class="data-col-middle">
							<div class="basic-data-card">
								<div class="card-header">
									<h3 class="card-header-title">샵 후기 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="master-review-wrap">
											<!-- 내용이 있을 때 -->			
											<div class="review-detail-list do_review_list" style="display: none;">
											</div>
											<!-- //내용이 있을 때 -->
											<!-- 내용이 없을 때 -->
											<div class="common-none-data none_review_list" style="display: block">
												<div class="none-inner">
													<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">이용 후기가 없습니다.<span>단골 고객께 후기를 권유해 보는 것은 어떨까요? </span></div>
												</div>
											</div>
											<!--//내용이 없을 때 -->
										</div>
									</div>
								</div>
							</div>			
						</div>
						<div class="data-col-right">
							<div class="basic-data-card page-preview-wrap">
								<iframe src="https://customer.banjjakpet.com/reserve_view_shop?type=beauty&artist_id=<?=$artist_id?>" class="page-preview-view"></iframe>
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

    <!-- 답글작성 팝업 -->
    <form id="recommentWrite" class="layer-pop-wrap">
        <input type="hidden" name="idx" class="idx" value="">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data data-pop-view">
                    <div class="pop-header">
                        <h4 class="con-title">답글 작성</h4>
                    </div>
                    <div class="pop-body">
                        <div class="form-group-item">
                            <div class="form-item-label">내용</div>
                            <div class="form-item-data type-3">
                                <textarea name="reply" class="reply"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-purple" onclick="pop.open('save_pop');"><strong>등록하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </form>
    <!-- //답글작성 팝업 -->

    <article id="save_pop" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">저장하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="save_ok();">저장</button>
                        <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <form id="delete_pop" class="layer-pop-wrap">
        <input type="hidden" name="idx" class="idx" value="">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">답글을 삭제하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="delete_ok();">삭제</button>
                        <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/shop.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_review_list(artist_id);
        console.log(shop_array);

        // 리스트 뿌려주기
        if(shop_array[0] != ''){
            var html = '';
            if(shop_array[0].length){
                $.each(shop_array[0], function(i,v){
                    var reg_year = v.reg_time.substr(0,4);
                    var reg_month = v.reg_time.substr(4,2);
                    var reg_day = v.reg_time.substr(6,2);

                    var reply_year = v.reply_time.substr(0,4);
                    var reply_month = v.reply_time.substr(4,2);
                    var reply_day = v.reply_time.substr(6,2);

                    var customer_photo = (v.photo != '')? img_link_change(v.photo) : "";
                    var rating = '';
                    for(var i=0;i<v.rating;i++){
                        rating += '<div class="icon icon-size-16 icon-star-yellow"></div>';
                    }
                    for(v.rating=0;i<5;i++){
                        rating += '<div class="icon icon-size-16 icon-star-gray"></div>';
                    }
                    var review_photo = '';
                    $.each(v.review_images, function(index,value){
                        review_photo += `<div class="list-cell"><div class="btn-portfolio-item"><img src="${img_link_change(value.path)}" alt=""></div></div>`;
                    })
                    var artist_reply = '';
                    if(v.artist_reply != ''){
                        artist_reply = `
                            <div class="recomment-list">
                                <div class="recomment-cell">
                                    <div class="recomment-item">
                                        <div class="user-thumb-wrap">
                                            <div class="user-thumb"><img src="${img_link_change(v.front_image)}" alt=""></div>
                                        </div>
                                        <div class="recomment-data">
                                            <div class="item-name">${v.name}<span class="date">${reply_year}-${reply_month}-${reply_day}</span></div>
                                            <div class="item-detail">${db_to_str(v.artist_reply)}</div>
                                        </div>
                                    </div>
                                    <div class="grid-layout toggle-button-group">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-gray btn-small-size" onclick="open_reply_pop('${v.review_seq}','${db_to_str(v.artist_reply)}');">수정</a></div>
                                            <div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-gray btn-small-size" onclick="open_delete_pop('${v.review_seq}');">삭제</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }else{
                        artist_reply = `
                            <div class="comment-item-btns"><a href="#" class="btn btn-outline-purple btn-small-size" onclick="open_reply_pop('${v.review_seq}','');">답글 작성</a></div>
                        `;
                    }
                    html += `
                        <div class="review-detail-cell">
                            <div class="comment-item">
                                <div class="item-user-info">
                                    <div class="user-thumb-wrap">
                                        <div class="user-thumb"><img src="${customer_photo}" alt=""></div>
                                    </div>
                                    <div class="user-data">
                                        <div class="data-inner">
                                            <div class="user-name">${v.nickname}</div>
                                            <div class="user-grade">
                                                <div class="icon-star-group">
                                                    ${rating}
                                                </div>
                                                <div class="time">${reg_year}-${reg_month}-${reg_day}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-gallery">
                                    <div class="portfolio-list-wrap">
                                        <div class="list-inner">
                                            ${review_photo}
                                        </div>
                                    </div>
                                </div>
                                <div class="item-detail">${db_to_str(v.review)}</div>
                            </div>
                            ${artist_reply}
                        </div>
                    `;
                })
            }else{
                var v = shop_array[0];
                var customer_photo = (v.photo != '')? img_link_change(v.photo) : "";
                var rating = '';
                for(var i=0;i<v.rating;i++){
                    rating += '<div class="icon icon-size-16 icon-star-yellow"></div>';
                }
                for(v.rating=0;i<5;i++){
                    rating += '<div class="icon icon-size-16 icon-star-gray"></div>';
                }
                var review_photo = '';
                $.each(v.review_images, function(index,value){
                    review_photo += `<div class="list-cell"><div class="btn-portfolio-item"><img src="${img_link_change(value.path)}" alt=""></div></div>`;
                })
                var artist_reply = '';
                if(v.artist_reply != ''){
                    artist_reply = `
                        <div class="recomment-list">
                            <div class="recomment-cell">
                                <div class="recomment-item">
                                    <div class="user-thumb-wrap">
                                        <div class="user-thumb"><img src="${img_link_change(v.front_image)}" alt=""></div>
                                    </div>
                                    <div class="recomment-data">
                                        <div class="item-name">${v.name}<span class="date">1일 전</span></div>
                                        <div class="item-detail">${db_to_str(v.artist_reply)}</div>
                                    </div>
                                </div>
                                <div class="grid-layout toggle-button-group">
                                    <div class="grid-layout-inner">
                                        <div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-gray btn-small-size" onclick="open_reply_pop('${v.review_seq}','${db_to_str(v.artist_reply)}');">수정</a></div>
                                        <div class="grid-layout-cell grid-2"><a href="#" class="btn btn-outline-gray btn-small-size" onclick="open_delete_pop('${v.review_seq}');">삭제</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }else{
                    artist_reply = `
                        <div class="comment-item-btns"><a href="#" class="btn btn-outline-purple btn-small-size" onclick="open_reply_pop('${v.review_seq}','');">답글 작성</a></div>
                    `;
                }
                html += `
                    <div class="review-detail-cell">
                        <div class="comment-item">
                            <div class="item-user-info">
                                <div class="user-thumb-wrap">
                                    <div class="user-thumb"><img src="${customer_photo}" alt=""></div>
                                </div>
                                <div class="user-data">
                                    <div class="data-inner">
                                        <div class="user-name">${v.nickname}</div>
                                        <div class="user-grade">
                                            <div class="icon-star-group">
                                                ${rating}
                                            </div>
                                            <div class="time">5시간 전</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-gallery">
                                <div class="portfolio-list-wrap">
                                    <div class="list-inner">
                                        ${review_photo}
                                    </div>
                                </div>
                            </div>
                            <div class="item-detail">${db_to_str(v.review)}</div>
                        </div>
                        ${artist_reply}
                    </div>
                `;
            }
            $(".do_review_list").css("display","block");
            $(".none_review_list").css("display","none");
            $(".do_review_list").html(html);
        }
    })

    // 수정, 저장 팝업
    function open_reply_pop(idx, reply){
        $("#recommentWrite .idx").val(idx);
        $("#recommentWrite .reply").val(reply);
        pop.open('recommentWrite');
    }

    // 답글 저장하기
    function save_ok(){
        pop.close();
        var idx = $("#recommentWrite .idx").val();
        var reply = str_to_db($("#recommentWrite .reply").val());
        var postData = '';
        postData += 'idx='+idx;
        postData += '&reply='+reply;
        postData += '&mode=put_reply';
        put_reply(postData);
    }

    // 삭제 팝업
    function open_delete_pop(idx){
        $("#delete_pop .idx").val(idx);
        pop.open('delete_pop');
    }

    // 삭제하기
    function delete_ok(){
        pop.close();
        var idx = parseInt($("#delete_pop .idx").val());
        del_reply(idx);
    }
</script>
</body>
</html>