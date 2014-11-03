<?php
session_start();
include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get_vitals = new nurse();
$get_vitals_rs = $get_vitals->get_previous_vitals($patient_id);
$num_rows = mysql_num_rows($get_vitals_rs);
//echo $num_rows;


for($r = 0; $r < $num_rows; $r++){
	
	
	echo"
		<th>".$vitals_name."</th>
	";
}
echo"</tr>";

if ($num_rows >0 ){
	
	$max_col = 0;
	$row = 0;
	$column = 0;
	
	for($s = 0; $s <$num_rows; $s++){
		
		$visit_vital_value = mysql_result($get_vitals_rs, $s, "visit_vital_value");
		$vitals_name = mysql_result($get_vitals_rs, $s, "vitals_name");
		$visit_id = mysql_result($get_vitals_rs, $s, "visit_id");
		$visit_date = mysql_result($get_vitals_rs, $s, "visit_date");
		
		if($s < ($num_rows-1)){
			$next_id = mysql_result($get_vitals_rs, $s+1, "visit_id");
		}
		
		if($visit_id == $next_id){
			$date[$row] = $visit_date;
			$title[$row][$column] = $vitals_name;
			$content[$row][$column] = $visit_vital_value;
			$column++;
			
			if($max_col < $column){
				$max_col = $column;
			}
		}
		
		else{
			
			$row++;
			$column = 0;
			$title[$row][$column] = $vitals_name;
			$content[$row][$column] = $visit_vital_value;
			$column++;
			
			if($max_col < $column){
				$max_col = $column;
			}
		}
	}$row++; $max_col++;
	$bgcolor="#5BA4BB";
	$bgcolor2="#FFFFFF";
	
	echo "<table width='auto' border='0' align='center'><tr  bgcolor=".$bgcolor.">";
	for($g = 0; $g < $row; $g++){
		echo "<th>".$date[$g]."</th>";
		for ($i = 0; $i < $max_col; $i++){
			  
			  echo"<th>".$title[$g][$i]."</th>";
		  }
	  }
	echo"</tr><tr  bgcolor=".$bgcolor2.">";
	
	for($g = 0; $g < $row; $g++){
		echo "<th></th>";
		for ($i = 0; $i < $max_col; $i++){
			  
			  echo"<td>".$content[$g][$i]."</td>";
		  }
	  }
	echo"</tr></table>";
}
