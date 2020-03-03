<?php
require_once ("config-DailyTech.php");

class Database
{
    //PDO Object
    private $_dbh;

    function __construct()
    {
        try {
            //Create new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getUsers()
    {
        $sql = "SELECT * FROM MyUser
                ORDER BY name";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getPosts()
    {
        $sql = "SELECT * FROM MyPost
                ORDER BY post_ID";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function insertUser($user) {
        $sql = "INSERT INTO MyUser(name, email, organization, position, myPassword, isAdmin)
                    VALUES (:name, :email, :org, :position, :pswd, :isAdmin)";
        $statement = $this->_dbh->prepare($sql);
        $passhash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $isAdmin = is_a($user, "AdminUser");
        $statement ->bindParam(':name', $user->getName());
        $statement ->bindParam(':email', $user->getEmail());
        $statement ->bindParam(':org', $user->getOrganization());
        $statement ->bindParam(':position', $user->getPosition());
        $statement ->bindParam(':pswd', $passhash);
        $statement ->bindParam(':isAdmin', $isAdmin);

        $statement->execute();
    }

    function verifyLogin($email, $password) {
        // PULL PASSWORD HASH
        $sql = "SELECT myPassword FROM MyUser
                    WHERE :email = email";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam('email', $email);
        $statement->execute();

        $hashArray = $statement->fetch(PDO::FETCH_ASSOC);
        $storedHash = $hashArray->get('myPassword');
        return password_verify($password, $storedHash);
    }

}