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

    private DiscussionManager $discussionManager;

    public function __construct(?DatabaseManager $database = null)
    {
        $this->discussionManager = new DiscussionManager();
        return parent::__construct($database);
    }

    /**
     * Add a new message in database
     */
    public function addMessage(Message $message, int $destinationUserId): Message
    {
        try {

            // 1. Récupérer ou valider l'ID de la discussion
            $discussionId = $message->getDiscussionId();

            // Si le message n'a pas encore d'ID de discussion, on cherche s'il en existe une
            if (is_null($discussionId)) {
                $discussionId = $this->discussionManager->getExistingDiscussionId($message->getUserId(), $destinationUserId);

                // Si aucune discussion n'existe, on la crée
                if (is_null($discussionId)) {
                    $discussion = new Discussion($message->getUserId(), $destinationUserId);
                    $discussion = $this->discussionManager->addDiscussion($discussion);
                    $discussionId = $discussion->getId();
                }

                // On met à jour l'objet message avec l'ID trouvé ou créé
                $message->setDiscussionId($discussionId);
            }

            // 2. Insertion du message en base de données
            $sql = 'INSERT INTO message (user_id, creation_date, discussion_id, content, is_read)
                VALUES (:user_id, NOW(), :discussion_id, :content, :is_read)';

            $this->database->query($sql, [
                'user_id'       => $message->getUserId(),
                'discussion_id' => $message->getDiscussionId(),
                'content'       => $message->getContent(),
                'is_read'       => (int) $message->getStatus() // Cast en int au cas où la DB attend un TINYINT/BOOLEAN
            ]);

            // 3. Hydratation finale de l'objet Message avant le retour
            $pdo = $this->database->getPDO();
            $message->setId((int) $pdo->lastInsertId());
            $message->setCreationDate(new DateTime());

            return $message;
        } catch (\PDOException $e) {
            // Loggez l'erreur originale $e ici si vous avez un système de log (ex: Monolog)
            throw new \Exception('An error occurred while adding the message to the database.', 0, $e);
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
            ORDER BY creation_date ASC';

            $results = $this->database->query($sql, ['discussion_id' => $discussionID]);

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
