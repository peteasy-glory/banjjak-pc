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
								<h3 class="card-header-title">쿠폰상품 등록/수정</h3>
							</div>
							<form id="couponForm" class="card-body">
                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="basic-data-group">										
											<div class="con-title-group">
												<h4 class="con-title">쿠폰(횟수) 상품</h4>
												<div class="grid-layout btn-grid-group">
													<div class="grid-layout-inner justify-content-end">
														<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('c');">구간추가</button></div>
													</div>
												</div>
											</div>
											<div class="basic-data-group vvsmall">
												<div class="read-table">
													<table>
														<colgroup>
                                                            <col style="width:50%;">
                                                            <col style="width:20%;">
                                                            <col style="width:20%;">
                                                            <col style="width:10%;">
														</colgroup>
														<thead>
															<tr>
																<th>상품명</th>
																<th>요금 (단위:원)</th>
																<th>이용횟수</th>
																<th>삭제</th>
															</tr>
														</thead>
														<tbody class="coupon_c_wrap">
														</tbody>
													</table>
												</div>
											</div>
											<div class="basic-data-group vmiddle">
												<div class="form-group-item">
													<div class="form-item-label">추가설명</div>
													<div class="form-item-data type-2">
                                                        <input type="hidden" name="coupon_memo_idx" class="coupon_memo_idx" value="">
														<textarea style="height:100px;" class="coupon_c_memo" placeholder="입력"></textarea>
<!--														<div class="form-input-info">0/1000</div>-->
													</div>
												</div>
											</div>
										</div>		
										<div class="basic-data-group">										
											<div class="con-title-group">
												<h4 class="con-title">정액 적립 요금 상품</h4>
												<div class="grid-layout btn-grid-group">
													<div class="grid-layout-inner justify-content-end">
														<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('f');">구간추가</button></div>
													</div>
												</div>
											</div>
											<div class="basic-data-group vvsmall">
												<div class="read-table">
													<table>
														<colgroup>
															<col style="width:50%;">
															<col style="width:20%;">
															<col style="width:20%;">
															<col style="width:10%;">
														</colgroup>
														<thead>
															<tr>
																<th>상품명</th>
																<th>요금 (단위:원)</th>
																<th>실적립금</th>
																<th>삭제</th>
															</tr>
														</thead>
														<tbody class="coupon_f_wrap">
														</tbody>
													</table>
												</div>
											</div>
											<div class="basic-data-group vmiddle">
												<div class="form-group-item">
													<div class="form-item-label">추가설명</div>
													<div class="form-item-data type-2">
														<textarea style="height:100px;" class="coupon_f_memo" placeholder="입력"></textarea>
														<div class="form-input-info">0/1000</div>
													</div>
												</div>
											</div>
										</div>		
									</div>
								</div>
							</form>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="javascript:open_pop();" class="btn-page-bottom">저장하기</a>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
        <article id="saveCoupon" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-body">
                            <div class="msg-txt">저장하시겠습니까?</div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm" onclick="save_coupon();">저장</button>
                            <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                        </div>
                    </div>

                </div>
            </div>
        </article>

        <article id="delCoupon" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-body">
                            <div class="msg-txt">해당 쿠폰을 삭제하시겠습니까?</div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm del_coupon">삭제</button>
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
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
        get_beauty_coupon(artist_id);
        console.log(setting_array);

        if(setting_array[0] != ''){
            var coupon_c_html = '';
            var coupon_f_html = '';
            $.each(setting_array[0], function(i,v){
                if(v.type == 'C'){
                    coupon_c_html += `
                        <tr class="tr_data">
                            <td class="no-padding">
                                <input type="hidden" name="idx_c[]" value="${v.idx}">
                                <div class="form-table-select">
                                    <input type="text" name="name_c[]" value="${v.name}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price_c[]" value="${v.price}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="given_c[]" value="${v.given}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del is_del_${v.idx}" data-idx="${v.idx}"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                    $(".coupon_c_memo").text(db_to_str(v.memo));
                    $(".coupon_memo_idx").val(v.memo_seq);
                }else{
                    coupon_f_html += `
                        <tr class="tr_data">
                            <td class="no-padding">
                                <input type="hidden" name="idx_f[]" value="${v.idx}">
                                <div class="form-table-select">
                                    <input type="text" name="name_f[]" value="${v.name}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="price_f[]" value="${v.price}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number" name="given_f[]" value="${v.given}" placeholder="입력">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del is_del_${v.idx}" data-idx="${v.idx}"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                    $(".coupon_f_memo").text(db_to_str(v.memo));
                    $(".coupon_memo_idx").val(v.memo_seq);
                }
            })
            $(".coupon_c_wrap").html(coupon_c_html);
            $(".coupon_f_wrap").html(coupon_f_html);
        }

    })

    // 구간추가
    function add_table(idx){
        var html = `
            <tr class="tr_data">
                <td class="no-padding">
                    <input type="hidden" name="idx_${idx}[]" value="">
                    <div class="form-table-select">
                        <input type="text" name="name_${idx}[]" value="" placeholder="입력">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="number" name="price_${idx}[]" placeholder="입력">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="number" name="given_${idx}[]" placeholder="입력">
                    </div>
                </td>
                <td class="no-padding text-align-center vertical-center">
                    <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                </td>
            </tr>
        `;
        if(idx == 'c'){
            $(".coupon_c_wrap").append(html);
        }else if(idx == 'f'){
            $(".coupon_f_wrap").append(html);
        }
    }

    // 구간삭제
    $(document).on("click",".btn-item-del",function(){
        var idx = $(this).data('idx');
        if(idx > 0){
            $("#delCoupon .del_coupon").data("idx", idx);
            pop.open('delCoupon');
        }else{
            $(this).parents('.tr_data').remove();
        }
    })

    // 구간삭제에서 기존 쿠폰 지우기
    $(document).on("click",".del_coupon",function(){
        var idx = $(this).data("idx");
        del_coupon(idx);
    })

    // 저장팝업
    function open_pop(){
        pop.open('saveCoupon');
    }

    // 저장하기
    function save_coupon(){
        var postData = decodeURIComponent($("#couponForm").serialize());
        postData += '&coupon_c_memo='+str_to_db($(".coupon_c_memo").val());
        postData += '&coupon_f_memo='+str_to_db($(".coupon_f_memo").val());
        postData += '&mode=put_coupon'
        console.log(postData);
        put_coupon(postData);
    }
</script>
</body>
</html>