<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.3
    @build			15th August, 2025
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

$layout  = $this->isModal ? 'modal' : 'edit';
$tmpl    = $this->input->get('tmpl');
$tmpl    = $tmpl ? '&tmpl=' . $tmpl : '';
?>
<script type="text/javascript">
    // waiting spinner
    var outerDiv = document.querySelector('body');
    var loadingDiv = document.createElement('div');
    loadingDiv.id = 'loading';
    loadingDiv.style.cssText = "background: rgba(255, 255, 255, .8) url('components/com_jofacebook/assets/images/ajax.gif') 50% 35% no-repeat; top: " + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + "px; left: " + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + "px; width: " + outerDiv.offsetWidth + "px; height: " + outerDiv.offsetHeight + "px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;";
    outerDiv.appendChild(loadingDiv);
    loadingDiv.style.display = 'block';
    // when page is ready remove and show
    window.addEventListener('load', function() {
        var componentLoader = document.getElementById('jofacebook_loader');
        if (componentLoader) componentLoader.style.display = 'block';
        loadingDiv.style.display = 'none';
    });
</script>
<div id="jofacebook_loader" style="display: none;">
<form action="<?php echo Route::_('index.php?option=com_jofacebook&&layout=' . $layout . $tmpl . '&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<div class="main-card">

    <?php echo Html::_('uitab.startTabSet', 'postTab', ['active' => 'details', 'recall' => true]); ?>

    <?php echo Html::_('uitab.addTab', 'postTab', 'details', Text::_('COM_JOFACEBOOK_POST_DETAILS', true)); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo LayoutHelper::render('post.details_left', $this); ?>
            </div>
        </div>
    <?php echo Html::_('uitab.endTab'); ?>

    <?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
    <?php $this->tab_name = 'postTab'; ?>
    <?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

    <?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('core.edit.state') || ($this->canDo->get('core.delete') && $this->canDo->get('core.edit.state'))) : ?>
    <?php echo Html::_('uitab.addTab', 'postTab', 'publishing', Text::_('COM_JOFACEBOOK_POST_PUBLISHING', true)); ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo LayoutHelper::render('post.publishing', $this); ?>
            </div>
            <div class="col-md-6">
                <?php echo LayoutHelper::render('post.publlshing', $this); ?>
            </div>
        </div>
    <?php echo Html::_('uitab.endTab'); ?>
    <?php endif; ?>

    <?php echo Html::_('uitab.endTabSet'); ?>

    <div>
        <input type="hidden" name="task" value="post.edit" />
        <?php echo Html::_('form.token'); ?>
    </div>
</div>
</form>
</div>
