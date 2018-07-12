<?php
	session_start();

	$userid=$_SESSION['userid'];
	$usernick=$_SESSION['usernick'];
	$userlevel=$_SESSION['userlevel'];

	$table = "concert";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>연주회</title>

	<!-- 공통 스타일 시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/common.css">

	<!-- 연주회 전용 스타일 시트 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/concert.css">
</head>
<body>
	<!-- 공통모듈 include -->-
	<div id="wrap">
		<header id="header">
			<?include "../lib/top_login2.php";?>
		</header>

		<nav id="menu">
			<?include "../lib/top_menu2.php";?>
		</nav>

		<div id="content">
			<aside id="col1">
				<div id="left_menu">
					<?include "../lib/left_menu.php";?>
				</div>
			</aside>
			<section id="col2">
				
				<!-- 제목 -->
				<div id="title">
					<img src="../img/title_concert.gif">
				</div>

				<div id="search_form">
					<!-- 연주회 리스트 검색 폼 영역 -->
					<form name="board_form" method="post">
						<div id="list_search">
							<!-- 게시글 갯수 설명 영역 -->
							<div id="list_search1">
								▷ 총 <?=$total_record?> 개의 게시물이 있습니다.
							</div>

							<!-- 게시글 search 글씨 그림 -->
							<div id="list_search2">
								<img src="../img/select_search.gif">
							</div>

							<!-- 분류 select 영역 -->
							<div id="list_search3">
								<select name="find">
									<option value="subject">제목</option>
									<option value="content">내용</option>
									<option value="nick">별명</option>
									<option value="name">이름</option>
								</select>
							</div>

							<!-- 검색상자 -->
							<div id="list_search4">
								<input type="text" name="search">
							</div>

							<!-- 검색 버튼 -->
							<div id="list_search5">
								<input type="image" src="../img/list_search_button.gif">
							</div>
						</div>

					</form>
				</div>
				




			</section>
		</div>
	</div>

</body>
</html>