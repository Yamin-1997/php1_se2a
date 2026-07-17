<?php

// config/dbconnect.php
// Database (MySQL) connect

class DB
{
    private $host = "localhost";
    private $dbname = "kwan_hon_kei";
    private $user = "kwan_hon_kei";
    private $pass = "*Hh$%tpr";

    public function connect()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->pass
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "DB接続失敗"]);
            exit;
        }
    }
}

//  ADD: global function (login.php の connect() をそのまま使えるようにする)
function connect()
{
    $db = new DB();
    return $db->connect();
}
