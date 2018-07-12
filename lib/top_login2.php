<!-- 홈페이지 메인 로고 이미지 -->
<div id="logo">
	<!-- 얘가 삽입된 아이의 기준으로 작성해야 한다. -->
	<a href="../index.php"><img src="../img/logo.gif"></a>
</div>

<!-- 홈페이지 상단 타이틀 이미지 -->
<div id="moto">
	<a href="../index.php"><img src="../img/moto.gif"></a>
</div>

<!-- 우측 상단의 로그인/회원가입 여부 표시 -->
<div id="top_login">
	<?

		//세션에 저장된 로그인 정보가 없는가?
		if(!$userid){
			//로그인 페이지로 이동하는 링크
			echo "<a href='../login/login_form.php'>로그인</a> | ";

			//회원가입 페이지로 이동하는 링크
			echo "<a href='../member/member_form.php'>회원가입</a>";

		}else{
			//로그인이 되어있는 회원 닉네임과 레벨 표시
			echo "{$usernick} 님 환영합니다 (level : {$userlevel}) | ";
			echo "<a href='../login/logout.php'>로그아웃</a> | ";
			echo "<a href='../member/member_form_modify.php'>정보수정</a>";
		}

	?>
</div>