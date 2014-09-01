<?php
include "connection.php";

class Export{
	function get_invoices(){
    $sql = "SELECT visit_charge.visit_charge_id,visit_charge.visit_id ,    visit_charge.service_charge_id ,visit_charge.visit_charge_timestamp ,visit_charge.visit_charge_amount,visit.patient_id, service_charge.service_id,service_charge.service_charge_name,service.service_name FROM visit, visit_charge,service_charge,service WHERE visit_charge.service_charge_id = service_charge.service_charge_id AND visit_charge.visit_id = visit.visit_id AND service_charge.service_id = service.service_id";
   
   
    $get = new Database;
   
    $rs = $get->select($sql);
   
    $num_rows = mysql_num_rows($rs);
   
    if($num_rows > 0){
        for($r=0; $r < $num_rows; $r++){
            $invoice_id = mysql_result($rs, $r,  "visit_id"); // A unique Invoice ID which can be used to locate the Invoices from your System

            $patient_id = mysql_result($rs, $r, "patient_id"); //The Patients Unique Identity Number
            $service_id = mysql_result($rs, $r, "service_id"); //A unique ID for distinguishing the Service being invoices
            $service_charge = mysql_result($rs, $r, "visit_charge_amount"); //Amount Invoiced
            $visit_charge_time = mysql_result($rs, $r, "visit_charge_timestamp"); //Date and Time of the transaction
            $service_charge_name = mysql_result($rs, $r, "service_charge_name"); //DESCRIPTION of the Invoice Payment

       
           
            $this->save_to_invoice($invoice_id, $patient_id, $service_id, $service_charge,$visit_charge_time, $service_charge_name);
           
           
            }
       
        }
   
   return $rs;
    }
function save_to_invoice($invoice_id, $patient_id, $service_id, $service_charge,$visit_charge_time, $service_charge_name){
    $sql = "INSERT INTO invoice (visit_id, service_id, service_description, service_charge_amount,visit_charge_time,patient_id) VALUES ('$invoice_id', '$service_id', '$service_charge_name', '$service_charge','$visit_charge_time','$patient_id')";
   
    $ins = new Database;
    $ins->insert($sql);
   
   
    }
	
    
	

function get_procedure(){
        $sql= "SELECT * FROM recipt";
        $get= new Database;
        $rs=$get->select($sql);
        return  $rs;       
        }
   
   
}
?>