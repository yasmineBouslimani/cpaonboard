<?php

namespace App\Model;

use PDO;

abstract class AbstractManager
{
    protected PDO $pdo; //variable de connexion

    protected string $table;

    protected string $className;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
        $connection = new Connection();
        $this->pdo = $connection->getPdoConnection();
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id_".$this->table."=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function countRecords(): array
    {
        return $this->pdo->query('SELECT COUNT(*) AS countRecords FROM ' . $this->table)->fetchAll();
    }

    public function selectEnumValues(string $table, string $enumField): array
    {
        return $this->pdo->query('SHOW COLUMNS FROM ' . $table . ' LIKE \'' . $enumField . '\';')->fetchAll();
    }

    public function insert(string $table, array $recordFields,array $recordFk=null): int
    {
        if (!is_null($recordFk)){
            foreach ($recordFk as $key => $value) {
                $recordFields = array_merge($recordFields, $recordFk);
            }
        }
        $labelsToUpdate = ' (';
        $valuesToUpdate = ' (';
        foreach($recordFields as $key => $value) {
            $labelsToUpdate = $labelsToUpdate . '`' . $key . '`,';
            $valuesToUpdate = $valuesToUpdate . '\'' . $value . '\',';
        }
        $labelsToUpdate = substr($labelsToUpdate, 0, -1);
        $labelsToUpdate = $labelsToUpdate . ')';
        $valuesToUpdate = substr($valuesToUpdate, 0, -1);
        $valuesToUpdate = $valuesToUpdate . ')';

        // prepared request
        $statement = $this->pdo->prepare('INSERT INTO ' . $table . $labelsToUpdate .' VALUES ' . $valuesToUpdate);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(string $table, array $recordFields): bool
    {
        $idFieldName = 'id_' . $table;
        $id = $recordFields[$idFieldName];
        $fieldsToUpdate = ' SET ';
        foreach($recordFields as $key => $value) {
            $fieldsToUpdate = $fieldsToUpdate . '`' . $key . '`=\'' . $value . '\',';
        }
        $fieldsToUpdate = substr($fieldsToUpdate, 0, -1);
        $statement = $this->pdo->prepare(
            'UPDATE ' . $table . $fieldsToUpdate . ' WHERE `' . $idFieldName . '`='. $id);
        $statement->execute();
        return $id;
    }

    public function delete(string $table, int $idRecord)
    {
        $idFieldName = 'id_' . $table;
        $statement = $this->pdo->prepare('DELETE FROM '. $table. ' WHERE `' . $idFieldName . '`='. $idRecord);
        $statement->execute();
    }

    public function GetIdRecordsByForeignKeys(string $table, string $foreignKeyField, int $foreignKeyValue): array
    {
        $idFieldName = 'id_' . $table;
        $statement = $this->pdo->prepare(
            'Select ' . $idFieldName . ' FROM '. $table. ' WHERE `' . $foreignKeyField . '`='. $foreignKeyValue);
        $statement->execute();
        return $statement->fetchAll();
    }
}