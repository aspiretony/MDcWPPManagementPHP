<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DispUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DispUsersTable Test Case
 */
class DispUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DispUsersTable
     */
    protected $DispUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.DispUsers',
        'app.Users',
        'app.Dispositivos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DispUsers') ? [] : ['className' => DispUsersTable::class];
        $this->DispUsers = $this->getTableLocator()->get('DispUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DispUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DispUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DispUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
