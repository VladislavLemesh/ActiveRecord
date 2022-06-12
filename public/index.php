<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Activerecord\Names\Names;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../src/templates');
$view = new Environment($loader);

echo $view->render('forms.twig');
$names = new Names();

if (isset($_GET["save_id"]) && isset($_GET["save_surname"]) && isset($_GET["save_name"])) {
  $names->setId($_GET["save_id"]);
  $names->setSurname($_GET["save_surname"]);
  $names->setName($_GET["save_name"]);
  $names->save();
}

if (isset($_GET["delete_id"])) {
  $names->setId($_GET["delete_id"]);
  $names->delete();
}

$db_results = $names->getAll();
echo 'Все записи:';
foreach ($db_results as $rows) {
  echo $view->render('index.twig', ['id' => $rows[0], 'surname' => $rows[1], 'name' => $rows[2]]);
}

if (isset($_GET["id"])) {
  $search_id = $_GET["id"];
  $db_results = $names->findById($search_id);
  echo '-Результат поиска по id:';
  echo $view->render('index.twig', ['id' => $db_results[0], 'surname' => $db_results[1], 'name' => $db_results[2]]);
}

if (isset($_GET["surname"])) {
  $search_surname = $_GET["surname"];
  $db_results = $names->findBySurname($search_surname);
  echo '-Результат поиска по фамилии:';
  foreach ($db_results as $row) {
    echo $view->render('index.twig', ['id' => $row[0], 'surname' => $row[1], 'name' => $row[2]]);
  }
}


