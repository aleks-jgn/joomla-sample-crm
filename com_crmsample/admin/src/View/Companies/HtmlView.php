<?php
namespace CrmSample\Component\Crmsample\Administrator\View\Companies;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class HtmlView extends BaseHtmlView
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        $this->items      = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state      = $this->get('State');

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_CRMSAMPLE_COMPANIES_TITLE'), 'address');
        ToolbarHelper::addNew('company.add');
        ToolbarHelper::editList('company.edit');
        ToolbarHelper::deleteList('', 'companies.delete');
    }
}