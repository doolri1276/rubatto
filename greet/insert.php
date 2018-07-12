<?php 

	session_start();

	header("Content-Type:text/html; charset=utf-8");

	//세션에 저장된 id, name, nick
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$usernick = $_SESSION['usernick'];

?>

<meta charset="utf-8">

<?php 

	//로그인이 안된 사람
	if(!$userid||!$usernick){
		echo ("
			<script>
				alert('로그인 후 이용가능한 페이지 입니다.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//post방식으로 전달된 제목, 내용 얻어오기
	$subject = $_POST['subject'];
	$content = $_POST['content'];

	//제목이 없으면 저장 불가!
	if(!$subject){
		echo ("
			<script>
				alert('제목을 입력하세요.');
				history.go(-1);
			</script>
		");
		exit;
	}

	if(!$content){
		echo ("
			<script>
				alert('내용을 입력하세요.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//html 쓰기 허용여부 확인
	$is_html = $_POST['is_html'];

	if($is_html!='y'){//html쓰기가 허용되지 않으면.
		// '<' '>' 같은 html문법 문자들을 특수문자(&lt; &gt;)로 변환하기!!
		$content = htmlspecialchars($content);
	}

	//글 저장 날짜
	$regist_day = date('Y-m-d (H:i:s)');

	//DB접속
	require "../lib/dbconn.php";

	//한글 깨짐 방지
	//mysqli_set_charset($conn, "utf8");

	//현재 실행중인 insert.php가 수정모드인지!
	$mode=$_GET['mode'];

	if($mode=='modify'){
		$num=$_GET[num];
		$sql = "UPDATE greet SET subject='$subject', content='$content', is_html ='$is_html' WHERE num='$num'";

	}else{
		//insert 쿼리문..
		$sql = "INSERT INTO greet(id, name, nick, subject, content, regist_day, hit, is_html) ";
		$sql.= "VALUES('$userid','$username','$usernick','$subject','$content','$regist_day','0','$is_html')";
	}

	//쿼리 요청
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	$page=$_GET[page];
	if($page){

	echo ("
		<script>
			location.href='view.php?num=$num&page=$page';
		</script>
	");	
	exit();

	}else{
	//글쓰기가 완료되면 다시 가입인사 목록 페이지로 이동
	//새글은 언제나 최신글이니 무조건 1page로 이동
	echo ("
		<script>
			location.href='list.php';
		</script>
	");	
	exit();
	}

	

?>