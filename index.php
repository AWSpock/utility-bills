<?php

include_once("/var/www/utility-bills/php/utilities/Common.php");
include_once("/var/www/utility-bills/php/utilities/RouteParser.php");

// include_once("/var/www/utility-bills/php/data/AddressMapper.php");
// include_once("/var/www/utility-bills/php/data/BillTypeMapper.php");
// include_once("/var/www/utility-bills/php/data/BillMapper.php");

include_once("/var/www/utility-bills/php/DataAccess/UserAuth.php");
include_once("/var/www/utility-bills/php/DataAccess/DataAccess.php");

$userAuth = new UserAuth();
$routeParser = new RouteParser("view");
$data = new DataAccess();
session_start();

switch ($routeParser->ResourcePath()) {
    case "/login":
    case "/logout":
    case "/error":
    case "/unauthorized":
        break;
    default:
        if (!$userAuth->checkToken()) {
            $userAuth->sendLogin();
        } elseif (!$userAuth->checkUtility()) {
            $userAuth->sendUnauthorized();
        }

        $uriparts = explode("/", $_SERVER['REQUEST_URI']);
        if (array_key_exists(2, $uriparts))
            $address_id = explode("/", $_SERVER['REQUEST_URI'])[2];
        if (array_key_exists(4, $uriparts))
            $billtype_id = explode("/", $_SERVER['REQUEST_URI'])[4];
        if (array_key_exists(6, $uriparts))
            $bill_id = explode("/", $_SERVER['REQUEST_URI'])[6];
        break;
}

?>

<head>
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/theme.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/layout.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/forms.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/tables.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/modal.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/gauge.css' />
    <link rel='stylesheet' type='text/css' href='//cdn.spockfamily.net/v2/css/filter.css' />

    <title>Utility Bills | Spockfamily</title>

    <link rel="icon" href="//cdn.spockfamily.net/img/icon.ico" type="image/x-icon">

    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
    <script src="https://kit.fontawesome.com/d3431fa995.js" crossorigin="anonymous"></script>

    <?php
    IncludeCSS($routeParser->CSS());
    ?>

    <script type="text/javascript"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
</head>

<body class="container">
    <div class="menu" id="menu">
        <h2 class="menu-title" id="menu-title">Menu</h2>
        <div class="menu-content" id="menu-content">
            <ul>
                <li><a href="/"><i class="fa-solid fa-hand-spock"></i>Spockfamily</a></li>
            </ul>
            <ul>
                <?php
                if ($userAuth->checkToken()) {
                ?>
                    <li><a href="//auth2.spockfamily.net/logout"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>Log Out</a></li>
                <?php
                } else {
                ?>
                    <li><a href="//auth2.spockfamily.net/login?redirect=<?php echo urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>Log In</a></li>
                <?php
                }
                ?>
            </ul>
            <?php
            $file = "/var/www/utility-bills/menu.php";
            if (file_exists($file)) {
            ?>
                <hr />
                <ul>
                    <?php
                    include($file);
                    ?>
                </ul>
            <?php
            }
            ?>
        </div>
    </div>

    <?php
    if (file_exists($routeParser->PagePath())) {
        try {
            if (file_exists($routeParser->CodePath()))
                require $routeParser->CodePath();
            if (isset($_SESSION['last_message_text']) && isset($_SESSION['last_message_type'])) {
    ?>
                <div class="alert alert-<?php echo $_SESSION['last_message_type']; ?> popup">
                    <div><?php echo $_SESSION['last_message_text']; ?></div>
                </div>
    <?php
                unset($_SESSION['last_message_text']);
                unset($_SESSION['last_message_type']);
            }
            require $routeParser->PagePath();
        } catch (DatabaseException $ex) {
            error_log("Database Error: " . $ex->getMessage(), 0);
            header("Location: /error?message=A database error occurred&route=" . urlencode($routeParser->Request()));
            die();
        } catch (Exception $ex) {
            error_log("Other Error: " . $ex->getMessage(), 0);
            header("Location: /error?message=" . $ex->getMessage() . "&route=" . urlencode($routeParser->Request()));
            die();
        }
    } else {
        http_response_code(404);
        require $routeParser->Page404();
    }
    echo "\n";
    ?>
    <div class="menu-button">
        <a class="close-button" href="javascript:void(0)" id="menu-button">
            <i class="fa-solid fa-bars"></i>
        </a>
    </div>

    <div class="footer">
        <div class="footer-content">
            <p>Your current IP Address: <?php echo ReturnUserIP(); ?></p>
        </div>
    </div>
    </div>
    <div id="PopupNotificationContainer"></div>

</body>

<script src='//cdn.spockfamily.net/v2/js/menu.js'></script>
<script src='//cdn.spockfamily.net/v2/js/layout.js'></script>
<script src='//cdn.spockfamily.net/v2/js/popup-notification.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/3.1.0/chartjs-plugin-annotation.min.js'></script>

<?php
IncludeJS($routeParser->JS());
?>

<script src='/js/date-formatter.js'></script>