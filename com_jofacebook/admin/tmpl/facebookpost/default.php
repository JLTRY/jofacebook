<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.5
    @build			23rd December, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		default.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2025. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use JLTRY\Component\Jofacebook\Administrator\Helper\JofacebookHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');

// No direct access to this file
defined('_JEXEC') or die;

?>
<?php if ($this->canDo->get('facebookpost.access')): ?>
<script type="text/javascript">
    Joomla.submitbutton = function(task) {
        if (task === 'facebookpost.back') {
            parent.history.back();
            return false;
        } else {
            var form = document.getElementById('adminForm');
            form.task.value = task;
            form.submit();
        }
    }
</script>
<?php $urlId = (isset($this->item->id)) ? '&id='. (int) $this->item->id : ''; ?>
<form action="<?php echo Route::_('index.php?option=com_jofacebook&view=facebookpost' . $urlId); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">


<!--[JCBGUI.custom_admin_view.default.2.$$$$]-->
<?php
         switch($this->getLayout())
         {
           case 'default':
                if (!is_numeric($this->profile)) {
                    echo sprintf('<div class="fb-post" data-href="https://www.facebook.com/%s/posts/%s" 
                                     data-show-text="true">&nbsp;</div>',
                                     $this->profile,
                                     $this->post);
                }
                 else {
                    echo sprintf('<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=%s&id=%s" 
                                     data-show-text="true">&nbsp;</div>',
                                     $this->post,
                                     $this->profile);
                 }
                 break;
          case 'json':
                 $app = Factory::getApplication();
                 $jinput = $app->getInput();
                  $this->id =  $jinput->getString('id', -1);
                  if ($this->id !== -1) {
                $model = new \JLTRY\Component\Jofacebook\Administrator\Model\PostModel;
                $this->setModel($model);
                $this->item = $model->getItem((int)$this->id);
                       ob_end_clean();
                        header('Content-Type: application/json');
                        header('Cache-Control: max-age=120, private, must-revalidate');
                        header('Content-Disposition: attachment; filename="jcoaching.json"');
                       ob_end_clean();
                       echo json_encode(["post" => $this->item->post, "profile" => $this->item->profile, "description" => $this->item->description ]);
                        Factory::getApplication()->close();
                 }
               break;
     }
?><!--[/JCBGUI$$$$]-->

<input type="hidden" name="task" value="" />
<?php echo Html::_('form.token'); ?>
</form>
<?php else: ?>
        <h1><?php echo Text::_('COM_JOFACEBOOK_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
