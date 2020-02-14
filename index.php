<?php

require_once "class-todo.php";

$gestionnaire = new Gestionnaire();

Gestionnaire::loadAllTasks();
//$gestionnaire->debug(Gestionnaire::$todos_ids);
//exit();

foreach(Gestionnaire::$todos_ids as $id) {
    $todos[] = new Todo($id);
}

$gestionnaire->debug($todos);
exit();

?>