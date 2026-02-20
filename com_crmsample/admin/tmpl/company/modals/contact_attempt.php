<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
?>
<div class="modal fade" id="modal-contact_attempt" tabindex="-1" aria-labelledby="modal-contact_attempt-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-contact_attempt-label"><?php echo Text::_('COM_CRMSAMPLE_ACTION_CONTACT_ATTEMPT'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo Route::_('index.php?option=com_crmsample&task=company.addEvent'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="company_id" value="<?php echo (int) $this->item->id; ?>">
                    <input type="hidden" name="event_type" value="contact_attempt">
                    <div class="mb-3">
                        <label for="comment" class="form-label"><?php echo Text::_('COM_CRMSAMPLE_COMMENT'); ?></label>
                        <textarea class="form-control" id="comment" name="event_data[comment]" rows="2"></textarea>
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