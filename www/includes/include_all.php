<?PHP
    require_once 'templating.php';
    require_once 'database.php';
    define('HMAC_KEY', 'why cant this semester be over already');

    function show_error($message) {
        global $mustache;
        $tpl = $mustache->loadTemplate('error');
        echo $tpl->render(array('error_message' => $message));
    }
?>
