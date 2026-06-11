<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use Exception;
use PDOException;

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

    /**
     * Add a new user to the database.
     * 
     * Only valid if the pseudo and email are not
     * already used by another user.
     * 
     * @param User $user User object to be added to the database
     *      
     */
    public function addUser(User $user): void
    {
        try {

            $sql = 'INSERT INTO user 
                (pseudo, email, password, photo, creation_date) 
                VALUES (:pseudo, :email, :password, :photo, NOW())';

            $this->database->query(
                $sql,
                [
                    'pseudo' => $user->getPseudo(),
                    'email' => $user->getEmail(),
                    'password' => $this->hashPassword($user->getPassword()),
                    'photo' => $user->getPhoto(),
                ]
            );

            $pdo = $this->database->getPDO();
            $user->setId((int) $pdo->lastInsertId());
            $user->setCreationDate(new DateTime());
            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Check if a pseudo is already in use
     * 
     * @param string $pseudo Pseudo to be checked
     */
    public function isPseudoExist(string $pseudo): bool
    {
        try {
            $sql = 'SELECT COUNT(*) FROM user WHERE pseudo = :pseudo';

            $result = $this->database->query($sql, [
                'pseudo' => $pseudo
            ]);

            $count = $result->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {

            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Check if an email is already in use
     * 
     * @param string $email Email to be checked
     */
    public function isEmailExist(string $email): bool
    {
        try {
            $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

            $result = $this->database->query($sql, [
                'email' => $email
            ]);

            $count = $result->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {

            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Get a user by his/her email.
     * 
     * @param string $email
     * 
     * @return ?User Return a user, used for authentication.
     */
    public function getUserByEmail(string $email): ?User
    {
        try {
            $sql = 'SELECT * FROM user WHERE email = :email';

            $result = $this->database->query($sql, [
                'email' => $email
            ]);

            $dbUser = $result->fetch();
            if ($dbUser === false) {
                return null;
            }

            $user = new User(
                $dbUser['pseudo'],
                $dbUser['email'],
                $dbUser['password'],
                $dbUser['photo'],
                $dbUser['id'],
                new DateTime($dbUser['creation_date'])
            );

            unset($dbUser);
            return $user;
        } catch (PDOException $e) {
            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Get a user by its id.
     * 
     * @param int $id
     * 
     * @return ?User Returns a user without password or null.
     */
    public function getUserById(int $id): ?User
    {
        try {
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $this->database->query($sql, [
                'id' => $id
            ]);

            $dbUser = $result->fetch();
            if ($dbUser === false) {
                return null;
            }

            $user = new User(
                $dbUser['pseudo'],
                $dbUser['email'],
                // We provide the user without password
                '',
                $dbUser['photo'],
                $dbUser['id'],
                new DateTime($dbUser['creation_date'])
            );

            unset($dbUser);
            return $user;
        } catch (PDOException $e) {
            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Get a user by its pseudo
     * 
     * @param string $pseudo
     * 
     * @return ?User Returns a user without password and without email.
     */
    public function getUserByPseudo(string $pseudo): ?User
    {
        try {
            $sql = 'SELECT * FROM user WHERE pseudo = :pseudo';

            $result = $this->database->query($sql, [
                'pseudo' => $pseudo
            ]);

            $dbUser = $result->fetch();
            if ($dbUser === false) {
                return null;
            }

            $user = new User(
                $dbUser['pseudo'],
                '',
                // We provide the user without email
                // and password.
                '',
                $dbUser['photo'],
                $dbUser['id'],
                new DateTime($dbUser['creation_date'])
            );

            unset($dbUser);
            return $user;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }

    /**
     * Authenticate a user.
     * 
     * @param User $user User to authenticate.
     * @param string $email Email provided by the visitor to log in.
     * @param string $password Password proved by the visitor to login.
     * 
     * @return bool Returns true if authentication is successful, false if not.
     */
    public function authenticate(User $user, string $email, string $password): bool
    {
        if ($user->getEmail() === $email && password_verify($password, $user->getPassword())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update user function.
     * 
     * Allow a user to update his/her pseudo, mail, password and/or photo.
     * 
     * @param User $user User to update.
     * @param string $newPseudo New pseudo to be recorded in specified user.
     * @param string $newEmail New email to be recorded in specified user.
     * @param string $newPassword New password to be recorded in specified user.
     * @param string $newPhoto New photo to be recorded in specified user.
     */
    public function updateUser(
        User $user,
        string $newPseudo,
        string $newEmail,
        string $newPassword,
        string $newPhoto
    ): void {

        try {
            // Managing to keep unchanged recorded photo if receiving a '' url.
            $sql = 'SELECT * FROM user WHERE id = :id';
            $result = $this->database->query($sql, ['id' => $user->getId()]);
            $row = $result->fetch(\PDO::FETCH_ASSOC);
            if ($row['photo'] !== '' && $newPhoto === '') {
                $newPhoto = ($row['photo']);
            }

            $sql = 'UPDATE user SET pseudo = :pseudo, email = :email, password = :password, photo = :photo WHERE id = :id';

            $this->database->query($sql, [
                'pseudo' => $newPseudo,
                'email' => $newEmail,
                'password' => $this->hashPassword($newPassword),
                'id' => $user->getId(),
                'photo' => $newPhoto
            ]);

            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception("Erreur de base de données : " . $e->getMessage());
        }
    }
}
