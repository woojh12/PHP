<?php
	header("Content-Type:text/html;charset=utf-8");		// 한글 깨짐 방지
	
	//	signup.html에서 post방식으로 데이터 가져오기
	$user_id = $_POST['user_id'];
	$user_pass = $_POST['user_pass'];
	$user_nickname = $_POST['user_nickname'];
	$user_signupyear = date("Y");	// date()함수 : 현재시간 Y : (현재)년도, m : (현재)월, d : (현재)일
	$user_signupmonth = date("m");
	$user_signupday = date("d");
	$uid = '';
	
	// 아스키코드 변환 과정
	$change_id = $_POST['user_id'];
	//$arr_id = str_split($change_id);
	$change_pass = $_POST['user_pass'];
	//$arr_pass = str_split($change_pass);
	$change_nickname = $_POST['user_nickname'];
	//$arr_nickname = str_split($change_nickname);
	
	$change_signupyear = str_split(date('Y'));		// 한단위씩 자르고 배열 형태로 저장
	$year = implode("", $change_signupyear);		// 배열을 하나의 문자열로 바꿔줌(형변환)
	$change_signupmonth = str_split(date('m'));
	$month = implode("", $change_signupmonth );
	$change_signupday = str_split(date('d'));
	$day = implode("", $change_signupday);
	
	// uid 설정
	for($i=0;$i<strlen($change_id);$i++)	// 문자열의 개수만큼 반복
	{
		$uid = $uid.(string)ord(substr($change_id,$i,$i+1));		// 가입하고자 하는 id를 한단위씩 아스키코드로 변환후 uid 값 추가
	}
	for($i=0;$i<strlen($change_pass);$i++)
	{
		$uid = $uid.(string)ord(substr($change_pass,$i,$i+1));
	}
	for($i=0;$i<strlen($change_nickname);$i++)
	{
		$uid = $uid.(string)ord(substr($change_nickname,$i,$i+1));
	}
	for($i=0;$i<strlen($year);$i++)
	{
		$uid = $uid.(string)ord(substr($year,$i,$i+1));
	}
	for($i=0;$i<strlen($month);$i++)
	{
		$uid = $uid.(string)ord(substr($month,$i,$i+1));;
	}
	for($i=0;$i<strlen($day);$i++)
	{
		$uid = $uid.(string)ord(substr($day,$i,$i+1));
	}
	
	$conn = mysqli_connect("localhost","root","");	// mysql 로그인
	$db = mysqli_select_db($conn, 'data');	// mysql db접속
	
	if($conn)
	{
		echo "db접속성공";
	}else{
		echo "접속실패";
	}
	/*---------------한글 깨짐 방지 -------------------*/
	mysqli_query($conn, "set session character_set_connection=utf8;");
	mysqli_query($conn, "set session character_set_results=utf8;");
	mysqli_query($conn, "set session character_set_client=utf8;");
	
	
	// 아이디 중복체크 검사 
	$sql = "select *from user where User_Id='{$user_id}'";		// user테이블에서 동일한 아이디가 존재하는지 검색
	$ret = mysqli_query($conn, $sql);
	$check=mysqli_num_rows($ret);
	
	if($check>0)	// 중복 아이디 한개이상 발견시  
	{
		echo "<script> alert('already user'); </script>";	// already user 문구 출력
		echo "<script> window.history.back(); </script>";	// 이전페이지로 돌아가기
		exit();
	}
	
	
	$sql = "INSERT ignore INTO User(User_Id, User_Pwd, User_NickName, SignupYear, SignuMonth, SignupDay, uid)
	VALUES('$user_id', '$user_pass', '$user_nickname', '$user_signupyear', '$user_signupmonth', '$user_signupday', '$uid')";
	
	
	
	mysqli_query($conn, $sql);
	
	$result = mysqli_query($conn, $sql);
	
	if($result)
	{
		echo "<script>alert('회원가입 성공');</script>";
	}else
	{
		echo "<script>alert('회원가입 실패');</script>";
	}
	
	
	mysqli_close($conn);
	echo "mysql 접속종료";
?>
<meta http-equiv="refresh" contetn="0, signup.html">