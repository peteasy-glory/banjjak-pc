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
									<h3 class="card-header-title">샵 정보 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="shop-management">
											<div class="basic-data-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="shop-picture-modify">
																<div class="picture-add-group">						
																	<div class="picture-add-data">
																		<!-- 사진 없을 때 -->
																		<div class="none_photo" style="display:block">
																			<a href="#" class="btn-picture-add">	
																				<div>
																					<div class="icon icon-size-24 icon-camera-gray"></div>
																					<div class="add-label">사진첨부</div>
																				</div>
																			</a>
																		</div>
																		<!-- 사진 있을 때 -->
																		<div class="do_photo" style="display:none">
																			<div class="picture-view">
																				<img class="shop_photo" src="" alt="">
																			</div>
																		</div>
																	</div>						
																</div>
																<div class="shop-picture-info">
																	<div class="shop-name">샵 이름</div>
																	<div class="shop-info"></div>
																	<!-- 사진 첨부 완료 시 활성화 -->
																	<div style="/* display:none; */">
																		<a href="#" class="btn-modify" onclick="MemofocusNcursor();"><div class="icon icon-size-24 icon-camera-gray"></div>사진 수정</a>
																	</div>
																</div>
															</div>
														</div>
                                                        <div style="display:none;position:absolute;top:-50px"><input type="file" accept="image/*" name=imgupfile id=addimgfile></div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">경력</div>
																<div class="form-item-data">
																	<div class="form-year">
																		<input type="text" class="form-control" maxlength="2">
																		<div class="unit"><span class="work_year"></span>년</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">간단소개<span>(최대 500자)</span></div>
																<div class="form-item-data type-3">
																	<textarea class="small shop_introduction"></textarea>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">주요경력<span>(최대 500자)</span></div>
																<div class="form-item-data type-3">
																	<textarea class="small shop_carrer"></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="basic-data-group">
												<div class="con-title-group">
													<h6 class="con-title">SNS</h6>
												</div>
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label"><div class="icon icon-size-24 icon-kakao-channel"></div>카카오채널 링크</div>
																<div class="form-item-data">
																	<input type="text" class="form-control kakao_channel">
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label"><div class="icon icon-size-24 icon-kakao-talk"></div>카카오 아이디</div>
																<div class="form-item-data">
																	<input type="text" class="form-control kakao_id">
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label"><div class="icon icon-size-24 icon-kakao-instargram"></div>인스타 계정</div>
																<div class="form-item-data">
																	<input type="text" class="form-control instagram_id">
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
															<div class="form-group-item">
																<div class="form-item-label">보유자격증 <a href="#" class="btn-form-add">추가하기</a></div>
																<div class="form-item-data type-3">
																	<div>
																		<!-- 리스트 있을 때 -->
																		<div class="vertical-list-wrap line license-list do_license" style="display: none;">
																			<div class="list-inner license_wrap">


																			</div>
																		</div>
																		<!-- //리스트 있을 때 -->
																		<!-- 리스트 없을 때 -->
																		<div class="none-license none_license" style="display: block;">등록된 보유자격증이 없습니다.</div>
																		<!-- //리스트 없을 때 -->
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">수상경력 <a href="#" class="btn-form-add">추가하기</a></div>
																<div class="form-item-data type-3">
																	<div>
																		<!-- 리스트 있을 때 -->
																		<div class="vertical-list-wrap line license-list do_award" style="display: none;">
																			<div class="list-inner award_wrap">


																			</div>
																		</div>
																		<!-- //리스트 있을 때 -->
																		<!-- 리스트 없을 때 -->
																		<div class="none-license none_award" style="display: block;">등록된 보유자격증이 없습니다.</div>
																		<!-- //리스트 없을 때 -->
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- 20220519 위치 이동
									<div class="card-footer">
										<a href="#" class="btn-page-bottom">저장하기</a>
									</div>
									//20220519 위치 이동 -->
								</div>
								<!-- 20220519 위치 이동 -->
								<div class="card-footer">
									<a href="#" class="btn-page-bottom">저장하기</a>
								</div>
								<!-- //20220519 위치 이동 -->
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
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_shop_info(artist_id);
        get_license_award(artist_id,0); // 자격증
        get_license_award(artist_id,1); // 수상
        console.log(shop_array);

        // 정보 뿌려주기
        if(shop_array[0].shop_photo != ''){
            $(".none_photo").css("display","none");
            $(".do_photo").css("display","block");
        }
        var photo = img_link_change(shop_array[0].shop_photo)
        $(".shop-info").text(shop_array[0].shop_name);
        $(".work_year").text(shop_array[0].shop_working_years);
        $(".shop_photo").attr('src',photo);
        $(".shop_introduction").text(db_to_str(shop_array[0].shop_introduction));
        $(".shop_carrer").text(db_to_str(shop_array[0].shop_carrer));
        $(".kakao_channel").val(shop_array[0].kakao_channel);
        $(".kakao_id").val(shop_array[0].kakao_id);
        $(".instagram_id").val(shop_array[0].instagram_id);

        console.log(typeof shop_array[1]);
        console.log(typeof shop_array[2]);

        // 자격증
        if(shop_array[1] != ''){
            var html = '';
            if(shop_array[1].length){
                $.each(shop_array[1], function(i,v){
                    var photo = (v.photo != '')? img_link_change(v.photo) : "";
                    var date = v.issue_date;
                    var year = date.substr(0,4);
                    var month = date.substr(4,2);
                    var day = date.substr(6,2);
                    html += `
                        <div class="list-cell">
                            <div class="basic-list-item license">
                                <div class="thumb">
                                    <img src="${photo}" alt="">
                                </div>
                                <div class="info-wrap">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">${v.issue_place} 발행</div>
                                    <div class="item-date">${year}.${month}.${day} 발급</div>
                                </div>
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </div>
                        </div>
                    `;
                })
            }else{
                    var v = shop_array[1];
                    var photo = (v.photo != '')? img_link_change(v.photo) : "";
                    var date = v.issue_date;
                    var year = date.substr(0,4);
                    var month = date.substr(4,2);
                    var day = date.substr(6,2);
                    html += `
                        <div class="list-cell">
                            <div class="basic-list-item license">
                                <div class="thumb">
                                    <img src="${photo}" alt="">
                                </div>
                                <div class="info-wrap">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">${v.issue_place} 발행</div>
                                    <div class="item-date">${year}.${month}.${day} 발급</div>
                                </div>
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </div>
                        </div>
                    `;
            }
            $(".do_license").css("display","block");
            $(".none_license").css("display","none");
            $(".license_wrap").html(html);
        }

        // 수상
        if(shop_array[2] != ''){
            var html = '';
            if(shop_array[2].length){
                $.each(shop_array[2], function(i,v){
                    var photo = (v.photo != '')? img_link_change(v.photo) : "";
                    var date = v.issue_date;
                    var year = date.substr(0,4);
                    var month = date.substr(4,2);
                    var day = date.substr(6,2);
                    console.log(year,month,day);
                    html += `
                        <div class="list-cell">
                            <div class="basic-list-item license">
                                <div class="thumb">
                                    <img src="${photo}" alt="">
                                </div>
                                <div class="info-wrap">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">${v.issue_place} 발행</div>
                                    <div class="item-date">${year}.${month}.${day} 발급</div>
                                </div>
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </div>
                        </div>
                    `;
                })
            }else{
                    var v = shop_array[2];
                    var photo = (v.photo != '')? img_link_change(v.photo) : "";
                    var date = v.issue_date;
                    var year = date.substr(0,4);
                    var month = date.substr(4,2);
                    var day = date.substr(6,2);
                    console.log(year,month,day);
                    html += `
                        <div class="list-cell">
                            <div class="basic-list-item license">
                                <div class="thumb">
                                    <img src="${photo}" alt="">
                                </div>
                                <div class="info-wrap">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">${v.issue_place} 발행</div>
                                    <div class="item-date">${year}.${month}.${day} 발급</div>
                                </div>
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </div>
                        </div>
                    `;
            }
            $(".do_award").css("display","block");
            $(".none_award").css("display","none");
            $(".award_wrap").html(html);
        }
    })

    // 이미지 추가
    $(document).on("change", "#addimgfile", function(e){
        var ext = $('#addimgfile').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 파일만 업로드 할수 있습니다.');
            return;
        }

        var filename = $("input[name=imgupfile]")[0].files[0];
        console.log($("input[name=imgupfile]")[0]);
        var type = ($("input[name=imgupfile]")[0].files[0].type).split('/')[1];
        //console.log(type);
        var formData = new FormData();
        formData.append("mode", "shop_info_photo");
        formData.append("login_id", artist_id);
        formData.append("mime", type);
        formData.append("image", $("input[name=imgupfile]")[0].files[0]);
        console.log(filename);

        $.ajax({
            url: '/data/pc_ajax.php',
            enctype: 'multipart/form-data',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(data) {

                if (/(MSIE|Trident)/.test(navigator.userAgent)) {
                    // ie 일때 input[type=file] init.
                    $("#addimgfile").replaceWith($("#addimgfile").clone(true));
                } else {
                    // other browser 일때 input[type=file] init.
                    $("#addimgfile").val("");
                }
                //console.log(data);
                pop.open('reloadPop', '완료되었습니다.');

            },
            error: function(xhr, status, error) {
                alert(error + "에러발생");
            }
        });

    });
</script>
</body>
</html>