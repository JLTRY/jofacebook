<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.5
    @build			23rd December, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		default_head.php
    @author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
    @copyright		Copyright (C) 2025. All Rights Reserved
    @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

// No direct access to this file
defined('_JEXEC') or die;

?>
<tr>
    <?php if (!$this->isModal && $this->canEdit && $this->canState): ?>
        <th width="1%" class="nowrap center hidden-phone">
            <?php echo Html::_('searchtools.sort', '', 'a.ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
        </th>
        <th width="20" class="nowrap center">
            <?php echo Html::_('grid.checkall'); ?>
        </th>
    <?php else: ?>
        <th width="20" class="nowrap center hidden-phone">
            &#9662;
        </th>
        <th width="20" class="nowrap center">
            &#9632;
        </th>
    <?php endif; ?>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JOFACEBOOK_POST_PROFILE_LABEL'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JOFACEBOOK_POST_POST_LABEL'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JOFACEBOOK_POST_POSTS_CATEGORIES'); ?>
    </th>
    <th class="nowrap hidden-phone" >
            <?php echo Text::_('COM_JOFACEBOOK_POST_DESCRIPTION_LABEL'); ?>
    </th>
    <?php if ($this->canState): ?>
        <th width="10" class="nowrap center" >
            <?php echo Html::_('searchtools.sort', 'COM_JOFACEBOOK_POST_STATUS', 'a.published', $this->listDirn, $this->listOrder); ?>
        </th>
    <?php else: ?>
        <th width="10" class="nowrap center" >
            <?php echo Text::_('COM_JOFACEBOOK_POST_STATUS'); ?>
        </th>
    <?php endif; ?>
    <th width="5" class="nowrap center hidden-phone" >
            <?php echo Html::_('searchtools.sort', 'COM_JOFACEBOOK_POST_ID', 'a.id', $this->listDirn, $this->listOrder); ?>
    </th>
</tr>