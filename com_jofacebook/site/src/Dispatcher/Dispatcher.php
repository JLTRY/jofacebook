<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			8th October, 2025
	@created		12th August, 2025
	@package		JOFacebook
	@subpackage		Dispatcher.php
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2025. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jofacebook\Site\Dispatcher;

use Joomla\CMS\Dispatcher\ComponentDispatcher;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * ComponentDispatcher class for com_jofacebook
 *
 * @since  4.0.0
 */
class Dispatcher extends ComponentDispatcher
{
	/**
	 * Dispatch a controller task. Redirecting the user if appropriate.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function dispatch()
	{
		parent::dispatch();
	}
}
