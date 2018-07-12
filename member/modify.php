<?php 
	session_start();

	//post로 전달된 데이터 받아오기
	$id = $_POST['id'];
	$pass_current=$_POST['pass_current'];
	$pass = $_POST['pass'];
	$name = $_POST['name'];
	$nick = $_POST['nick'];
	$hp = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
	if($_POST['email1']&&$_POST['email2']){
		$email = $_POST['email1']."@".$_POST['email2'];
	}else{
		$email=NULL;
	}

	//DB접속..
	require "../lib/dbconn.php";

	echo "<meta charset='utf-8'>";

	//한글처리
	mysqli_query($conn, "set names utf8");

	$sql="SELECT * FROM member WHERE id='$id' AND pass=password('$pass_current')";

	//쿼리 요청
	$result=mysqli_query($conn, $sql);

	//결과로부터 찾아진 레코드의 개수 확인
	$rowNum=mysqli_num_rows($result);

	if(!$rowNum){//찾아온 개수가 0개라면.
		//id, pass가 맞지 않는 상황
		//경고창 및 이전 페이지 이동
		echo ("
			<script>
				alert('현재 비밀번호가 틀렸습니다.');
				history.go(-1);
			</script>
		");
		exit;
	}

	//업데이트 쿼리
	$sql = "UPDATE member set ";
	if($pass){
		$sql.="pass=password('$pass'), ";
	}
	$sql.="name='$name', nick='$nick', hp='$hp', email='$email' where id='$id'";

	//쿼리 요청
	$result = mysqli_query($conn, $sql);
	// if($result){
	// 	echo "success";
	// 	exit;
	// }else{
	// 	echo "fail";
	// }

	mysqli_close($conn);

	//세션의 정보를 변경..
	$_SESSION['username']=$name;
	$_SESSION['usernick']=$nick;

	//업데이트가 완료후 다시 메인 페이지로 이동
	echo ("
		<script>
			location.href='../index.php';
		</script>
	");



?>