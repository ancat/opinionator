<?PHP
    require_once 'includes/include_all.php';

    $tpl = $mustache->loadTemplate('index');
    echo $tpl->render();
?>
