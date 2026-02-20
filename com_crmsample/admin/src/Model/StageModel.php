<?php
namespace CrmSample\Component\Crmsample\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class StageModel extends ListModel
{
    public function getListQuery()
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true);
        $query->select('*')
            ->from($db->quoteName('#__crmsample_stages'))
            ->order('ordering');
        return $query;
    }
}