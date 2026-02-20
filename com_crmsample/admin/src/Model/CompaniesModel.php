<?php
namespace CrmSample\Component\Crmsample\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;

class CompaniesModel extends ListModel
{
    public function __construct($config = [])
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'id', 'a.id',
                'name', 'a.name',
                'current_stage', 'a.current_stage',
                'created', 'a.created',
            ];
        }
        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true);

        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.name, a.current_stage, a.created, a.modified'
            )
        )
            ->from($db->quoteName('#__crmsample_companies', 'a'));

        // Фильтр по поиску
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = '%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%');
                $query->where('a.name LIKE :search')
                    ->bind(':search', $search);
            }
        }

        // Фильтр по стадии
        $stage = $this->getState('filter.current_stage');
        if (!empty($stage)) {
            $query->where($db->quoteName('a.current_stage') . ' = :stage')
                ->bind(':stage', $stage);
        }

        // Сортировка
        $orderCol  = $this->state->get('list.ordering', 'a.name');
        $orderDirn = $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}