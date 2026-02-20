<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
?>
<div class="modal fade" id="modal-discovery_filled" tabindex="-1" aria-labelledby="modal-discovery_filled-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-discovery_filled-label"><?php echo Text::_('COM_CRMSAMPLE_ACTION_DISCOVERY_FILLED'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo Route::_('index.php?option=com_crmsample&task=company.addEvent'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="company_id" value="<?php echo (int) $this->item->id; ?>">
                    <input type="hidden" name="event_type" value="discovery_filled">
                    <div class="mb-3">
                        <label for="needs" class="form-label"><?php echo Text::_('COM_CRMSAMPLE_DISCOVERY_NEEDS'); ?></label>
                        <textarea class="form-control" id="needs" name="event_data[needs]" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label"><?php echo Text::_('COM_CRMSAMPLE_DISCOVERY_BUDGET'); ?></label>
                        <input type="text" class="form-control" id="budget" name="event_data[budget]">
                    </div>
                    <div class="mb-3">
                        <label for="timeline" class="form-label"><?php echo Text::_('COM_CRMSAMPLE_DISCOVERY_TIMELINE'); ?></label>
                        <input type="text" class="form-control" id="timeline" name="event_data[timeline]">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo Text::_('JCANCEL'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo Text::_('JSAVE'); ?></button>
                </div>
                <?php echo HTMLHelper::_('form.token'); ?>
            </form>
        </div>
    </div>
</div>