<?php


require('credentials.php');

try {
  $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
  $conn->query("SET SEARCH_PATH TO tran;");
  $conn->query("SET CLIENT_ENCODING TO 'UTF8';");
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
