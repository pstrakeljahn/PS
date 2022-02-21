<?php

namespace PS\Source\Core;

use Exception;

class DB
{

    public function getByPK(int $id)
    {
        $table = lcfirst(self::getClassName()) . 's';
        $db = new DBConnector();
        $db->query("SELECT * FROM `$table` WHERE ID =:id");
        $db->bind(':id', $id);
        $result =  $db->resultSet();
        if (!count($result)) {
            return null;
        }
        return $this->prepareResult($result)[0];
    }

    public function prepareResult($result): array
    {
        $output = [];
        if ($result) {
            foreach ($result as $row) {
                $instanceName = '\PS\Source\Classes\\' . self::getClassName();
                $selfInstance = new $instanceName();
                foreach ($selfInstance as $key => &$value) {
                    if (ctype_digit($row[$key])) {
                        $row[$key] = (int)$row[$key];
                    }
                    $value = $row[$key];
                }
                $output[] = $selfInstance;
            }
        }
        return $output;
    }

    public function add(string $column, $value, $isNull = null): self
    {
        switch ($isNull) {
            case null:
                $tmpQuery = 'WHERE ' . $column . ' = \'' . $value . '\'';
                break;
            case 'isNotNull':
                $tmpQuery = 'WHERE ' . $column . ' IS NOT NULL';
                break;
            case 'isNull':
                $tmpQuery = 'WHERE ' . $column . ' IS NULL';
                break;
        }

        if (!isset($this->searchString)) {
            $this->searchString = $tmpQuery;
        } else {
            $this->searchString = $this->searchString . ' AND ' . substr($tmpQuery, 6);
        }
        return $this;
    }

    public function orderBy(string $column, string $order)
    {
        if ($order === 'ASC' || $order === 'DESC') {
            $this->orderBy = 'ORDER BY ' . $column . ' ' . $order;
        }
        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function go(): array
    {
        $query = 'SELECT * FROM ' . strtolower(self::getClassName()) . 's ';
        if (isset($this->searchString)) {
            $query = $query  . $this->searchString;
        }
        if (isset($this->orderBy)) {
            $query = $query . ' ' . $this->orderBy;
        }
        if (isset($this->limit)) {
            $query = $query . ' LIMIT ' . $this->limit;
        }
        unset($this->orderBy);
        unset($this->searchString);
        unset($this->limit);
        $db = new DBConnector();
        $db->query($query);
        return $this->prepareResult($db->resultSet());
    }

    public function save()
    {
        if (isset($this->searchString)) {
            unset($this->searchString);
        }
        $this->checkValidity();

        // create a new entry
        $db = new DBConnector();
        if (is_null($this->getID())) {
            $query = 'INSERT INTO ' . strtolower(self::getClassName()) . 's (';
            $valueString = '';
            foreach ($this as $key => $value) {
                if ($key === 'ID') {
                    continue;
                }
                $query = $query . $key . ', ';
                if (is_null($value)) {
                    $valueString = $valueString . 'NULL, ';
                } else {
                    $valueString = $valueString . '\'' . $value . '\'' . ', ';
                }
            }
            $query = substr($query, 0, -2) . ') VALUES (' . substr($valueString, 0, -2) . ');';

            $db->query($query);
            $db->execute();

            $this->{'ID'} = (int)$db->lastInsertId();
            return $this;
        }
        // update entry
        if (!is_null($this->getID())) {
            $query = 'UPDATE ' . strtolower(self::getClassName()) . 's SET';
            $valueString = '';
            foreach ($this as $key => $value) {
                if ($key === 'ID') {
                    $condition = ' WHERE ID = ' . $value . ';';
                    continue;
                }
                if (!is_null($value)) {
                    $value = '\'' . $value . '\'';
                } else {
                    $value = 'NULL';
                }
                $query = $query . ' ' . $key . ' = ' . $value . ', ';
            }
            $query = substr($query, 0, -2) . $condition;
            $db->query($query);
            $db->execute();
            return $this;
        }
        return $this;
    }

    public function delete(): bool
    {
        if (is_null($this->getID())) {
            return false;
        }
        $db = new DBConnector();
        $query = 'DELETE FROM ' . strtolower(self::getClassName()) . 's  WHERE id=' . $this->getID() . ';';
        $db->query($query);
        $db->execute();
        return true;
    }

    public function getID()
    {
        return $this->{'ID'};
    }

    private function checkValidity(): void
    {
        foreach ($this as $key => $value) {
            $instanceName = '\PS\Source\Classes\\' . self::getClassName();
            if (in_array($key, $instanceName::REQUIRED_VALUES) && is_null($this->{$key})) {
                throw new Exception($key . ' is required!');
            }
        }
    }

    protected static function getClassName(): string
    {
        $calledClass = explode('\\', get_called_class());
        return $calledClass[count($calledClass) - 1];
    }
}
