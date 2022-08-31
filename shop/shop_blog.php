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
									<h3 class="card-header-title">샵 연동 블로그 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="shop-blog-wrap">
										<a href="/shop/shop_blog_write.php" class="btn btn-outline-purple btn-inline btn-basic-wide"><strong>추가하기</strong></a>
										<!-- 내용이 있을 때 -->			
										<div class="do_blog" style="display: none;">
											<div class="vertical-list-wrap line">
												<div class="list-inner blog_list_wrap">
												</div>
											</div>
										</div>
										<!-- //내용이 있을 때 -->
										<!-- 내용이 없을 때 -->
										<div class="common-none-data none_blog" style="display: block;">
											<div class="none-inner">
												<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
												<div class="item-info">마이샵에 노출되는 블로그가 없습니다.<br><span>추가하기를 통해 네이버 블로그를<br>연동하여 샵에 노출해 주세요!</span></div>
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
    <form id="delete_pop" class="layer-pop-wrap">
        <input type="hidden" name="idx" class="idx" value="">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">삭제하시겠습니까?</div>
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
        get_blog_list(artist_id);
        console.log(shop_array);

        // 리스트 뿌려주기
        if(shop_array[0] != ''){
            var html = '';
            if(shop_array[0].length){
                $.each(shop_array[0], function(i,v){
                    var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                    var year = v.post_date.substr(0,4);
                    var month = v.post_date.substr(4,2);
                    var day = v.post_date.substr(6,2);
                    html += `
                        <div class="list-cell">
                            <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                            <div class="basic-item">
                                <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                    ${thumbnail}
                                    <div class="info-wrap">
                                        <div class="item-name">${v.title}</div>
                                        <div class="item-desc">${v.desc}</div>
                                        <div class="item-blog-option">
                                            <div class="name"><div class="ellipsis">${v.blogger_name}</div></div>
                                            <div class="date">${year}.${month}.${day}</div>
                                        </div>
                                    </div>
                                </a>
                                <div class="basic-item-ui">
                                    <button type="button" class="btn-basic-item-ui-nav"><span class="icon icon-size-16 icon-dot-more"></span></button>
                                    <div class="basic-item-ui-list">
                                        <a href="#" class="btn-basic-item-ui-item delete_blog" data-idx="${v.blog_seq}">삭제</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
            }else{
                var v = shop_array[0];
                var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                var year = v.post_date.substr(0,4);
                var month = v.post_date.substr(4,2);
                var day = v.post_date.substr(6,2);
                html += `
                    <div class="list-cell">
                        <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                        <div class="basic-item">
                            <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                ${thumbnail}
                                <div class="info-wrap">
                                    <div class="item-name">${v.title}</div>
                                    <div class="item-desc">${v.desc}</div>
                                    <div class="item-blog-option">
                                        <div class="name"><div class="ellipsis">${v.blogger_name}</div></div>
                                        <div class="date">${year}.${month}.${day}</div>
                                    </div>
                                </div>
                            </a>
                            <div class="basic-item-ui">
                                <button type="button" class="btn-basic-item-ui-nav"><span class="icon icon-size-16 icon-dot-more"></span></button>
                                <div class="basic-item-ui-list">
                                    <a href="#" class="btn-basic-item-ui-item delete_blog" data-idx="${v.blog_seq}">삭제</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            $(".do_blog").css("display","block");
            $(".none_blog").css("display","none");
            $(".blog_list_wrap").html(html);
        }
    })

    // 블로그 삭제 팝업
    $(document).on("click",".delete_blog",function(){
        $("#delete_pop .idx").val($(this).data("idx"));
        pop.open('delete_pop');
    })

    // 블로그 삭제
    function delete_ok(){
        pop.close();
        var postData = $("#delete_pop").serialize();
        postData += '&mode=del_blog';
        del_blog(postData)

    }
</script>
</body>
</html>