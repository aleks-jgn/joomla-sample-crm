<?php
namespace CrmSample\Component\Crmsample\Administrator\View\Company;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class HtmlView extends BaseHtmlView
{
    protected $item;
    protected $form;
    protected $events;
    protected $availableActions;

    public function display($tpl = null)
    {
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');
        $model = $this->getModel();

        // Определяем текущую стадию (для новой компании – 'Ice')
        $stage = $this->item->current_stage ?? 'Ice';
        $this->availableActions = $model->getAvailableActions($stage);

        // Load events (только для существующей компании)
        if ($this->item->id) {
            $eventModel = $this->getModel('Event', 'Administrator');
            if ($eventModel !== null) {
                $this->events = $eventModel->getEventsByCompany($this->item->id);
            } else {
                $this->events = [];
            }
        } else {
            $this->events = [];
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $isNew = ($this->item->id == 0);
        ToolbarHelper::title(Text::_('COM_CRMSAMPLE_COMPANY_TITLE'), 'address');
        ToolbarHelper::apply('company.apply');
        ToolbarHelper::save('company.save');
        ToolbarHelper::cancel('company.cancel', 'JTOOLBAR_CLOSE');
        // ToolbarHelper::deleteList('', 'companies.delete', 'JTOOLBAR_DELETE');
    }

}