<?php

namespace App\Model;

class UserManager extends AbstractManager
{

    public const TABLE = 'users';

    const PERMISSIONS = [
        "AU"    => "Administration des utilisateurs",
        "GP"    => "Gestion des produits",
        "GCPP"  => "Gestion des clients professionnels et particuliers",
        "GL"    => "Gestion des litiges",
        "DA"    => "Demande d'achat",
        "GA"    => "Gestion des achats",
        "GV"    => "Gestion des ventes",
        "GC"    => "Gestion des collaborateurs"
    ];

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
                 `login` = :login, `password` = :password, `permissions` =  :permissions, `is_active` = :is_active
WHERE id_users = :id_users");
        $statement->bindValue('id_users', $user['id_users'], \PDO::PARAM_INT);
        $statement->bindValue('login', $user['login'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('is_active', $user['is_active'], \PDO::PARAM_INT);
        $statement->bindValue('permissions', $user['permissions'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function insertUser(array $user): int
    {
        $statement = $this->pdo->prepare(
        "INSERT INTO $this->table (`login`,`password`,`is_active`,
        `permissions`, `fk_id_employee`) 
        VALUES (:login, :password, :is_active, :permissions, :fk_id_employee)");

        $statement->bindValue('login', $user['login'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('is_active', $user['is_active'], \PDO::PARAM_INT);
        $statement->bindValue('permissions', $user['permissions'], \PDO::PARAM_STR);
        $statement->bindValue('fk_id_employee', $user['fk_id_employee'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

}