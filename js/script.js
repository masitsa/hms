// JavaScript Document
//var host = "http://192.168.178.118/hms/";
//var host = "http://sagana/hms/";
var host = 'http://localhost/sumc/';


function checkup_interface(visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/nurse/medical_checkup_interface.php?visit_id="+visit_id;
			
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("medical_checkup");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
				
				var count;
				for(count = 1; count < 12; count++){
					load_vitals(count, visit_id);
				}
			patient_details(visit_id);
			get_physiological_history(visit_id);
				
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function checkup_interface1(visit_id){

			patient_details(visit_id);
			plan1(visit_id);							

}



function calculate_bmi(vitals_id, visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/calculate_bmi.php?vitals_id="+vitals_id+"&visit_id="+visit_id;//window.alert(url);

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("bmi_out");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function calculate_hwr(vitals_id, visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/calculate_hwr.php?vitals_id="+vitals_id+"&visit_id="+visit_id;//window.alert(url);

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("hwr_out");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function previous_vitals(visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/previous_vitals.php?visit_id="+visit_id;//window.alert(url);

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("previous_vitals");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function get_family_history(visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/family_history.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("history");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function save_condition1(cond, family, patient_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var condition = document.getElementById("checkbox"+cond+family);
	var url = host+"data/nurse/";
		
		url = url + "save_family.php?disease_id="+cond+"&family_id="+family+"&patient_id="+patient_id;

	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				get_family_history(visit_id);
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}
function delete_condition(cond, family, patient_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var condition = document.getElementById("checkbox"+cond+family);
	var url = host+"data/nurse/";
		
		url = url + "delete_family.php?disease_id="+cond+"&family_id="+family+"&patient_id="+patient_id;


	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				get_family_history(visit_id);
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}

	




function procedures(id, v_id, suck){
	/*alert(id);
	alert(v_id);
	alert(suck);*/
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/procedure.php?procedure_id="+id+"&visit_id="+v_id+"&suck="+suck;
	
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				window.close(this);
				window.opener.document.getElementById("procedures").innerHTML=XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function calculatetotal(amount, id, procedure_id, v_id){
		
	var units = document.getElementById('units'+id).value;	

	grand_total(id, units, amount);
	display_procedure(v_id);
}

function grand_total(procedure_id, units, amount){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(procedure_id);
	var url = host+"data/nurse/procedure_total.php?procedure_id="+procedure_id+"&units="+units+"&amount="+amount;
	
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function delete_procedure(id, visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/nurse/delete_procedure.php?procedure_id="+id;
	
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				display_procedure(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function do_a_search(){
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var variable = document.getElementById("item_name").value;
	var url =  host+"data/nurse/procedures.php?search="+variable;
//	window.alert(url);
	window.location.href =url;
}

function get_medication(visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/load_medication.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("medication");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}









function delete_vaccine(vaccine_id, visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/nurse/delete_vaccine.php?id="+vaccine_id;
	
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				get_vaccines(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}





function patient_details(visit_id){
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/nurse_data.php?visit_id="+visit_id;alert(url);
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("patient_details");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function hold_visit(visit_id){
	
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/hold_visit.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
	XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				patient_details(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function unhold_visit(visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/unhold_visit.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
	XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				patient_details(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function symptoms(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	var url = host+"data/doctor/view_symptoms.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("symptoms");
			
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
				
				patient_details(visit_id);
				objective_findings(visit_id);
				assessment(visit_id);
				plan(visit_id);
				doctor_notes(visit_id);
				nurse_notes(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function symptoms2(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	var url = host+"data/doctor/view_symptoms.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = window.opener.document.getElementById("symptoms");
			
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function symptoms3(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	var url = host+"data/doctor/view_symptoms.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("symptoms");
			
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function symptoms4(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	var url = host+"data/doctor/view_symptoms.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = window.opener.document.getElementById("symptoms");
			
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}



 

function close_search(visit_id){
	window.location.href="laboratory.php?visit_id="+visit_id;
}

function close_symptoms(visit_id){
	window.close(this);
}







function toggleFieldX(myTFx,preg) {
var myTarget = document.getElementById(myTFx);
var pregnant = document.getElementById(preg).value;
//alert(pregnant);
if((myTarget.style.display == 'none')&&(pregnant=='YES')){
  myTarget.style.display = 'block';
    } 
else {
  myTarget.style.display = 'none';
  myTarget.value = '';
}}
function toggleFieldh(myTFh,illness) {
var myTarget = document.getElementById(myTFh);
var illness = document.getElementById(illness).value;
//alert(illness);
if((myTarget.style.display == 'none')&&(illness=='YES')){
  myTarget.style.display = 'block';
    } 
else {
  myTarget.style.display = 'none';
  myTarget.value = '';
}}
function objective_findings1(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/view_objective_findings.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj =window.opener.document.getElementById("objective_findings");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//obj.innerHTML = XMLHttpRequestObject.responseText;
				
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function update_visit_obj(objective_findings_id,visit_id,update_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var id= "myTF".concat(objective_findings_id);
	var description = document.getElementById(id).value;

	var url = host+"data/doctor/add_objective_findings.php?id="+description+"&objective_findings_id="+objective_findings_id+"&visit_id="+visit_id+"&update_id="+update_id;
		if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
			//	window.alert(objective_findings1(visit_id));
				symptoms(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}


function delete_symptom(visit_symptom_id, visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/doctor/delete_symptom.php?visit_symptoms_id="+visit_symptom_id;
	
	if(XMLHttpRequestObject) {
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				symptoms(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}



function objective_findings(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/view_objective_findings.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("objective_findings");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}






function delete_objective_findings(visit_objective_findings_id, visit_id){
	
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/doctor/delete_objective_findings.php?visit_objective_findings_id="+visit_objective_findings_id;
		if(XMLHttpRequestObject) {
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				objective_findings(visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}



function assessment(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/view_assessment.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("assessment");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}


function plan(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/view_plan.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("plan");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
				get_test_results(100, visit_id);
				closeit(79, visit_id);
				display_prescription(visit_id, 2);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function plan1(visit_id){
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/view_plan1.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("plan");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
				get_test_results(100, visit_id);
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}


function search_lab_test(visit_id){

	var search_item = document.getElementById("search_item").value;

	var url = host+"data/doctor/laboratory.php?search="+search_item+"&visit_id="+visit_id;

	window.location.href = url;
}



function send_to_lab(visit_id){
	get_test_results(65, visit_id);
}



function get_test_results(page, visit_id){

	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if((page == 1) || (page == 65) || (page == 85)){
		url = host+"data/lab/test.php?visit_id="+visit_id;
	}
	
	else if ((page == 75) || (page == 100)){
		url = host+"data/lab/test1.php?visit_id="+visit_id;
	}
	
	if(XMLHttpRequestObject) {
		if((page == 75) || (page == 85)){
			var obj = window.opener.document.getElementById("test_results");
		}
		else{
			var obj = document.getElementById("test_results");
		}
		XMLHttpRequestObject.open("GET", url);
		
		XMLHttpRequestObject.onreadystatechange = function(){
		
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
	//window.alert(XMLHttpRequestObject.responseText);
				obj.innerHTML = XMLHttpRequestObject.responseText;
				if((page == 75) || (page == 85)){
					window.close(this);
				}
				
			}
		}
		XMLHttpRequestObject.send(null);
	}
}

function delete_cost(id, visit_id){
	
	var XMLHttpRequestObject = false;
	
	if (window.XMLHttpRequest) {
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
	
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/lab/delete_cost.php?visit_charge_id="+id+"&visit_id="+visit_id;
	//window.alert(url);
	
	if(XMLHttpRequestObject) {
		var obj = document.getElementById("lab_table");
		
		XMLHttpRequestObject.open("GET", url);
		
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				obj.innerHTML = XMLHttpRequestObject.responseText;
				window.location.href = host+"data/doctor/laboratory.php?visit_id="+visit_id;
			}
		}
		XMLHttpRequestObject.send(null);
	}
}

function print_previous_test2(visit_id, patient_id){
	
	var url = host+"data/lab/print_test.php?visit_id="+visit_id+"&patient_id="+patient_id;
	
    window.open(url, "Popup", "height=1200, width=600, ,scrollbars=yes, "+ "directories=yes,location=yes,menubar=yes," + "resizable=no status=no,history=no top = 50 left = 100");
}





function closeit(page, visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/doctor/diagnose.php?visit_id="+visit_id;
			
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				if(page == 1){
					window.opener.document.getElementById("diagnosis").innerHTML = XMLHttpRequestObject.responseText;
					window.close(this);
				}
				
				else{
					document.getElementById("diagnosis").innerHTML = XMLHttpRequestObject.responseText;
				}
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}
function delete_diagnosis(id, visit_id){
	
	var XMLHttpRequestObject = false;
	
	if (window.XMLHttpRequest) {
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
	
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/delete_diagnosis.php?diagnosis_id="+id;
	
	if(XMLHttpRequestObject) {
		
		XMLHttpRequestObject.open("GET", url);
		
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				
				get_disease(visit_id);
			}
		}
		XMLHttpRequestObject.send(null);
	}
}


			


function search_drugs(visit_id){
	var variable = document.getElementById("item_name").value;
	var url =  host+"data/doctor/drugs.php?search="+variable+"&visit_id="+visit_id;
	
	window.location.href =url;
}


function send_to_pharmacy21(visit_id){
 
	window.location.href="http://sagana/hms/index.php/pharmacy/send_to_accounts/"+visit_id;
}

function send_to_pharmacy(visit_id, page){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/pharmacy/send_to_pharmacy.php?visit_id="+visit_id+"&page="+page;//window.alert(url);
			
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				display_prescription(visit_id, 1);
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}

function display_prescription(visit_id, page){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/pharmacy/display_prescription.php?v_id="+visit_id;
	
	if(page == 1){
		var obj = window.opener.document.getElementById("prescription");
	}
	
	else{
		var obj = document.getElementById("prescription");
	}
			
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
				
				if(page == 1){
					window.close(this);
				}
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}

function test(page, visit_id){
	
	patient_details(visit_id);
	get_test_results(1, visit_id);
	test_comments(visit_id);
}

function save_result_format(id, format, visit_id){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var res = document.getElementById("laboratory_result2"+format).value;
		var resg =encodeURIComponent(res);
	var uri ="save_result_lab.php?id="+id+"&result="+resg+"&format="+format+"&visit_id="+visit_id;
	

	var url= host+"data/lab/"+uri;
	//alert(url);
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("result_space"+format);
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}


function save_comment(visit_charge_id){

	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var comment = document.getElementById("test_comment").value;
	var url = host+"data/lab/save_comment.php?comment="+comment+"&visit_charge_id="+visit_charge_id;
			
	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("patient_plan");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function print_previous_test(visit_id, patient_id){

    window.open(host+"data/lab/print_test.php?visit_id="+visit_id+"&patient_id="+patient_id,"Popup","height=900,width=1200,,scrollbars=yes,"+
                        "directories=yes,location=yes,menubar=yes," +
                         "resizable=no status=no,history=no top = 50 left = 100");
}



function get_previous_tests(page){
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = host+"data/lab/previous_tests.php?id="+page;
	
	var obj = document.getElementById("previous_test_results");
			
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}

function get_personnel_departments(personnel_id){//window.alert("here");
	
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = host+"data/personnel/get_personnel_departments.php?id="+personnel_id;//window.alert(url);

	var obj = document.getElementById("departments");
			
	if(XMLHttpRequestObject) {
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		
		XMLHttpRequestObject.send(null);
	}
}

function search_symptoms(visit_id){

	var search_item = document.getElementById("search_item").value;

	var url = host+"data/doctor/symptoms_list.php?search="+search_item+"&visit_id="+visit_id;//window.alert(url);

	window.location.href = url;
}

function close_symptoms_search(visit_id){

	var url = host+"data/doctor/symptoms_list.php?visit_id="+visit_id;

	window.location.href = url;
}

function do_a_search_diseases(visit_id){

	var search_item = document.getElementById("search_item").value;

	var url = host+"data/doctor/disease.php?search="+search_item+"&visit_id="+visit_id;

	window.location.href = url;
}




function set_service_charge_id(id){
	document.getElementById("service_charge_id").value = id;
}


function get_medical_checkup(visit_id){
	//window.alert("here");
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/medical_checkup.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("medical_checkup");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function get_physiological_history(visit_id){
	//window.alert("here");
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/physiological_history.php?visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("physiological_history");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function insurance_company(patient_type,insured){

	var myTarget = document.getElementById("patient_type").value;

	var myTarget2 = document.getElementById("insured");
	if((myTarget=="Insurance")||(myTarget==4))
	{
	//alert(myTarget );
	 myTarget2.style.display = 'block';
	 }
else{
  myTarget2.style.display = 'none';	
	}

}

function medical_exam(cat_items_id,format_id,visit_id){
	

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/save_medical_exam.php?cat_items_id="+cat_items_id+"&format_id="+format_id+"&visit_id="+visit_id;
		//alert(url);
	
	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("insurance_company");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function del_medical_exam(cat_items_id,format_id,visit_id){
	

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/nurse/delete_medical_exam.php?cat_items_id="+cat_items_id+"&format_id="+format_id+"&visit_id="+visit_id;
		//alert(url);
	
	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("insurance_company");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function save_illness(mec_id,visit_id){
	//alert(mec_id);

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var str1 = "gg";
var mec_id;
var n = str1.concat(mec_id); 
//alert(n);
	var illness = document.getElementById(n).value;
	//alert(illness);
	var url = host+"data/nurse/save_illness.php?mec_id="+mec_id+"&illness="+illness+"&visit_id="+visit_id;
	//alert(url);	
	
	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("insurance_company");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function save_no(mec_id,visit_id){
	//alert(mec_id);

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var str1 = "ggg";
var mec_id;
var n = str1.concat(mec_id); 
//alert(n);
	var illness = document.getElementById(n).value;
	//alert(illness);
	var url = host+"data/nurse/save_illness.php?mec_id="+mec_id+"&illness="+illness+"&visit_id="+visit_id;
	//alert(url);	
	
	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("insurance_company");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
function prescript(visit_id){
	

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url = host+"data/doctor/prescript.php?visit_id="+visit_id;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("prescription");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function delete_pres(visit_id,prescription_id,visit_charge_id){
	

	
	var url = "192.168.172.39/hms/data/doctor/delete_prescritpion.php?visit_id="+visit_id+"&prescription_id="+prescription_id+"&visit_charge_id="+visit_charge_id;
	window.location= url;
}

function save_lab_comment(id, visit_id){
	
	//alert(id);
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var res = document.getElementById("laboratory_comment"+id).value;
	var url = host+"data/lab/save_lab_comment.php?id="+id+"&result="+res+"&visit_id="+visit_id;
	
	//window.location.href=url;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("result_space"+id);
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}


function check_patient(type,id,strath_no){
 //alert(type);	 alert(id);  alert(strath_no);
 
 	//alert(id);
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//var res = document.getElementById("laboratory_comment"+id).value;
	var url = host+"data/check_patient.php?id="+id+"&type="+type+"&strath_no="+strath_no;
	
	window.location.href=url;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("result_space"+id);
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function save_dental_procedure(visit_id,procedure_id){
	
id=document.getElementById(procedure_id).value;
//alert(id);
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//var res = document.getElementById("laboratory_comment"+id).value;
	var url = host+"data/dental/dental.php?visit_id="+visit_id+"&procedure_id="+id;
	
	window.location.href="http://sagana/hms/index.php/doctor/dental_interface/"+visit_id;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("result_space"+id);
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function save_dentalstuff(visit_id,additional,id){
	//alert(id);
	var oral_exam=document.getElementById("additional1").value;
	var tongue=document.getElementById("additional2").value;
	var palate=document.getElementById("additional3").value;
	var gingivae=document.getElementById("additional4").value;
	var teeth=document.getElementById("additional5").value;
	//var other_finding=document.getElementById("additional6").value;
	var xray_exam=document.getElementById("additional7").value;	
	//var radio_graphy=document.getElementById("additional8").value;	
	var aesthetic_observation=document.getElementById("additional9").value;//alert(xray_exam);
	var diagnosis=document.getElementById("additional10").value;
		
 var radioButtons = document.getElementsByName("oral");
    for (var x = 0; x < radioButtons.length; x ++) {
      if (radioButtons[x].checked) {
     //  alert("You checked " + radioButtons[x].id);
       //alert("Value is " + radioButtons[x].value);
	   var oral=radioButtons[x].value;
	  //alert(oral);
     }
     }
 var calculusx = document.getElementsByName("calculus");
    for (var x = 0; x < radioButtons.length; x ++) {
      if (calculusx[x].checked) {
     //  alert("You checked " + radioButtons[x].id);
       //alert("Value is " + radioButtons[x].value);
	   var calculus=calculusx[x].value;
	 
     }
     }
	 
	if(id==1){
		var oral_exam=document.getElementById(additional).value;
	}
	else if(id==2){
		var tongue=document.getElementById(additional).value;	
	}
	
	else if(id==3){
		var palate=document.getElementById(additional).value;
	}
	else if(id==4){
		var gingivae=document.getElementById(additional).value;
	}
	else if(id==5){
		var teeth=document.getElementById(additional).value;
	}
	else if(id==6){
		var other_finding=document.getElementById(additional).value;
	}
	else if(id==7){
				var xray_exam=document.getElementById(additional).value;
	}
	else if(id==8){
				var radio_graphy=document.getElementById(additional).value;
	}
	else if(id==9){
				var aesthetic_observation=document.getElementById(additional).value;
	}
	else if(id==10){
				var diagnosis=document.getElementById(additional).value;
			//	alert(diagnosis);
	}
	else if(id==11){
			 var radioButtons = document.getElementsByName("oral");
    for (var x = 0; x < radioButtons.length; x ++) {
      if (radioButtons[x].checked) {
     //  alert("You checked " + radioButtons[x].id);
       //alert("Value is " + radioButtons[x].value);
	   var oral=radioButtons[x].value;
	 
     } 
     }
	}
	else if(id==12){
	 var calculusx = document.getElementsByName("calculus");
    for (var x = 0; x < radioButtons.length; x ++) {
      if (calculusx[x].checked) {
     //  alert("You checked " + radioButtons[x].id);
       //alert("Value is " + radioButtons[x].value);
	   var calculus=calculusx[x].value;
	 
     }  
     }
	}
	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//var res = document.getElementById("laboratory_comment"+id).value;
	var url = host+"data/dental/dental_interface.php?visit_id="+visit_id+"&id="+id+"diagnosis="+diagnosis+"&radio_graphy="+radio_graphy+"&aesthetic_observation="+aesthetic_observation+"&xray_exam="+xray_exam+"&oral_exam="+oral_exam+"&tongue="+tongue+"&palate="+palate+"&gingivae="+gingivae+"&teeth="+teeth+"&other_finding="+other_finding+"&diagnosis="+diagnosis+"&calculus="+calculus+"&oral="+oral;
	//alert(url);
//	window.location.href=url;
//alert(calculus);
//alert(oral);

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("result_space"+id);
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
	
	
	}
function check_date(){
	var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = yyyy+'-'+mm+'-'+dd;

	}
function dispense(id,visit_id,date4,datepicker3,quantity,units_given){
	
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var date4=document.getElementById(date4).value;
var datepicker3=document.getElementById(datepicker3).value;
var quantity=document.getElementById(quantity).value;
var units_given=document.getElementById(units_given).value;

if(units_given){
	
var urlpp = host+"data/doctor/save_prescript.php?id="+id+"&date4="+date4+"&datepicker3="+datepicker3+"&quantity="+quantity+"&units_given="+units_given;

	window.location.href=urlpp;
}else{
	alert('Fill in the Quantity given to patient');
	}


	if(XMLHttpRequestObject) {
		
		//var obj = document.getElementById("result_space"+id);
				
		XMLHttpRequestObject.open("POST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				//get_test_results(1, visit_id);
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
	
	}
	
	function check_selection(patient_type,insured){

var myTarget = document.getElementById(patient_type).value;
//alert(myTarget);
var myTarget2 = document.getElementById(insured);
if(myTarget==4)
{
	//alert(myTarget );
	 myTarget2.style.display = 'block';
	 }
else{
  myTarget2.style.display = 'none';	
	}

}
