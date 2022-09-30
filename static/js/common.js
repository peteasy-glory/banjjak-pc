var include = {

    headerContainer: null,
    gnbContainer: null,
    footerContainer: null,

    init: function () {

        this.headerContainer = document.querySelector('#header');
        this.gnbContainer = document.querySelector('#gnb');
        this.footerContainer = document.querySelector('#footer');
        if (this.headerContainer && this.headerContainer.children.length == 0) this.header();
        if (this.gnbContainer && this.gnbContainer.children.length == 0) this.gnb();
        if (this.footerContainer && this.footerContainer.children.length == 0) this.footer();

    },
    header: function () {
        var _html = `<div class="header-wrap">
                        <h1><a href="/home/index.php">반짝 반려미용샵의 단짝</a></h1>
                        <div class="header-menu-wrap">
                            <div class="header-menu">
                                <!--header-menu-cell 클래스에 actived 클랫 추가시 활성화 -->
                                <div class="header-menu-cell">
                                    <a href="/customer/customer_pet_new.php">신규등록</a>
                                </div>
                                <div class="header-menu-cell">
                                    <a href="/customer/customer_all_inquiry1.php">전체고객조회</a>
                                </div>
                                <div class="header-menu-cell">
                                    <a href="/booking/reserve_registration.php">예약 접수하기</a>
                                </div>
                                <div class="header-menu-cell">
                                    <a href="/booking/reserve_advice_view.php">상담대기
                                        <div class="label label-pink consulting_count"></div>
                                    </a>
                                </div>
                            </div>
<!--                            <div class="header-alarm">-->
<!--                                &lt;!&ndash; 알람 있을때 btn-page-alarm 클래스에 actived클래스 추가시 활성화 &ndash;&gt;-->
<!--                                <button type="button" class="btn-page-ui btn-page-alarm btn-header-alarm-toggle actived">-->
<!--                                    <span class="icon icon-size-24 icon-page-alarm">알람</span>-->
<!--                                </button>-->
<!--                                <div class="header-alarm-wrap">-->
<!--                                    <div class="header-alarm-top">-->
<!--                                        <div class="header-alarm-title">반짝 알림</div>-->
<!--                                        <button type="button" class="btn-header-alarm-toggle btn-header-alarm-close">닫기</button>-->
<!--                                    </div>-->
<!--                                    <div class="header-alarm-body">-->
<!--                                        &lt;!&ndash; 데이타 있을 때 &ndash;&gt;-->
<!--                                        <div class="alarm-list-wrap">-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                            <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                            <div class="item-date">3일전</div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                            <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                            <div class="item-date">3일전</div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                            <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                            <div class="item-date">3일전</div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                            <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                            <div class="item-date">3일전</div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                            <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                            <div class="item-date">3일전</div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="list-cell">-->
<!--                                                <div class="alarm-list-item">-->
<!--                                                    <div class="logo"></div>-->
<!--                                                    <div class="info-wrap">-->
<!--                                                        <div class="info-inner">-->
<!--                                                            <div class="item-subject">반짝, 미용 예약 안내</div>-->
<!--                                                                <div class="item-info">예약일 (3월10일) 3일전입니다. 고객님의 귀여운 아이들 뷰티를 위해 최선을 다하도록 하겠습니다.</div>-->
<!--                                                                <div class="item-date">3일전</div>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                        <button type="button" class="btn-alarm-del">삭제</button>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            &lt;!&ndash; //데이타 있을 때 &ndash;&gt;-->
<!--                                            -->
<!--                                            &lt;!&ndash; 데이타 없을 때 &ndash;&gt;-->
<!--                                            <div class="common-none-data">-->
<!--                                                <div class="none-inner">-->
<!--                                                    <div class="item-visual">-->
<!--                                                        <img src="../../static/images/icon/img-illust-3@2x.png" alt="" width="103">-->
<!--                                                    </div>-->
<!--                                                    <div class="item-info">알림이 없습니다.</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            &lt;!&ndash; //데이타 없을 때 &ndash;&gt;-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>`;


        this.headerContainer.innerHTML = _html;
    },

    gnb: function () {
        var _html = `<div class="gnb-wrap">
                        <div class="gnb-inner">
                            <!-- 메뉴 토글 버튼 -->
                            <button type="button" class="btn-gnb-toggle">메뉴 활성화 버튼</button>
                            
                            <!-- 메뉴 유저 정보 -->
                            <div class="gnb-user-data">
                                <div class="thumb-data">
                                    <div class="content-thumb" style="cursor:pointer" onclick="location.href='/home/index.php'">
                                        <img src="" alt="" class="front_image">
                                    </div>
                                </div>
                                <div class="txt-data">
                                    <div class="user-name nick nickname"></div>
                                    <div class="user-cate shop_name">
                                        <a href="/data/logout_process.php" onclick="localStorage.clear()" class="btn-gnb-logout">로그아웃</a>
                                    </div>
                                </div>
                            </div><!-- 메인 메뉴 -->
                            <div class="gnb-menu-list">
                                <div class="gnb-menu-inner">
                                    <!-- gnb-menu-cell 클래스에 페이지 진입시 actived클래스와 actived클래스 추가시 활성화-->
                                    <div class="gnb-menu-cell" id="gnb_home">
                                        <a href="/home/index.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-gnb-menu-home-black off"></span>
                                                <span class="icon icon-size-24 icon-gnb-menu-home-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">홈</span>
                                        </a>
                                    </div>
                                    <div class="gnb-menu-cell " id="gnb_reserve_wrap">
                                        <a href="/booking/reserve_beauty_day.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-calendar-black off"></span>
                                                <span class="icon icon-size-24 icon-calendar-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">예약 관리</span>
                                        </a>
                                        <!-- 2뎁스 메뉴가 있을 시 아래 구조로 처리 요망 -->
                                        <div class="snb-menu-list" >
                                        <!-- snb-menu-cell 클래스에 actived클래스 추가시 활성화 -->
                                            <div class="snb-menu-cell" id="gnb_beauty">
                                                <a href="/booking/reserve_beauty_day.php" class="btn-snb-nav" >
                                                    <div class="txt">미용 예약 관리</div>
                                                </a>
                                            </div>
<!--                                            <div class="snb-menu-cell" id="gnb_hotel">-->
<!--                                                <a href="#" class="btn-snb-nav" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">-->
<!--                                                    <div class="txt">호텔 예약 관리</div>-->
<!--                                                </a>-->
<!--                                            </div>-->
<!--                                            <div class="snb-menu-cell" id="gnb_kindergarden">-->
<!--                                                <a href="#" class="btn-snb-nav" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">-->
<!--                                                <div class="txt">유치원 예약 관리</div>-->
<!--                                                </a>-->
<!--                                            </div>-->
                                            <div class="snb-menu-cell" id="gnb_consulting">
                                                <a href="/booking/reserve_advice_view.php" class="btn-snb-nav">
                                                    <div class="txt">상담 대기</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_reserve">
                                                <a href="/booking/reserve_registration.php" class="btn-snb-nav">
                                                    <div class="txt">예약 접수하기</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gnb-menu-cell " id="gnb_customer_wrap">
                                        <a href="/customer/customer_inquiry.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-dubble-user-black off"></span>
                                                <span class="icon icon-size-24 icon-dubble-user-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">고객 관리</span>
                                        </a>
                                        <div class="snb-menu-list" >
                                            <div class="snb-menu-cell" id="gnb_inquire">
                                                <a href="/customer/customer_inquiry.php" class="btn-snb-nav">
                                                    <div class="txt">빠른 조회하기</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_inquire_all">
                                                <a href="/customer/customer_all_inquiry1.php" class="btn-snb-nav">
                                                    <div class="txt">전체 고객 조회</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_new">
                                                <a href="/customer/customer_pet_new.php" class="btn-snb-nav">
                                                    <div class="txt">신규 등록</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_grade">
                                                <a href="/customer/customer_grade.php" class="btn-snb-nav">
                                                    <div class="txt">회원 등급 설정</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gnb-menu-cell" id="gnb_shop_wrap">
                                        <a href="/shop/shop_gate_picture.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-shop-black off"></span>
                                                <span class="icon icon-size-24 icon-shop-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">샵 관리</span>
                                        </a>
                                        <div class="snb-menu-list">
                                            <div class="snb-menu-cell" id="gnb_front">
                                                <a href="/shop/shop_gate_picture.php" class="btn-snb-nav">
                                                    <div class="txt">샵 대문 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_info">
                                                <a href="/shop/shop_management.php" class="btn-snb-nav">
                                                    <div class="txt">샵 정보 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_portfolio">
                                                <a href="/shop/shop_portfolio.php" class="btn-snb-nav">
                                                    <div class="txt">포트폴리오 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_review">
                                                <a href="/shop/shop_review_list.php" class="btn-snb-nav">
                                                    <div class="txt">샵 후기 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_blog">
                                                <a href="/shop/shop_blog.php" class="btn-snb-nav">
                                                    <div class="txt">샵 연동 블로그 관리</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gnb-menu-cell" id="gnb_detail_wrap">
                                        <a href="/setting/set_schedule_list.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-set-black off"></span>
                                                <span class="icon icon-size-24 icon-set-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">상세 설정</span>
                                        </a>
                                        <div class="snb-menu-list">
                                            <div class="snb-menu-cell" id="gnb_schedule">
                                                <a href="/setting/set_schedule_list.php" class="btn-snb-nav">
                                                    <div class="txt">일정 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_authority">
                                                <a href="/setting/set_right.php" class="btn-snb-nav">
                                                    <div class="txt">권한 설정</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_artist">
                                                <a href="/setting/set_teacher.php" class="btn-snb-nav">
                                                    <div class="txt">미용사 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_merchandise">
                                                <a href="/setting/set_beauty_management.php" class="btn-snb-nav">
                                                    <div class="txt">판매 상품 관리</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_deposit">
                                                <a href="/setting/set_deposit.php" class="btn-snb-nav">
                                                    <div class="txt">예약금 설정</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_keep">
                                                <a href="/setting/set_save_money.php" class="btn-snb-nav">
                                                    <div class="txt">적립금 설정</div>
                                                </a>
                                            </div>
                                            
                                            <div class="snb-menu-cell" id="gnb_payment">
                                                <a href="/setting/set_pay_type.php" class="btn-snb-nav">
                                                    <div class="txt">결제 방식</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gnb-menu-cell" id="gnb_stats_wrap">
                                        <a href="/report/stats_sale_1.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-money-black off"></span>
                                                <span class="icon icon-size-24 icon-money-black-fill on"></span>
                                            </span>
                                            <span class="nav-txt">판매 실적</span>
                                        </a>
                                        <div class="snb-menu-list">
                                            <div class="snb-menu-cell" id="gnb_stats">
                                                <a href="/report/stats_sale_1.php" class="btn-snb-nav">
                                                    <div class="txt">판매실적 조회</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gnb-menu-cell" id="gnb_etc_wrap">
                                        <a href="/etc/other_notice_list.php" class="btn-gnb-nav">
                                            <span class="nav-icons">
                                                <span class="icon icon-size-24 icon-other off"></span>
                                                <span class="icon icon-size-24 icon-other-fill on"></span>
                                            </span>
                                            <span class="nav-txt">기타</span>
                                        </a>
                                        <div class="snb-menu-list">
                                            <div class="snb-menu-cell" id="gnb_notice">
                                                <a href="/etc/other_notice_list.php" class="btn-snb-nav">
                                                    <div class="txt">공지사항</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_ask">
                                                <a href="/etc/other_inquiry.php" class="btn-snb-nav">
                                                    <div class="txt">문의하기</div>
                                                </a>
                                            </div>
                                            <div class="snb-menu-cell" id="gnb_profile">
                                                <a href="/etc/other_member.php" class="btn-snb-nav">
                                                    <div class="txt">회원정보 관리</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>`;


        this.gnbContainer.innerHTML = _html;
    },

    footer: function () {
        var _html = '<div class="footer-wrap"><div class="footer-title">(주)펫이지 사업자 정보</div><div class="footer-info-wrap"><div class="footer-info-cell"><div class="footer-info-list"><div class="footer-info-item">대표: 신동찬</div><div class="footer-info-item">사업자등록번호: 157-86-01070 <a href="#" class="font-underline" onClick="window.open(\'https://www.ftc.go.kr/bizCommPop.do?wrkr_no=1578601070\');">사업자정보확인</a></div><div class="footer-info-item">통신판매업 제 2021-서울종로-0183호</div><div class="footer-info-item">개인정보 담당자: 이석범 <a href="mailTo:privacy@peteasy.kr">privacy@peteasy.kr</a></div><div class="footer-info-item">서울시 종로구 종로6 5층 서울창조경제혁신센터</div></div></div><div class="footer-info-cell"><div class="footer-info-list"><div class="footer-info-item"><a href="/etc/other_terms4.php"><strong>이용약관</strong></a></div><div class="footer-info-item"><a href="/etc/other_terms3.php"><strong>개인정보처리방침</strong></a></div></div></div></div></div>';
        this.footerContainer.innerHTML = _html;
    }
};
/**********************************
 @ common
 **********************************/
var common = {

    stage: {width: 0, height: 0, top: 0},
    pageBannerElement: null,
    pageBannerSlider: null,
    pageBannerSliderCur: 0,
    pageBannerSliderLen: -1,
    toastPopElement: null,
    toastPopActive: false,
    toastPopTimer: null,
    pageTopFlag: false,

    init: function () {

        include.init();

        var _this = this;

        //공통 스와이퍼
        $('.basic-swiper-banner').each(function () {
            var $element = $(this);
            if ($element.find('.swiper-slide').length > 1) {
                var slider = new Swiper($(this).find('.swiper-container')[0], {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    speed: 450,
                    resistance: false,
                    simulateTouch: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: $element.find('.swiper-pagination')[0],
                        clickable: true,
                        bulletElement: 'button'
                    },
                    navigation: {
                        nextEl: $element.find('.btn-swiper-slider-next')[0],
                        prevEl: $element.find('.btn-swiper-slider-prev')[0]
                    }
                });
            } else {
                $element.addClass('none');
            }
            ;
        });

        //메인 공통 배너
        if ($('.page-banner-slider').length > 0 && $('.page-banner-wrap').hasClass('actived') == true) {
            common.pageBannerElement = $('.page-banner-slider');
            common.pageBannerSliderLen = common.pageBannerElement.find('.swiper-slide').length;
            common.pageBannerSlider = new Swiper(common.pageBannerElement.find('.swiper-container')[0], {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 0,
                simulateTouch: true,
                speed: 450,
                navigation: {
                    nextEl: common.pageBannerElement.find('.btn-swiper-slider-next')[0],
                    prevEl: common.pageBannerElement.find('.btn-swiper-slider-prev')[0]
                }
            });
            common.pageBannerSlider.on('slideChange', function () {
                common.pageBannerSliderCur = this.realIndex;
                common.pageBannerSwiperSort();
            });
            common.pageBannerSwiperSort();
        }
        ;

        //상품 상세 텍스트 더보기 버튼 이벤트
        $(document).on('click', '.btn-desc-more', function () {
            var $parents = $(this).parents('.item-desc');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
                $(this).html('더보기');
            } else {
                $parents.addClass('actived');
                $(this).html('닫기');
            }
            ;
        });

        //아코디언 메뉴 클릭 이벤트
        $(document).on('click', '.btn-accordion-menu', function () {
            common.accordionToggle($(this));
        });

        //메뉴 토글 버튼
        $(document).on('click', '.btn-gnb-toggle', function () {
            common.gnbToggle();
        });

        //gnb 메뉴 클릭 이벤트
        /*
        $(document).on('click' , '.btn-gnb-nav' , function(){
            var $element = $(this);
            var $parents = $(this).parents('.gnb-menu-cell');
            if(!$('#gnb').hasClass('hide')){
                if($parents.hasClass('current')){
                    $parents.removeClass('current');
                }else{
                    $parents.addClass('current');
                }
            }
        });
        */

        $(document).on('click', '.btn-pay-card-toggle', function () {
            var $parents = $(this).parents('.pay-card-rule-wrap');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
            } else {
                $parents.addClass('actived');
            }

        });

        //헤더 알람 토글 이벤트
        $(document).on('click', '.btn-header-alarm-toggle', function () {
            if ($('.header-alarm-wrap').hasClass('actived')) {
                $('.header-alarm-wrap').removeClass('actived');
            } else {
                $('.header-alarm-wrap').addClass('actived');
            }
            ;
        });

        // 사진 편집 버튼 이벤트
        $(document).on('click', '.btn-picture-ui', function () {
            var $parents = $(this).parents('.picture-thumb-view');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
            } else {
                $parents.addClass('actived');
            }
        });

        //리스트 삭제 버튼 이벤트
        $(document).on('click', '.btn-basic-item-ui-nav', function () {
            var $parents = $(this).parents('.basic-item');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
            } else {
                $parents.addClass('actived');
            }
        });

        //토글 더보기 버튼
        $(document).on('click', '.btn-detail-toggle', function () {
            var $parents = $(this).parents('.detail-toggle-parents');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
                $(this).html('펫 정보 자세히 보기');
            } else {
                $parents.addClass('actived');
                $(this).html('펫 정보 닫기');
            }
        });

        //서비스내역 상세 토글 버튼
        $(document).on('click', '.pay-accordion-items .btn-data-view', function () {
            var $parents = $(this).parents('.pay-accordion-items');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
            } else {
                $parents.addClass('actived');
            }
        });

        //데이타 더보기 버튼
        $(document).on('click', '.btn-note-toggle', function () {
            var $parents = $(this).parents('.note-toggle-group');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
                $(this).removeClass('actived').html('더보기');
            } else {
                $parents.addClass('actived');
                $(this).addClass('actived').html('접기');
            }
        });


        //캘린더 주단위 더보기 버튼
        /*
        $(document).on('click' , '.btn-calendar-item-more' , function(){
            var $parents = $(this).parents('.calendar-week-time-item');
            if($parents.hasClass('actived')){
                $parents.removeClass('actived');
            }else{
                $parents.addClass('actived');
            }
        });
        */

        // 캘린더 월 선택 버튼
        $(document).on('click', '.reserve-calendar-title button.txt', function () {
            var $parents = $(this).parents('.reserve-calendar-select');
            if (!$parents.hasClass('disabled')) {
                if ($parents.find('.calendar-title-sort').hasClass('actived')) {
                    $parents.find('.calendar-title-sort').removeClass('actived');
                } else {
                    $parents.find('.calendar-title-sort').addClass('actived');
                }
            }
        });

        $(document).on('click', function (e) {
            if ($('.reserve-calendar-select').find('.calendar-title-sort').length > 0) {
                if ($(e.target).parents('.reserve-calendar-select').length == 0) {
                    if ($('.reserve-calendar-select').find('.calendar-title-sort').hasClass('actived')) $('.reserve-calendar-select').find('.calendar-title-sort').removeClass('actived');
                }
            }
        });

        // 미니캘린더 월 선택 버튼
        $(document).on('click', '.mini-reserve-calendar-title button.txt', function () {
            var $parents = $(this).parents('.mini-reserve-calendar-top');
            if (!$parents.hasClass('disabled')) {
                if ($parents.find('.calendar-title-sort').hasClass('actived')) {
                    $parents.find('.calendar-title-sort').removeClass('actived');
                } else {
                    $parents.find('.calendar-title-sort').addClass('actived');
                }
            }
        });

        $(document).on('click', function (e) {
            if ($('.mini-reserve-calendar-top').find('.calendar-title-sort').length > 0) {
                if ($(e.target).parents('.mini-reserve-calendar-top').length == 0) {
                    if ($('.mini-reserve-calendar-top').find('.calendar-title-sort').hasClass('actived')) $('.mini-reserve-calendar-top').find('.calendar-title-sort').removeClass('actived');
                }
            }
        });


        //정보 더보기 토글 버튼
        $(document).on('click', '.btn-more-toggle-nav', function () {
            var $parents = $(this).parents('.more-toggle-parents');
            if ($parents.hasClass('actived')) {
                $parents.removeClass('actived');
            } else {
                $parents.addClass('actived');
            }
        });

        $('#wrap').addClass('open');

        this.gnbDataSet();
        this.scroll();
        this.resize();
    },
    pageBannerSwiperSort: function () {
        var _value = '<em>' + String((common.pageBannerSliderCur + 1) + '</em> / ' + common.pageBannerSliderLen);
        common.pageBannerElement.find('.swiper-page').html(_value);
    },
    accordionToggle: function (_obj) {
        var parentsElement = _obj.parents('.accordion-list');
        parentsElement.find('.accordion-cell').each(function () {
            if ($(this).index() == _obj.parents('.accordion-cell').index()) {
                if ($(this).hasClass('actived')) {
                    $(this).removeClass('actived');
                } else {
                    $(this).addClass('actived');
                }
            } else {
                //$(this).removeClass('actived');
            }
        });
    },
    gnbToggle: function () {
        if ($('#gnb').hasClass('hide')) {
            $('#gnb').removeClass('hide');
            $('#container').removeClass('hide');
        } else {
            $('#gnb').addClass('hide');
            $('#container').addClass('hide'); }
        common.gnbDataSort();
    },
    gnbDataSet: function () {
        $('.gnb-menu-cell').each(function () {
            var $anchor = $(this).find('.btn-gnb-nav');
            $anchor.attr('data-url', $anchor.attr('href'));
            if ($(this).find('.snb-menu-list').length == 0) $(this).addClass('single');
        });
    },
    gnbDataSort: function () {
        /*
        $('.gnb-menu-cell').each(function(){
            var $anchor = $(this).find('.btn-gnb-nav');
            if($('#gnb').hasClass('hide')){
                $anchor.attr('href' , $anchor.attr('data-url'));
            }else{
                if($(this).find('.snb-menu-list').length > 0){
                    $anchor.attr('href' , 'javascript:;');
                }else{
                    $anchor.attr('href' , $anchor.attr('data-url'));
                };
            };
        });
        */
    },
    scroll: function () {
        common.stage.top = $(window).scrollTop();
        if (common.stage.width > 1024) {
            if ($('#btnPageTop').length > 0) {
                if (common.stage.top >= 100) {
                    if (!common.pageTopFlag) {
                        $('#btnPageTop').stop(true).fadeIn(300);
                    }
                    common.pageTopFlag = true;

                } else {
                    if (common.pageTopFlag) {
                        $('#btnPageTop').stop(true).fadeOut(300);
                    }
                    common.pageTopFlag = false;
                }
            }
        }
    },
    resize: function () {
        common.stage.width = $(window).width();
        common.stage.height = $(window).height();
        common.stage.top = $(window).scrollTop();
        if ($('.gnb-menu-list').length > 0) common.gnbDataSort();
    },
    toastPopOpen: function (id) {

        if (!common.toastPopActive) {
            if (common.toastPopTimer) clearTimeout(common.toastPopTimer);
            common.toastPopActive = true;
            common.toastPopElement = $('#' + id);
            common.toastPopElement.addClass('actived');
            common.toastPopTimer = setTimeout(function () {
                common.toastPopElement.removeClass('actived');
                common.toastPopActive = false;
            }, 1500);
        }
    },
    pageMove: function (_y) {
        $('.page-body').stop().animate({'scrollTop': _y}, {queue: false, duration: 350});
    }
};

var pop = {

    element: null,
    elementArr: [],
    isActive: false,
    zIndex: 99959,

    init: function () {
        //팝업 컨텐츠 외 영역 클릭시 닫기 이벤트
        $(document).on('click', '.layer-pop-wrap', function (e) {
            if (pop.isActive) {
                if ($(e.target).parents('.pop-data').length == 0) {
                    pop.close();
                }
            }
        });
    },

    // 팝업 열기
    open: function (_id, _item) {
        pop.isActive = true;
        $('html').addClass('fix');
        this.element = $('#' + _id);
        $('#' + _id + " .msg-txt").text(_item);
        this.element.addClass('actived').css({'z-index': pop.zIndex});
        this.elementArr.push(this.element);
        pop.zIndex += 1;
    },

    //팝업 닫기
    close: function (_item) {
        var $element;
        pop.isActive = false;
        $('html').removeClass('fix');
        /*
        if(_item){
            $(_item).parents('.layer-pop-wrap').removeClass('actived');
        }else{
            this.element.removeClass('actived');
        }
        */
        if (_item) {
            $element = $(_item);
            $element.removeClass('actived');
        } else {
            $element = pop.elementArr[pop.elementArr.length - 1];
            $element.removeClass('actived');
        }
        pop.elementArr.pop();


    },

    change: function () {

    }
};

$(function () {
    common.init();
    pop.init();

    /******************************************************
     @ Window Scroll
     ******************************************************/
    $(window).on("scroll", function () {
        common.scroll();
    });

    /******************************************************
     @ Window Resize
     ******************************************************/
    $(window).on("resize", function () {
        common.resize();
        common.scroll();
    });
    //$('html').addClass('dark');
});

function darkMode() {
    if ($('html').hasClass('dark')) {
        $('html').removeClass('dark');
        localStorage.removeItem('dark');
    } else {
        $('html').addClass('dark');
        localStorage.setItem('dark','1');
    }
    ;
};

function stopProp(){
    Array.from(document.getElementsByClassName('btn-snb-nav')).forEach(function(el){

        el.addEventListener('click',function (evt){

            evt.stopPropagation();

        })
    })
}

$(document).ready(function(){

    stopProp();
})
