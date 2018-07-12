<?php 
	session_start();

	header('Content-Type:text/html; charset=utf-8');

	$userid=$_SESSION['userid'];
	$username=$_SESSION['username'];
	$usernick = $_SESSION['usernick'];
?>

<meta charset="utf-8">

<?

	//로그인 안되면 작성 불가
	if(!$userid||!$usernick){
		echo ("
			<script>
				alert('로그인 후 이용가능한 페이지 입니다.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//post로 전달된 content, parent 얻어오기
	$content = $_POST['content'];
	$parent=$_POST['parent'];
	$page=$_POST['page'];

	//콘텐츠가 비어있으면 저장이 안되도록..
	if(!$content){
		echo ("
			<script>
				alert('내용을 입력하세요.');
				history.go(-1);
			</script>
		");
		exit;
	}

	$regist_day = date('Y-m-d (H:i)');

	require "../lib/dbconn.php";

	//memo_ripple 테이블에 저장하는 쿼리문
	$sql ="INSERT INTO memo_ripple(parent, id, name, nick, content, regist_day) ";
	$sql.="values('$parent','$userid','$username','$usernick','$content','$regist_day')";

	//쿼리 요청
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	echo ("
		<script>
			location.href='memo.php?page=$page';
		</script>
	");



?>