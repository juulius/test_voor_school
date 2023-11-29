<?php



$servername = 'localhost';
$database = 'website';
$portnummer = '3308';
$username = "root";
$password = "root";

class test
{
    private function test()
    {

    }

}

function SELECT ($info, $colom, $conn)
{

    $SQL = 'SELECT *';
    $text = '';
    foreach ($info as $key => $value)
    {
        $text = $text . $key . ',';
    }
    $text = rtrim($text, ',');

    $SQL = $SQL . $text. ' FROM '. $colom;
    $query = $conn->query($SQL);
    $gelukt = $query->execute();

    if ($gelukt)
        while ($result=$query->fetch(PDO::FETCH_ASSOC)) // checken of alles binnen is
        {
            $info[] = $result; //push result
        }
        $info["ID"] = $conn->lastInsertId();
    else
        $info = "fault during SELECT statement";

    return $info;
}




// Create connection
try{
    $conn = new PDO('mysql:host='.$servername.';port='.$portnummer.';dbname='.$database , $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connection succesful";
    $sql = 'SHOW TABLES';
    $query = $conn->query($sql);
    print_r($query->fetchAll(PDO::FETCH_COLUMN));

    $sql = 'INSERT INTO Persoon(voornaam, achternaam) VALUES (?, ?)';
    $voornaam = "pietje";
    $achternaam = "puk";
    $query = $conn->prepare($sql);
    $gelukt = $query->execute([$voornaam, $achternaam]);
    $result=$conn->lastInsertId();
    echo $result;


/*
    $sql = 'SELECT ID FROM Persoon WHERE voornaam = ? and achternaam = ?';
    $query = $conn->prepare($sql);
    $gelukt = $query->execute([$voornaam, $achternaam]);
    $result=$query->fetch(PDO::FETCH_ASSOC);
*/


    $sql = 'INSERT INTO Klant(Klantcode, Straatnaam, postcode, persoonid) VALUES (?, ?, ?, ?)';
    $query = $conn->prepare($sql);
    $gelukt = $query->execute(['test', 'yes het doet het',  '9951MH' , $result]);
    
/*
    $sql = 'DELETE FROM Klant WHERE Klantcode = ?';
    $query = $conn->prepare($sql);
    $gelukt = $query->execute(['test']);

    $sql = 'DELETE FROM Persoon WHERE voornaam = ?';
    $query = $conn->prepare($sql);
    $gelukt = $query->execute(['pietje']);
*/
    
    $sql = "SELECT * FROM Klant";
    $query = $conn->prepare($sql);
    $gelukt = $query->execute();
    if ($gelukt)
        while ($result=$query->fetch(PDO::FETCH_ASSOC))
        {
            print_r($result);
        }

}
catch (PDOException $e)
{
    echo $e;

}



