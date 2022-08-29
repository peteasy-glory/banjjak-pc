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
									<h3 class="card-header-title">샵 대문 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="shop-gate-picture-wrap">
											<div class="shop-gate-info-title">Shop 대문 사진함</div>
											<div class="shop-gate-info-desc">아래 사진 중 원하시는 사진을 SHOP 대문사진으로 설정해 주세요.<br>보관함에 있는 사진들도 언제든지 대문사진 변경 가능합니다.</div>
											<div class="shop-gate-picture-select">
												<div class="list-inner img_wrap">
													<div class="list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor();"><span><em>이미지 추가</em></span></a></div>
                                                    <div style="display:block;position:absolute;top:-50px"><input type="file" accept="image/*" name=imgupfile id=addimgfile></div>
												</div>
											</div>
											<div class="picture-add-info">이미지는 최대 25개까지 등록할 수 있습니다.<br>gif, png, jpg, jpeg 형식의 절차 이미지만 등록됩니다.</div>
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
        get_front_img(artist_id);
        console.log(shop_array);

        var main = '';
        var html = '';
        $.each(shop_array[0], function(i, v){
            var img_path = img_link_change(v.image);
            if(v.main_image == 1){
                main = `
                    <div class="list-cell">
                        <div class="picture-thumb-view">
                            <div class="picture-obj"><img src="${img_path}" alt=""></div>
                            <div class="check-point"></div>
                        </div>
                    </div>
                `;
            }else{
                html += `
                    <div class="list-cell">
                        <div class="picture-thumb-view">
                            <div class="picture-obj"><img src="${img_path}" alt=""></div>
                            <div class="picture-ui">
                                <button type="button" class="btn-picture-ui"></button>
                            </div>
                            <div class="picture-ui-list">
                                <div class="picture-ui-list-inner">
                                    <a href="javascript:change_main('${artist_id}','${v.image}');" class="btn-picture-ui-nav">대표 사진 등록</a>
                                    <a href="javascript:del_front('${artist_id}','${v.image}');" class="btn-picture-ui-nav">삭제</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        $(".img_wrap").append(main+html);
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
        formData.append("mode", "post_front_img");
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