<?php
namespace CrmSample\Component\Crmsample\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;

class EventModel extends ListModel
{
    public function __construct($config = [])
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'id', 'a.id',
                'company_id', 'a.company_id',
                'event_type', 'a.event_type',
                'created', 'a.created',
            ];
        }
        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true);

        $query->select('a.*')
            ->from($db->quoteName('#__crmsample_events', 'a'));

        // Фильтр по компании
        $companyId = $this->getState('filter.company_id');
        if (!empty($companyId)) {
            $query->where($db->quoteName('a.company_id') . ' = :companyId')
                ->bind(':companyId', $companyId, ParameterType::INTEGER);
        }

        // Сортировка
        $orderCol  = $this->state->get('list.ordering', 'a.created');
        $orderDirn = $this->state->get('list.direction', 'DESC');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }

    /**
     * Получить события для конкретной компании
     */
    public function getEventsByCompany($companyId)
    {
        $this->setState('filter.company_id', $companyId);
        return $this->getItems();
    }
}