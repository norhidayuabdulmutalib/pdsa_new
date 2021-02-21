<html>
<head>
<script language="javascript">
function postRequest(strURL){
var xmlHttp;
if(window.XMLHttpRequest){ // For Mozilla, Safari, ...
var xmlHttp = new XMLHttpRequest();
}
else if(window.ActiveXObject){ // For Internet Explorer
var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlHttp.open('POST', strURL, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlHttp.onreadystatechange = function(){
if (xmlHttp.readyState == 4){
ajaxloginupdate(xmlHttp.responseText);
}
}
xmlHttp.send(strURL);
}

function ajaxloginupdate(str){
if(str=="ok"){
alert("Hi , user");
}else{
alert("Login falied try again later");
}
}

function loginajax(){
var username = window.document.loginform.username.value;
var password = window.document.loginform.password.value;
var url = "login.php?username=" + username + "&password=" +password ;
postRequest(url);
} 
</script>
</head>

<body>
<Center>

<form name="loginform" onsubmit="return loginajax();">
<table border="0" bgcolor="#00CC66" cellspacing="1" cellpadding="3" width="300">
<tr>
<td align="left" colspan="2" width="300"><b><font size="5" color="#990000">Login Form</font></b></td>
</tr>
<tr>
<td align="right" width="90"><b><font color="#0000CC">Username:</font></b></td>
<td width="175"><input type="text" name="username" id="user" size="30" value="" /></td>
</tr>
<tr>
<td align="right" width="90"><b><font color="#0000CC">Password:</font></b></td>
<td width="175"><input type="password" name="password" size="30" value="" /></td>
</tr>
<tr>
<td colspan="2" align="center" width="275"><input type="button" name="LoginButton" value="Login" onclick="loginajax()"></td>
</tr>
</table>
</form>

</center>
</body>
</html>