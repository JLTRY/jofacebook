<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.4
    @build			8th October, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		default.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2015. All Rights Reserved
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
use JCB\Component\Jofacebook\Administrator\Helper\JofacebookHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');

// No direct access to this file
defined('_JEXEC') or die;

?>
<?php if ($this->canDo->get('jofbkpost.access')): ?>
<script type="text/javascript">
    Joomla.submitbutton = function(task) {
        if (task === 'jofbkpost.back') {
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


<!--[JCBGUI.custom_admin_view.default.1.$$$$]-->
<?php
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');


?>
<form  action="<?php echo Route::_('index.php?option=com_jofacebook&view=jofbkpost&layout=' . $layout . $tmpl . '&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<div class="main-card">
    <?php echo \Joomla\CMS\Layout\LayoutHelper::render('post.details_left', $this); ?>
</div>
      <button type="button" class="btn btn-success" onclick="insertFacebookPost(jQuery, '<?php echo $this->editor ?>');">
                            <?php echo Text::_('JOFBK_ADD_POST'); ?>
                         </button>
     <button  type="button" onclick="showFacebookPost(jQuery);">
                            <?php echo Text::_('JOFBK_VIEW_POST'); ?>
                         </button>
    <div>
        <input type="hidden" name="task" value="post.edit" />
        <?php echo Html::_('form.token'); ?>
    </div>
</form>


<!--[/JCBGUI$$$$]-->

<?php else: ?>
        <h1><?php echo Text::_('COM_JOFACEBOOK_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
