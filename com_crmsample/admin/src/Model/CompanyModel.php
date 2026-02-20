<?php
namespace CrmSample\Component\Crmsample\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\User\User;
use Joomla\Database\ParameterType;

class CompanyModel extends AdminModel
{
    public function getTable($name = 'Company', $prefix = 'Administrator', $options = array())
    {
        return parent::getTable($name, $prefix, $options);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_crmsample.company', 'company', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    protected function prepareTable($table)
    {
        if (empty($table->current_stage)) {
            $table->current_stage = 'Ice';
        }
    }

    protected function loadFormData()
    {
        $data = Factory::getApplication()->getUserState('com_crmsample.edit.company.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }
        return $data;
    }

    /**
     * Returns available actions (events) for a given stage.
     */
    public function getAvailableActions($stage)
    {
        $stage = $stage ?? 'Ice'; // защита от null
        $actions = [];
        switch ($stage) {
            case 'Ice':
                $actions[] = 'contact_attempt';
                break;
            case 'Touched':
                $actions[] = 'executive_conversation';
                break;
            case 'Aware':
                $actions[] = 'discovery_filled';
                break;
            case 'Interested':
                $actions[] = 'demo_planned';
                break;
            case 'demo_planned':
                $actions[] = 'demo_done';
                break;
            case 'Demo_done':
                $actions[] = 'invoice_issued';
                break;
            case 'Committed':
                $actions[] = 'payment_received';
                break;
            case 'Customer':
                $actions[] = 'certificate_issued';
                break;
            default:
                // No actions
        }
        return $actions;
    }

    /**
     * Process an event and possibly transition stage.
     */
    public function processEvent($companyId, $eventType, $eventData)
    {
        $db = $this->getDatabase();
        $company = $this->getItem($companyId);
        if (!$company) {
            throw new \Exception('Company not found');
        }

        // Save event
        $eventTable = $this->getTable('Event', 'Administrator');
        $eventDataForDb = json_encode($eventData);
        $eventDataObj = (object) [
            'company_id' => $companyId,
            'event_type' => $eventType,
            'event_data' => $eventDataForDb,
        ];
        if (!$eventTable->save($eventDataObj)) {
            throw new \Exception('Could not save event');
        }

        // Determine if this event triggers a stage transition
        $nextStage = $this->getNextStageForEvent($company->current_stage, $eventType, $eventData);
        if ($nextStage) {
            // Check if transition is allowed by stage rules (using allow_skip_to)
            if ($this->canTransition($company->current_stage, $nextStage)) {
                $oldStage = $company->current_stage;
                $company->current_stage = $nextStage;
                // Save company
                
                $companyTable = $this->getTable('Company');
                $companyData = (array) $company;
                if (!$companyTable->save($companyData)) {
                    throw new \Exception('Could not update company stage');
                }

                /*
                if (!$this->save((array) $company)) {
                    throw new \Exception('Could not update company stage');
                }
                */

                // Log stage history
                $historyTable = $this->getTable('StageHistory', 'Administrator');
                $user = Factory::getApplication()->getIdentity();
                $historyData = (object) [
                    'company_id' => $companyId,
                    'from_stage' => $oldStage,
                    'to_stage'   => $nextStage,
                    'user_id'    => $user->id,
                ];
                $historyTable->save($historyData);
            } else {
                // Transition not allowed by stage rules – we still log event but no transition
                // For prototype, we ignore
            }
        }

        return true;
    }

    /**
     * Determine next stage based on current stage and event.
     */
    protected function getNextStageForEvent($currentStage, $eventType, $eventData)
    {
        // Hardcoded mapping based on task
        $map = [
            'Ice' => ['contact_attempt' => 'Touched'],
            'Touched' => ['executive_conversation' => 'Aware'],
            'Aware' => ['discovery_filled' => 'Interested'],
            'Interested' => ['demo_planned' => 'demo_planned'],
            'demo_planned' => ['demo_done' => 'Demo_done'],
            'Demo_done' => ['invoice_issued' => 'Committed'],
            'Committed' => ['payment_received' => 'Customer'],
            'Customer' => ['certificate_issued' => 'Activated'],
        ];

        if (isset($map[$currentStage][$eventType])) {
            // Additional checks
            if ($eventType === 'demo_planned') {
                if (empty($eventData['datetime'])) {
                    return null;
                }
            }
            if ($eventType === 'demo_done') {
                // optional: check if link present
            }
            return $map[$currentStage][$eventType];
        }
        return null;
    }

    /**
     * Check if transition from current to target is allowed based on stage rules.
     */
    protected function canTransition($fromStage, $toStage)
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('allow_skip_to'))
            ->from($db->quoteName('#__crmsample_stages'))
            ->where($db->quoteName('stage_code') . ' = :stage')
            ->bind(':stage', $fromStage);
        $db->setQuery($query);
        $allowJson = $db->loadResult();
        if (!$allowJson) {
            return false;
        }
        $allowed = json_decode($allowJson, true) ?: [];
        return in_array($toStage, $allowed);
    }
}