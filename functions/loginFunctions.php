<?php
class loginFunctions        
{
     /** @var PDO */
    private $mypdo; 
    
    function __construct(PDO $mypdo) 
    {
        $this->mypdo = $mypdo;   
    }

    function logIn ($name, $passwort)
    {
        $url = 'http://localhost/Basteln/index.php?do=login&user=' . $name . '&pwd=' . $passwort;
        $urlWrapper = new UrlWrapper($url);
        
        $result = $urlWrapper->getDecodedContent(false);
       // 
        if ($result->status == 'ok') {
           $_SESSION['login_daten_id'] = $result->id;
            return true;
        }
        return false;
    }
    
    function logOut() 
    {
        unset ($_SESSION['login_daten_id']);
    }
    
    function isLoggedIn () 
    {
        return (isset ($_SESSION['login_daten_id']));
    }
    
    // umbenennen
    function rowCount ($variabel ,$name)
    {
        $statement = $this->mypdo->prepare('SELECT id FROM login_daten WHERE ' . $variabel .'=?' );
        $statement->bindValue(1, $name);
        $statement->execute();
        if ($statement->errorCode() != '0000') {
            print '<pre>';
            var_dump($statement->queryString);
            var_dump($statement->debugDumpParams());
            var_dump($statement->errorInfo());
            print '</pre>';
        }
        
    
        return $statement->rowCount();
    }
    
    function find($id)
    {
        $statement = $this->mypdo->prepare('SELECT id FROM login_daten WHERE id=?;');
        $statement->bindValue(1, $id);
        $statement->execute();
        return $statement->fetch();
    }
    
    
    // test objekt nicht sichder ob es funzt
    function findAll(array $where = array(), array $order = array()) 
    {
        $q = 'SELECT id FROM login_daten ';
        $q .= $this->where($where);
        if (count($order) > 0) {
            $q .= 'ORDER BY ';
            $orders = array();
            foreach ($order as $key => $value) {
                $orders[] = $key . ' ' . $value;
            }
            $q .= implode(', ', $orders) . ' ';
        }
        $statement = $this->pdo->query($q);
        return $statement->fetchAll();
    }
    
    private function where(array $parts)
    {
        $result = '';
        if (count($parts) > 0) {
            $result .= 'WHERE ';
            $sq = array();
            foreach ($parts as $key => $value) {
                $sq[] = $key . ' = ' . $this->pdo->quote($value);
            }
            $result .= implode(' AND ', $sq) . ' ';
        }
        return $result;
    }
    
    public function getCurrentUser($column = null)
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        $statement = $this->mypdo->prepare('SELECT id, rolle, benutzername From login_daten WHERE id=?');
        $statement->bindValue(1, $_SESSION['login_daten_id']);
        $statement->execute();


        $user = $statement->fetch();
        
        if ($column === null) {
            return $user;
        }
        
        return $user[$column];
    }
}


        
        
        
?>
