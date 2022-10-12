<?php
	if(!isset($_SESSION['gobeauty_user_id'])) {
?>

	<script>
		/*
		$.MessageBox({
			buttonDone      : "확인",
			message         : "<center><b>로그인이 필요한 메뉴입니다</b><br>(로그인 페이지로 이동합니다)</center>"
		}).done(function(){
			location.href="<?=$login_directory?>/index.php";
		});
		*/
		location.href="/login/login.php";
	</script>

<?php
		exit;
	}elseif(isset($_SESSION['gobeauty_user_id']) && $_SESSION['my_shop_flag']!='1' && $_SESSION['artist_flag']!=true) {
		?>
		<script>
            // 입점신청 or 권한요청 페이지
            alert('입점신청 및 미용사 권한 요청을 해주세요.');
		    location.href="/data/logout_process.php";
		</script>
		<?
		exit;
	}
?>
