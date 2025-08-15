<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.3
    @build			15th August, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		ImportController.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jofacebook\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Utilities\ArrayHelper;
use JCB\Component\Jofacebook\Administrator\Helper\JofacebookHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jofacebook Import Base Controller
 *
 * @since  1.6
 */
class ImportController extends BaseController
{
    /**
     * Import an spreadsheet.
     *
     * @return  void
     */
    public function import()
    {
        // Check for request forgeries
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $model = $this->getModel('import');
        if ($model->import())
        {
            $cache = Factory::getCache('mod_menu');
            $cache->clean();
            // TODO: Reset the users acl here as well to kill off any missing bits
        }

        $app = Factory::getApplication();
        $redirect_url = $app->getUserState('com_jofacebook.redirect_url');
        if (empty($redirect_url))
        {
            $redirect_url = Route::_('index.php?option=com_jofacebook&view=import', false);
        }
        else
        {
            // wipe out the user state when we're going to redirect
            $app->setUserState('com_jofacebook.redirect_url', '');
            $app->setUserState('com_jofacebook.message', '');
            $app->setUserState('com_jofacebook.extension_message', '');
        }
        $this->setRedirect($redirect_url);
    }
}
