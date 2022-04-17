<?php

use Adianti\Database\TTransaction;

/**
 * SystemChangeLogTrait
 *
 * @version    1.0
 * @package    model
 * @subpackage log
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
trait SystemChangeLogTrait
{
    public function onAfterDelete( $object )
    {
        $deletedat = self::getDeletedAtColumn();
        if ($deletedat)
        {
            $lastState = (array) $object;

            $info = TTransaction::getDatabaseInfo();
            $date_mask = (in_array($info['type'], ['sqlsrv', 'dblib', 'mssql'])) ? 'Ymd H:i:s' : 'Y-m-d H:i:s';
            $object->{$deletedat} = date($date_mask);

            SystemChangeLogService::register($this, $lastState, (array) $object);
        }
        else
        {
            SystemChangeLogService::register($this, $object, array());
        }
    }
    
    public function onBeforeStore($object)
    {
        $pk = $this->getPrimaryKey();
        $this->lastState = array();
        if (isset($object->$pk) and self::exists($object->$pk))
        {
            $this->lastState = parent::load($object->$pk, TRUE)->toArray();
        }
    }
    
    public function onAfterStore($object)
    {
        SystemChangeLogService::register($this, $this->lastState, (array) $object);
    }
}
