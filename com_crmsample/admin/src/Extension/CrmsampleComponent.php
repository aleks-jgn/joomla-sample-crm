<?php
namespace CrmSample\Component\Crmsample\Administrator\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;

class CrmsampleComponent extends MVCComponent implements RouterServiceInterface
{
    use RouterServiceTrait;
}