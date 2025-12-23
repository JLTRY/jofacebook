<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.5
    @build			23rd December, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		edit.php
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
<div class="jofacebook-post">
<?php echo $this->toolbar->render(); ?>
<form action="<?php echo Route::_('index.php?option=com_jofacebook&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

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
