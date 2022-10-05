<?php

namespace Token;
require_once '../hashids/HashGenerator.php';
require_once '../hashids/Hashids.php';

class Token
{
    static public function GetToken(PDO $conn, string $original_link): string
    {
        $stmt = $conn->prepare('SELECT count(*) FROM links WHERE original_link = ?');
        $stmt->execute([$original_link]);

        $count = (int)$stmt->fetchColumn();

        if ($count == 0) {
            do {
                $id = self::GetNewToken();
            } while (!self::TokenIsFree($conn, $id));

            $stmt = $conn->prepare("INSERT INTO links VALUES (?, ?, NOW())");
            $stmt->execute([$original_link, $id]);

            return $id;
        } else {
            $stmt = $conn->prepare("SELECT token FROM links WHERE original_link = ?");
            $stmt->execute([$original_link]);

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rows['token'];
        }
    }

    static public function GetOriginalLink(PDO $conn, string $token): string
    {
        $stmt = $conn->prepare('SELECT original_link FROM links WHERE token = ?');
        $stmt->execute([$token]);

        if ($stmt->rowCount() > 0)
            return $stmt->fetchColumn();
        else {
            $domainName = $_SERVER['HTTP_HOST'];
            $scheme = $_SERVER['REQUEST_SCHEME'] . '://';
            return $scheme . $domainName . '/404';
        }
    }

    static private function GetNewToken(): string
    {
        $hashids = new \Hashids\Hashids('', 8);
        $id = $hashids->encode(rand());
        return $id;
    }

    static private function TokenIsFree(PDO $conn, string $token): bool
    {
        $stmt = $conn->prepare('SELECT count(*) FROM links WHERE token = ?');
        $stmt->execute([$token]);
        $count = (int)$stmt->fetchColumn();

        if ($count == 0) {
            return true;
        }

        return false;
    }
}