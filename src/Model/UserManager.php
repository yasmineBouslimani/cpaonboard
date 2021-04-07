<?php

namespace App\Model;

class UserManager extends AbstractManager
{

    const PERMISSIONS = [
        "manager" => "Manager",
        "director" => "Directeur",
        "admin" => "Administrateur",
    ];
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

    public function selectAllUsersWithContact()
    {

        return $this->pdo->query('SELECT *
    FROM ' . $this->table .
            ' LEFT JOIN contact ON contact.id_contact = users.fk_id_employee')->fetchAll();


    }

    public function getUserWithEmployeeById($id): array
    {
        return $this->pdo->query(
            'SELECT *
    FROM ' . $this->table .
            ' LEFT JOIN contact ON contact.id_contact = users.fk_id_employee
            WHERE users.id_users =' . $id . ';')->fetch();

    }

    public function selectAllActiveUsers(): array
    {
        return $this->pdo->query(
            'SELECT * FROM ' . $this->table .
            ' LEFT JOIN contact ON contact.id_contact = users.fk_id_employee
             WHERE is_active = 1;')->fetchAll();

    }

    public function selectAllInactiveUsers(): array
    {
        return $this->pdo->query(
            'SELECT * FROM ' . $this->table .
            ' LEFT JOIN contact ON contact.id_contact = users.fk_id_employee
             WHERE is_active = 0;')->fetchAll();

    }

    /**
     * @param array $user
     * @return bool
     */
    public function updateUser(array $user): bool
    {

        $statement = $this->pdo->prepare("UPDATE $this->table SET  
                 `login` = :login,  `permissions` =  :permissions, `is_active` = :is_active
WHERE id_users = :id_users");
        $statement->bindValue('id_users', $user['id_users'], \PDO::PARAM_INT);
        $statement->bindValue('login', $user['login'], \PDO::PARAM_STR);
        $statement->bindValue('is_active', $user['is_active'], \PDO::PARAM_INT);
        $statement->bindValue('permissions', $user['permissions'] , \PDO::PARAM_STR);

        return $statement->execute();
    }

}