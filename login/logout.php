<?php 
	session_start();

	header('Content-Type:text/html; charset=utf-8');

	unset($_SESSION['userid']);
	unset($_SESSION['usernick']);
	unset($_SESSION['username']);
	unset($_SESSION['userlevel']);

	//로그아웃 되었으니 다시 메인페이지로 이동
	echo ("
		<script>
			location.href='../index.php';
		</script>
	");
?>