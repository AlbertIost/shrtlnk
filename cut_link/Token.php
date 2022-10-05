<?php
require_once '../hashids/HashGenerator.php';
require_once '../hashids/Hashids.php';
class Token
{
    static public function GetToken (PDO $db, string $original_link): string {
        $stmt = $db->prepare('SELECT count(*) FROM links WHERE original_link = ?');
        $stmt->execute([$original_link]);

        $count = (int)$stmt->fetchColumn();

        if ($count == 0) {
            do{
                $id = self::GetNewToken();
            }while(!self::TokenIsFree($db, $id));

            $stmt = $db->prepare("INSERT INTO links VALUES (?, ?, NOW())");
            $stmt->execute([$original_link, $id]);

            return $id;
        }
        else{
            $stmt = $db->prepare("SELECT token FROM links WHERE original_link = ?");
            $stmt->execute([$original_link]);

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rows['token'];
        }
    }
    static private function GetNewToken(): string {
        $hashids = new \Hashids\Hashids('', 8);
        $id = $hashids->encode(rand());
        return $id;
    }
    static private function TokenIsFree(PDO $db, string $token): bool {
        $stmt = $db->prepare('SELECT count(*) FROM links WHERE token = ?');
        $stmt->execute([$token]);
        $count = (int)$stmt->fetchColumn();

        if ($count == 0) {
            return true;
        }

        return false;
    }
}