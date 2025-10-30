/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			8th October, 2025
	@created		12th August, 2025
	@package		JOFacebook
	@subpackage		facebookpost.js
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2025. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.custom_admin_view.javascript_file.2.$$$$]***/
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/fr_FR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

/***[/JCBGUI$$$$]***/
