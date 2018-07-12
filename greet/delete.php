<?php 
	$num = $_GET['num'];
	$page = $_GET['page'];

	echo ("<script>alert('wejfoijewoifjwe');</script>");

	require "../lib/dbconn.php";

	//삭제 쿼리문
	$sql = "DELETE FROM greet WHERE num='$num'";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	echo ("
		<script>
			alert('삭제되었습니다.');
			location.href='list.php?page=$page';
		</script>
	");
?>