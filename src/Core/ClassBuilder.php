<?php

namespace PS\Source\Core;

use Exception;
use PS\Source\Core\DBConnector;

class ClassBuilder extends DBConnector
{

    public function __construct()
    {
        $this->arrEntitites = glob('./entities/*.php');
    }

    public function buildClass()
    {

        foreach ($this->arrEntitites as $entity) {
            // @todo DAS MUSS NOCH BESSER!
            $arrPath = explode(DIRECTORY_SEPARATOR, $entity);
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
        }
    }

    private function checkEntityValidity($arrEntity): bool
    {
        $check = 0;
        foreach ($arrEntity as $entity) {
            if (
                isset($entity['name']) && isset($entity['type']) &&
                ($entity['type'] !== 'enum' && isset($entity['length']) || $entity['type'] === 'enum' && isset($entity['values'])) || ($entity['type'] === 'datetime' && !isset($entity['length']))
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
            } else {
                $query = $query . "`" . $entity['name'] . "` " . $entity['type'] . "(" . $entity['length'] . ") ";
            }
            if (isset($entity['notnull']) && $entity['notnull']) {
                $query = $query . "NOT NULL";
            }

            $query = $query . ",";
        }
        $query = $query . "PRIMARY KEY  (`ID`)) ENGINE = InnoDB;";
        $db = new DBConnector();
        $db->query($query);
        $test = $db->execute();
        return $test;
    }

    private function generateBasicClass(string $className): bool
    {
        $initClass = new BuildClassFile($className);
        return $initClass->execute();
    }
}
