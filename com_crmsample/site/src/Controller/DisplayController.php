<?php
namespace CrmSample\Component\Crmsample\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

class DisplayController extends BaseController
{
    public function display($cachable = false, $urlparams = array())
    {
        // Для сайта ничего не делаем, просто заглушка
        parent::display($cachable, $urlparams);
    }
}