<?php
try {
    $server = 'localhost';
    $db = 'exo_198';
    $user = 'root';
    $pswd = '';

    $bdd = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pswd);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//    create('Nectoux', 'vanessa', 30, $bdd);
//    create('blabla', 'car', 50, $bdd);

    read($bdd);
    update('Picasso', 'Pablo', 250, 34, $bdd);

    delete(30, $bdd);

}
catch (PDOException $e) {
    echo $e->getMessage();
}

function create($nom, $prenom, $age, $bdd) {
    $sql = " INSERT INTO eleves VALUES(null, '$nom', '$prenom', $age)";
    $result = $bdd->exec($sql);
    echo $result;
}

function read ($bdd) {
    $stmt = $bdd->prepare("SELECT * FROM eleves");
    if($stmt->execute()) {
        foreach ($stmt->fetchAll() as $user) {
            echo "Eleve" . $user['id'] . ": " . $user['nom'] . " " . $user['prenom'] . ", " . $user['age'] . " ans. <br>";
        }
    }
}

function update ($prenom,$nom, $age, $id, $bdd) {
    $stm = $bdd->prepare("
        UPDATE eleves SET prenom = :prenom, nom = :nom, age = :age WHERE id = :id
    ");

    $stm->bindParam(':nom', $nom);
    $stm->bindParam(':prenom', $prenom);
    $stm->bindParam(':age', $age);
    $stm->bindParam(':id', $id);

    $stm->execute();
}

function delete($idEleve, $bdd) {
    $sql = "DELETE FROM eleves WHERE id = $idEleve";
    if($bdd->exec($sql) !==false){
        echo "suppression validée";
    }
}