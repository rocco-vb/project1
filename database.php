<?php
// database.php
class DB{
    private $host;
    private $user;
    private $pass;
    private $name;
    private $charset;

    protected $dbh; // dit is de verbinding met de database
    protected $resultSet; // hierin komen de resultaten te staan van een query


    public function __construct($host, $user, $pass, $name, $charset){
        $this->host = $host; // localhost
        $this->user = $user; //root
        $this->pass = $pass; //db password
        $this->name = $name; // db name
        $this->charset = $charset; // db charset

        try{
            $dsn = "mysql:host=$this->host; dbname=$this->name; charset=$this->charset";
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            $this->resultSet = [];
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error){
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function alreadyexists($email){
        //  check if the user already exists in the database
        $this->stmt = $this->dbh->prepare("SELECT email FROM account WHERE email = :email");
        $result = $this->stmt->execute(
            array(
                'email' => $email
            )
        );

        // if query fails ($result not true or null), then echo error.
        if(!$result){
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }

        // store result in class resultset array
        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        // store result in $stack so we can alter or use data
        $stack = $this->resultSet;
        $emailcheck = $stack[0]["email"];

        if($emailcheck == $email){
            return TRUE;
        }
    }

    public function registreer($firstname, $tsv, $lastname, $email, $uname, $psw){
        
        try{
            // insert new account
            $query1 = "INSERT INTO account (username, email, password, created, updated, usertype) VALUES (:username, :email, :wachtwoord, CURRENT_TIMESTAMP , CURRENT_TIMESTAMP, 2)";
            $statement1 = $this->dbh->prepare($query1);
            $statement1->execute(
                array(
                    'username' => $uname,
                    'email' => $email,
                    'wachtwoord' => password_hash($psw, PASSWORD_DEFAULT)
                )
            );

            // store account_id for later use, account_id is equal to last inserted id
            $account_id = $this->dbh->lastInsertId();

            // insert new person
            $query2 = "INSERT INTO persoon (voornaam, tussenvoegsel, achternaam, account_id, created, updated) VALUES (:voornaam, :tussenvoegsel, :achternaam, :account_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            $statement2 = $this->dbh->prepare($query2);
            $statement2->execute(
                array(
                    'voornaam' => $firstname,
                    'tussenvoegsel' => $tsv,
                    'achternaam' => $lastname,
                    'account_id' => $account_id
                )
            );

            // redirect to login page
            header("location:login.php");

        }catch(PDOException $error){
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function login($email, $wachtwoord){
        
        try{
            // get hashed password from account where email is equal to given email
            $gethash = "SELECT password FROM account WHERE email = :email";
            $statement2 = $this->dbh->prepare($gethash);
            $statement2->execute(
                array(
                    'email' => $email
                )
            );

            // store result inside $result
            $result = $this->resultSet = $statement2->fetchAll(PDO::FETCH_ASSOC);

            // initialize $hash variable
            $hash = "";

            // if $result return is true and not null then store the result inside $hash
            if($result){
                $hash = $result[0]["password"];
            };

            // get all accounts where email is equal to given email and password is equal to given password
            $query1 = "SELECT * FROM account where email = :email AND password = :password";
            $statement1 = $this->dbh->prepare($query1);
            $statement1->execute(
                array(
                    'email' => $email,
                    'password' => $hash
                )
            );

            // count1 variable is the total amount of rows returned
            $count1 = $statement1->rowCount();
            
            // if password is equal to $hash
            if(password_verify($wachtwoord, $hash)){

                // if $count is not empty then the query for said user was successful and then do next part
                if($count1 > 0){

                    // set $_SESSION["email"]
                    $_SESSION["email"] = $email;
                    
                    // if the users role is admin then redirect to login_admin page else redirect to the login_user page
                    if($this->checkRole() == "Admin"){
                        header("location:login_admin.php");
                    } else{
                        header("location:login_user.php");
                    }
                } 
            }else {
                // login unsuccessful echo Verkeerd wachtwoord of username
                echo '<label>Verkeerd wachtwoord of username</label>';
            }
            
        }catch (PDOException $error){
            echo $error->getMessage();
            exit("An error occured");
        }
    }

    public function checkRole(){
        // get usertype from account where the email is the $_SESSION['email']
        $this->stmt = $this->dbh->prepare("SELECT usertype FROM account WHERE email = :email");
        $result = $this->stmt->execute(
            array(
                'email' => $_SESSION['email']
            )
        );

        // if query fails ($result not true or null), then echo error.
        if(!$result){
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }

        // store result in class resultset array
        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        // store result in $stack so we can alter or use data
        $stack = $this->resultSet;
        $usertype = $stack[0]["usertype"];

        // if usertype = 1 then return admin else user
        if($usertype == 1){
            return "Admin";
        } else{
            return "User";
        }
    }

    public function getPersons(){
        // get all users from person
        $this->stmt = $this->dbh->prepare("
            SELECT a.id, a.password, u.type, p.voornaam, p.tussenvoegsel, p.achternaam, a.username, a.email 
            FROM persoon as p
            LEFT JOIN account as a
            ON p.account_id = a.id
            LEFT JOIN usertype as u
            ON a.usertype = u.id    
            ");
        $result = $this->stmt->execute();
        
        // if query fails ($result not true or null), then echo error.
        if(!$result){
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }
        
        // store result in class resultset array
        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        // store result in $stack so we can alter or use data
        $result = $this->resultSet;

        // return $result so we can use the data
        return $result;
    }

    public function getPerson(){
        // get user from person
        $this->stmt = $this->dbh->prepare("
            SELECT a.id, a.password, u.type, p.voornaam, p.tussenvoegsel, p.achternaam, a.username, a.email 
            FROM persoon as p
            LEFT JOIN account as a
            ON p.account_id = a.id
            LEFT JOIN usertype as u
            ON a.usertype = u.id   
            WHERE a.email = :email 
            ");
        $result = $this->stmt->execute(
            array(
                'email' => $_SESSION["email"]
            )
        );
        
        // if query fails ($result not true or null), then echo error.
        if(!$result){
            die('<pre>Oops, Error execute query ' . $result . '</pre><br><pre>' . 'Result code: ' . $result . '</pre>');
        }
        
        // store result in class resultset array
        $this->resultSet = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        // store result in $stack so we can alter or use data
        $result = $this->resultSet;

        // return $result so we can use the data
        return $result;
    }

    public function editPerson($acc_id){
        // get the user where the id is equal to the given id
        $sql = "SELECT * FROM persoon where account_id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(
            array(
                'id' => $acc_id
            )
        );

        // store result in
        $result = $stmt->fetch();
        
        // return the id as $result
        return $result;
    }

    public function editAccount($id){
        // get the account where the id is equal to the given id
        $sql = "SELECT * FROM account where id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(
            array(
                'id' => $id
            )
        );

        // store result in
        $result = $stmt->fetch();
        
        // return the id as $result
        return $result;
    }
    
    public function updatePerson($voornaam, $tussenvoegsel, $achternaam, $acc_id){
        // update the person's firstname, tsv, achternaam where the id is equal to given id
        $sql = "UPDATE persoon SET voornaam = :voornaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(
            array(
                'voornaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'id' => $acc_id
            )
        );
    }

    public function updateAccount($email, $password, $id){
        // get password from account where the email is equal to given email
        $sql1 = "SELECT password FROM account WHERE email = :email";
        $stmt = $this->dbh->prepare($sql1);
        $stmt->execute(
            array(
                'email' => $email
            )
        );
        // store result in $samepasswordcheck so we can check if the given $password is equal to the one in the database
        $samepasswordcheck = $stmt->fetch();
        
        // update the account's email and password where the id is equal to given id when the password is not equal to password already in db else do it but dont update password
        if($password == $samepasswordcheck[0]){
            $sql2 = "UPDATE account SET email = :email WHERE id = :id";
            $stmt = $this->dbh->prepare($sql2);
            $stmt->execute(
                array(
                    'email' => $email,
                    'id' => $id
                )
            );
        } else{
            $sql2 = "UPDATE account SET email = :email, password = :password WHERE id = :id";
            $stmt = $this->dbh->prepare($sql2);
            $stmt->execute(
                array(
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'id' => $id
                )
            );
        }

    }

    public function deletePerson($id){
        // delete the persoon where account_id is equal to the given id
        $sql = "DELETE FROM persoon WHERE account_id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(
            array(
                'id' => $id
            )
        );

        // delete the account where the id is equal to given id
        $sql = "DELETE FROM account WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(
            array(
                'id' => $id
            )
        );
    }
}
