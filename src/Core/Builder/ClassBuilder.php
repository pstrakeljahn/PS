<?php

namespace PS\Source\Core\Builder;

use Exception;
use PS\Source\Core\DBConnector;

class ClassBuilder extends DBConnector
{
    const KEYWORDS = ['CASCADE', 'SET NULL', 'NO ACTION', 'RESTRICT'];

    public function __construct()
    {
        $this->keyConstraints = [];
        $this->arrEntitites = glob('./entities/*.php');
    }

    public function buildClass()
    {

        foreach ($this->arrEntitites as $entity) {
            // @todo DAS MUSS NOCH BESSER!
            $arrPath = explode(DIRECTORY_SEPARATOR, $entity);
            // @todo this might be wrong!!!
            $className = ucfirst(substr($arrPath[count($arrPath) - 1], 11, -4));

            // Check Validity
            if (!$this->checkEntityValidity(include $entity)) {
                throw new Exception('Invalid Entity ' . $className);
            };

            // @todo ALTERLOGIK FEHLT HIER NOCH!
            if (!$this->generateTables($className, include $entity)) {
                $e = new \Exception('Cannot create Table ' . $className . 's!');
                throw $e;
            }
            echo 'Table ' . strtolower($className) . 's created.<br>';
            if (!$this->generateBasicClass($className)) {
                throw new \Exception('Cannot create BasicClass ' . $className);
            }
            echo 'BasicClass ' . $className . ' created.<br><br>';
            $this->fetchKeyConstraints();
        }
    }

    private function fetchKeyConstraints()
    {
        foreach ($this->keyConstraints as $query) {
            $db = new DBConnector();
            $db->query($query);
            $db->execute();
        }
    }

    private function checkEntityValidity($arrEntity): bool
    {
        $check = 0;
        foreach ($arrEntity as $entity) {
            if (
                isset($entity['name']) && isset($entity['type']) &&
                ($entity['type'] === 'bool' || $entity['type'] !== 'enum' && isset($entity['length']) || $entity['type'] === 'enum' && isset($entity['values'])) || ($entity['type'] === 'datetime' && !isset($entity['length']))
            ) {
                continue;
            }
            $check++;
        }
        return $check > 0 ? false : true;
    }

    private function generateTables(string $className, array $arrEntity): bool
    {
        $query = "CREATE TABLE IF NOT EXISTS `" . strtolower($className) . "s` (";

        // HIER KANN NOCH NE KONDITION REIN. ERSTMAL IMMER MIT ID 
        if (true) {
            $query = $query . "`ID` int(11) unsigned NOT NULL auto_increment,";
        }
        foreach ($arrEntity as $entity) {
            if ($entity['type'] === 'enum') {
                if (!isset($entity['values']) || is_null($entity['values'])) {
                    throw new Exception('In case you want to use an enum, insert values!');
                } else {
                    $enumValues = '';
                    foreach ($entity['values'] as $value) {
                        $enumValues = $enumValues . '\'' . $value . '\',';
                    }
                    $enumValues = trim($enumValues, ",");
                }
                $query = $query . "`" . $entity['name'] . "` ENUM (" . $enumValues . ") ";
            } elseif ($entity['type'] === 'datetime') {
                $query = $query . "`" . $entity['name'] . "` " . $entity['type'] . " ";
            } elseif ($entity['type'] === 'bool') {
                $query = $query . "`" . $entity['name'] . "` boolean ";
            } else {
                $query = $query . "`" . $entity['name'] . "` " . $entity['type'] . "(" . $entity['length'] . ") ";
            }
            if (isset($entity['notnull']) && $entity['notnull']) {
                $query = $query . "NOT NULL";
            }
            if (isset($entity['unique']) && $entity['unique']) {
                $query = $query . " UNIQUE";
            }
            if ($entity['type'] === 'bool' && isset($entity['default'])) {
                if ($entity['default'] === true || $entity['default'] === false) {
                    $default = $entity['default'] ? '1' : '0';
                    $query = $query . "DEFAULT " . $default;
                }
            }
            if (isset($entity['reference']) && $entity['ref_column'] && isset($entity['ref_update']) && isset($entity['ref_delete'])) {
                $onUpdate = strtoupper($entity['ref_update']);
                $onDelete = strtoupper($entity['ref_delete']);
                if (in_array($onUpdate, self::KEYWORDS) && in_array($onDelete, self::KEYWORDS)) {
                    $this->keyConstraints[] = 'ALTER TABLE `' . strtolower($className) . 's` CHANGE `' . $entity['name'] . '` `' . $entity['name'] . '` INT(11) UNSIGNED';
                    $this->keyConstraints[] = 'ALTER TABLE `' . strtolower($className) . 's` ADD CONSTRAINT `FK_' . $entity['reference'] . $className . '` FOREIGN KEY (`' . $entity['name'] . '`) REFERENCES `' . strtolower($entity['reference']) . 's`(`' . $entity['ref_column'] . '`) ON DELETE ' . $onDelete . ' ON UPDATE ' . $onUpdate;
                }
            }

            $query = $query . ",";
        }
        $query = $query . "PRIMARY KEY  (`ID`)) ENGINE = InnoDB;";
        $db = new DBConnector();
        $db->query($query);
        return $db->execute();
    }

    private function generateBasicClass(string $className): bool
    {
        $initClass = new BuildClassFile($className);
        return $initClass->execute();
    }
}
