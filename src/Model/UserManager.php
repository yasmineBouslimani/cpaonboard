<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneByUserLogin(string $userLogin)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE `login` = :login");
        $statement->bindValue('login', $userLogin, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}