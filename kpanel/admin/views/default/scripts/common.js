//user
function checkUsername(){
	var username = document.getElementById('username').value;
	var reg = /^[a-z]+[a-z0-9]{5,11}$/i;
	if(!reg.test(username)){
		alert('请输入6-12个英文和数字的组合');
		return;
	}
	$.ajax({
		type: 'post',
		url: "/?c=user&a=check&r="+Math.random(),
		data: 'username='+username,
		success: function(data){
			if(data !=1 ){
				document.getElementById('check').innerHTML = '<font color=blue>ok</fon>';
			}else{
				document.getElementById('check').innerHTML = '<font color=red>用户已存在</fon>';
			}
		}
    });
}
function checkPasswd(){
	var p1 = document.getElementById('passwd').value;
	var p2 = document.getElementById('passwd2').value;
	if(p1 == p2){
		return;
	}else{
		alert("确认密码不对");
	}
}
//userftp
function checkFtpname(){
	var ftpname = document.getElementById('ftpname').value;
	var reg = /^[a-z]+[a-z0-9]{5,11}$/i;
	if(!reg.test(ftpname)){
		alert('请输入6-12个英文和数字的组合');
		return;
	}
	$.ajax({
		type: 'post',
		url: "/?c=ftp&a=check&r="+Math.random(),
		data: 'ftpname='+ftpname,
		success: function(data){
			if(data !=1 ){
				document.getElementById('check').innerHTML = '<font color=blue>ok</fon>';
			}else{
				document.getElementById('check').innerHTML = '<font color=red>用户已存在</fon>';
			}
		}
    });
}
function checkFtpPasswd(){
	var p1 = document.getElementById('ftppasswd').value;
	var p2 = document.getElementById('ftppasswd2').value;
	if(p1 == p2){
		return;
	}else{
		alert("确认密码不对");
	}
}
//user db
function checkDbname(){
	var dbname = document.getElementById('dbname').value;
	var reg = /^[a-z]+[a-z0-9]{5,11}$/i;
	if(!reg.test(dbname)){
		alert('请输入6-12个英文和数字的组合');
		return;
	}
	$.ajax({
		type: 'post',
		url: "/?c=db&a=check&r="+Math.random(),
		data: 'dbname='+dbname,
		success: function(data){
			if(data !=1 ){
				document.getElementById('check').innerHTML = '<font color=blue>ok</fon>';
			}else{
				document.getElementById('check').innerHTML = '<font color=red>用户已存在</fon>';
			}
		}
    });
}
function checkDbPasswd(){
	var p1 = document.getElementById('dbpasswd').value;
	var p2 = document.getElementById('dbpasswd2').value;
	if(p1 == p2){
		return;
	}else{
		alert("确认密码不对");
	}
}
//host
function checkName(){
	var name = document.getElementById('name').value;
	var reg = /^[a-z]+[a-z0-9]{5,11}$/i;
	if(!reg.test(name)){
		alert('请输入6-12个英文和数字的组合');
		return;
	}
	$.ajax({
		type: 'post',
		url: "/?c=host&a=check&r="+Math.random(),
		data: 'name='+name,
		success: function(data){
			if(data !=1 ){
				document.getElementById('check').innerHTML = '<font color=blue>ok</fon>';
			}else{
				document.getElementById('check').innerHTML = '<font color=red>用户已存在</fon>';
			}
		}
    });
}
function checkForm(){
	var name = document.getElementById('name').value;
	if(!name){
		alert('请填主机名');
		return false;
	}
	var host = document.getElementById('host').value;
	if(!host){
		alert('请填主机域名');
		return false;
	}
	var doc_root = document.getElementById('doc_root').value;
	if(!doc_root){
		alert('请填主机目录');
		return false;
	}
	return true;
}