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
									<h3 class="card-header-title">포트폴리오 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="master-portfolio-list">
											<ul id="sortable" class="list-inner img_wrap" >
												<li class="list-cell filtered" onclick="MemofocusNcursor();">
													<div class="btn-gate-picture-register">
														<span><em>이미지 추가</em></span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>			
						</div>
                        <div style="display:block;position:absolute;top:-50px"><input type="file" accept="image/*" name=imgupfile id=addimgfile></div>
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

<div class="gallery-pop-wrap">
    <div class="gallery-pop-inner">
        <div class="gallery-pop-data" id="ga-da">
            <div class="gallery-pop-slider" id="ga-sl" style="width:100%;height:100%;">
                <div class="swiper-container" id="sw-con">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-item">
                                <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                                <img src="/static/pub/images/gate_picture.jpg" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-page"></div>
                <button type="button" class="btn-swiper-slider-prev"></button>
                <button type="button" class="btn-swiper-slider-next"></button>
            </div>
            <div class="gallery-pop-ui" id="ga-btn">
                <button type="button" class="btn-gallery-pop-nav btn-gallery-mode" onclick="gallery.viewModeChange(this);">
                    <span class="icon icon-size-24 icon-viewall-white off"></span>
                    <span class="icon icon-size-24 icon-viewmax-white on"></span>
                </button>
                <button type="button" class="btn-gallery-pop-nav" onclick="gallery.close();"><span class="icon icon-size-24 icon-close-white"></span></button>
            </div>
        </div>
        <div class="gallery-thumb-data">
            <div class="gallery-thumb-list">
                <button type="button" class="btn-gallery-thumb-nav">
                    <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                    <img src="/static/pub/images/user_thumb.png" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/shop.js"></script>
<script src="../static/js/Sortable.min.js"></script>
<script src="/static/js/imagesloaded.pkgd.min.js"></script>
<script>

    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        gallery.init();
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_shop_wrap','gnb_portfolio');
        get_portfolio(artist_id);
        allim_reserve_test('600990','01086331776','범shop수정');
        allim_customer_test('2022-08-01','2022-09-01','01086331776');
        console.log(shop_array);

        var html = '';
        let img_list = '';
        $.each(shop_array[0],function(i,v){


            var img_path = img_link_change(v.image);

            if( i === shop_array[0].length-1){


                img_list += `${img_path.replace('https://image.banjjakpet.com','')}`
            }else{

                img_list += `${img_path.replace('https://image.banjjakpet.com','')}|`
            }

        })
        $.each(shop_array[0], function(i, v){
            var img_path = img_link_change(v.image);
            html += `
                <li class="list-cell">
                    <div class="master-portfolio-item">
                        <div class="item-thumb" onclick="showReviewGallery(${i},'${img_list}')"><img src="${img_path}" alt=""></div>
                        <div class="item-info">
                            <!--<div class="item-number">${v.sort_number}</div>-->
<!--                            <button type="button" class="btn-item-hand"></button>-->
                        </div>
                        <button type="button" class="btn-data-del" data-idx=${v.idx}>데이타삭제</button>
                    </div>
                </li>
            `;
        })
        $(".img_wrap").append(html);
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
        formData.append("mode", "post_shop_gallery");
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

    $(function(){
        /*
        $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight",
            cancel:''
        });
        $( "#sortable" ).disableSelection();
        */

        //https://github.com/SortableJS/Sortable

        var el = document.getElementById('sortable');
        var sortable = Sortable.create(el , {
            handle : '.btn-item-hand',
            delay : 0,
            ghostClass: 'guide',
            dataIdAttr:'data-id',
            filter: '.filtered',
            onMove: function(evt) {
                return evt.related.className.indexOf('filtered') === -1; //and this
              },
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

    $(document).on('click' , '.btn-data-del' , function(){
        pop.open('delete_pop');
        var idx = parseInt($(this).data("idx"));
        $("#delete_pop .idx").val(idx);
    });

    function delete_ok(){
        var idx = $("#delete_pop .idx").val();
        del_gallery(idx);
    }
</script>
</body>
</html>