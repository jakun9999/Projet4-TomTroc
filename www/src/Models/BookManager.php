<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use PDOException;
use Exception;

/**
 * Model representing a book in the TomTroc application.
 */
class BookManager extends AbstractClassManager
{
    /**
     * Add a new book to the collection.
     * 
     * @param Book $book Book object to be added to the database
     */
    public function addBook(Book $book): void
    {
        try {

            $sql = 'INSERT INTO book 
                (title, author, author_pseudo, description, image_url, status, user_id, creation_date) 
                VALUES (:title, :author, :author_pseudo, :description, :image_url, :status, :user_id, NOW())';

            $this->database->query($sql, [
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'author_pseudo' => $book->getAuthorPseudo(),
                'description' => $book->getDescription(),
                'image_url' => $book->getImageUrl(),
                'status' => $book->getStatus(),
                'user_id' => $book->getUserId()
            ]);

            $pdo = $this->database->getPDO();
            $book->setId((int) $pdo->lastInsertId());
            $book->setCreationDate(new DateTime());
            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while adding the book to the database.');
        }
    }

    /**
     * Update an existing book in the collection.
     * 
     * @param Book $book Book object to be updated in the database
     */
    public function updateBook(Book $book): void
    {
        try {

            // Managing to keep unchanged recorded image if receiving a '' url.
            $sql = 'SELECT * FROM book WHERE id = :id';
            $result = $this->database->query($sql, ['id' => $book->getId()]);
            $row = $result->fetch(\PDO::FETCH_ASSOC);

            if ($row['image_url'] !== '' && $book->getImageUrl() === '') {
                $book->setImageUrl($row['image_url']);
            }

            $sql = 'UPDATE book SET 
                title = :title, 
                author = :author,                 
                author_pseudo = :author_pseudo, 
                description = :description, 
                image_url = :image_url, 
                status = :status, 
                user_id = :user_id
                WHERE id = :id';

            $this->database->query($sql, [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'author_pseudo' => $book->getAuthorPseudo(),
                'description' => $book->getDescription(),
                'image_url' => $book->getImageUrl(),
                'status' => $book->getStatus(),
                'user_id' => $book->getUserId()
            ]);

            return;
        } catch (PDOException $e) {

            // We throw an error as this is an unexpected error that should not happen
            // meaning the database is not working properly or there is a bug in the code.
            throw new Exception('An error occurred while updating the book in the database.');
        }
    }

    /**
     * Get a book by its id.
     * 
     * @param int $id Id of the book to be retrieved
     * 
     * @return Book|null The book object if found, null otherwise
     */
    public function getBookById(int $id): ?Book
    {
        try {
            $sql = 'SELECT * FROM book WHERE id = :id';
            $result = $this->database->query($sql, ['id' => $id])->fetch();

            if ($result) {
                return new Book(
                    $result['title'],
                    $result['author'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['status'],
                    $result['user_id'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date'])
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the book from the database.');
        }
    }

    /**
     * Get the last four books added to the database.
     * 
     * @return array The list of the last four books
     */
    public function getLastFourBooks(): array
    {
        try {
            $sql = 'SELECT book.*, user.pseudo 
                AS user_pseudo
                FROM book
                INNER JOIN user ON book.user_id = user.id 
                ORDER BY creation_date DESC LIMIT 4';
            $results = $this->database->query($sql)->fetchAll();

            $books = [];
            foreach ($results as $result) {
                $books[] = new Book(
                    $result['title'],
                    $result['author'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['status'],
                    $result['user_id'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date']),
                    $result['user_pseudo']
                );
            }

            return $books;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the books from the database.');
        }
    }

    /**
     * Get all books from the database.
     * 
     * @return array The list of all books
     */
    public function getAllBooks(): array
    {
        try {
            $sql = 'SELECT book.*, user.pseudo 
                AS user_pseudo
                FROM book
                INNER JOIN user ON book.user_id = user.id
                ORDER BY title ASC';
            $results = $this->database->query($sql)->fetchAll();

            $books = [];
            foreach ($results as $result) {
                $books[] = new Book(
                    $result['title'],
                    $result['author'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['status'],
                    $result['user_id'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date']),
                    $result['user_pseudo']
                );
            }

            return $books;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the books from the database.');
        }
    }

    public function getBooksByUserId(int $userId): array
    {
        try {
            $sql = 'SELECT * FROM book WHERE user_id = :user_id';
            $results = $this->database->query($sql, ['user_id' => $userId]);

            $books = [];
            foreach ($results as $result) {
                $books[] = new Book(
                    $result['title'],
                    $result['author'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['status'],
                    $result['user_id'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date']),
                );
            }

            return $books;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the books from the database.');
        }
    }

    public function deleteBook(int $id): void
    {
        try {
            $sql = 'DELETE FROM book
                WHERE id = :id';

            $result = $this->database->query($sql, ['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the books from the database.');
        }
    }
}
