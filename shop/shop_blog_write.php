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
											<div class="shop-blog-review-title">블로그 리뷰 추가하기</div>
											<div class="shop-blog-review-info">네이버 블로그에 있는 우리샵 소개글을 검색하여 선택 후 올릴 수 있습니다.</div>
											<div class="form-btns">
												<input type="text" placeholder="검색어 입력" class="search_text">
												<button type="button" class="btn-data-send btn-data-search"><span class="icon icon-size-24 icon-page-search">검색</span></button>
											</div>
											<!-- 내용이 있을 때 -->	
											<div class="do_blog">
												<div class="vertical-list-wrap line">
													<div class="list-inner blog_list_wrap">
													</div>
												</div>
											</div>
											<!-- //내용이 있을 때 -->
										<!-- 내용이 없을 때 -->
										<div class="common-none-data none_blog" style="display: none;">
											<div class="none-inner">
												<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
												<div class="item-info">내용이 없습니다.</div>
											</div>
										</div>
										<!--//내용이 없을 때 -->	
										</div>
									</div>
								</div>
								<div class="card-footer">
									<!--<a href="#" class="btn-page-bottom disabled">블로그를 선택해 주세요</a>-->
                                    <a href="#" class="btn-page-bottom disabled">총 <span class="total_cnt">0</span>개 추가하기</a>
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
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/shop.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    var link_array = []
    var timer;
    var search_txt = "";
    var idx = 1;
    var limit = 1;
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_blog_list(artist_id);
        $.each(shop_array[0],function(i,v){
            link_array.push(v.link);
        })
        search_txt = data.shop_name+" 애견";
        get_naver_blog_list(artist_id, search_txt, 10, limit);
        get_blog_list_view(shop_array[idx].items);
        console.log(shop_array[1]);

        $(".search_text").val(search_txt);
    })

    // 리스트 뿌려주기
    function get_blog_list_view(array){
        if(array != ''){
            var html = '';
            if(array.length){
                $.each(array, function(i,v){
                    var result = jQuery.inArray(v.link, link_array);
                    var disabled = (result > 0)? " checked disabled":"";
                    //var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                    var year = v.postdate.substr(0,4);
                    var month = v.postdate.substr(4,2);
                    var day = v.postdate.substr(6,2);
                    html += `
                        <div class="list-cell">
                            <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                            <div class="basic-item">
                                <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                    <label class="form-radiobox large">
                                        <input type="checkbox" id="chk" class="chk" name="check" data-title="${v.title}" data-link="${v.link}" data-desc="${v.description}" data-date="${year}-${month}-${day}" data-blogger="${v.bloggername}" ${disabled}>
                                        <span class="form-check-icon"><em></em></span>
                                    </label>
                                    <div class="info-wrap">
                                        <div class="item-name">${v.title}</div>
                                        <div class="item-desc">${v.description}</div>
                                        <div class="item-blog-option">
                                            <div class="name"><div class="ellipsis">${v.bloggername}</div></div>
                                            <div class="date">${year}.${month}.${day}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    `;
                })
            }else{
                var v = array;
                var result = jQuery.inArray(v.link, link_array);
                var disabled = (result > 0)? " checked disabled":"";
                //var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                var year = v.postdate.substr(0,4);
                var month = v.postdate.substr(4,2);
                var day = v.postdate.substr(6,2);
                html += `
                    <div class="list-cell">
                        <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                        <div class="basic-item">
                            <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                <label class="form-radiobox large">
                                    <input type="checkbox" id="chk" class="chk" name="check" data-title="${v.title}" data-link="${v.link}" data-desc="${v.description}" data-date="${year}-${month}-${day}" data-blogger="${v.bloggername}" ${disabled}>
                                    <span class="form-check-icon"><em></em></span>
                                </label>
                                <div class="info-wrap">
                                    <div class="item-name">${v.title}</div>
                                    <div class="item-desc">${v.description}</div>
                                    <div class="item-blog-option">
                                        <div class="name"><div class="ellipsis">${v.bloggername}</div></div>
                                        <div class="date">${year}.${month}.${day}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                `;
            }
            limit = limit + 10;
            $(".do_blog").css("display","block");
            $(".none_blog").css("display","none");
            $(".blog_list_wrap").append(html);
        }
    }

    // 체크박스 클릭
    $(document).on("click",".chk",function(){
        var chk = 0;
        $("input[type='checkbox']").each(function(i, v){
            var isChked = $(this).prop("checked");
            var isdisabled = $(this).prop("disabled");
            if (isChked && !isdisabled) {
                chk++;
            }
        })
        $(".total_cnt").text(chk);
        if(chk == 0){
            $(".btn-page-bottom").addClass("disabled");
        }else{
            $(".btn-page-bottom").removeClass("disabled");
        }
    })

    // 추가하기 클릭
    $(document).on("click",".btn-page-bottom",function(){
        //console.log("test");
        $("input[type='checkbox']").each(function(i, v){
            var isChked = $(this).prop("checked");
            var isdisabled = $(this).prop("disabled");
            if (isChked && !isdisabled) {
                var post_title = $(this).data('title');
                var post_link = $(this).data('link');
                var post_desc = $(this).data('desc');
                var post_date = $(this).data('date');
                var post_blogger = $(this).data('blogger');
                post_naver_blog_list(artist_id, post_link, post_title, post_desc, post_date, post_blogger);
            }
        })
    })

    // 스크롤 다운
    $(".card-body").on('scroll', function () {
        if (this.offsetHeight + this.scrollTop >= (this.scrollHeight - 200)) {
            if (!timer) {
                timer = setTimeout(function () {
                    timer = null;
                    scroll_down(limit);
                    //console.log("test");
                }, 100);
            }
        }
    });

    // 스크롤 다운 시 리스트 출력
    function scroll_down(num){
        get_naver_blog_list(artist_id, search_txt, 10, num);
        idx = idx+1;
        get_blog_list_view(shop_array[idx].items);
    }

    // 검색시
    $(document).on("click",".btn-data-search",function(){
        $(".blog_list_wrap").html('');
        search_txt = $(".search_text").val();
        limit = 1;
        idx = idx+1;
        console.log(search_txt, limit);
        get_naver_blog_list(artist_id, search_txt, 10, limit);
        get_blog_list_view(shop_array[idx].items);

    })

</script>
</body>
</html>