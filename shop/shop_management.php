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
								<form id="info_form" class="card-body">
                                    <input type="hidden" name="partner_id" value="<?=$artist_id?>">
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
																		<input type="text" class="form-control working_years" name="working_years" maxlength="2">
																		<div class="unit">년</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">간단소개<span>(최대 500자)</span></div>
																<div class="form-item-data type-3">
																	<textarea class="small shop_introduction" name="working_years"></textarea>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">주요경력<span>(최대 500자)</span></div>
																<div class="form-item-data type-3">
																	<textarea class="small shop_carrer" name="shop_carrer"></textarea>
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
																	<input type="text" name="kakao_channel" class="form-control kakao_channel">
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label"><div class="icon icon-size-24 icon-kakao-talk"></div>카카오 아이디</div>
																<div class="form-item-data">
																	<input type="text" name="kakao_id" class="form-control kakao_id">
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label"><div class="icon icon-size-24 icon-kakao-instargram"></div>인스타 계정</div>
																<div class="form-item-data">
																	<input type="text" name="instagram_id" class="form-control instagram_id">
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
																<div class="form-item-label">보유자격증 <a href="#" class="btn-form-add" onclick="open_add_pop('license');">추가하기</a></div>
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
																<div class="form-item-label">수상경력 <a href="#" class="btn-form-add" onclick="open_add_pop('award');">추가하기</a></div>
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
								</form>
								<!-- 20220519 위치 이동 -->
								<div class="card-footer">
									<a href="#" class="btn-page-bottom save_info">저장하기</a>
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

    <!-- 보유자격증 등록 팝업 -->
    <article id="license_award_form" class="layer-pop-wrap">
        <input type="hidden" class="type" value="0">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data data-pop-view">
                    <div class="pop-header">
                        <h4 class="con-title">보유 자격증 등록</h4>
                    </div>
                    <div class="pop-body">
                        <div class="license-add-wrap">
                            <div class="con-title-group">
                                <h5 class="con-title">주의사항</h5>
                            </div>
                            <div class="line-text-list">
                                <div class="list-cell">주민번호 등의 개인정보는 지운 후 올려주세요.</div>
                                <div class="list-cell">깔끔하게 스캔 및 촬영된 사진을 올려주세요.</div>
                            </div>
                            <div class="form-group">
                                <div class="form-group-cell">
                                    <div class="picture-add-group">
                                        <div class="picture-add-data">
                                            <!-- 사진 없을 때 -->
                                            <div class="none_pic" style="display:block">
                                                <a href="#" class="btn-picture-add" onclick="MemofocusNcursorSub();">
                                                    <div>
                                                        <div class="icon icon-size-24 icon-camera-gray"></div>
                                                        <div class="add-label">사진첨부</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- 사진 있을 때 -->
                                            <div class="do_pic" style="display:none">
                                                <div class="picture-view">
                                                    <img src="/static/pub/images/user_thumb.png" id="preview-image" alt="">
                                                </div>
                                            </div>
                                            <div style="display:none;position:absolute;top:-50px"><input type="file" accept="image/*" name=imgupfilesub id=addimgfilesub></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-cell">
                                    <div class="form-group-item">
                                        <div class="form-item-label photo_name"></div>
                                        <div class="form-item-data">
                                            <input type="text" class="form-control name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-cell">
                                    <div class="form-group-item">
                                        <div class="form-item-label from"></div>
                                        <div class="form-item-data">
                                            <input type="text" class="form-control issued_by">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-cell">
                                    <div class="form-group-item">
                                        <div class="form-item-label">획득 일자</div>
                                        <div class="form-item-data type-2">
                                            <div class="form-cell-group">
                                                <div class="form-cell-group-inner">
                                                    <select class="year">
                                                        <option value="2022">2022년</option>
                                                        <option value="2021">2021년</option>
                                                        <option value="2020">2020년</option>
                                                        <option value="2019">2019년</option>
                                                        <option value="2018">2018년</option>
                                                        <option value="2017">2017년</option>
                                                        <option value="2016">2016년</option>
                                                        <option value="2015">2015년</option>
                                                        <option value="2014">2014년</option>
                                                        <option value="2013">2013년</option>
                                                        <option value="2012">2012년</option>
                                                        <option value="2011">2011년</option>
                                                        <option value="2010">2010년</option>
                                                        <option value="2009">2009년</option>
                                                        <option value="2008">2008년</option>
                                                        <option value="2007">2007년</option>
                                                        <option value="2006">2006년</option>
                                                        <option value="2005">2005년</option>
                                                        <option value="2004">2004년</option>
                                                        <option value="2003">2003년</option>
                                                        <option value="2002">2002년</option>
                                                        <option value="2001">2001년</option>
                                                        <option value="2000">2000년</option>
                                                    </select>
                                                    <select class="month">
                                                        <option value="01">01월</option>
                                                        <option value="02">02월</option>
                                                        <option value="03">03월</option>
                                                        <option value="04">04월</option>
                                                        <option value="05">05월</option>
                                                        <option value="06">06월</option>
                                                        <option value="07">07월</option>
                                                        <option value="08">08월</option>
                                                        <option value="09">09월</option>
                                                        <option value="10">10월</option>
                                                        <option value="11">11월</option>
                                                        <option value="12">12월</option>
                                                    </select>
                                                    <select class="day">
                                                        <?php
                                                        for($i=1;$i<=31;$i++){
                                                            ?>
                                                            <option value="<?=$i?>"><?=$i?>일</option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-purple add_license_award"><strong>등록하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </article>
    <!-- //보유자격증 등록 팝업 -->

    <form id="delete_pop" class="layer-pop-wrap">
        <input type="hidden" name="login_id" value="<?=$artist_id?>">
        <input type="hidden" name="type" class="type" value="">
        <input type="hidden" name="src" class="src" value="">
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
        $(".working_years").val(shop_array[0].shop_working_years);
        $(".shop_photo").attr('src',photo);
        $(".shop_introduction").val(db_to_str(shop_array[0].shop_introduction));
        $(".shop_carrer").val(db_to_str(shop_array[0].shop_carrer));
        $(".kakao_channel").val(shop_array[0].kakao_channel);
        $(".kakao_id").val(shop_array[0].kakao_id);
        $(".instagram_id").val(shop_array[0].instagram_id);

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
                                <button type="button" class="btn-item-del" onclick="del_license_award('${v.photo}',0);"><span class="icon icon-size-36 icon-trash"></span></button>
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
                                <button type="button" class="btn-item-del" onclick="del_license_award('${v.photo}',0);"><span class="icon icon-size-36 icon-trash"></span></button>
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
                                <button type="button" class="btn-item-del" onclick="del_license_award('${v.photo}',1);"><span class="icon icon-size-36 icon-trash"></span></button>
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
                                <button type="button" class="btn-item-del" onclick="del_license_award('${v.photo}',1);"><span class="icon icon-size-36 icon-trash"></span></button>
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

    // 정보 저장
    $(document).on("click",".save_info",function(){
        var working_years = $(".working_years").val();
        var shop_introduction = str_to_db($(".shop_introduction").val());
        var shop_carrer = str_to_db($(".shop_carrer").val());
        var kakao_channel = $(".kakao_channel").val();
        var kakao_id = $(".kakao_id").val();
        var instagram_id = $(".instagram_id").val();

        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: 'save_shop_info',
                login_id: artist_id,
                working_years: working_years,
                introduction: shop_introduction,
                career: shop_carrer,
                kakao_channel: kakao_channel,
                instagram: instagram_id,
                kakao_id: kakao_id,
            },
            type: 'POST',
            async:false,
            success: function (res) {
                console.log(res);
                let response = JSON.parse(res);
                console.log(response);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    pop.open('firstRequestMsg1', '저장되었습니다.');
                }
            }
        })
    })

    // 자격증, 수상경력 추가
    function open_add_pop(type){
        if(type == 'license'){
            $("#license_award_form .pop-header .con-title").text('보유 자격증 등록');
            $("#license_award_form .photo_name").text('자격증 공식명칭');
            $("#license_award_form .from").text('발행처');
            $("#license_award_form .type").val(0);
        }else{
            $("#license_award_form .pop-header .con-title").text('수상경력 등록');
            $("#license_award_form .photo_name").text('수상명칭');
            $("#license_award_form .from").text('주관처');
            $("#license_award_form .type").val(1);
        }
        pop.open('license_award_form');
    }

    // 자격증 수상 사진 첨부 클릭시
    function MemofocusNcursorSub() {
        html = "<div id='upimgarea'></div>";
        //document.getElementById('dmemo').focus();
        var sel, range;
        if (window.getSelection) {
            // IE9 and non-IE
            sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                range = sel.getRangeAt(0);
                range.deleteContents();

                // Range.createContextualFragment() would be useful here but is
                // non-standard and not supported in all browsers (IE9, for one)
                var el = document.createElement("div");
                el.innerHTML = html;
                var frag = document.createDocumentFragment(),
                    node, lastNode;
                while ((node = el.firstChild)) {
                    lastNode = frag.appendChild(node);
                }
                range.insertNode(frag);

                // Preserve the selection
                if (lastNode) {
                    range = range.cloneRange();
                    range.setStartAfter(lastNode);
                    range.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        } else if (document.selection && document.selection.type != "Control") {
            // IE < 9
            document.selection.createRange().pasteHTML(html);
        }

        $("#addimgfilesub").trigger("click");

    }
    // 자격증 수상 사진 등록
    var mime = '';
    $(document).on("change", "#addimgfilesub", function(e){
        var ext = $('#addimgfilesub').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
            alert('png,jpg,jpeg 파일만 업로드 할수 있습니다.');
            return;
        }

        mime = ($("input[name=imgupfilesub]")[0].files[0].type).split('/')[1];
        //console.log(type);


        // 인풋 태그에 파일이 있는 경우
        if($("input[name=imgupfilesub]")[0].files && $("input[name=imgupfilesub]")[0].files[0]) {
            // 이미지 파일인지 검사 (생략)
            // FileReader 인스턴스 생성
            const reader = new FileReader()
            // 이미지가 로드가 된 경우
            reader.onload = e => {
                const previewImage = document.getElementById("preview-image")
                previewImage.src = e.target.result
            }
            // reader가 이미지 읽도록 하기
            reader.readAsDataURL($("input[name=imgupfilesub]")[0].files[0])

            $(".none_pic .add-label").text("사진 수정");
            $(".do_pic").css("display","block");
        }

    });

    // 자격증 수상 저장
    $(document).on("click",".add_license_award",function(){
        var type = parseInt($("#license_award_form .type").val());
        var name = $("#license_award_form .name").val();
        var issued_by = $("#license_award_form .issued_by").val();
        var year = $("#license_award_form .year").val();
        var month = $("#license_award_form .month").val();
        var day = $("#license_award_form .day").val();
        var published_date = year+'-'+month+'-'+day;
        if(day < 10){
            day = '0'+day;
        }

        var formData = new FormData();
        formData.append("mode", "save_license_award");
        formData.append("login_id", artist_id);
        formData.append("type", type);
        formData.append("name", name);
        formData.append("issued_by", issued_by);
        formData.append("published_date", published_date);
        formData.append("mime", mime);
        formData.append("image", $("input[name=imgupfilesub]")[0].files[0]);

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
                    $("#addimgfilesub").replaceWith($("#addimgfilesub").clone(true));
                } else {
                    // other browser 일때 input[type=file] init.
                    $("#addimgfilesub").val("");
                }
                //console.log(data);
                pop.open('reloadPop', '완료되었습니다.');

            },
            error: function(xhr, status, error) {
                alert(error + "에러발생");
            }
        });


    })

    // 자격증 수상 삭제 팝업
    function del_license_award(src, type){
        $("#delete_pop .type").val(type);
        $("#delete_pop .src").val(src);
        pop.open('delete_pop');
    }

    // 자격증 수상 삭제
    function delete_ok(){
        pop.close();
        var postData = decodeURIComponent($("#delete_pop").serialize());
        postData += "&mode=del_license_award"
        console.log(postData);
        delete_license_award(postData);
    }
</script>
</body>
</html>