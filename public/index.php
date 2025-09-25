<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Controller\HomeController;

$login = isset($_SESSION['id_user']);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($uri) {
    case '/':
        $controller = new HomeController();
        $controller->home();
        break;
    case '/selling':
        $controller = new HomeController();
        $controller->homeSelling();
        break;
    case '/user':
        $controller = new HomeController();
        $controller->homeUser();
        break;
    case '/statistic':
        $controller = new HomeController();
        $controller->homeStatistic();
        break;
    


    default:
        http_response_code(404);
        echo "Page non trouvée";
        echo ($uri);
        break;
}

?>
