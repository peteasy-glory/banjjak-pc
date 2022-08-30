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
														<div class="list-cell">
															<div class="basic-item">
																<a href="#" class="basic-list-item blog">
																	<div class="thumb">
																		<label class="form-radiobox large"><input type="checkbox" id="c11" name="check"><span class="form-check-icon"><em></em></span></label>
																	</div>
																	<div class="info-wrap">
																		<div class="item-name">블로그용 타이틀 입니다. 타이틀 입니다. 타이틀 입니다. 타이틀 입니다. 타이틀 입니다. </div>
																		<div class="item-desc">내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. 내용입니다. </div>
																		<div class="item-blog-option">
																			<div class="name"><div class="ellipsis">블로그명 블로그명 블로그명 블로그명 블로그명 블로그명 블로그명 블로그명 블로그명 블로그명</div></div>
																			<div class="date">2020.11.20</div>
																		</div>
																	</div>
																</a>			
																<div class="basic-item-ui">
																	<button type="button" class="btn-basic-item-ui-nav"><span class="icon icon-size-16 icon-dot-more"></span></button>									
																	<div class="basic-item-ui-list">
																		<a href="#" class="btn-basic-item-ui-item">삭제</a>
																	</div>
																</div>
															</div>
														</div>
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
									<a href="#" class="btn-page-bottom">총 2개 추가하기</a>
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
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_blog_list(artist_id);
        $.each(shop_array[0],function(i,v){
            link_array.push(v.link);
        })
        get_naver_blog_list(artist_id, data.shop_name+" 애견", 10, 1);
        get_blog_list_view(shop_array[1].items);

        $(".search_text").val(data.shop_name+" 애견");
    })

    // 리스트 뿌려주기
    function get_blog_list_view(array){
        if(array != ''){
            var html = '';
            if(array.length){
                $.each(array, function(i,v){
                    var result = jQuery.inArray(v.link, link_array);
                    var disabled = (result > 0)? "checked disabled":"";
                    //var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                    var year = v.postdate.substr(0,4);
                    var month = v.postdate.substr(4,2);
                    var day = v.postdate.substr(6,2);
                    html += `
                        <div class="list-cell">
                            <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                            <div class="basic-item">
                                <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                    <label class="form-radiobox large"><input type="checkbox" id="c11" name="check" ${disabled}><span class="form-check-icon"><em></em></span></label>
                                    <div class="info-wrap">
                                        <div class="item-name">${v.title}</div>
                                        <div class="item-desc">${v.description}</div>
                                        <div class="item-blog-option">
                                            <div class="name"><div class="ellipsis">${v.bloggername}</div></div>
                                            <div class="date">${year}.${month}.${day}</div>
                                        </div>
                                    </div>
                                </a>
                                <div class="basic-item-ui">
                                    <button type="button" class="btn-basic-item-ui-nav"><span class="icon icon-size-16 icon-dot-more"></span></button>
                                    <div class="basic-item-ui-list">
                                        <a href="#" class="btn-basic-item-ui-item">삭제</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
            }else{
                var v = array;
                //var thumbnail = (v.thumbnail != '')? `<div class="thumb"><img src="${img_link_change(v.thumbnail)}" alt=""></div>` : ``;
                var year = v.postdate.substr(0,4);
                var month = v.postdate.substr(4,2);
                var day = v.postdate.substr(6,2);
                html += `
                    <div class="list-cell">
                        <!-- basic-item 클래스에 actived클래스 추가시 ui 활성화 -->
                        <div class="basic-item">
                            <a href="${v.link}" class="basic-list-item blog" target="_blank">
                                <label class="form-radiobox large"><input type="checkbox" id="chk" name="check"><span class="form-check-icon"><em></em></span></label>
                                <div class="info-wrap">
                                    <div class="item-name">${v.title}</div>
                                    <div class="item-desc">${v.description}</div>
                                    <div class="item-blog-option">
                                        <div class="name"><div class="ellipsis">${v.bloggername}</div></div>
                                        <div class="date">${year}.${month}.${day}</div>
                                    </div>
                                </div>
                            </a>
                            <div class="basic-item-ui">
                                <button type="button" class="btn-basic-item-ui-nav"><span class="icon icon-size-16 icon-dot-more"></span></button>
                                <div class="basic-item-ui-list">
                                    <a href="#" class="btn-basic-item-ui-item">삭제</a>
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
    }

    $(document).on("click",".btn-page-bottom",function(){
        console.log("test");
        $("input[type='checkbox']").each(function(i, v){
            // var isChked = $(this).prop("checked"); //
            // if (isChked) {
            //     var accessMode = $(this).val();
            //     console.log(isChked);
            // }
            console.log(v);
        })
    })

</script>
</body>
</html>