<?PHP
    require_once 'includes/include_all.php';

    $tpl = $mustache->loadTemplate('index');

    $result = pg_query($postgres, 'SELECT * FROM products');
    if (!$result) {
        die('error');
    }

    $code = '';
    while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
        $code .= '<option value="' . $row['product_id'] . '">' . trim($row['product_name']) . '</option>' . "\n";
    }

    echo $tpl->render(array('drop_down' => $code));
