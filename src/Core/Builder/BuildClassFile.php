<?php

namespace PS\Source\Core\Builder;

class BuildClassFile
{

    public function __construct(string $className)
    {
        $this->className = $className;
        $this->fileName = './src/BasicClasses/' . $className . 'Basic.php';
        $this->templatePath = './src/Core/templates/';
        $this->fileContent = file_get_contents($this->templatePath . 'basicClassTemplate.txt');
        $this->fileContentGetterSetter = file_get_contents($this->templatePath . 'getterSetterTemplate.txt');
    }

    public function execute(): bool
    {
        $this->fileContent = str_replace('###seperator###', "explode('\\\', __CLASS__);", $this->fileContent);
        $this->fileContent = str_replace('###className###', $this->className, $this->fileContent);
        $this->fileContent = str_replace('###definitionOfAttr###', $this->prepareProperties(), $this->fileContent);
        $this->prepareRequiredValues();
        if (file_put_contents($this->fileName, $this->fileContent) !== false && $this->prepareSetterGetter() && $this->prepareClass($this->virtualCheck)) {
            return true;
        }
        return false;
    }

    private function prepareProperties()
    {
        $entity = include('./entities/' . $this->className . '.php');
        $returnString = '    const ID = \'ID\';' . PHP_EOL;;
        foreach ($entity as $column) {
            if (isset($column['virtual']) && $column['virtual']) {
                continue;
            }
            $returnString = $returnString . '    const ' . strtoupper($column['name']) . ' = \'' . $column['name'] . '\';' . PHP_EOL;
            if ($column['type'] === 'enum') {
                foreach ($column['values'] as $value) {
                    $returnString = $returnString . '    const ENUM_' . strtoupper($column['name']) . '_' . strtoupper($value) . ' = \'' . $value . '\';' . PHP_EOL;
                }
            }
        }
        return $returnString;
    }

    private function prepareSetterGetter(): bool
    {
        $entity = include('./entities/' . $this->className . '.php');
        // ID IS HARDCODED!
        $concatString = '';
        foreach ($entity as $column) {
            $this->virtualCheck = [];
            if (isset($column['virtual']) && $column['virtual']) {
                continue;
            }
            $concatString = $concatString . $this->fileContentGetterSetter;
            $concatString = str_replace('###value###', $column['name'], $concatString);
            $concatString = str_replace('###VALUE###', ucfirst($column['name']), $concatString);
        }
        if (file_put_contents($this->fileName, $concatString, FILE_APPEND | LOCK_EX) === false) {
            return false;
        }
        if (file_put_contents($this->fileName, '}', FILE_APPEND | LOCK_EX) === false) {
            return false;
        }
        return true;
    }

    private function prepareClass(): bool
    {
        $fileName = './src/Classes/' . $this->className . '.php';
        if (file_exists($fileName)) {
            $entity = include('./entities/' . $this->className . '.php');
            foreach ($entity as $column) {
                if (isset($column['virtual']) && $column['virtual']) {
                    $namespace = '\PS\Source\Classes\\' . $this->className;
                    if (!method_exists(new $namespace(), 'get' . ucfirst($column['name']))) {
                        echo $namespace. '::get' . ucfirst($column['name']) . '() is not callable! <br>';
                    }
                    if (!method_exists(new $namespace(), 'set' . ucfirst($column['name']))) {
                        echo $namespace. '::set' . ucfirst($column['name']) . '() is not callable! <br>';
                    }
                }
            }
            return true;
        }
        $fileContent = file_get_contents($this->templatePath . 'classTemplate.txt');
        $fileContent = str_replace('###className###', $this->className, $fileContent);
        if (file_put_contents($fileName, $fileContent) === false) {
            return false;
        }

        //check virtual values
        return true;
    }

    private function prepareRequiredValues(): void
    {
        $entititeFile = glob('./entities/' . $this->className . '.php')[0];
        $this->requiredValues = [];
        foreach (include $entititeFile as $entity) {
            if (isset($entity['required']) && $entity['required']) {
                array_push($this->requiredValues, $entity['name']);
            }
        }
        $requiredValuesString = '\'' . implode("', '", $this->requiredValues) . '\'';
        if ($requiredValuesString === "''") {
            $requiredValuesString = substr($requiredValuesString, 0, -2);
        }
        $this->fileContent = str_replace('###requiredValues###', $requiredValuesString, $this->fileContent);
    }
}
