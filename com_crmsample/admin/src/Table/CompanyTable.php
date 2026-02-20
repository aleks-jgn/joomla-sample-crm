<?php
namespace CrmSample\Component\Crmsample\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class CompanyTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__crmsample_companies', 'id', $db);
    }

    public function check()
    {
        if (empty($this->name)) {
            $this->setError('Name is required');
            return false;
        }
        return true;
    }
}