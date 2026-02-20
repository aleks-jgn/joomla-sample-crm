<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('bootstrap.modal');
?>

<form action="<?php echo Route::_('index.php?option=com_crmsample&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php echo $this->form->renderField('name'); ?>
                    <?php echo $this->form->renderField('id'); ?>
                    <input type="hidden" name="jform[current_stage]" value="<?php echo $this->escape($this->item->current_stage); ?>" />
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header"><?php echo Text::_('COM_CRMSAMPLE_CURRENT_STAGE'); ?></div>
                <div class="card-body">
                    <?php 
                    $currentStage = $this->item->current_stage ?? 'Ice';
                    $stageClass = '';
                    if ($currentStage === 'Ice') $stageClass = 'text-primary';
                    elseif ($currentStage === 'Activated') $stageClass = 'text-success';
                    else $stageClass = 'text-warning';
                    ?>
                    <h3 class="<?php echo $stageClass; ?>"><?php echo $this->escape($currentStage); ?></h3>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header"><?php echo Text::_('COM_CRMSAMPLE_AVAILABLE_ACTIONS'); ?></div>
                <div class="card-body">
                    <?php foreach ($this->availableActions as $action) : ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $action; ?>">
                            <?php echo Text::_('COM_CRMSAMPLE_ACTION_' . strtoupper($action)); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header"><?php echo Text::_('COM_CRMSAMPLE_INSTRUCTION_SCRIPT'); ?></div>
                <div class="card-body">
                    <?php 
                    $stage = $this->item->current_stage ?? 'Ice';
                    $instruction = Text::_('COM_CRMSAMPLE_INSTRUCTION_' . strtoupper($stage));
                    echo $instruction ?: Text::_('COM_CRMSAMPLE_NO_INSTRUCTION');
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><?php echo Text::_('COM_CRMSAMPLE_EVENT_HISTORY'); ?></div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled">
                        <?php foreach ($this->events as $event) : 
                            $data = json_decode($event->event_data, true);
                        ?>
                            <li class="mb-2">
                                <strong><?php echo Text::_('COM_CRMSAMPLE_EVENT_' . strtoupper($event->event_type)); ?></strong>
                                <br>
                                <small><?php echo HTMLHelper::_('date', $event->created, Text::_('DATE_FORMAT_LC6')); ?></small>
                                <?php if ($data) : ?>
                                    <pre style="font-size: 0.8rem;"><?php print_r($data); ?></pre>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for actions -->
    <?php foreach ($this->availableActions as $action) : 
        $modalFile = __DIR__ . '/modals/' . $action . '.php';
        if (file_exists($modalFile)) {
            include $modalFile;
        }
    endforeach; ?>

    <input type="hidden" name="task" value="">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>