<?php
include_once "scripts/checkbro.php";
if (isset($_GET['bro'])){
	$bro = $_GET['bro'];
	$bro_sql = mysql_query("SELECT * FROM brothers WHERE bro='$bro' LIMIT 1");
	$bro_count = mysql_num_rows($bro_sql);
	if ($bro_count > 0) {
		while ($row = mysql_fetch_array($bro_sql)){
			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$lastname = $row['LastName'];
			$callname = $row['CallName'];
			$callnamestory = $row['CallNameStory'];
			$class = $row['Class'];
			$recruitclass = $row['RecruitClass'];
			$house = $row['House'];
			$concentration = $row['Concentration'];
			$hometown = $row['Hometown'];
			$ethnicity = $row['Ethnicity'];
			$birthday_full = $row['Birthday'];
			$leadership = $row['Leadership'];
			$email_harvard = $row['Email'];
			$email_personal = $row['Email_personal'];
			$email_work = $row['Email_work'];
			$phone_cell = $row['Phone_cell'];
			$phone_home = $row['Phone_home'];
			$phone_work = $row['Phone_work'];
			$huid = $row['HUID16'];
			$campusAdd = $row['CampusAdd'];
			$mailAdd = $row['MailingAdd'];
			$homeAdd = $row['HomeAdd'];
			$facebook = $row['Facebook'];
			$twitter = $row['Twitter'];
			$linkedin = $row['LinkedIn'];
			$currentloc = $row['CurrentLocation'];
			$address = $row['Address'];
			$occupation = $row['Occupation'];
			$companyorg = $row['CompanyOrg'];
			$position = $row['Position'];
			$hobbiesint = $row['HobbiesInterests'];
			
				if (isset($_GET['source'])){
					$source = $_GET['source'];
					if ($source == "profile") {
						$hobbies = $row['Hobbies'];
						$careergoals = $row['CareerGoals'];
						$intelint = $row['Interests'];
						$whyaab = $row['WhyAAB'];
						
						$survey = "<div class='category'>
							<span>Survey</span><br>
							<textarea name='hobbies' placeholder='Hobbies and Activities' class='edit survey'>$hobbies</textarea><br>
							<textarea name='careergoals' placeholder='Career Goals' class='edit survey'>$careergoals</textarea><br>
							<textarea name='intelint' placeholder='Intellectual Interests' class='edit survey'>$intelint</textarea><br>
							<textarea name='whyaab' placeholder='Why AAB?' class='edit survey'>$whyaab</textarea>
							</div>";
					} else {
					$survey = "";
				}
			
			$classY = substr($class, 2);
			
				/*=======  Birthday Configuration  =======*/
				if ($birthday_full != "") {
					list($bday_y,$bday_m,$bday_d) = explode("-", $birthday_full);
					$selected_year = $bday_y;
					$selected_month = $bday_m;
					$selected_day = $bday_d;
				} else {
					$selected_year = "null";
					$selected_month = "null";
					$selected_day = "null";
				}
			
				$month_name = array(1 => "January",
									2 => "February",
									3 => "March",
									4 => "April",
									5 => "May", 
									6 => "June", 
									7 => "July", 
									8 => "August", 
									9 => "September", 
									10 => "October",
									11 => "November",
									12 => "December");
				$yearRange = 40;
				$ageLimit = 18; // Selected Age
				$thisYear = date('Y');  // Generate Options
				$startYear = ($thisYear - $yearRange);
				$selectYear = ($thisYear - $ageLimit);
				
				foreach (range($thisYear, $startYear) as $year) {
					$selected = "";
					if($year == $selected_year) { $selected = " selected"; }
						$birthday_year .= '<option value='.$year.' ' . $selected . '>' . $year . '</option>';
				}
				
				foreach (range(01, 12) as $month) {
					$selected = "";
					if($month == $selected_month) { $selected = " selected"; }
						$birthday_month .= "<option value='$month'$selected>$month_name[$month]</option>";
				}
				
				foreach (range(01, 31) as $day) {
					$selected = "";
					if($day == $selected_day) { $selected = " selected"; }
						$birthday_day .= '<option value='.$day.' ' . $selected . '>' . $day . '</option>';
				}
			
			/*=======  House Affiliation  =======*/
				if ($house != "") {
					$selected_house = $house;
				} else {
					$selected_house = "null";
				}
				
				$house_name = array(1 => "Adams",
									2 => "Cabot",
									3 => "Currier",
									4 => "Dunster",
									5 => "Eliot", 
									6 => "Kirkland", 
									7 => "Leverett", 
									8 => "Lowell", 
									9 => "Mather", 
									10 => "Pforzheimer",
									11 => "Quincy",
									12 => "Winthrop");
				
				foreach (range(1,12) as $house_num) {
					$selected = "";
					if($house_name[$house_num] == $selected_house) { $selected = " selected"; }
						$house_select .= '<option value='.$house_name[$house_num].' ' . $selected . '>' . $house_name[$house_num] . '</option>';
				}
				
$birthday =	"<select name='bday_m' class='edit' style='width:130'>
    		<option value=''>Month</option>
    		$birthday_month
    	</select>
    	<select name='bday_d' class='edit' style='width:60'>
    		<option value=''>Day</option>
    		$birthday_day
    	</select>
    	<select name='bday_y' class='edit' style='width:75'>
    		<option value=''>Year</option>
    		$birthday_year
    	</select>";
			
			$profpic = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($profpic)) {
				$thumb = "<a href='directory_photo?request=form&bro=$bro&source=$source' id='thumb'><img src='$profpic' class='thumb big' id='thumbnail' title='Upload a photo!'/></a>";
			} else {
				$thumb = "<a href='directory_photo?request=form&bro=$bro&source=$source' id='thumb'><img src='$default' class='thumb big' id='thumbnail' title='Upload a photo!'/></a>";
			}
			
			$fb = "<img src='pix/icons/socialfb.png' class='social' />";
			$tw = "<img src='pix/icons/socialtw.png' class='social' />";
			$li = "<img src='pix/icons/socialli.png' class='social' />";

			
			/*=======  leadership positions 
			$position_name = array("archives" => "Director of Archives",
									   "finance" => "Director of Finance",
									   "brotherhood" => "Director of Brotherhood",
									   "edpol" => "Director of Educational/Political Awareness",
									   "service" => "Director of Service",
									   "alumni" => "Director of Alumni Relations");
				
			$add_position = "<a href='#' id='leadToggle' style='color:#ccc'>+ Add Position</a>
					<div class='leadForm hidden' style='padding:10; border:solid 1 #ccc; width:330'>
						<form id='PositionForm'>
							<input name='lead_year' id='focus' placeholder='Year' style='width:100'/>
							<select name='lead_name' class='editselect' style='width:150'>
								<option value='null'>Position</option>
								<option value='archives'>Archives</option>
								<option value='finance'>Finance</option>
								<option value='brotherhood'>Brotherhood</option>
								<option value='edpol'>EdPol Awareness</option>
								<option value='service'>Service</option>
								<option value='alumni'>Alumni Relations</option>
							</select>
							<input type='hidden' name='leader_bro' value='$bro' />
							<input type='button' class='submit' id='SavePosition' style='width:60;height:29' value='Add' onclick='return submitPosition(); return false;'/>
						</form>
					</div>";

			if ($leadership != "") {
				$all_positions = explode(",", $leadership);
				foreach ($all_positions as $each_position){
						preg_match_all('/(\d)|(\w)/', $each_position, $matches);
						$lead_year = implode($matches[1]);
						$position = implode($matches[2]);
						$position = $position_name[$position];
					
						$position_list .= "<tr><td>$lead_year</td><td>$position</td></tr>";
						$positions = "<table cellspacing='0' cellpadding='10' id='positions'>
							<thead>
								<tr bgcolor='#eee'><td>Year</td><td>Position</td></tr>
							</thead>
							<tbody>
								$position_list
							</tbody>
							</table>
							$add_position";
				}
			} else {
				$positions = "<table><tr><td><h3>This brother has not held any positions.</h3></td></tr></table>
					$add_position";
			} =======*/
		}
		
		$broster .= "<div class='lookupContent'>
		<table cellspacing='0' cellpadding='0' class='profile'><tr>
		<td width='70px' valign='top'>
		<div class='thumb'>$thumb</div>
		</td>
		
		<td>
		<div class='profile'>
		<form id='profile' method='post' action='".$source."?bro=$bro'>
		<input name='bro_profile' type='hidden' value='$bro' />
		<input name='firstname' placeholder='First' value='$firstname' class='name edit'>
		<input name='middlename' placeholder='Middle' value='$middlename' class='name edit' />
		<input name='lastname' placeholder='Last' value='$lastname' class='name edit'/>
		
		<div class='category' style='margin-top:30px'>
		<table cellspacing='0' cellpadding='0'><tr>
			<td width='350px'>
			<span id='heading'>Profile</span><br/>
			<label>Graduating Class of </label><input name='class' value='$class' class='edit' style='width:50px' /><br>
			<label>Recruiting Class of </label><input name='recruitclass' value='$recruitclass' class='edit' style='width:50px' /><br>
				<select name='house' class='edit select' style='width: 130px'>
				<option value=''>House Affiliation</option>$house_select
				</select><br>
			<input name='concentration' placeholder='Concentration' value='$concentration' class='edit' /><br>
			<input name='hometown' placeholder='Hometown' value='$hometown' class='edit' /><br>
			<label>Birthday </label>$birthday<br>
			<input name='ethnicity' placeholder='Ethnicity' value='$ethnicity' class='edit'/><br>
			<input name='huid' placeholder='16-digit HUID / Crimson Cash Number' value='$huid' class='edit'/>
			</td>
			<td>
			<label>Brother </label><input name='callname' value='$callname' class='edit' style='width: 100px' /><br>
			<label>Story Behind the Call Name</label><br/>
			<textarea name='callnamestory' placeholder='When he stepped up to the brotherhood at the Kong...' class='edit' style='width: 300px; height: 150px'>$callnamestory</textarea>
			</td>
		</tr></table>
		</div>
		
		<div class='category'>
			<span>Social</span><br>
			$fb<input name='facebook' placeholder='https://www.facebook.com/YOURID' value='$facebook' class='edit'/><br>
			$tw<input name='twitter' placeholder='https://www.twitter.com/YOURID' value='$twitter' class='edit' /><br>
			$li<input name='linkedin' placeholder='https://www.linkedin.com/YOURID' value='$linkedin' class='edit' /><br>
		</div>
		
		<div class='category'>
			<span>Contact</span><br>
			<input name='emailharv' placeholder='@harvard' value='$email_harvard' class='edit' /><br>
			<input name='emailpers' placeholder='@gmail' value='$email_personal' class='edit' /><br>
			<input name='emailwork' placeholder='@work' value='$email_work' class='edit' /><br>
			<input name='phonecell' placeholder='cell' value='$phone_cell' class='edit' /><br>
			<input name='phonehome' placeholder='home' value='$phone_home' class='edit' /><br>
			<input name='phonework' placeholder='work' value='$phone_work' class='edit' />
		</div>
		
		<div class='category'>
			<span>Location</span><br>
			<input name='campusadd' placeholder='Campus Address (Leverett D41)' value='$campusAdd' class='edit' /><br>
			<input name='mailadd' placeholder='Mailing Address (341 Leverett Mail Center)' value='$mailAdd' class='edit' /><br>
			<input name='homeadd' placeholder='Home Address (123 Oak St, New York, NY)' value='$homeAdd' class='edit' /><br>
		</div>
		
		$survey
		
		<div class='category'>
			<span>Alumni</span><br>
			<input name='occupation' placeholder='Occupation' value='$occupation' class='edit'/><br>
			<input name='position' placeholder='Position' value='$position' class='edit' /><br>
			<input name='companyorg' placeholder='Company/Organization' value='$companyorg' class='edit' /><br>
			<input name='currentloc' placeholder='Current Location' value='$currentloc' class='edit' /><br>
			<input name='address' placeholder='Address' value='$address' class='edit' /><br>
			<textarea name='hobbiesint' class='edit' placeholder='What do you like to do in your free time?'>$hobbiesint</textarea>
		</div>
		<input type='submit' class='submit' id='SaveProfile' value='Update'/>
		</form>
		</div>
		</td>
		</tr></table>
		</div>
		
		<script>
		$(function(){
			$('img.thumb.big[title]').tooltip();
			
			$('img#thumbnail').click(function(){
				$('div.lookupDiv').empty();
				$('div.lookupDiv').load('directory_photo?request=form&bro=$bro');
				return false;
			});
		});
		</script>";
		
		echo $broster;
		}
	}
}
?>