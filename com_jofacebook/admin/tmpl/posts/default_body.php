<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
                JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

    @version		1.0.4
    @build			8th October, 2025
    @created		12th August, 2025
    @package		JOFacebook
    @subpackage		default_body.php
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
use JCB\Component\Jofacebook\Administrator\Helper\JofacebookHelper;
use Joomla\CMS\User\UserFactoryInterface;

// No direct access to this file
defined('_JEXEC') or die;

$edit = "index.php?option=com_jofacebook&view=posts&task=post.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
    <?php
        $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
        $userChkOut = Factory::getContainer()->
            get(UserFactoryInterface::class)->
                loadUserById($item->checked_out ?? 0);
        $canDo = JofacebookHelper::getActions('post',$item,'posts');
    ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td class="order nowrap center hidden-phone">
        <?php if (!$this->isModal && $canDo->get('core.edit.state')): ?>
            <?php
                $iconClass = '';
                if (!$this->saveOrder)
                {
                    $iconClass = ' inactive tip-top" hasTooltip" title="' . Html::tooltipText('JORDERINGDISABLED');
                }
            ?>
            <span class="sortable-handler<?php echo $iconClass; ?>">
                <i class="icon-menu"></i>
            </span>
            <?php if ($this->saveOrder) : ?>
                <input type="text" style="display:none" name="order[]" size="5"
                value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
            <?php endif; ?>
        <?php else: ?>
            &#8942;
        <?php endif; ?>
        </td>
        <td class="nowrap center">
        <?php if (!$this->isModal && $canDo->get('core.edit')): ?>
                <?php if ($item->checked_out) : ?>
                    <?php if ($canCheckin) : ?>
                        <?php echo Html::_('grid.id', $i, $item->id); ?>
                    <?php else: ?>
                        &#9633;
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo Html::_('grid.id', $i, $item->id); ?>
                <?php endif; ?>
        <?php else: ?>
            &#9633;
        <?php endif; ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->profile); ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->post); ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->category_title); ?>
        </td>
        <td class="hidden-phone">
            <?php echo $this->escape($item->description); ?>
        </td>
        <td class="center">
        <?php if (!$this->isModal && $canDo->get('core.edit.state')) : ?>
                <?php if ($item->checked_out) : ?>
                    <?php if ($canCheckin) : ?>
                        <?php echo Html::_('jgrid.published', $item->published, $i, 'posts.', true, 'cb'); ?>
                    <?php else: ?>
                        <?php echo Html::_('jgrid.published', $item->published, $i, 'posts.', false, 'cb'); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo Html::_('jgrid.published', $item->published, $i, 'posts.', true, 'cb'); ?>
                <?php endif; ?>
        <?php else: ?>
            <?php echo Html::_('jgrid.published', $item->published, $i, 'posts.', false, 'cb'); ?>
        <?php endif; ?>
        </td>
        <td class="nowrap center hidden-phone">
            <?php echo $item->id; ?>
        </td>
    </tr>
<?php endforeach; ?>