<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DispositivosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DispositivosTable Test Case
 */
class DispositivosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DispositivosTable
     */
    protected $Dispositivos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Dispositivos',
        'app.DispUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dispositivos') ? [] : ['className' => DispositivosTable::class];
        $this->Dispositivos = $this->getTableLocator()->get('Dispositivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Dispositivos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DispositivosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
