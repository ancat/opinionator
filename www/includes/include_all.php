<?PHP
    require_once 'templating.php';
    require_once 'database.php';

    function show_error($message) {
        global $mustache;
        $tpl = $mustache->loadTemplate('error');
        echo $tpl->render(array('error_message' => $message));
    }
?>
