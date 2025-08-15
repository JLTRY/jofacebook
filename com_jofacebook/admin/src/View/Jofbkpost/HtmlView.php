<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.3
    @build			15th August, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		HtmlView.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/
namespace JCB\Component\Jofacebook\Administrator\View\Jofbkpost;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\User\User;
use Joomla\CMS\Document\Document;
use JCB\Component\Jofacebook\Administrator\Helper\HeaderCheck;
use JCB\Component\Jofacebook\Administrator\Helper\JofacebookHelper;
use JCB\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die; 

/**
 * Jofacebook Html View class for the Jofbkpost
 *
 * @since  1.6
 */
#[\AllowDynamicProperties]
class HtmlView extends BaseHtmlView
{
    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     * @throws \Exception
     * @since  1.6
     */
    public function display($tpl = null): void
    {
        // get component params
        $this->params = ComponentHelper::getParams('com_jofacebook');
        // get the application
        $this->app ??= Factory::getApplication();
        // get the user object
        $this->user ??= Factory::getApplication()->getIdentity();
        // get global action permissions
        $this->canDo = JofacebookHelper::getActions('jofbkpost');
        $this->styles = $this->get('Styles');
        $this->scripts = $this->get('Scripts');
        // Initialise variables.
        $this->item = $this->get('Item');
        
        /***[JCBGUI.custom_admin_view.php_jview_display.1.$$$$]***/
        // Load the form manually by name
        \Joomla\CMS\Form\Form::addFormPath(JPATH_COMPONENT . '/forms');
        $form = \Joomla\CMS\Form\Form::getInstance('post', 'post', array('control' => 'jform'));
        $this->form = $form;
        $app = Factory::getApplication();
        $jinput = $app->getInput();
        $this->editor = $jinput->getString('editor', null);
        $this->id =  $jinput->getString('id', -1);
        if ($this->id !== -1) {
            $model = new \JCB\Component\Jofacebook\Administrator\Model\PostModel;
            $this->setModel($model);
            $this->item = $model->getItem((int)$this->id);
               $this->form->bind($this->item);
        }
        /***[/JCBGUI$$$$]***/
        

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal')
        {
            // add the tool bar
            $this->addToolBar();
        }

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new \Exception(implode(PHP_EOL, $errors), 500);
        }

        // Set the html view document stuff
        $this->_prepareDocument();

        parent::display($tpl);
    }

    /**
     * Prepare some document related stuff.
     *
     * @return  void
     * @since   1.6
     */
    protected function _prepareDocument(): void
    {

        // Only load jQuery if needed. (default is true)
        if ($this->params->get('add_jquery_framework', 1) == 1)
        {
            Html::_('jquery.framework');
        }
        // Load the header checker class.
        // Initialize the header checker.
        $HeaderCheck = new HeaderCheck();

        // Add View JavaScript File
        Html::_('script', "administrator/components/com_jofacebook/assets/js/jofbkpost.js", ['version' => 'auto']);
        // add styles
        foreach ($this->styles as $style)
        {
            Html::_('stylesheet', $style, ['version' => 'auto']);
        }
        // Set the Custom CSS script to view
        $this->document->addStyleDeclaration("
            
        ");
        // add scripts
        foreach ($this->scripts as $script)
        {
            Html::_('script', $script, ['version' => 'auto']);
        }
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     * @since   1.6
     */
    protected function addToolbar(): void
    {
        // hide the main menu
        $this->app->input->set('hidemainmenu', true);
        // set the title
        if (isset($this->item->name) && $this->item->name)
        {
            $title = $this->item->name;
        }
        // Check for empty title and add view name if param is set
        if (empty($title))
        {
            $title = Text::_('COM_JOFACEBOOK_JOFBKPOST');
        }
        // add title to the page
        ToolbarHelper::title($title,'joomla');
        // add cpanel button
        ToolbarHelper::custom('jofbkpost.dashboard', 'grid-2', '', 'COM_JOFACEBOOK_DASH', false);

        // set help url for this view if found
        $this->help_url = JofacebookHelper::getHelpUrl('jofbkpost');
        if (StringHelper::check($this->help_url))
        {
            ToolbarHelper::help('COM_JOFACEBOOK_HELP_MANAGER', false, $this->help_url);
        }

        // add the options comp button
        if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
        {
            ToolbarHelper::preferences('com_jofacebook');
        }
    }

    /**
     * Escapes a value for output in a view script.
     *
     * @param   mixed  $var     The output to escape.
     * @param   bool   $shorten The switch to shorten.
     * @param   int    $length  The shorting length.
     *
     * @return  mixed  The escaped value.
     * @since   1.6
     */
    public function escape($var, bool $shorten = false, int $length = 40)
    {
        if (!is_string($var))
        {
            return $var;
        }

        return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
    }
}
