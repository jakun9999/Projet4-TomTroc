<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use PDOException;
use Exception;

/**
 * Manage Message objects to be recorder or read
 */
class MessageManager extends AbstractClassManager
{
    /**
     * Add a new message in database
     */
    public function addMessage(Message $message, int $destinationUserId): void
    {
        try {
            $sql = 'INSERT INTO message
                (user_id, creation_date, discussion_id, content, is_read)
                VALUES (:user_id, NOW(), :discussion_id, :content, :is_read)';

            // Before adding the message in DB we need to check if a discussion id
            // exists and we confirm that a discussion between the 2 users
            // is already in the DB. if not we need to create the discussion.

            $discussionManager = new DiscussionManager();
            if (
                is_null($message->getDiscussionId()) &&
                !$discussionManager->isDiscussionExists($message->getUserId(), $destinationUserId)
            ) {
                // no discussion already exists between both users,
                // we need to create a new one.
                $discussion = new Discussion($message->getUserId(), $destinationUserId);
                $discussionManager->addDiscussion($discussion);

                // We can now set discussionId in the message.
                $message->setDiscussionId($discussion->getId());
            }

            $this->database->query($sql, [
                'user_id' => $message->getUserId(),
                'discussion_id' => $message->getDiscussionId(),
                'content' => $message->getContent(),
                'is_read' => $message->getStatus()
            ]);

            $pdo = $this->database->getPDO();
            $message->setId((int) $pdo->lastInsertId());
            $message->setCreationDate(new DateTime());
            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while adding the message to the database.');
        }
    }

    public function getAllMessageByDisccusionId(int $discussionID): array
    {
        try {
            $sql = 'SELECT message.*, user.photo
            AS user_photo
            FROM message
            INNER JOIN user ON message.user_id = user.id 
            WHERE discussion_id = :discussion_id
            ORDER BY creation_date DESC';
            $results = $this->database->query($sql, ['discussion_id' => $discussionID]);

            $messages = [];
            foreach ($results as $result) {
                $messages[] = new Message(
                    $result['user_id'],
                    $result['content'],
                    $result['is_read'],
                    $result['id'],
                    $result['creation_date'],
                    $result['discussion_id'],
                    $result['user_photo']
                );
            }

            return $messages;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the messages from the database.');
        }
    }

    public function setMessageRead(int $id): void
    {
        try {

            $sql = 'UPDATE message SET is_read = :is_read WHERE id = :id';

            $this->database->query($sql, [
                'is_read' => true,
                'id' => $id
            ]);
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while updating the message status in the database.');
        }
    }
}
