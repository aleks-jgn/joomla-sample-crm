<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
?>
<div class="modal fade" id="modal-payment_received" tabindex="-1" aria-labelledby="modal-payment_received-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-payment_received-label"><?php echo Text::_('COM_CRMSAMPLE_ACTION_PAYMENT_RECEIVED'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo Route::_('index.php?option=com_crmsample&task=company.addEvent'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="company_id" value="<?php echo (int) $this->item->id; ?>">
                    <input type="hidden" name="event_type" value="payment_received">
                    <div class="mb-3">
                        <label for="amount" class="form-label"><?php echo Text::_('COM_CRMSAMPLE_AMOUNT'); ?></label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="event_data[amount]" required>
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