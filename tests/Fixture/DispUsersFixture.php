<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DispUsersFixture
 */
class DispUsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'user_id' => 'd3981415-4165-48d0-a614-6d42179e6a4f',
                'dispositivo_id' => 1,
                'id' => 1,
                'created' => '2022-10-01 22:32:16',
                'modified' => '2022-10-01 22:32:16',
            ],
        ];
        parent::init();
    }
}
