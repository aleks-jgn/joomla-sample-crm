<?php
namespace CrmSample\Component\Crmsample\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class EventTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__crmsample_events', 'id', $db);
    }

    public function check()
    {
        if (empty($this->company_id) || empty($this->event_type)) {
            $this->setError('Missing required fields');
            return false;
        }
        return true;
    }
}