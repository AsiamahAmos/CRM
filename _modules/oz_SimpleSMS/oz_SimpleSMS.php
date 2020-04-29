<?PHP
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/oz_SimpleSMS/oz_SimpleSMS_sugar.php');
class oz_SimpleSMS extends oz_SimpleSMS_sugar {
	
	function oz_SimpleSMS(){	
		parent::oz_SimpleSMS_sugar();
	}
	
	function oz_configure_panel($host,$port,$user,$pass) {
		global $mod_strings;
		print("<h1 style='text-align:center'>".$mod_strings['LBL_MODULE_TITLE']." ".$mod_strings["LBL_CONF_PANEL"]."</h1>");
		print("<hr>\n");
		print("<form method=\"get\">\n");
		print("<table style=\"margin: 0px auto 0px auto;\">\n");
		print("<tr><td>".$mod_strings["LBL_HOST"]."</td><td><input type=\"text\" name=\"ozhost\" value=\"$host\"></td></tr>\n");
		print("<tr><td>".$mod_strings["LBL_PORT"]."</td><td><input type=\"text\" name=\"ozport\" value=\"$port\"></td></tr>\n");
		print("<tr><td>".$mod_strings["LBL_USER"]."</td><td><input type=\"text\" name=\"ozuser\" value=\"$user\"></td></tr>\n");
		print("<tr><td>".$mod_strings["LBL_PASSWORD"]."</td><td><input type=\"text\" name=\"ozpass\" value=\"$pass\"></td></tr>\n");
		print("<tr><td colspan=\"2\" style=\"text-align:center\"><input type=\"Submit\" value=\"Save\"></td></tr>\n");
		print("</table>\n");
		print("<input type=\"hidden\" name=\"module\" value=\"oz_SimpleSMS\">\n");
		print("<input type=\"hidden\" name=\"action\" value=\"index\">\n");
		print("<input type=\"hidden\" name=\"param\" value=\"conf_save\">\n");
		print("</form>\n");	
		print("<hr>\n");
	}
	
	function oz_get_configure() {
		$sql_query="SELECT * FROM oz_simplesms_param WHERE id=1";
		$result=$this->db->query($sql_query,true);
		$row = $this->db->fetchByAssoc($result); 
		return $row;
	}

	function oz_set_configure($nghost,$ngport,$nguser,$ngpass) {
		$sql_query="UPDATE oz_simplesms_param SET nghost='$nghost', ngport='$ngport', nguser='$nguser', ngpass='$ngpass' WHERE id=1";
		$this->db->query($sql_query,true);
	}
	
	function oz_sms_send_panel($type) {
		global $mod_strings;
		print("<hr>\n");
		print("<div style='width:750px; margin:0px auto 0px auto;'>\n");
		print("<form method='get' name='oz'>\n");
		print("<table style='margin: 0px auto 0px auto;'>\n");
		if ($type=="simple") {
			print("<tr><td>".$mod_strings["LBL_RECIPIENT"]."</td><td><input type='text' name='ozphone'></td></tr>\n");
		}
		print("<tr><td colspan='2' style='text-align:center'>".$mod_strings["LBL_MESSAGE"]."</td></tr>\n");
		print("<tr><td colspan='2' style='text-align:center'><textarea rows='5' cols='30' name='ozmessage'></textarea><br/>\n");
		print("<tr><td colspan='2' style='text-align:center'><input type='Submit' value='".$mod_strings["LBL_SEND"]."'></td></tr>\n");
		print("</table>\n");
		print("<input type=\"hidden\" name=\"module\" value=\"oz_SimpleSMS\">\n");
		print("<input type=\"hidden\" name=\"action\" value=\"index\">\n");
		if ($type=="contact"){
			print("<input type=\"hidden\" name=\"param\" value=\"con_send\">\n");
			$result=$this->oz_get_current_user_contact();
			print("<hr>\n");	
			print("<table style='width:100%'>\n");
			print("<tr><td style='font-weight:bold'>".$mod_strings["LBL_NAME"]."</td><td style='font-weight:bold'>".$mod_strings["LBL_MOBILE_PHONE"]."</td><td style='font-weight:bold'>".$mod_strings["LBL_SELECT"]."</td></tr>");
			$i=1;
			foreach ($result as $user) {
				if ($user["Phone"]!='') {
					if ($i % 2 == 0){
						print("<tr><td>$i., ".$user["Name"].'</td><td>'.$user["Phone"].'</td><td><input type="checkbox" name="oz_recipient[]" value="'.$user["Phone"].'"></td></tr>');
					}
					else {
						print("<tr style='background:#B5B3B3;'><td>$i., ".$user["Name"].'</td><td>'.$user["Phone"].'</td><td><input type="checkbox" name="oz_recipient[]" value="'.$user["Phone"].'"></td></tr>');
					}
					print("\n");
					$i++;
				}	
			}
			print('</table>');
			print('<hr>');
		}
		elseif ($type=="simple") {
			print("<input type=\"hidden\" name=\"param\" value=\"send\">\n");
		}
		print("</form>\n");
		print("</div>\n");
		print("<hr>\n");
	}
	
	function oz_get_current_user_contact() {
		global $current_user;  
		$sql_query="SELECT * FROM contacts";
		if (is_admin($current_user)) {
			$where="";
		}
		else {
			$where=" WHERE assigned_user_id='".$current_user->id."'";
		}
		$sql_query.=$where;
		$result=$this->db->query($sql_query,true);
		$ret_val=array();
		while ($row = $this->db->fetchByAssoc($result)) {
			$name=$row["first_name"]." ".$row["last_name"];
			$phone=$row["phone_mobile"];
			$ret_val[] = array("Name"=>$name, "Phone"=>$phone);
		}
		return $ret_val;
	}
	
	function oz_error_display ($error_message,$type){
		if ($type=="error") {
			print("<div style='background-color:#e88888; width:700px; text-align:center; margin: 0px auto 0px auto;'>");
		}
		else {
			print("<div style='background-color:#91e888; width:700px; text-align:center; margin: 0px auto 0px auto;'>");
		}
		print($error_message);
		print("</div>");
	}
	
}
?>