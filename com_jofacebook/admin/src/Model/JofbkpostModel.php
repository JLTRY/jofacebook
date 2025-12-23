<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.5
    @build			23rd December, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		JofbkpostModel.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2025. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JLTRY\Component\Jofacebook\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\User\User;
use Joomla\Input\Input;
use Joomla\Utilities\ArrayHelper;
use JLTRY\Component\Jofacebook\Administrator\Helper\JofacebookHelper;
use Joomla\CMS\Helper\TagsHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Jofacebook Jofbkpost Item Model
 *
 * @since  1.6
 */
class JofbkpostModel extends ItemModel
{
    /**
     * Model context string.
     *
     * @var     string
     * @since   1.6
     */
    protected $_context = 'com_jofacebook.jofbkpost';

    /**
     * Represents the current user object.
     *
     * @var   User  The user object representing the current user.
     * @since 3.2.0
     */
    protected User $user;

    /**
     * The unique identifier of the current user.
     *
     * @var   int|null  The ID of the current user.
     * @since 3.2.0
     */
    protected ?int $userId;

    /**
     * Flag indicating whether the current user is a guest.
     *
     * @var   int  1 if the user is a guest, 0 otherwise.
     * @since 3.2.0
     */
    protected int $guest;

    /**
     * An array of groups that the current user belongs to.
     *
     * @var   array|null  An array of user group IDs.
     * @since 3.2.0
     */
    protected ?array $groups;

    /**
     * An array of view access levels for the current user.
     *
     * @var   array|null  An array of access level IDs.
     * @since 3.2.0
     */
    protected ?array $levels;

    /**
     * The application object.
     *
     * @var   CMSApplicationInterface  The application instance.
     * @since 3.2.0
     */
    protected CMSApplicationInterface $app;

    /**
     * The input object, providing access to the request data.
     *
     * @var   Input  The input object.
     * @since 3.2.0
     */
    protected Input $input;

    /**
     * The styles array.
     *
     * @var    array
     * @since  4.3
     */
    protected array $styles = [
        'administrator/components/com_jofacebook/assets/css/admin.css',
        'administrator/components/com_jofacebook/assets/css/jofbkpost.css'
    ];

    /**
     * The scripts array.
     *
     * @var    array
     * @since  4.3
     */
    protected array $scripts = [
        'administrator/components/com_jofacebook/assets/js/admin.js'
    ];

    /**
     * A custom property for UI Kit components.
     *
     * @var   mixed  Property for storing UI Kit component-related data or objects.
     * @since 3.2.0
     */
    protected $uikitComp = [];

    /**
     * @var     object item
     * @since   1.6
     */
    protected $item;

    /**
     * Constructor
     *
     * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
     * @param   ?MVCFactoryInterface  $factory  The factory.
     *
     * @since   3.0
     * @throws  \Exception
     */
    public function __construct($config = [], ?MVCFactoryInterface $factory = null)
    {
        parent::__construct($config, $factory);

        $this->app ??= Factory::getApplication();
        $this->input ??= $this->app->getInput();

        // Set the current user for authorisation checks (for those calling this model directly)
        $this->user ??= $this->getCurrentUser();
        $this->userId = $this->user->get('id');
        $this->guest = $this->user->get('guest');
        $this->groups = $this->user->get('groups');
        $this->authorisedGroups = $this->user->getAuthorisedGroups();
        $this->levels = $this->user->getAuthorisedViewLevels();

        // will be removed
        $this->initSet = true;
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     * @since   1.6
     */
    protected function populateState()
    {
        // Get the item main id
        $id = $this->input->getInt('id', null);
        $this->setState('jofbkpost.id', $id);

        // Load the parameters.
        parent::populateState();
    }

    /**
     * Method to get article data.
     *
     * @param   integer  $pk  The id of the article.
     *
     * @return  mixed  Menu item data object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        // check if this user has permission to access item
        if (!$this->user->authorise('jofbkpost.access', 'com_jofacebook'))
        {
            $this->app->enqueueMessage(Text::_('Not authorised!'), 'error');
            // redirect away if not a correct to cPanel/default view
            $this->app->redirect('index.php?option=com_jofacebook');
            return false;
        }

        $pk = (!empty($pk)) ? $pk : (int) $this->getState('jofbkpost.id');

        if ($this->_item === null)
        {
            $this->_item = [];
        }

        if (!isset($this->_item[$pk]))
        {
            try
            {
                // Get a db connection.
                $db = $this->getDatabase();

                // Create a new query object.
                $query = $db->getQuery(true);

                // Get from #__jofacebook_post as a
                $query->select($db->quoteName(
            array('a.id','a.asset_id','a.profile','a.post','a.published','a.created_by','a.modified_by','a.created','a.modified','a.version','a.hits','a.ordering'),
            array('id','asset_id','profile','post','published','created_by','modified_by','created','modified','version','hits','ordering')));
                $query->from($db->quoteName('#__jofacebook_post', 'a'));

                // Reset the query using our newly populated query object.
                $db->setQuery($query);
                // Load the results as a stdClass object.
                $data = $db->loadObject();

                if (empty($data))
                {
                    $app = Factory::getApplication();
                    // If no data is found redirect to default page and show warning.
                    $app->enqueueMessage(Text::_('COM_JOFACEBOOK_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
                    $app->redirect('index.php?option=com_jofacebook');
                    return false;
                }

                // set data object to item.
                $this->_item[$pk] = $data;
            }
            catch (\Exception $e)
            {
                if ($e->getCode() == 404)
                {
                    // Need to go thru the error handler to allow Redirect to work.
                    throw $e;
                }
                else
                {
                    $this->setError($e);
                    $this->_item[$pk] = false;
                }
            }
        }

        return $this->_item[$pk];
    }

    /**
     * Method to get the styles that have to be included on the view
     *
     * @return  array    styles files
     * @since   4.3
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * Method to set the styles that have to be included on the view
     *
     * @return  void
     * @since   4.3
     */
    public function setStyles(string $path): void
    {
        $this->styles[] = $path;
    }

    /**
     * Method to get the script that have to be included on the view
     *
     * @return  array    script files
     * @since   4.3
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * Method to set the script that have to be included on the view
     *
     * @return  void
     * @since   4.3
     */
    public function setScript(string $path): void
    {
        $this->scripts[] = $path;
    }
}
