<?php 
	session_start();

	$userid=$_SESSION['userid'];
	$usernick=$_SESSION['usernick'];
	$userlevel=$_SESSION['userlevel'];
	$username=$_SESSION['username'];

	header('Content-Type:text/html; charset=utf-8');

	//로그인 안된 사람은 글 작성 않고 종료
	if(!$userid||!$usernick||!$userlevel){
		echo ("
			<script>
				alert('로그인 후 이용가능한 페이지 입니다.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//post로 받은 content값 얻어오기
	$content = $_POST['content'];

	//혹시 content작성 없이 저장 버튼을 눌렀을 수도 있으니
	if(!$content){
		echo ("
			<script>
				alert('내용을 입력하세요.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//글작성날짜 (저장일자)
	$regist_day = date('Y-m-d (h:i)');

	//DB접속
	require "../lib/dbconn.php";

	mysqli_query($conn, "set names utf8");

	//저장을 위한 query
	$sql ="INSERT INTO memo(id, name, nick, content, regist_day) ";
	$sql.="VALUES('$userid', '$username', '$usernick', '$content','$regist_day');";

	mysqli_query($conn, $sql);
	mysqli_close($conn);

	//글작성이 끝났으면 다시 낙서장 페이지로 이동.
	echo ("
		<script>
			location.href='memo.php';
		</script>
	");



?>