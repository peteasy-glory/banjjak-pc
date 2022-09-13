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
								<h3 class="card-header-title">개인정보 수집 및 이용동의(필수)</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="terms-group">
										<div class="terms-sentence"> (1) 회원 정보의 수집·이용목적, 수집항목, 보유·이용기간은 아래와 같습니다.</div>
										<div class="terms-sentence">
											<table class="terms-table">
												<colgroup>
													<col style="width:12%">
													<col style="width:13%">
													<col style="width:25%">
													<col style="width:25%">
													<col style="width:25%">
												</colgroup>
												<thead>
													<tr>
														<th colspan="2">수집방법</th>
														<th>수집·이용목적</th>
														<th>수집 항목</th>
														<th>보유·이용기간</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td rowspan="4">입력정보<br>(필수)</td>
														<td>상담신청/미용동의서 작성시</td>
														<td>선택한 펫샵에서 첫미용을 요청하거나 미용작업에 대한 상호(견주-펫샵)동의를 위해</td>
														<td>이름,전화번호,펫정보(견종,몸무게,성별 등 펫특이사항)</td>
														<td>목적달성(회원탈퇴 등) 후 지체 없이 파기(단, 관련법령 및 회사정책에 따라 별도 보관되는 정보는 예외)</td>
													</tr>
													<tr>
														<td>회원가입</td>
														<td>회원서비스 이용 및 상담 관리, 중복 확인 체크</td>
														<td>ID(전자우편주소), 비밀번호, 휴대전화번호,닉네임</td>
														<td>목적달성(회원탈퇴 등) 후 지체 없이 파기(단, 관련법령 및 회사정책에 따라 별도 보관되는 정보는 예외)</td>
													</tr>
													<tr>
														<td rowspan="2">예약/주문시</td>
														<td>예약/출장/배송서비스이용</td>
														<td>수취인의 배송지 정보(수취인명, 휴대전화번호, 수취인 주소)</td>
														<td rowspan="2">전자상거래등에서의소비자보호에관한법률에 따라 5년간 보관</td>
													</tr>
													<tr>
														<td>결제서비스이용(상품 구매 및 환불, 취소 포함)<br>* 결제 대행사가 별도 동의를 통해 수집하는 정보</td>
														<td>* 신용카드 결제대행사 수집정보 : 생년월일, 카드번호, 이름, 휴대전화번호, 전자우편주소<br>* 실시간 계좌 이체 결제대행사 수집정보 : 은행명, 계좌번호, 비밀번호,주민등록번호(현금영수증 발행용), 예금주, 전자우편주소</td>
													</tr>
													<tr>
														<td>생성정보<br>(필수)</td>
														<td>회원가입 및 서비스이용</td>
														<td>서비스이용 및 부정거래 확인</td>
														<td>로그기록 및 접속지 정보</td>
														<td>통신비밀보호법에 따라 3개월간 보관</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="terms-group">
										<div class="terms-sentence">(2) 법령에 의하여 수집 · 이용되는 이용자의 정보는 아래와 같은 수집 · 이용목적으로 보관합니다.</div>
										<div class="terms-sentence">
											<table class="terms-table">
												<colgroup>
													<col style="width:25%">
													<col style="width:25%">
													<col style="width:25%">
													<col style="width:25%">
												</colgroup>
												<thead>
													<tr>
														<th>법령/내부정책</th>
														<th>수집·이용목적</th>
														<th>수집 항목</th>
														<th>보유·이용기간</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>통신비밀보호법</td>
														<td>통신사실확인자료 제공</td>
														<td>로그기록, 접속지 정보 등</td>
														<td>3개월</td>
													</tr>
													<tr>
														<td rowspan="4">전자상거래 등에서의 소비자 보호에 관한 법률</td>
														<td>표시·광고에 관한 기록</td>
														<td>표시·광고 기록</td>
														<td>6개월</td>
													</tr>
													<tr>
														<td>대금결제 및 재화 등의 공급에 관한 기록</td>
														<td>대금결제/재화 등의 공급 기록</td>
														<td>5년</td>
													</tr>
													<tr>
														<td>계약 또는 청약철회 등에 관한 기록</td>
														<td>소비자 식별정보 계약/청약철회 기록</td>
														<td>5년</td>
													</tr>
													<tr>
														<td>소비자 불만 또는 분쟁처리에 관한 기록</td>
														<td>소비자 식별정보 분쟁처리 기록</td>
														<td>3년</td>
													</tr>
												</tbody>
											</table>
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
</script>
</body>
</html>