<?php 
/* functions to support tecnavia paywall. 
	31Jan16 zig 
*/


	function eai_technav_loginmenu(){

		$out_string = "";		
		$login_url = "#";
		$out_string .= '<ul class="ea-technav-login ea-leaky-login">';
		$out_string .=    '<li>';
		$out_string .=       '<a id="ta_account_button" onclick="ta_account()" >~</a>';
		$out_string .=    "</li>";
		$out_string .= "</ul>";

		return $out_string;
	}

?>