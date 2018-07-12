<?php 
	session_start();

	$userid = $_SESSION['userid'];
	$usernick = $_SESSION['usernick'];
	$userlevel = $_SESSION['userlevel'];

	if(!$userid||!$usernick||!$userlevel){
		echo ("
			<script>
				alert('로그인 후 이용가능한 페이지 입니다.');
				location.href='../login/login_form.php';
			</script>
		");
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>정보수정</title>

	<!-- 공통 스타일 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/common.css">

	<!-- 회원가입 전용 스타일 적용 -->
	<link rel="stylesheet" type="text/css" href="../css/modify.css">

	<!-- 자바스크립트 -->
	<script type="text/javascript">
		//중복 아이디 체크 함수
		function checkId(){
			//사용자가 입력한 'id'값 얻어오기
			//document.forms['member_form'].inputs['id'].value;
			var id=document.member_form.id.value;
			//DB에서 같은 id가 있는지 확인하고 그 결과를 보여주는 새 윈도우를 띄우기.
			open("./checkId.php?id="+id, "아이디체크","width=300, height=100, left=200, top=100");
		}

		//중복 닉네임 체크 함수
		function checkNick(){
			//사용자가 입력한 'nick'값 얻어오기
			//document.forms['member_form'].inputs['nick'].value;
			var nick=document.member_form.nick.value;
			//DB에서 같은 id가 있는지 확인하고 그 결과를 보여주는 새 윈도우를 띄우기.
			open("./checkNick.php?nick="+nick, "닉네임체크","width=300, height=100, left=200, top=100");
		}

		//submit 이미지 버튼
		function joinSubmit(){
			//form요소에게 JS로 직접 submit을 코드로 실행!
			//document.member_form.submit();//강제 submit

			//필수 input 요소들에 값들이 모두 들어갔는지 검사.
			//required 속성은 JS에서 코드로 submit() 하면 동작하지 않음.

			//아이디 칸이 비어있는가?
			if(!document.member_form.id.value){
				alert("아이디를 입력 하세요");
				//아이디 input 요소로 포커스 이동
				document.member_form.id.focus();

				//submit()되지 않도록 여기서 함수 종료
				return;
			}

			//패스워드 칸이 비어있는가?
			if(!document.member_form.pass_current.value){
				alert("현재 비밀번호를 입력하세요");
				document.member_form.pass_current.focus();
				return;
			}

			//패스워드 변경칸에는 값이 있는데 패스워드 확인 칸이 비어있는가?
			if(document.member_form.pass.value&&!document.member_form.pass_confirm.value){
				alert("패스워드 확인 칸을 입력하세요");
				document.member_form.pass_confirm.focus();
				return;
			}

			if(!document.member_form.pass.value&&document.member_form.pass_confirm.value){
				alert("패스워드 변경 칸을 입력하세요");
				document.member_form.pass.focus();
				return;
			}

			//이름 칸이 비어있는가?
			if(!document.member_form.name.value){
				alert("이름을 입력하세요");
				document.member_form.name.focus();
				return;
			}

			//닉네임 칸이 비어있는가?
			if(!document.member_form.nick.value){
				alert("닉네임을 입력하세요");
				document.member_form.nick.focus();
				return;
			}

			//휴대폰 칸이 비어있는가?
			if(!document.member_form.hp2.value||!document.member_form.hp3.value){
				alert("핸드폰 번호를 입력하세요");
				document.member_form.h1.focus();
				return;
			}

			//패스워드와 패스워드 확인칸이 같지 않은가?
			if(document.member_form.pass.value != document.member_form.pass_confirm.value){
				alert("비밀번호변경칸을 확인하세요");
				document.member_form.pass_confirm.focus();

				//input 요소칸 안에 글씨들을 전체 선택
				document.member_form.pass_confirm.select();
				return;
			}

			//form요소에 submit요청 (action 속성값 : modify.php 실행)
			document.member_form.submit();








		}

		//reset 이미지 버튼클릭
		function joinReset(){
			document.member_form.pass_current.value="";
			document.member_form.pass.value="";
			document.member_form.pass_confirm.value="";
			document.member_form.name.value="";
			document.member_form.nick.value="";
			document.member_form.hp1.value="010";
			document.member_form.hp2.value="";
			document.member_form.hp3.value="";
			document.member_form.email1.value="";
			document.member_form.email2.value="";

			document.member_form.pass.focus();

		}
	</script>
</head>

<!-- HTML요소들에 미리 값이 입력되어 있도록 -->
<!-- DB에서 회원정보를 모두 읽어오기. -->
<?php
	//DB접속
	require "../lib/dbconn.php";

	//로그인 되어있는 '아이디'(세션에 저장되어 있는 $userid)의 회원정보를 member테이블에서 읽어오는 쿼리문.
	$sql="SELECT * FROM member where id='$userid'";
	$result=mysqli_query($conn, $sql);
	//찾아온 결과 레코드(row) 받아오기
	$row=mysqli_fetch_array($result);

	//아이디($userid), 닉네임($usernick), 레벨($userlevel)은 이미 세션에 있다.
	//나머지 비번, 휴대폰, 이메일, 이름
	$pass=$row[pass];
	$name=$row[name];
	$hp=$row[hp];
	$email=$row[email];

	//휴대폰 번호는 자리마다 '-' 문자로 나누어 input요소에 대입
	$hps=explode("-",$hp);
	//$hps는 배열임.

	//이메일도 두칸으로 나누어야 함.
	$emails=explode("@",$email);
	mysqli_close($conn);
?>

<body>
	<div id="wrap">
		
		<header id="header">
			<?include("../lib/top_login2.php");?>
		</header>

		<nav id="menu">
			<?include("../lib/top_menu2.php");?>
		</nav>

		<div id="content">
			<!-- 왼쪽 사이드 nav 메뉴영역 : 다른 menu화면들에서도 공통으로 사용되므로.. lib폴더에 만들고 include -->
			<aside id="col1">
				<div id="left_menu">
					<?include("../lib/left_menu.php");?>
				</div>
			</aside>

			<!-- 나머지 콘텐츠 영역 : 회원가입 폼 -->
			<section id="col2">
				<!-- member테이블을 수정하는 서버 측 modify.php로 제출할 form태그 -->
				<form action="modify.php" method="post" name="member_form">
					<!-- title영역 : border와 스타일-->
					<div id="title">
						<img src="../img/title_member_modify.gif">
					</div>

					<!-- title아래에 있는 input들 -->
					<div id="form_join">
						<!-- 라벨들 영역 -->
						<div id="join_labels">
							<ul>
								<li><span class="red_star">*</span> 아이디</li>
								<li><span class="red_star">*</span> 현재 비밀번호</li>
								<li><span class="red_star">&nbsp;</span> 비밀번호 변경</li>
								<li><span class="red_star">&nbsp;</span> 비밀번호 확인</li>
								<li><span class="red_star">*</span> 이름</li>
								<li><span class="red_star">*</span> 닉네임</li>
								<li><span class="red_star">*</span> 휴대폰</li>
								<li>&nbsp;&nbsp;이메일</li>
							</ul>	
						</div>

						<!-- input들 영역 -->
						<div id="join_inputs">
							<ul>
								<li>
									<!-- 아이디칸은 변경불가! readonly속성 부여 -->
									<div id="id1"><input type="text" name="id" readonly value="<?=$userid?>"></div>
								</li>
								<li><input type="password" name="pass_current" required ></li>
								<li><input type="password" name="pass" required></li>
								<li><input type="password" name="pass_confirm" required></li>
								<li><input type="text" name="name" required value="<?=$name?>"></li>
								<li>
									<!-- 스타일을 위해 input, a요소를 각각 div로 나누어 작성 -->
									<div id="nick1"><input type="text" name="nick" required value="<?=$usernick?>"></div>
									<div id="nick2"><a href="#"><img src="../img/check_id.gif" onclick="checkNick()"></a></div>
								</li>
								<li>
									<!-- 휴대폰 앞 3자리 번호 종류 선택을 콤보박스 형태로 -->
									<select class="hp" name="hp1">
										<option value="010" <?if($hps[0]=='010') echo "selected";?> >010</option>
										<option value="011" <?if($hps[0]=='011') echo "selected";?> >011</option>
										<option value="017" <?if($hps[0]=='017') echo "selected";?> >017</option>
									</select>
									 - <!-- 번호 사이 - 기호 -->
									<input type="text" name="hp2" class="hp" value="<?=$hps[1];?>">
									 - 
									<input type="text" name="hp3" class="hp" value="<?=$hps[2]?>">
								</li>
								<li>
									<input type="text" name="email1" id="email1" value="<?=$emails[0]?>">
									 @ 
									<input type="text" name="email2" id="email2" value="<?=$emails[1]?>">
								</li>
							</ul>
						</div>

						<!-- 위요소들의 float영향 없애려고 -->
						<div class="clear"></div>

						<!-- 안내메세지 영역 -->
						<div id="join_must"><span class="red_star">*</span> 은 필수 입력항목입니다.</div>

						<!-- 위 -->

						<!-- join form 저장버튼, 취소버튼 -->
						<!-- input 요소의 submit, reset 이미지를 보여줄 수 없어서.. a로 대체하고 js로 submit하기.. -->
						<div id="join_button">
							<!-- 강제 submit하려면 반드시 #이 있어야 함. -->
							<a href="#"><img src="../img/button_save.gif" onclick="joinSubmit()"></a>
							<a href="#"><img src="../img/button_reset.gif" onclick="joinReset()"></a>
						</div>
						
					</div>
				</form>
			</section>
			
		</div>

	</div>
</body>
</html>