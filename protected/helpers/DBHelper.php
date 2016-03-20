<?php

/**
 * хелпер для работы с таблицами
 *
 * Created by PhpStorm.
 * User: Alexius
 * Date: 13.03.2016
 * Time: 20:52
 */
class DBHelper
{
    /**
     * обновляет строки в таблице
     * @param mixed $connection
     * @param string $tbl
     * @param array $values
     * @param array $where
     * @return bool
     */
    public static function updateTbl($connection, $tbl = '', $values = array(), $where = array() )
    {
        $sql = "UPDATE $tbl SET " . implode(', ', $values) . '  WHERE ' .  implode(' AND ', $where);
        //  echo'<pre>';print_r($sql);echo'</pre>';die;
        $command = $connection->createCommand($sql);
        $res = $command->execute();
        return $res;
    }

}