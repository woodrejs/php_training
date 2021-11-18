<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use PDO;
use Throwable;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDOException;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validationConfig($config);
            $this->createConnection($config);
        } catch (PDOException $th) {
            throw new StorageException('connection error');
        }
    }

    public function createNote(array $data): void
    {
        $title = $this->conn->quote($data['title']);
        $description = $this->conn->quote($data['description']);
        $created = $this->conn->quote(date('Y-m-d H:i:s'));

        $query = "
                INSERT INTO notes (title, description, created) 
                VALUES ($title, $description, $created)
                ";

        try {
            $this->conn->exec($query);
        } catch (Throwable $th) {
            echo 'blad podczas dodawania notatki';
        }
    }

    public function getNotes(string $sortby, string $orderby): array
    {
        try {
            $query = "SELECT * FROM notes ORDER BY $sortby $orderby";
            $notes = $this->conn->query($query);

            return $notes->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {       
            throw new StorageException('Błąd przy pobieraniu notatek');
        }
    }

    public function getNote(int $id): array
    {
        try {
            $query = "SELECT * FROM notes WHERE id=$id";
            $note = $this->conn->query($query);
            $result = $note->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Błąd przy pobieraniu notatki');
        }

        if (!$result) {
            throw new NotFoundException("W bazie nie istnieje notatka o id: $id");
        }

        return $result;
    }

    public function editNote(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $query = "
            UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id
            ";
            $this->conn->exec($query);
        } catch (\Throwable $th) {
            throw new StorageException('Błąd podczas edycji notatki');
        }
    }

    public function deleteNote(int $id): void
    {

        try {
            $query = "
            DELETE FROM notes
            WHERE id = $id
            LIMIT 1
            ";

            $this->conn->exec($query);
        } catch (\Throwable $th) {
            throw new StorageException('Błąd podczas usuwania notatki');
        }
    }

    private function createConnection(array $config): void
    {

        $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
        $username = $config['username'];
        $password = $config['password'];


        $this->conn = new PDO($dsn, $username, $password);
    }

    private function validationConfig($config): void
    {
        if (
            empty($config['dbname']) ||
            empty($config['host']) ||
            empty($config['username']) ||
            empty($config['password'])
        ) {
            throw new ConfigurationException('Błąd konfiguracji');
        }
    }
}