<?php 

	//get방식으로 전달된 댓글의 번호 (num) 얻어오기
	$num=$_GET['num'];
	$page=$_GET['page'];

	require "../lib/dbconn.php";

	$sql = "DELETE FROM memo_ripple WHERE num='$num'";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	//다시 이전 페이지(memo페이지)
	echo ("
		<script>
			location.href='memo.php?page=$page';
		</script>
	");



?>