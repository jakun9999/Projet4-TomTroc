<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use Exception;
use PDOException;

/**
 * Manage Message objects to be recorder or read
 */
class MessageManager extends AbstractClassManager
{
    private DiscussionManager $discussionManager;

    /**
     * MessageManager constructeur.
     * 
     * Extends AbstractClassManager and initialize 
     * other class managers we uses.
     */
    public function __construct(?DatabaseManager $database = null)
    {
        $this->discussionManager = new DiscussionManager();
        return parent::__construct($database);
    }

    /**
     * Add a new message in database.
     * 
     * Add a new message in database but also create a new discussion
     * if no existing discussion between the sender and the destination.
     * 
     * @param Message $message
     * @param int $destinationUserId Used if a discussion needs to be reacted.
     * 
     * @return Message Returns a message with new discussion id.
     * 
     */
    public function addMessage(Message $message, int $destinationUserId): Message
    {
        try {
            // We check if a discussion Id already exists in the message.
            $discussionId = $message->getDiscussionId();

            // If an id exists, we check that this id is real and correct.
            if (is_null($discussionId)) {
                $discussionId = $this->discussionManager->getExistingDiscussionId($message->getUserId(), $destinationUserId);

                // If there is no discussion id, we can now create a new discussion.
                if (is_null($discussionId)) {
                    $discussion = new Discussion($message->getUserId(), $destinationUserId);
                    $discussion = $this->discussionManager->addDiscussion($discussion);
                    $discussionId = $discussion->getId();
                }

                // And we provide to the message the correct discussionId.
                $message->setDiscussionId($discussionId);
            }

            $sql = 'INSERT INTO message 
                    (user_id, creation_date, discussion_id, content, is_read)
                    VALUES 
                    (:user_id, NOW(), :discussion_id, :content, :is_read)';

            $this->database->query(
                $sql,
                [
                    'user_id' => $message->getUserId(),
                    'discussion_id' => $message->getDiscussionId(),
                    'content' => $message->getContent(),
                    'is_read' => (int) $message->getStatus(), // Cast to int if DB await a TINYINT/BOOLEAN
                ]
            );

            // We hydrate message with newly created information (id and creation date)
            $pdo = $this->database->getPDO();
            $message->setId((int) $pdo->lastInsertId());
            $message->setCreationDate(new DateTime());

            return $message;
        } catch (\PDOException $e) {
            throw new \Exception('An error occurred while adding the message to the database.', 0, $e);
        }
    }

    /**
     * Provides all the messages related to a discussion.
     * 
     * @param int $discussionId
     * 
     * @return array Returns an array of Message.
     */
    public function getAllMessageByDisccusionId(int $discussionId): array
    {
        try {
            $sql = 'SELECT message.*, user.photo
            AS user_photo
            FROM message
            INNER JOIN user ON message.user_id = user.id 
            WHERE discussion_id = :discussion_id
            ORDER BY creation_date ASC';

            $results = $this->database->query($sql, ['discussion_id' => $discussionId]);

            $rows = $results->fetchAll(\PDO::FETCH_ASSOC);

            $messages = [];
            foreach ($rows as $row) {
                $messages[] = new Message(
                    $row['user_id'],
                    $row['content'],
                    $row['is_read'] === 0 ? false : true,
                    $row['id'],
                    new DateTime($row['creation_date']),
                    $row['discussion_id'],
                    $row['user_photo']
                );
            }

            return $messages;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the messages from the database.');
        }
    }

    /**
     * Change message status (read / not read).
     * 
     * @param int $id Message id.
     */
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

    /**
     * Provides unread message count for a specific user id.
     * 
     * tips: user_id in message table is always sender id.
     * 
     * @param int $userId
     * 
     * @return ?int Return int as unread message count of null.
     */
    public function getUnReadMessagesByUserId(int $userId): ?int
    {
        try {
            $sql = 'SELECT COUNT(m.id) AS total_unread
                    FROM message m
                    INNER JOIN discussion d ON m.discussion_id = d.id
                    WHERE (d.user_1_id = :user_id OR d.user_2_id = :user_id)
                    AND m.is_read = 0
                    AND m.user_id != :user_id';

            $count = (int)$this->database->query($sql, ['user_id' => $userId])->fetchColumn();

            return $count !== false ? $count : null;
        } catch (PDOException $e) {
            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while counting unread messages in the database.');
        }
    }
}
