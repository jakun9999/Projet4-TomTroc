<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use PDOException;
use Exception;

/**
 * Class managing discussions. Convert user1 and user2 to currentUser
 * and otherUser to simplify messaging template.
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

            $rows = $results->fetchAll(\PDO::FETCH_ASSOC);

            $discussions = [];

            foreach ($rows as $row) {

                // converting user1 and user2 to currentUser and otherUser
                // $_SESSION['user'] is placed first
                $currentUserId = $row['user_1_id'] === $userId ? $row['user_1_id'] : $row['user_2_id'];
                $otherUserId = $row['user_1_id'] === $userId ? $row['user_2_id'] : $row['user_1_id'];

                $currentUserPseudo = $row['user_1_id'] === $userId ? $row['user_1_pseudo'] : $row['user_2_pseudo'];
                $otherUserPseudo = $row['user_1_id'] === $userId ? $row['user_2_pseudo'] : $row['user_1_pseudo'];


                $currentUserPhoto = $row['user_1_id'] === $userId ? $row['user_1_photo'] : $row['user_2_photo'];
                $otherUserPhoto = $row['user_1_id'] === $userId ? $row['user_2_photo'] : $row['user_1_photo'];

                $discussions[] = new Discussion(
                    $currentUserId,
                    $otherUserId,
                    $currentUserPseudo,
                    $otherUserPseudo,
                    $currentUserPhoto,
                    $otherUserPhoto,
                    $row['id'],
                    new DateTime($row['creation_date']),
                );
            }

            return $discussions;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception($e . ' An error occurred while fetching discussions from the database.');
        }
    }

    public function addDiscussion(Discussion $discussion): Discussion
    {
        try {

            $sql = 'INSERT INTO discussion 
                    (user_1_id, user_2_id, creation_date)
                    VALUES 
                    (:user_1_id, :user_2_id, NOW())';

            $this->database->query($sql, [
                'user_1_id' => $discussion->getCurrentUserId(),
                'user_2_id' => $discussion->getOtherUserId()
            ]);

            $pdo = $this->database->getPDO();
            $discussion->setId((int) $pdo->lastInsertId());
            $discussion->setCreationDate(new DateTime());
            return $discussion;
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

    public function getExistingDiscussionId(int $user1Id, int $user2Id): ?int
    {
        try {

            $sql = 'SELECT id FROM discussion
            WHERE (user_1_id = :user_1_id AND user_2_id = :user_2_id)
            OR (user_1_id = :user_2_id AND user_2_id = :user_1_id)';

            $results = $this->database->query($sql, [
                'user_1_id' => $user1Id,
                'user_2_id' => $user2Id
            ]);

            $discussion = $results->fetch(\PDO::FETCH_ASSOC);

            if ($discussion !== false) {
                return $discussion['id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while accessing the database.');
        }
    }
}
