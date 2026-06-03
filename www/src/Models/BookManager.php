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
                (title, author_firstname, author_lastname, author_pseudo, description, image_url, status, user_id, creation_date) 
                VALUES (:title, :author_firstname, :author_lastname, :author_pseudo, :description, :image_url, :status, :user_id, NOW())';

            $this->database->query($sql, [
                'title' => $book->getTitle(),
                'author_firstname' => $book->getAuthorFirstName(),
                'author_lastname' => $book->getAuthorLastName(),
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
                    $result['author_firstname'],
                    $result['author_lastname'],
                    $result['author_pseudo'],
                    $result['description'],
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
            $sql = 'SELECT * FROM book ORDER BY creation_date DESC LIMIT 4';
            $results = $this->database->query($sql)->fetchAll();

            $books = [];
            foreach ($results as $result) {
                $books[] = new Book(
                    $result['title'],
                    $result['author_firstname'],
                    $result['author_lastname'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date'])
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
            $sql = 'SELECT * FROM book ORDER BY creation_date DESC';
            $results = $this->database->query($sql)->fetchAll();

            $books = [];
            foreach ($results as $result) {
                $books[] = new Book(
                    $result['title'],
                    $result['author_firstname'],
                    $result['author_lastname'],
                    $result['author_pseudo'],
                    $result['description'],
                    $result['image_url'],
                    (int) $result['id'],
                    new DateTime($result['creation_date'])
                );
            }

            return $books;
        } catch (PDOException $e) {
            throw new Exception('An error occurred while fetching the books from the database.');
        }
    }
}
