<?php
include ("connection.php");

class Personnel{
	
	function get_personnel_departments($personnel_id){
			$sql = "SELECT departments_name, personnel.personnel_password, departments.departments_url, personnel.personnel_id, departments.departments_image
			
			FROM personnel, personnel_department, departments
			
			WHERE personnel.personnel_id = $personnel_id AND personnel.personnel_id = personnel_department.personnel_id AND personnel_department.department_id = departments.department_id";
			
			$get = new Database;
			$rs = $get->select($sql);
			
			return $rs;
	}
}
?>