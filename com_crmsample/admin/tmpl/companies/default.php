<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.tooltip');
?>
<form action="<?php echo Route::_('index.php?option=com_crmsample&view=companies'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php if (empty($this->items)) : ?>
                    <div class="alert alert-info">
                        <span class="icon-info-circle" aria-hidden="true"></span>
                        <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                    </div>
                <?php else : ?>
                    <table class="table table-striped" id="companiesList">
                        <thead>
                            <tr>
                                <th style="width:1%" class="text-center">
                                    <?php echo HTMLHelper::_('grid.checkall'); ?>
                                </th>
                                <th><?php echo Text::_('COM_CRMSAMPLE_COMPANY_NAME'); ?></th>
                                <th><?php echo Text::_('COM_CRMSAMPLE_CURRENT_STAGE'); ?></th>
                                <th><?php echo Text::_('COM_CRMSAMPLE_CREATED'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->items as $i => $item) : 
                                $stageClass = '';
                                if ($item->current_stage === 'Ice') $stageClass = 'text-primary';
                                elseif ($item->current_stage === 'Activated') $stageClass = 'text-success';
                                else $stageClass = 'text-warning';
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo Route::_('index.php?option=com_crmsample&task=company.edit&id=' . (int) $item->id); ?>">
                                            <?php echo $this->escape($item->name); ?>
                                        </a>
                                    </td>
                                    <td class="<?php echo $stageClass; ?>">
                                        <?php echo $this->escape($item->current_stage); ?>
                                    </td>
                                    <td>
                                        <?php echo HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC6')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->pagination->getListFooter(); ?>
                <?php endif; ?>
                <input type="hidden" name="task" value="">
                <input type="hidden" name="boxchecked" value="0">
                <?php echo HTMLHelper::_('form.token'); ?>
            </div>
        </div>
    </div>
</form>