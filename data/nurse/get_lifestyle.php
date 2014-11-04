<?php
session_start();

include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get = new nurse;
$rs = $get->patient_history($patient_id);
$num_rows = mysql_num_rows($rs);

if($num_rows >0){
$lifestyle_exercise = mysql_result($rs, 0, "lifestyle_exercise"); 
$lifestyle_sleep = mysql_result($rs, 0, "lifestyle_sleep"); 
$lifestyle_coffee = mysql_result($rs, 0, "lifestyle_coffee"); 
$lifestyle_diet = mysql_result($rs, 0, "lifestyle_diet"); 
$lifestyle_smokes = mysql_result($rs, 0, "lifestyle_smokes"); 
$lifestyle_passive_smoker = mysql_result($rs, 0, "lifestyle_passive_smoker"); 
$lifestyle_alcohol = mysql_result($rs, 0, "lifestyle_alcohol"); 
$lifestyle_exsmoker_start = mysql_result($rs, 0, "lifestyle_exsmoker_start"); 
$lifestyle_exsmoker_quit = mysql_result($rs, 0, "lifestyle_exsmoker_quit"); 
$lifestyle_drugs = mysql_result($rs, 0, "lifestyle_drugs"); 
$lifestyle_exaddict_start = mysql_result($rs, 0, "lifestyle_exaddict_start"); 
$lifestyle_exaddict_quit = mysql_result($rs, 0, "lifestyle_exaddict_quit"); 
$lifestyle_diseasegene = mysql_result($rs, 0, "lifestyle_diseasegene"); 
$lifestyle_allergies = mysql_result($rs, 0, "lifestyle_allergies"); 
$lifestyle_education = mysql_result($rs, 0, "lifestyle_education");
$lifestyle_housing = mysql_result($rs, 0, "lifestyle_housing");
$lifestyle_singleparent = mysql_result($rs, 0, "lifestyle_singleparent"); 
$lifestyle_working_children = mysql_result($rs, 0, "lifestyle_working_children"); 
$lifestyle_sexual_abuse = mysql_result($rs, 0, "lifestyle_sexual_abuse"); 
$lifestyle_domestic_violence = mysql_result($rs, 0, "lifestyle_domestic_violence"); 
$lifestyle_beeninprison = mysql_result($rs, 0, "lifestyle_beeninprison"); 
$lifestyle_teenagepregnancy = mysql_result($rs, 0, "lifestyle_teenagepregnancy"); 
$lifestyle_drug_addict = mysql_result($rs, 0, "lifestyle_drug_addict"); 
$lifestyle_school_withdrawal = mysql_result($rs, 0, "lifestyle_school_withdrawal"); 
$lifestyle_relative_in_prison = mysql_result($rs, 0, "lifestyle_relative_in_prison"); 
$lifestyle_alcoholic = mysql_result($rs, 0, "lifestyle_alcoholic"); 
$lifestyle_beer = mysql_result($rs, 0, "lifestyle_beer"); 
$lifestyle_wine = mysql_result($rs, 0, "lifestyle_wine"); 
$lifestyle_meals = mysql_result($rs, 0, "lifestyle_meals"); 
$beer_quantity = mysql_result($rs, 0, "beer_quantity"); 
$wine_quantity = mysql_result($rs, 0, "wine_quantity"); 
$drug_type = mysql_result($rs, 0, "drug_type");
}
	echo "
		<div class='patients_history_head_inner'><strong>Genetics</strong></div>
                 	<table align='center'>
                    	<tr>
                    		<td><strong>Disease Gene: </strong>".$lifestyle_diseasegene."</td>
                        </tr>
                 	</table>
                 
           		<div class='patients_history_head_inner'><strong>Social Economics</strong></div>
                <table align='center'>
                <tr>
                	<td>
                	<div class='patients_history_head_inner2'><strong>Education & Housing</strong></div>
           			<table align='center'>
              			<tr>
               		 	 <th scope='col'></th>
                      	<th scope='col'> <div align='left'></div></th>
               			</tr>
               			<tr>
               		  		<td><strong>Education: </strong>".$lifestyle_education."</td>
                     	</tr>
                     	<tr>
                     		<td><strong>Housing Conditions: </strong>".$lifestyle_housing."</td>
         				</tr>  		  
               		</table>
                </td>
                <td>
                	<div class='patients_history_head_inner2'><strong>Family</strong></div>
            		<table align='center'>
			 			<tr>
        					<td>".$lifestyle_singleparent."</td>
        					<td>".$lifestyle_teenagepregnancy."</td>
       						<td>".$lifestyle_working_children."</td>
       			 			<td>".$lifestyle_drug_addict."</td>
       						<td>".$lifestyle_sexual_abuse."</strong></td>
     			 		</tr>
     			 		<tr>
       			 			<td>".$lifestyle_school_withdrawal."</td>
       			 			<td>".$lifestyle_domestic_violence."</td>
       			 			<td><input type='checkbox' name='isinprison' value='Is in Prison'></td>
       			 			<td>".$lifestyle_beeninprison."</td>
       			 			<td>".$lifestyle_relative_in_prison."</td>
     			 		</tr>
               	 	</table>
                 </td>
                </tr>
               </table>
               <table align='center'>
               	<tr>
                	<td>
                		<div class='patients_history_head_inner2'><strong>Excercise & Sleep</strong></div>
                 			<table align='center'>
                     			<tr>
       				 				<th>".$lifestyle_exercise."</th>
       						</tr>
      						<tr>
                    			<td>".$lifestyle_sleep."</td>
                    		</tr>
                   		</table>
                      </td>
                      <td>
                			<div class='patients_history_head_inner2'><strong>Meals & Diet</strong></div>
                				<table align='center'>
                    				<tr>
                        				<td>".$lifestyle_meals."</td>
                    				</tr>
                    				<tr>
                        				<td><strong>Cups of Coffee per day:</strong></td>
                     				</tr>
                     				<tr>
                        				<td>".$lifestyle_coffee."</td>
                     			</tr>
                   			</table>
                         </td>
                         <td>
                			<div class='patients_history_head_inner2'><strong>Diet</strong></div>
                				<table align='center'>
                     				<tr>
                        				<td>".$lifestyle_diet."</td>
                        			</tr>
            					</table>
                            </td>
                         </tr>
                      </table>
            <div class='patients_history_head_inner'><strong>Addictions</strong></div>
            <table align='center'>
            	<tr>
                	<td>
            	<div class='patients_history_head_inner2'><strong>Smoking</strong></div>
                 <table align='center'>
                      <tr>
                        <td>Smokes ".$lifestyle_smokes." cigarretes per day</td>
                      </tr>
                      <tr>
                        <td>Ex-Smoker:</strong></td>
                        <td><strong>Start age: ".$lifestyle_exsmoker_start."</td>
                        <td><strong>Quit age: ".$lifestyle_exsmoker_quit."</td>
                      </tr>
                   </table>
                   </td>
                   <td>
            	<div class='patients_history_head_inner2'><strong>Alcohol</strong></div>
               		<table align='center'>
                      <tr>
                        <td>".$lifestyle_alcohol."</td>
                        <td>".$lifestyle_alcoholic."</td>
                      </tr>
                      <tr>
                        <td>".$lifestyle_beer."</td>"; if(!empty($lifestyle_beer)){echo "<td>".$beer_quantity."</td>";}
                        
						echo "
                      </tr>
                      <tr>
                        <td>".$lifestyle_wine."</td>"; if(!empty($lifestyle_wine)){echo "<td>".$wine_quantity."</td>";}
                        
						echo "
                      </tr>
                   </table>
                   </td>
                   <td>
            	<div class='patients_history_head_inner2'><strong>Drugs</strong></div>
                	<table align='center'>
                      <tr>
                        <td>".$lifestyle_drugs."</td>"; if(!empty($lifestyle_drugs)){echo "<td>".$drug_type."</td>";}
                        
						echo "
                      </tr>
                      <tr>
					  ";
					  if(!empty($lifestyle_exaddict_start)){
						  echo"
                        <td>Ex-Addict: </td>
                        <td><strong>Start age:</strong> ".$lifestyle_exaddict_start."</td>
                        <td><strong>Quit age: </strong>".$lifestyle_exaddict_quit."</td>
						";}
						echo"
                      </tr>
               </table>
               </td>
             </tr>
           </table>";
?>