<?php

namespace tutoAPI\Controllers;

use tutoAPI\Models\TutoManager;
use tutoAPI\Models\Tuto;
use tutoAPI\Controllers\abstractController;

class tutoController extends abstractController
{

    public function show($id)
    {

        // Données issues du Modèle

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        // Template issu de la Vue

        return $this->jsonResponse($tuto, 200);
    }

    public function index()
    {

        $tutos = [];

        $manager = new TutoManager();

        $tutos = $manager->findAll();

        return $this->jsonResponse($tutos, 200);
    }

    public function add()
    {

        // Ajout d'un tuto
        $tuto = new Tuto();
        $tuto->setTitle($_POST["title"]);
        $tuto->setDescription($_POST["description"]);
        $now = new \DateTime();
        $tuto->setCreatedAt($now->format('Y-m-d H:i:s'));
        
        $manager = new TutoManager();
        $tuto = $manager->add($tuto);
        // TODO: ajout d'un tuto

        return $this->jsonResponse($tuto, 200);
    }

    function update($id)
    {
        parse_str(file_get_contents('php://input'),$_PATCH);

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        $tuto->setTitle($_PATCH["title"]);
        $tuto->setDescription($_PATCH["description"]);
        $now = new \DateTime();
        $tuto->setCreatedAt($now->format('Y-m-d H:i:s'));

        $tutos = $manager->update($tuto);

        return $this->jsonResponse($tutos, 200);
    }

    function delete($id)
    {
        $manager = new TutoManager();
        $tuto = $manager->find($id);
        $tutos = $manager->delete($tuto);
        return $this->jsonResponse($tutos, 200);
    }

}
