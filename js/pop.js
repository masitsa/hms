// JavaScript Document
function popup(patient_id,balance){
	$("#overlay_form").fadeIn(1000);

  positionPopup();
   ajaxpage("http://sagana/hms/index.php/welcome/make_payment/"+patient_id+"/"+balance, "overlay_form");
  $(document).ready(function(){
//open popup
$("#pop").click(function(){
  $("#overlay_form").fadeIn(1000);
  positionPopup();
});

//close popup
$("#close").click(function(){
	$("#overlay_form").fadeOut(500);
});
});


//position the popup at the center of the page
function positionPopup(){
if(!$("#overlay_form").is(':visible')){
	  return;
  } 
  $("#overlay_form").css({
      left: ($(window).width() - $('#overlay_form').width()) / 2,
      top: ($(window).width() - $('#overlay_form').width()) / 7,
      position:'absolute'
 });
}

//maintain the popup at center of the page when browser resized
$(window).bind('resize',positionPopup);


/***********************************************
* Dynamic Ajax Content- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function ajaxpage(url, containerid){
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
page_request.onreadystatechange=function(){
loadpage(page_request, containerid)
}
page_request.open('GET', url, true)
page_request.send(null)
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText
}
}


function toggleField(field1) {
 myTarget = document.getElementById(field1);

if(myTarget.style.display == 'none'){
  myTarget.style.display = 'block';
document.tender.myTF.focus()
    } }
	
	function doMath(tax,myTF,balance) {
	
	var totalparts = document.getElementById('myTF').value;
		//alert(totalparts);
 var change =totalparts - (-balance);
	   
	if (change<0){
document.getElementById('tax').value = change;
document.getElementById('tax').className = 'design11';  
	}
	else{
document.getElementById('tax').value = change;
document.getElementById('tax').className = 'design13';
		}
	   }
	   
	   	   	function whichButton(event)
{
var keycode=event.keyCode;
//alert(keycode);
 if(keycode==27){
$("#overlay_form").fadeOut(1000);
	}}
