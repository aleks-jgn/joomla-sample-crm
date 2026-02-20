<?php
namespace CrmSample\Component\Crmsample\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

class CompanyController extends FormController
{
    protected $default_view = 'company';

    public function addEvent()
    {
        $this->checkToken();

        $app = Factory::getApplication();
        $companyId = $app->input->getInt('company_id');
        $eventType = $app->input->getCmd('event_type');
        $eventData = $app->input->get('event_data', [], 'array');

        $model = $this->getModel('Company');

        try {
            $model->processEvent($companyId, $eventType, $eventData);
            $this->setMessage('Event recorded successfully.');
        } catch (\Exception $e) {
            $this->setMessage($e->getMessage(), 'error');
        }

        $this->setRedirect(Route::_('index.php?option=com_crmsample&view=company&layout=edit&id=' . $companyId, false));
    }

    public function delete()
    {
        $this->checkToken();

        $ids = $this->input->get('cid', [], 'array');
        $model = $this->getModel('Company');

        if ($model->delete($ids)) {
            $this->setMessage('Companies deleted.');
        } else {
            $this->setMessage('Error deleting companies', 'error');
        }

        $this->setRedirect(Route::_('index.php?option=com_crmsample&view=companies', false));
    }
}