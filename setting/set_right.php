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
					<div class="data-col-middle">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">권한 설정</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-right-wrap">
										<div class="basic-data-group text-align-center">
											<button type="button" class="btn btn-outline-purple btn-basic-wide" onclick="pop.open('rightAdd');"><strong>추가하기</strong></button>
											<div class="form-bottom-info">샵주인이 직원에게 예약접수 기능만을 부여할 수 있습니다.<br>(해당직원이 <strong class="font-color-purple">반짝(펫샵용)</strong> 회원으로 가입된 상태이어야 합니다.)<br>(완료 후 직원이 재로그인을 하면 예약 접수 권한 사용이 가능합니다.)</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">권한받은 ID</h4>
											</div>
											<div class="basic-data-group vvsmall3">
												<div class="grid-layout margin-5-12">
													<div class="grid-layout-inner artist_wrap">
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
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
    </section>
    <!-- //container -->

    <!-- 접수 권한 추가하기 팝업 -->
    <article id="rightAdd" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data data-pop-view">
                    <div class="pop-header">
                        <h4 class="con-title">접수 권한 추가하기</h4>
                    </div>
                    <div class="pop-body">
                        <div class="set-right-input">
                            <div class="basic-data-group">
                                <div class="form-group-item">
                                    <div class="form-item-label">이메일 입력</div>
                                    <div class="form-item-data">
                                        <div class="form-inpus">
                                            <div class="form-inpus-inner">
                                                <div class="form-inputs-cell"><input type="text" id="check_email" class="form-control" placeholder="입력"></div>
                                                <div class="form-inputs-cell">
                                                    <select id="email_type">
                                                        <option  value="@naver.com">@naver.com</option>
                                                        <option  value="@daum.net">@daum.net</option>
                                                        <option  value="@gmail.com">@gmail.com</option>
                                                        <option  value="@hotmail.com">@hotmail.com</option>
                                                        <option  value="@lycos.co.kr">@lycos.co.kr</option>
                                                        <option  value="@empal.com">@empal.com</option>
                                                        <option  value="@dreamwiz.com">@dreamwiz.com</option>
                                                        <option  value="@korea.com">@korea.com</option>
                                                        <option  value="@nate.com">@nate.com</option>
                                                        <option  value="">직접입력</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group vvsmall3">
                                <button type="button" class="btn btn-outline-purple btn-basic-full" onclick="ck_id()">ID 조회</button>
                            </div>
                            <!-- 검색 완료시 -->
                            <form id="authority_form" class="basic-data-group vmiddle ck_id_wrap" style="display:none">
                                <input type="hidden" name="artist_id" value="<?=$artist_id ?>">
                                <input type="hidden" id="customer_id" name="customer_id">
                                <input type="hidden" name="del" value="N">
                                <div class="id-inquiry-data">
                                    <div class="msg">ID조회가 완료되었습니다.</div>
                                    <div class="value"></div>
                                </div>
                                <div class="basic-data-group middle">
                                    <div class="form-group-item">
                                        <div class="form-item-label">직원이름 입력</div>
                                        <div class="form-item-data">
                                            <input type="text" name="name" class="form-control name" placeholder="입력">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- //검색 완료시 -->
                        </div>
                    </div>
                    <div class="pop-footer">
                        <!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                        <button type="button" class="btn btn-purple" onclick="save_authority()"><strong>저장하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </article>
    <!-- //접수 권한 추가하기 팝업 -->

    <!-- 접수 권한 수정하기 팝업 -->
    <article id="rightModify" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <form id="modify_form" class="pop-data data-pop-view">
                    <input type="hidden" name="artist_id" value="<?=$artist_id ?>">
                    <input type="hidden" class="customer_id" name="customer_id" value="">
                    <input type="hidden" name="del" value="N">
                    <div class="pop-header">
                        <h4 class="con-title">접수 권한 수정</h4>
                    </div>
                    <div class="pop-body">
                        <div class="set-right-input">
                            <div class="basic-data-group">
                                <div class="id-inquiry-data">
                                    <div class="msg">등록된 ID</div>
                                    <div class="value">banjjak_2425@naver.com</div>
                                </div>
                            </div>
                            <div class="basic-data-group middle">
                                <div class="form-group-item">
                                    <div class="form-item-label">직원이름 입력</div>
                                    <div class="form-item-data">
                                        <input type="text" name="name" class="name form-control" placeholder="입력">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pop-footer">
                        <!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                        <button type="button" class="btn btn-purple" onclick="modify_artist();"><strong>저장하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </form>
            </div>
        </div>
    </article>
    <!-- //접수 권한 수정하기 팝업 -->
    <!-- 삭제하기 팝업 -->
    <article id="deleteArtist" class="layer-pop-wrap">
        <form id="delete_form" class="layer-pop-parent">
            <input type="hidden" name="artist_id" value="<?=$artist_id ?>">
            <input type="hidden" class="customer_id" name="customer_id" value="">
            <input type="hidden" class="name" name="name" value="">
            <input type="hidden" name="del" value="Y">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">삭제하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="delete_artist();">확인</button>
                    </div>
                </div>

            </div>
        </form>
    </article>
    <!-- //삭제하기 팝업 -->
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
        gnb_actived('gnb_detail_wrap','gnb_authority');
        get_authority(artist_id);
        console.log(setting_array);

        // 권한받은 미용사 리스트
        var artist_array = setting_array[0];
        var html = '';
        $.each(artist_array, function(i,v){
            console.log(v);
            html += `
                <div class="grid-layout-cell grid-2">
                    <div class="customer-card-item middle">
                        <div class="item-right-info">
                            <div class="item-right-name">${v.name}</div>
                            <div class="item-right-mail">${v.customer_id}</div>
                        </div>
                        <div class="item-btns">
                            <a href="#" class="btn btn-outline-gray btn-middle-size btn-basic-full modify_artist" data-id="${v.customer_id}" data-name="${v.name}">수정</a>
                            <a href="#" class="btn btn-outline-gray btn-middle-size btn-basic-full delete_artist" data-id="${v.customer_id}" data-name="${v.name}">삭제</a>
                        </div>
                    </div>
                </div>
            `;
        });
        $(".artist_wrap").html(html);
    })

    // 미용사 정보 수정
    $(document).on("click", ".modify_artist", function(){
        $("#rightModify .id-inquiry-data .value").text($(this).data("id"));
        $("#rightModify .customer_id").val($(this).data("id"));
        $("#rightModify .form-control").val($(this).data("name"));
        pop.open('rightModify');
    })

    function modify_artist(){
        var form_data = decodeURIComponent($("#modify_form").serialize());
        form_data += "&mode=put_authority";
        put_authority(form_data);
    }

    // 미용사 삭제
    $(document).on("click", ".delete_artist", function(){
        $("#deleteArtist .customer_id").val($(this).data("id"));
        $("#deleteArtist .name").val($(this).data("name"));
        pop.open('deleteArtist');
    })

    function delete_artist(){
        var form_data = decodeURIComponent($("#delete_form").serialize());
        form_data += "&mode=put_authority";
        put_authority(form_data);
    }

    // 권한 ID 조회
    var email_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    function ck_id() {
        var input_id = $("#check_email").val();
        var email_type = $("#email_type").val();

        if (input_id == "" || input_id == undefined) {
            pop.open('firstRequestMsg1', '아이디를 입력해주세요.');
            return false;
        }
        var email_all = input_id;
        if (email_type != "" && email_type != undefined) {
            email_all = email_all + email_type;
        }
        if (email_regex.test(email_all) === false) {
            pop.open('firstRequestMsg1', '이메일 형식을 확인해 주세요.');
            return false;
        }
        is_authority(email_all);
    }

    function save_authority(){
        var name = $("#authority_form .name").val();
        if(name == "" || name == undefined){
            pop.open('firstRequestMsg1', '이름을 입력해주세요.');
            return false;
        }
        var form_data = decodeURIComponent($("#authority_form").serialize());
        form_data += "&mode=put_authority";
        put_authority(form_data);
    }
</script>
</body>
</html>