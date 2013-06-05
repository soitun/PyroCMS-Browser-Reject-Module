<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_Browser_reject extends Plugin
{
	public function __construct()
	{		
		$this->load->model('browser_reject_m');
	}

	function show_popup()
	{
		$options = $this->browser_reject_m->get_all_options();
		
		if( $options != 0 )
		{
			$str = "";
			
			foreach( $options as $option )
			{
				$jquery = $option->include_jquery;
				$header = str_replace("'", "\'", $option->header);
				$par1 = str_replace("'", "\'", $option->paragraph1);
				$par2 = str_replace("'", "\'", $option->paragraph2);
				$close_msg = str_replace("'", "\'", $option->close_message);
				$close_link = $option->close_link_message;
				$cookie = $option->use_cookie;
				$expire = $option->cookie_expire;
				
				$browsers = explode("\n", $option->not_allowed);
				
				$i=1;
				if( count($browsers) > 0)
				{
					$str_browser = "reject: {";
					foreach($browsers as $browser)
					{
						if( $browser != "default" )
						{
							$str_browser .= $browser.": true";
							if( $i != count($browser) )
							{
								$str_browser .= ",";
							}
							$i++;
						}
					}
					$str_browser .= "},";
				}				
				
				//Check if user need jquery
				if( $jquery )
					$str .= "<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.9.1.min.js\"></script>";
				
				
				//check where user installed the module
				if( is_dir(ADDONPATH.'modules/browser_reject') )
				{
					$path = ADDONPATH.'modules/browser_reject';
				}
				else
				{
					$path = SHARED_ADDONPATH.'modules/browser_reject';
				}
				
				$str .= ("
					<script type=\"text/javascript\" src=\"$path/js/jquery.reject.js\"></script>
					<link rel=\"stylesheet\" type=\"text/css\" href=\"$path/css/jquery.reject.css\">
					<script type=\"text/javascript\">
					$(document).ready(function() {
						$.reject({
							$str_browser	
							header: '$header',
							paragraph1: '$par1',
					        paragraph2: '$par2',  
					        closeMessage: '$close_msg',
			    		    imagePath: '$path/img/reject/',
					        closeLink: '$close_link',
					        closeCookie: $cookie,
					        cookieSettings: {  
						        path: '/',  
						        expires: $expire  
						    },  					        
						});  
   						 return false; 
			    	});
	    		</script>
				");
			}
			
			return $str;
		}
	}
}