<?php
namespace CrmSample\Component\Crmsample\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class StageHistoryTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__crmsample_stage_history', 'id', $db);
    }
}