<?php 

	header('Content-Type:text/html; charset=utf-8');

	//GET방식으로 전달된 'nick'식별자의 값 얻어오기
	$nick=$_GET['nick'];
	//$nick의 값이 없는지??
	if(!$nick){
		echo "닉네임을 입력하세요.";
		exit;
	}

	//DB안에 $nick의 값과 같은 값이 있는지 검사

	//DB접속하기..
	//include("../lib/dbconn.php");
	//include는 삽입되는 문서에 오류가 있어도
	//오류 표시만 도고 다음 이 문서의 코드를 실행.

	//require는 삽입문서에 오류가 있으면 프로그램이 종료됨..
	require('../lib/dbconn.php');

	//여기까지 왔다는 것은 접속이 성공!

	//전달받은 'nick'값이 DB에 있는지 sql요청
	$sql="SELECT * from member where nick='$nick'";
	$result=mysqli_query($conn, $sql);

	//요청한 select의 row(레코드) 개수 확인
	$rowNum = mysqli_num_rows($result);

	if($rowNum){
		echo "닉네임이 중복됩니다.<br>";
		echo "다른 닉네임을 사용하세요.<br>";
	}else{
		echo "사용가능한 닉네임 입니다.";
	}

	mysqli_close($conn);


?>