<?php

namespace PS\Source\Core;

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
        if (file_put_contents($this->fileName, $this->fileContent) !== false && $this->prepareSetterGetter() && $this->prepareClass($this->className)) {
            return true;
        }
        return false;
    }

    private function prepareProperties()
    {
        $entity = include('./entities/' . $this->className . '.php');
        $returnString = '';
        foreach ($entity as $column) {
            if (isset($column['virtual']) && $column['virtual']) {
                continue;
            }
            $returnString = $returnString . '    const ' . strtoupper($column['name']) . ' = \'' . $column['name'] . '\';' . PHP_EOL;
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
                $this->virtualCheck[] = $column['name'];
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
            foreach ($this->virtualCheck as $name) {
                // @todo DAS GEHT SO NICHT!
                $namespace = '\PS\Source\Classes\\' . $this->className;
                $methodVariable = array(new $namespace(), 'get' . ucfirst($name) . '()');
                $test = is_callable($methodVariable, false, $callable_name);
                if (is_callable($methodVariable, true, $callable_name)) {
                    echo $callable_name . ' is not callable! <br>';
                }
                $methodVariable = array(new $this->className(), 'set' . ucfirst($name));
                if (is_callable($methodVariable, true, $callable_name)) {
                    echo $callable_name . ' is not callable! <br>';
                }
            }
            echo 'ClassFile already exists.<br>';
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
