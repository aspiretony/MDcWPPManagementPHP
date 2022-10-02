<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dispositivo Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $sessao
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $numero
 * @property string|null $descricao
 *
 * @property \App\Model\Entity\DispUser[] $disp_users
 */
class Dispositivo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'nome' => true,
        'sessao' => true,
        'token' => true,
        'created' => true,
        'modified' => true,
        'numero' => true,
        'descricao' => true,
        'disp_users' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'token',
    ];
}
