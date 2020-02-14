<?php 


class Gestionnaire
{
    protected static $db;

    public function __construct()
    {
        self::db_connect();
    }
    
    private static function db_connect()
    {
        try {
            self::$db = new PDO('mysql:host=localhost; dbname=todo; charset=utf8mb4', 'root', '');
        } catch (PDOExecption $e) {
            echo "erreur ! :" . $e->getMessage() . "</br>";
            die();
        }
    }
    

    public static $todos_ids;
    private static $_priority_sort = "DESC";

    public static function loadAllTasks()
    {
        $query = self::$db->prepare("SELECT id FROM todo ORDER BY priority ".self::$_priority_sort);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $result = $query->fetchAll();


        foreach ($result as $k => $todo) {
            self::$todos_ids[] = $todo['id'];
        } 
    }

    public function debug($debug)
    {
        echo "<pre>";
        print_r($debug);
        echo "</pre>";
    }

    public static $cnt_todos;

} // fermeture de la class Gestionnaire

class todo extends Gestionnaire
{
    private $_id;
    private $_title;
    private $_description;
    private $_priority;

    public function __construct($id = 0)
    {
        if ($id > 0) {
            $this->_id = $id;
            $this->load();
            self::$cnt_todos++;
        }
    }

    public function load()
    {
        $query = self::$db->prepare("SELECT * FROM todo WHERE id = :id");
        $query->setFetchMode(PDO::FETCH_OBJ);
        $query->execute(['id' => $this->_id]);
        $result = $query->fetch();

        if ($query->errorCode() !== '00000') {
            exit(self::pdo_error($query));
        } else {
            $this->_title = $result->title;
            $this->_description = $result->description;
            $this->_priority = $result->priority;
        }

    }
}



?>