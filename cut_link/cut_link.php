<?

use Token\Token;

require_once 'Token.php';
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $link = $_POST["link"];

    try{
        $conn = new PDO('mysql:host=localhost;dbname=short_link_database', 'root', '');
    }
    catch (PDOException $e){
        echo "Error! " . $e->getMessage();
        die();
    }

    $token = Token::GetToken($conn, $link);
    $domainName = $_SERVER['HTTP_HOST'];
    $scheme = $_SERVER['REQUEST_SCHEME'] . '://';
    echo $scheme . $domainName . '/' . $token;
}
