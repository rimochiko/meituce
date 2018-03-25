function checkRegister()
{
	$username = $("input[name='username']").val();
	$pattern = /^[_a-zA-Z0-9]{6,10}$/;
	if(!$pattern.test($username))
	{
		alert('账号只能包括英文字母，数字和下划线。');
		return false;
	}

	$nickname = $("input[name='nickname']").val();
	$pattern = /^[\u4E00-\u9FA5A-Za-z0-9]{1,10}$/;
	if(!$nickname)
	{
		alert('昵称不能包含特殊字符，只能包含中文、数字、英文字母');
		return false;
	}

	$password = $("input[name='password']").val();
	$pattern = /^[_a-zA-Z0-9]{6,16}$/;
	if(!$password)
	{
		alert('密码只能输入6-16个字母、数字、下划线');
		return false;
	}

	$repassword =  $("input[name='re_password']").val();	
	if($password != $repassword)
	{
		alert('密码和确认密码不一致');
		return false;
	}
}