<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use PDOException;
use Exception;

/**
 * Class managing user persistency and password hash
 */
class UserManager extends AbstractClassManager
{
    /**
     * Encrypt user defined password, to be used before
     * recording user details in the database.
     * 
     * @param string $password Plain text password to be hashed
     * 
     * @return string Hashed password
     */
    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }


    public function addUser(User $user): void
    {
        try {

            $sql = 'INSERT INTO user 
                (pseudo, email, password, photo, creation_date) 
                VALUES (:pseudo, :email, :password, :photo, NOW())';

            $this->database->query($sql, [
                'pseudo' => $user->getPseudo(),
                'email' => $user->getEmail(),
                'password' => $this->hashPassword($user->getPassword()),
                'photo' => $user->getPhoto()
            ]);

            $pdo = $this->database->getPDO();
            $user->setId((int) $pdo->lastInsertId());
            $user->setCreationDate(new DateTime());
        } catch (PDOException $e) {

            if ($e->getCode() == '23000') {
                throw new Exception("Le pseudo ou l'email est déjà utilisé.");
            }

            // throw new Exception("Erreur lors de la création de l'utilisateur");
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    public function getUserByEmail(string $email): ?User
    {
        try {

            $sql = 'SELECT * FROM user WHERE email = :email';

            $result = $this->database->query($sql, [
                'email' => $email
            ]);

            $dbUser = $result->fetch();
            $user = new User(
                $dbUser['pseudo'],
                $dbUser['email'],
                $dbUser['password'],
                $dbUser['photo'],
                $dbUser['id'],
                new DateTime($dbUser['creation_date'])
            );

            return $user;
        } catch (PDOException $e) {

            if ($e->getCode() == '23000') {
                throw new Exception("Le pseudo ou l'email est déjà utilisé.");
            }

            // throw new Exception("Erreur lors du chargement de l'utilisateur");
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    public function authenticate(User $user, string $email, string $password): bool
    {
        if ($user->getEmail() === $email && password_verify($password, $user->getPassword())) {
            return true;
        } else {
            return false;
        }
    }
}
