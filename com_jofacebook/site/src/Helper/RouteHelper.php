<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.5
    @build			23rd December, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		RouteHelper.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2025. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JLTRY\Component\Jofacebook\Site\Helper;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jofacebook Component Route Helper
 *
 * @since       1.5
 */
abstract class RouteHelper
{
    /**
     * Registry to hold the jofacebook params
     *
     * @var    Registry
     * @since  5.1.3
     */
    protected static Registry $params;

    /**
     * Retrieve a legacy-configured menu item override.
     *
     * This method is preserved for backward compatibility with older
     * JCB-generated components where menu item overrides could be defined
     * in the component's **global Options** panel. Administrators were able
     * to add menu-item selector fields under the same tab name as the
     * related entity/view type, using the naming convention:
     *
     *     {type}_menu
     *
     * Example:
     *   - A field named `tag_menu` allowed administrators to force all tag
     *     routing to use a specific menu item.
     *
     * These overrides served as a convenience mechanism for redirecting
     * routing behaviour *without* modifying the router code.
     *
     * Joomla 5's recommended pattern now is to implement all routing
     * decisions directly inside the router class. This method therefore
     * remains solely as a **legacy fallback**, ensuring older sites continue
     * functioning during migrations or long-term upgrade paths.
     *
     * If a matching `{type}_menu` parameter exists and contains a valid
     * menu item ID (>0), that ID is returned. Otherwise, `null` is returned.
     *
     * @param  string  $type  The entity/view type whose `{type}_menu`
     *                        override should be checked.
     *
     * @return int|null  The overridden menu item ID if available, otherwise null.
     * @since   5.1.3
     */
    protected static function _findItem(string $type): ?int
    {
        // Lazy-load the component parameters only once.
        self::$params ??= ComponentHelper::getParams('com_jofacebook');

        // Read the legacy override (0 means "not set").
        $override = (int) self::$params->get($type . '_menu', 0);

        return $override > 0 ? $override : null;
    }
}
