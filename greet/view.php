<?php 
	session_start();

	//세션에 저장된 id, name, nick
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$usernick = $_SESSION['usernick'];
	$userlevel = $_SESSION['userlevel'];

	//GET방식으로 전달된 num, page값 얻어외
	$num = $_GET['num'];
	$page = $_GET['page'];

	//선택된 num의 가입인사글 DB에서 읽어오기
	require "../lib/dbconn.php";

	mysqli_set_charset($conn,"utf8");

	$sql = "SELECT * FROM greet WHERE num='$num'";
	$result = mysqli_query($conn,$sql);

	//레코드(한줄)은 1개만 존재할 것임! (num으로 검색했기에..)
	$row=mysqli_fetch_array($result);

	//읽어온 레코드에서 각 필드값들 얻어오기
	$item_num = $row[num];
	$item_id = $row[id];
	$item_name = $row[name];
	$item_nick = $row[nick];
	$item_hit = $row[hit];
	$item_date = $row[regist_day];
	$item_subject = $row[subject];
	$item_content = $row[content];

	//제목(띄어쓰기 여러갤ㄹ 적용하기 위해)
	$item_subject = str_replace(" ","&sbsp;",$row[subject]);

	//내용
	//html쓰기를 햇다면 태그문을 사용하는 것이므로 띄어쓰기나 줄바꿈을 신경쓸 필요가 없다.
	if($is_html!='y'){
		$item_content = str_replace (" ","&nbsp",$item_content);

	}

	$visitNum="visited".$num;

	$visited=$_COOKIE[$visitNum];


	if(!$visited){
		//view.php 가 실행된다는 것은 그 글을 한번 조회했다.
		$item_hit = $item_hit+1;
		$sql = "UPDATE greet set hit=$item_hit where num=$num";
		mysqli_query($conn, $sql);
		setcookie($visitNum,$item_hit,time()+60*60*24);
	}

	

	//읽어온 DB값들을 브라우저에 이쁘게 출력하기 

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>

	<!-- 공통 스타일 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/common.css">

	<!-- view.php전용 스타일 -->
	<link rel="stylesheet" type="text/css" href="../css/greet.css">

	<script type="text/javascript">
		
		//삭제버튼 눌렀을 때 호출되는 함수
		function del(href) {
			if(confirm('정말로 삭제하시겠습니까?')){
				//페이지를 delete.php로 이동
				locaiton.href=href;
			}
		}

	</script>
</head>
<body>

	<div id="wrap">
		
		<header id="header">
			<?include "../lib/top_login2.php"?>
		</header>

		<nav id="menu">
			<?include "../lib/top_menu2.php"?>
		</nav>

		<div id="content">
			<aside id="col1">
				<div id="left_menu">
					<?include "../lib/left_menu.php"?>
				</div>
			</aside>

			<section id="col2">
				
				<div id="title">
					<img src="../img/title_greet.gif">
				</div>

				<!-- 내용물 표시 영역 -->
				<!-- 1. view 타이틀 영역 -->
				<div id="view_title">
					<div id="view_title1"><?=$item_subject?></div>
					<div id="view_title2"><?=$item_nick?> | 조회 : <?=$item_hit?> | <?=$item_date?></div>
				</div>

				<!-- 2. view 내용물 영역 -->
				<div id="view_content">
					<?=$item_content?>
				</div>

				<!-- 3. 버튼들 영역 -->
				<div id="view_button">
					<!-- 목록보기 버튼 -->
					<a href="list.php?page=$page"><img src="../img/list.png"></a>&nbsp;

					<!-- 수정, 삭제는 본인글만 가능 or 레벨 1단계 or 관리자계정도 가능하게-->
					<?

						if($userid==$item_id||$userlevel==1||$userid=="admin"){
					?>

					<a href="modify_form.php?num=<?=$num?>&page=<?=$page?>"><img src="../img/modify.png"></a>&nbsp;

					<!-- 삭제는 한번 더 삭제 의사를 물어보는 경고창을 보여주고  -->
					<!-- 그 경고창에서 확인 또는 취소를 선택하도록.. -->
					<!-- 그 결과가 확인 선택이면 그 때 delete.php가 실행되도록.. -->
					<!-- a를 눌렀을 때 Javascript로 del()함수 호출! -->
					<a href="javascript:del('delete.php?num=<?=$num?>&page=<?=$page?>')"><img src="../img/delete.png"></a>&nbsp;

					<?
						}
					?>

					<!-- 로그인 되어 있다면 글쓰기 가능 -->
					<?
						if($userid){
							echo "<a href='write_form.php'><img src='../img/write.png'></a>";
						}

					?>

				</div>

			</section>
		</div>



	</div>

</body>
</html>
