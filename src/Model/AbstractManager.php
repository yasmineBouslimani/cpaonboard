<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    protected PDO $pdo; //variable de connexion

    protected string $table;

    protected string $className;

    /**
     * Initializes Manager Abstract class.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
        $connection = new Connection();
        $this->pdo = $connection->getPdoConnection();
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function countRecords(): array
    {
        /**
         * Get the number of records in database for a particular table.
         *
         * @return array
         */
        return $this->pdo->query("SELECT COUNT(*) AS countRecords FROM . $this->table")->fetchAll();
    }

    public function SelectEnumValues(string $table, string $enumField): array
    {
        /**
         * Get the number of records in database for a particular table.
         *
         * @return array
         */

        return $this->pdo->query('SHOW COLUMNS FROM ' . $table . ' LIKE \'' . $enumField . '\';')->fetchAll();
    }

    public function insert(string $table, array $recordFields,array $recordFk=null): int
    {
        /**
         * Insert a record in table.
         *
         * @return array
         */
        if (!is_null($recordFk)){
            foreach ($recordFk as $key => $value) {
                $recordFields = array_merge($recordFields, $recordFk);
                var_dump($recordFields);
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
        /**
         * Update a record in table.
         *
         * @return array
         */
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
}