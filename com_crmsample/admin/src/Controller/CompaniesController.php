<?php
namespace CrmSample\Component\Crmsample\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;

class CompaniesController extends AdminController
{
    protected $default_view = 'companies';

    public function getModel($name = 'Company', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
}