<?php

include('../classes/connection.php');
session_start();
$id = $_SESSION["personnel_id"];


class User{
	
	function reset_password($password,$id){
		$sql="UPDATE personnel SET personnel_password = '$password' WHERE personnel_id=$id";
		//echo $sql;
		$get= new Database;
		$get->insert($sql);
		}
	function get_user_details($id){
		$sql = "SELECT * FROM personnel WHERE personnel_id = $id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;	
	}
	
}


$get1=new User();
$rs1=$get1->get_user_details($id);
$num_rows=mysql_num_rows($rs1);

$password1=mysql_result($rs1, 0,"personnel_password");


if ($_REQUEST['password1']){
	
	$oldpassword = md5($_POST['oldpassword']);
	
	if($password1 == $oldpassword){
		
		$password = addslashes($_POST['passconfirm']);
		$password = md5($password);
		
		$get= new User(); 
		$get->reset_password($password,$id);
	
		?>
		<script type="text/javascript">
           	window.alert("Password Updated Successfully");
			window.location.href = "http://sagana/hms/";
      	</script>
		<?php
      }
		
	else{
		?>
		<script type="text/javascript">
           	window.alert("Incorrect Old Password. Password Not Changed");
			window.location = "http://sagana/hms/";
      	</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <style>
   .btn {
  display: inline-block;
  *display: inline;
  padding: 4px 14px;
  margin-bottom: 0;
  *margin-left: .3em;
  font-size: 14px;
  line-height: 20px;
  *line-height: 20px;
  color: #333333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  cursor: pointer;
  background-color: #f5f5f5;
  *background-color: #e6e6e6;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  border: 1px solid #bbbbbb;
  *border: 0;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-bottom-color: #a2a2a2;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
  filter: progid:dximagetransform.microsoft.gradient(enabled=false);
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
     -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
          box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}

   </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link type="text/css" rel="stylesheet" href="../css/bootstrap.css" />
<script language="javascript" type="text/javascript">
        
  function checkPassword(str)
  {
    var re = /[a-zA-Z0-9]{8,}/ ;
    return re.test(str);
  }

  function checkForm(form)
  {
	  
    if(form.password.value != "" && form.password.value == form.passconfirm.value) {
      if(!checkPassword(form.password.value)) {
        alert("Error: Password must contain 8 characters of numbers and letters");
        form.password.focus();
        return false;
      }
	  else if(form.oldpassword.value == ""){
	alert("Error: Enter Old Password");
      form.oldpassword.focus();
      return false;
		  
		  }
    } else {
      alert("Error: Passwords do not match");
      form.password.focus();
      return false;
    }
    return true;
  }

</script>
</head>

<body>

	<div id="contactLogin" style="margin-top:25%;">
    <div style="color:#A8D8EB; font:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:25px; text-align:center;  background-color: #E5E5E5;
    border-bottom: 1px solid #FFFFFF;"  >Change Password </div>
      <center>
<form action="http://sagana/hms/data/change_password.php" method="POST" onSubmit="return checkForm(this);">
<table align="center" border="0">
  <tbody><tr>
    <td><div style="color:#FFF; font:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px"  >Old Password </div></td>
    <td>
  <label for="oldpassword"></label>
  <input type="password" name="oldpassword" id="oldpassword" required  autocomplete="off" >
  
  </tr>
  <tr>
    <td><div style="color:#FFF; font:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px"  >New Password</div></td>
    <td>
   <label   style="color:#FFF;" for="password"></label>
    <input type="password" name="password" required pattern='[a-zA-Z0-9]{8,}'  id="password" autocomplete="off" onChange="this.setCustomValidity(this.validity.patternMismatch ? 'Password must contain at least 8 characters, including letters and numbers' : ''); if(this.checkValidity()) form.passconfirm.pattern = this.value;">

   </td>
  </tr>
  <tr>
    <td><div style="color:#FFF; font:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px"  >Confirm Password</div></td>
    <td>
<label  style="color:#FFF;" for="passconfirm"></label>
<input type="password" required pattern='[A-Za-z0-9]{8,}' name="passconfirm" id="passconfirm" autocomplete="off"  onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');
"> 
  </tr>
  </tbody></table>
  <table align="center">
  <tbody><tr>
    <td>&nbsp;</td>
    <td><input name="password1" class='btn btn-primary' value="Change Password" type="submit"></td>
  </tr>
</tbody></table>

</form>
</center>
</div>

</body>
 		
</html>