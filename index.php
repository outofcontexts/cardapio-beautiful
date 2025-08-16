<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once 'model/PratoDAO.php';

$dao = new PratoDAO();
$pratos = $dao->listarTodos();

include 'view/listar.php';