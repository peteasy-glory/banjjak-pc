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
								<h3 class="card-header-title">탈퇴하기</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="user-hack-wrap">
										<div class="hack-info">회원탈퇴 전에 유의사항을 반드시 확인해주세요.</div>
										<div class="hack-detail">
											<div class="detail-txt">탈퇴 시 보유하고 계신 포인트, 쿠폰은 소멸되며 재발행이 불가능합니다.</div>
											<div class="detail-txt">탈퇴한 계정의 이용기록은 모두 삭제되며, 삭제된 데이터는 복구되지 않습니다.<br>
												<span>(단, 작성된 리뷰와 결제내역은 5년까지 보관)</span></div>
											<div class="detail-txt">탈퇴 후에는 본인여부 확인이 불가하여 게시글을 임의로 삭제해드릴수 없습니다.</div>
											<div class="detail-txt"><em>[삭제되는 정보]</em>이메일아이디, 닉네임, 휴대폰 번호, 주문이력, 단골, 포인트, 쿠폰</div>
										</div>
										<div class="hack-check"><label class="form-checkbox"><input type="checkbox" name="hack_chk" class="hack_chk"><span class="form-check-icon"><em>탈퇴 유의사항을 확인했습니다.</em></span></label></div>
										<div class="hack-visual">
											<div class="visual"><img src="../static/images/icon/img-illust-4@2x.png" alt="" width="203"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom disabled">탈퇴하기</a>
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

    <!--  회원 탈퇴 질문 -->
    <article id="hackMsg1" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">탈퇴하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" id="btn_confirm" onclick="go_hack();">확인</button>
                        <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <!-- //회원 탈퇴 질문 -->

    <!--  회원 탈퇴 완료 -->
    <article id="hackMsg2" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">탈퇴되었습니다.<br>메인화면으로 이동합니다.</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="pop.close(); location.href='/data/logout_process.php'; ">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <!-- //회원 탈퇴 완료 -->
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
        gnb_actived('gnb_etc_wrap','gnb_profile');
    })

    // 체크 이벤트
    $(document).on("click",".hack_chk",function(){
        var is_chk = $(this).is(':checked');
        if(is_chk){
            $(".btn-page-bottom").removeClass('disabled');
        }else{
            $(".btn-page-bottom").addClass('disabled');
        }
    })

    // 탈퇴버튼 클릭
    $(document).on("click",".btn-page-bottom",function(){
        var is_chk = $(".hack_chk").is(':checked');
        if(is_chk){
            pop.open('hackMsg1');
        }
    })

    // 탈퇴
    function go_hack(){
        pop.close();
        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: 'put_resign',
                login_id: artist_id,
            },
            type: 'POST',
            async:false,
            success: function (res) {
                //console.log(res);
                let response = JSON.parse(res);
                let head = response.data.head;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    pop.open('hackMsg2');
                }
            }
        })
    }


</script>
</body>
</html>