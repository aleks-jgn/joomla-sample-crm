<?php
namespace CrmSample\Component\Crmsample\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class EventModel extends ListModel
{
    public function getListQuery()
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true);
        $query->select('*')
            ->from($db->quoteName('#__crmsample_events'))
            ->order('created DESC');

        // Filter by company if set
        $companyId = $this->getState('filter.company_id');
        if ($companyId) {
            $query->where($db->quoteName('company_id') . ' = :companyId')
                ->bind(':companyId', $companyId, ParameterType::INTEGER);
        }

        return $query;
    }

    public function getEventsByCompany($companyId)
    {
        $this->setState('filter.company_id', $companyId);
        return $this->getItems();
    }
}