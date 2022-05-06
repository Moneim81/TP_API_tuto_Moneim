<?php

namespace tutoAPI\Models;

use tutoAPI\Services\Manager;

class TutoManager extends Manager
{

    public function find($id)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);

        // Retour
        return $tuto;
    }


    public function findPage($page)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;
        }
        $tutosPage = [];
        for ($i = 0; $i <= 4; $i++) {
            $idPage = ($page - 1) * 5 + $i;
            if (!isset($tutos[$idPage])) {
                break;
            }
            $tutosPage[$i] = $tutos[$idPage];
        }

        return $tutosPage;
    }

    public function findAll()
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;
        }

        return $tutos;
    }

    public function add(Tuto $tuto)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('INSERT INTO tutos (title, description, createdAt) VALUES (:title, :description, :createdAt)');
        $title = $tuto->getTitle();
        $sth->bindParam(':title', $title);
        $description = $tuto->getDescription();
        $sth->bindParam(':description', $description);
        $createdAt = $tuto->getCreatedAt();
        $sth->bindParam(':createdAt', $createdAt);
        $sth->execute();

        // Retour
        $id = $dbh->lastInsertId();
        $tuto->setId($id);
        return $tuto;
    }

    public function update(Tuto $tuto)
    {

        $dbh = static::connectDb();

        $id = $tuto->getId();
        $titre = $tuto->getTitle();
        $descr = $tuto->getDescription();
        $dateAt = $tuto->getCreatedAt();

        $sth = $dbh->prepare('Update tutos SET title="' . $titre . '",description="' . $descr . '",createdAt="' . $dateAt . '" WHERE id=' . $id);
        $sth->execute();
        return $tuto;
    }


    public function delete(Tuto $tuto)
    {
        $dbh = static::connectDb();

        $id = $tuto->getId();
        $sth = $dbh->prepare('delete from tutos where id=' . $id);
        $sth->execute();

        return $tuto;
    }
}
