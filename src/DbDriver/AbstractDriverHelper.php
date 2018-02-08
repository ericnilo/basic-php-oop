<?php

namespace DbDriver;

abstract class AbstractDriverHelper
{
    protected $mysqlTypes;

    protected function createInsertStatement($tableName, $insertData)
    {
        $columnDetails = implode(', ', array_keys($insertData));
        $values        = array_values($insertData);
        list($mask, $type) = $this->getInsertMaskAndTypes($values);

        return [
            'INSERT INTO ' . $tableName . ' ( ' . $columnDetails . ' ) ' . ' VALUES ( ' . $mask . ')',
            $values,
            $type
        ];
    }

    private function getInsertMaskAndTypes($values)
    {
        $mask = '';
        $type = [];

        foreach ($values as $value) {
            $mask .= '?, ';
            $type[] = $this->mysqlTypes[gettype($value)];
        }

        $mask = rtrim($mask, ', ');

        return [
            $mask,
            $type
        ];
    }
}
