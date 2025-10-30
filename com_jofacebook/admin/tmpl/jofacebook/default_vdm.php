<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			8th October, 2025
	@created		12th August, 2025
	@package		JOFacebook
	@subpackage		default_vdm.php
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2025. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

use Joomla\CMS\Language\Text;
use JCB\Joomla\Utilities\ArrayHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<img alt="<?php echo Text::_('COM_JOFACEBOOK'); ?>" width="100%"  src="components/com_jofacebook/assets/images/vdm-component.png">
<ul class="list-striped">
	<li><b><?php echo Text::_('COM_JOFACEBOOK_VERSION'); ?>:</b> <?php echo $this->manifest->version; ?>&nbsp;&nbsp;<span class="update-notice" id="component-update-notice"></span></li>
	<li><b><?php echo Text::_('COM_JOFACEBOOK_DATE'); ?>:</b> <?php echo $this->manifest->creationDate; ?></li>
	<li><b><?php echo Text::_('COM_JOFACEBOOK_AUTHOR'); ?>:</b> <a href="mailto:<?php echo $this->manifest->authorEmail; ?>"><?php echo $this->manifest->author; ?></a></li>
	<li><b><?php echo Text::_('COM_JOFACEBOOK_WEBSITE'); ?>:</b> <a href="<?php echo $this->manifest->authorUrl; ?>" target="_blank"><?php echo $this->manifest->authorUrl; ?></a></li>
	<li><b><?php echo Text::_('COM_JOFACEBOOK_LICENSE'); ?>:</b> <?php echo $this->manifest->license; ?></li>
	<li><b><?php echo $this->manifest->copyright; ?></b></li>
</ul>
<div class="clearfix"></div>
<?php if(ArrayHelper::check($this->contributors)): ?>
	<?php if(count($this->contributors) > 1): ?>
		<h3><?php echo Text::_('COM_JOFACEBOOK_CONTRIBUTORS'); ?></h3>
	<?php else: ?>
		<h3><?php echo Text::_('COM_JOFACEBOOK_CONTRIBUTOR'); ?></h3>
	<?php endif; ?>
	<ul class="list-striped">
		<?php foreach($this->contributors as $contributor): ?>
		<li><b><?php echo $contributor['title']; ?>:</b> <?php echo $contributor['name']; ?></li>
		<?php endforeach; ?>
	</ul>
	<div class="clearfix"></div>
<?php endif; ?>