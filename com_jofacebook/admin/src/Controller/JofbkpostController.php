<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.4
    @build			8th October, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		JofbkpostController.php
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
 * Jofacebook Jofbkpost Base Controller
 *
 * @since  1.6
 */
class JofbkpostController extends BaseController
{
    /**
     * The context for storing internal data, e.g. record.
     *
     * @var    string
     * @since  1.6
     */
    protected $context = 'jofbkpost';

    /**
     * The URL view item variable.
     *
     * @var    string
     * @since  1.6
     */
    protected $view_item = 'jofbkpost';

    /**
     * Adds option to redirect back to the dashboard.
     *
     * @return  void
     * @since   3.0
     */
    public function dashboard(): void
    {
        $this->setRedirect(Route::_('index.php?option=com_jofacebook', false));
    }
}
