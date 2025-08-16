<?php
class ConnectionFactory {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'restaurante';
        $user = 'root';
        $pass = '1234';

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}
