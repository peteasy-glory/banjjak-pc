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
					<div class="data-col-middle wide">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">매장상품 등록/수정</h3>
							</div>
							<form id="shopEtcForm" class="card-body">
                                <input type="hidden" name="artist_id" value="<?=$artist_id ?>">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="wide-tab card">
											<div class="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell shop_etc_tab shop_etc_merchandise_tab actived"><p class="btn-tab-item">용품</p></div>
												<div class="tab-cell shop_etc_tab shop_etc_snack_tab"><p class="btn-tab-item">간식</p></div>
												<div class="tab-cell shop_etc_tab shop_etc_feed_tab"><p class="btn-tab-item">사료</p></div>
												<div class="tab-cell shop_etc_tab shop_etc_etc_tab"><p class="btn-tab-item">기타</p></div>
											</div>
										</div>
										<div class="basic-data-group vmiddle shop_etc_wrap shop_etc_merchandise">
											<div class="basic-data-group">										
												<div class="con-title-group">
													<h4 class="con-title">용품</h4>
													<div class="grid-layout btn-grid-group">
														<div class="grid-layout-inner justify-content-end">
															<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table(1);">구간추가</button></div>
														</div>
													</div>
												</div>
												<div class="basic-data-group vvsmall">
													<div class="read-table">
														<table>
															<colgroup>
																<col style="width:53px;">
																<col style="width:auto;">
																<col style="width:30%;">
																<col style="width:10%;">
															</colgroup>
															<thead>
																<tr>
																	<th></th>
																	<th>상품명</th>
																	<th>가격 (단위:원)</th>
																	<th>삭제</th>
																</tr>
															</thead>
															<tbody class="drag-sort-wrap shop_etc_merchandise_table">
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
                                        <div class="basic-data-group vmiddle shop_etc_wrap shop_etc_snack" style="display: none;">
                                            <div class="basic-data-group">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">간식</h4>
                                                    <div class="grid-layout btn-grid-group">
                                                        <div class="grid-layout-inner justify-content-end">
                                                            <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table(2);">구간추가</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group vvsmall">
                                                    <div class="read-table">
                                                        <table>
                                                            <colgroup>
                                                                <col style="width:53px;">
                                                                <col style="width:auto;">
                                                                <col style="width:30%;">
                                                                <col style="width:10%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>상품명</th>
                                                                    <th>가격 (단위:원)</th>
                                                                    <th>삭제</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="drag-sort-wrap shop_etc_snack_table">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group vmiddle shop_etc_wrap shop_etc_feed" style="display: none;">
                                            <div class="basic-data-group">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">사료</h4>
                                                    <div class="grid-layout btn-grid-group">
                                                        <div class="grid-layout-inner justify-content-end">
                                                            <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table(3);">구간추가</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group vvsmall">
                                                    <div class="read-table">
                                                        <table>
                                                            <colgroup>
                                                                <col style="width:53px;">
                                                                <col style="width:auto;">
                                                                <col style="width:30%;">
                                                                <col style="width:10%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>상품명</th>
                                                                    <th>가격 (단위:원)</th>
                                                                    <th>삭제</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="drag-sort-wrap shop_etc_feed_table">
                                                            <tr class="drag-sort-cell">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group vmiddle shop_etc_wrap shop_etc_etc" style="display: none;">
                                            <div class="basic-data-group">
                                                <div class="con-title-group">
                                                    <h4 class="con-title">기타</h4>
                                                    <div class="grid-layout btn-grid-group">
                                                        <div class="grid-layout-inner justify-content-end">
                                                            <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table(4);">구간추가</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group vvsmall">
                                                    <div class="read-table">
                                                        <table>
                                                            <colgroup>
                                                                <col style="width:53px;">
                                                                <col style="width:auto;">
                                                                <col style="width:30%;">
                                                                <col style="width:10%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>상품명</th>
                                                                    <th>가격 (단위:원)</th>
                                                                    <th>삭제</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="drag-sort-wrap shop_etc_etc_table">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
							</form>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="javascript:open_submit_pop();" class="btn-page-bottom">저장하기</a>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
        <article id="saveEtc" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-body">
                            <div class="msg-txt">저장하시겠습니까?</div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm" onclick="save_etc();">저장</button>
                            <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                        </div>
                    </div>

                </div>
            </div>
        </article>
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/Sortable.min.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
        get_etc_product(artist_id);
        console.log(setting_array);

        if(setting_array[0] != ''){
            var shop_etc_merchandise_body_html = '';
            var shop_etc_snack_body_html = '';
            var shop_etc_feed_body_html = '';
            var shop_etc_etc_body_html = '';
            $.each(setting_array[0], function(i,v){
                if(v.type == 1){
                    shop_etc_merchandise_body_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" name="name1[]" value="${v.name}" placeholder="상품명 입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price1[]" value="${v.price}" placeholder="가격 입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }else if(v.type == 2){
                    shop_etc_snack_body_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" name="name2[]" value="${v.name}" placeholder="상품명 입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price2[]" value="${v.price}" placeholder="가격 입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }else if(v.type == 3){
                    shop_etc_feed_body_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" name="name3[]" value="${v.name}" placeholder="상품명 입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price3[]" value="${v.price}" placeholder="가격 입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }else if(v.type == 4){
                    shop_etc_etc_body_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" name="name4[]" value="${v.name}" placeholder="상품명 입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price4[]" value="${v.price}" placeholder="가격 입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }
            })
            $(".shop_etc_merchandise_table").html(shop_etc_merchandise_body_html);
            $(".shop_etc_snack_table").html(shop_etc_snack_body_html);
            $(".shop_etc_feed_table").html(shop_etc_feed_body_html);
            $(".shop_etc_etc_table").html(shop_etc_etc_body_html);
        }

    })

    // 상위 탭 클릭
    $(document).on("click",".shop_etc_tab",function(){
        $(".shop_etc_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".shop_etc_wrap").css("display","none");

        if($(this).hasClass('shop_etc_merchandise_tab')){
            $(".shop_etc_merchandise").css("display","block");
        }else if($(this).hasClass('shop_etc_snack_tab')){
            $(".shop_etc_snack").css("display","block");
        }else if($(this).hasClass('shop_etc_feed_tab')){
            $(".shop_etc_feed").css("display","block");
        }else if($(this).hasClass('shop_etc_etc_tab')){
            $(".shop_etc_etc").css("display","block");
        }
    })

    // 구간추가
    function add_table(idx){
        var html = `
            <tr class="drag-sort-cell">
                <td class="no-padding">
                    <div class="form-table-select">
                        <button type="button" class="btn-data-handler">드래그바</button>
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="text" name="name${idx}[]" value="" placeholder="상품명 입력">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="number" name="price${idx}[]" placeholder="가격 입력">
                    </div>
                </td>
                <td class="no-padding text-align-center vertical-center">
                    <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                </td>
            </tr>
        `;
        if(idx == 1){
            $(".shop_etc_merchandise_table").append(html);
        }else if(idx == 2){
            $(".shop_etc_snack_table").append(html);
        }else if(idx == 3){
            $(".shop_etc_feed_table").append(html);
        }else if(idx == 4){
            $(".shop_etc_etc_table").append(html);
        }
    }

    // 구간삭제
    $(document).on("click",".btn-item-del",function(){
        $(this).parents('.drag-sort-cell').remove();
    })

    // 저장팝업
    function open_submit_pop(){
        pop.open('saveEtc');
    }

    // 저장하기
    function save_etc(){
        var postData = decodeURIComponent($("#shopEtcForm").serialize());
        postData += '&mode=put_shop_etc'
        console.log(postData);
        put_shop_etc(postData);
    }

$(function(){
	//https://github.com/SortableJS/Sortable

	$('.drag-sort-wrap').each(function(){
		var sortable = Sortable.create($(this)[0] , {
			delay : 0,
			ghostClass: 'guide',
			draggable : '.drag-sort-cell',
			handle : '.btn-data-handler',
			onStart : function(evt){
				//드래그 시작 
				console.log('drag start');
			},
			onEnd : function(evt){
				//드래그 끝
				console.log('drag end');
				//evt.to;    // 현재 아이템
				//evt.from;  // 이전 아이템
				//evt.oldIndex;  // 이전 인덱스값
				//evt.newIndex;  // 새로운 인덱스값
			},
			onUpdate : function(evt){
				console.log('update');
			},
			onUpdate : function(evt){
				console.log('onChange');
			},
			onRemove: function (/**Event*/evt) {
				console.log('remove');
			}
			
		});
	});
});
</script>
</body>
</html>