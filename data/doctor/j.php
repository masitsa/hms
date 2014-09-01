
<!-- Written by Adam Khoury @ www.developphp.com -->
<html>
<head>
<script type="text/javascript" language="javascript">
function toggleField(field) {
var myTarget = document.getElementById(field);
if(myTarget.style.display == 'none'){
  myTarget.style.display = 'block';
    } else {
  myTarget.style.display = 'none';
  myTarget.value = '';
}
}
</script>
</head>
<body>
<input type="checkbox" onClick="javascript:toggleField(myTF);"/>
Give optional information
<input name="myTF" id="myTF" type="text" style="display:none;" />

</body>
</html>