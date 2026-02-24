<?php
namespace CrmSample\Tests\Unit;

use CrmSample\Component\Crmsample\Administrator\Model\CompanyModel;
use PHPUnit\Framework\TestCase;

class CompanyModelTest extends TestCase
{
    /**
     * @dataProvider stageActionProvider
     */
    public function testGetAvailableActions($stage, $expectedActions)
    {
        $model = new CompanyModel();
        $actions = $model->getAvailableActions($stage);
        $this->assertEquals($expectedActions, $actions);
    }

    public function stageActionProvider()
    {
        return [
            ['Ice', ['contact_attempt']],
            ['Touched', ['executive_conversation']],
            ['Aware', ['discovery_filled']],
            ['Interested', ['demo_planned']],
            ['demo_planned', ['demo_done']],
            ['Demo_done', ['invoice_issued']],
            ['Committed', ['payment_received']],
            ['Customer', ['certificate_issued']],
            ['Activated', []],
            ['UnknownStage', []],
        ];
    }

    /**
     * @dataProvider transitionProvider
     */
    public function testGetNextStageForEvent($currentStage, $eventType, $eventData, $expectedStage)
    {
        $model = $this->getMockBuilder(CompanyModel::class)
            ->onlyMethods(['canTransition'])
            ->getMock();
        $model->method('canTransition')->willReturn(true);

        // Используем рефлексию для доступа к protected-методу
        $reflection = new \ReflectionMethod($model, 'getNextStageForEvent');

        $result = $reflection->invokeArgs($model, [$currentStage, $eventType, $eventData]);
        $this->assertEquals($expectedStage, $result);
    }

    public function transitionProvider()
    {
        return [
            'Ice + contact_attempt -> Touched' => ['Ice', 'contact_attempt', [], 'Touched'],
            'Touched + executive_conversation -> Aware' => ['Touched', 'executive_conversation', [], 'Aware'],
            'Aware + discovery_filled -> Interested' => ['Aware', 'discovery_filled', [], 'Interested'],
            'Interested + demo_planned (with datetime) -> demo_planned' => ['Interested', 'demo_planned', ['datetime' => '2025-01-01T12:00'], 'demo_planned'],
            'Interested + demo_planned (no datetime) -> null' => ['Interested', 'demo_planned', [], null],
            'demo_planned + demo_done -> Demo_done' => ['demo_planned', 'demo_done', [], 'Demo_done'],
            'Demo_done + invoice_issued -> Committed' => ['Demo_done', 'invoice_issued', [], 'Committed'],
            'Committed + payment_received -> Customer' => ['Committed', 'payment_received', [], 'Customer'],
            'Customer + certificate_issued -> Activated' => ['Customer', 'certificate_issued', [], 'Activated'],
        ];
    }

    /**
     * Тест метода canTransition с моком базы данных.
     */
    public function testCanTransition()
    {
        // Создаём мок базы данных Joomla
        $db = $this->createMock(\Joomla\Database\DatabaseDriver::class);
        $query = $this->createMock(\Joomla\Database\DatabaseQuery::class);

        $db->method('getQuery')->willReturn($query);
        $query->method('select')->willReturnSelf();
        $query->method('from')->willReturnSelf();
        $query->method('where')->willReturnSelf();
        $query->method('bind')->willReturnSelf();

        // Эмулируем результат запроса (JSON со списком разрешённых стадий)
        $db->method('loadResult')->willReturn('["Touched","Aware"]');

        $model = $this->getMockBuilder(CompanyModel::class)
            ->onlyMethods(['getDatabase'])
            ->getMock();
        $model->method('getDatabase')->willReturn($db);

        $reflection = new \ReflectionMethod($model, 'canTransition');

        $this->assertTrue($reflection->invokeArgs($model, ['Ice', 'Touched']));
        $this->assertFalse($reflection->invokeArgs($model, ['Ice', 'Activated']));
    }
}