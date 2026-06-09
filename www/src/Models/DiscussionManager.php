<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use PDOException;
use Exception;

/**
 * Class managing discussions
 */
class DiscussionManager extends AbstractClassManager
{
    public function getAllDiscussionByUserId(int $userId): array
    {
        try {

            $sql = 'SELECT d.*, 
                    u1.pseudo AS user_1_pseudo, u1.photo AS user_1_photo,
                    u2.pseudo AS user_2_pseudo, u2.photo AS user_2_photo
                    FROM discussion d
                    INNER JOIN user u1 ON d.user_1_id = u1.id
                    INNER JOIN user u2 ON d.user_2_id = u2.id
                    WHERE d.user_1_id = :user_id 
                    OR d.user_2_id = :user_id';

            $results = $this->database->query($sql, [
                'user_id' => $userId
            ]);

            $discussions = [];

            foreach ($results as $result) {

                $discussions[] = new Discussion(
                    $result['user_1_id'],
                    $result['user_2_id'],
                    $result['user_1_pseudo'],
                    $result['user_2_pseudo'],
                    $result['user_1_photo'],
                    $result['user_2_photo'],
                    $result['id'],
                    $result['creation_date'],
                );
            }

            return $discussions;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception($e . ' An error occurred while fetching discussions from the database.');
        }
    }

    public function addDiscussion(Discussion $discussion): void
    {
        try {

            $sql = 'INSERT INTO discussion 
                    (user_1_id, user_2_id, creation_date)
                    VALUES 
                    (:user_1_id, :user_2_id, NOW())';

            $this->database->query($sql, [
                'user_1_id' => $discussion->getUser1Id(),
                'user_2_id' => $discussion->getUser2Id()
            ]);

            $pdo = $this->database->getPDO();
            $discussion->setId((int) $pdo->lastInsertId());
            $discussion->setCreationDate(new DateTime());
            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while adding a discussions to the database.');
        }
    }

    public function isDiscussionExists(int $user1Id, int $user2Id): bool
    {
        try {

            $sql = 'SELECT * FROM discussion
            WHERE (user_1_id = :user_1_id AND user_2_id = :user_2_id)
            OR (user_1_id = :user_2_id AND user_2_id = :user_1_id)';

            $results = $this->database->query($sql, [
                'user_1_id' => $user1Id,
                'user_2_id' => $user2Id
            ]);

            if (!empty($results)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while accessing the database.');
        }
    }
}
