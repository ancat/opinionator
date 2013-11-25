<?PHP
    require_once 'includes/include_all.php';

    $tpl = $mustache->loadTemplate('index');

    // get all the unique products
    $result = pg_query($postgres, 'SELECT * FROM products');
    if (!$result) {
        die('error');
    }

    $code = '';
    while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
        $code .= '<option value="' . $row['product_id'] . '">' . trim($row['product_name']) . '</option>' . "\n";
    }

    // get top 10 products
    $result = pg_query($postgres, 'SELECT * FROM products ORDER BY product_rating DESC LIMIT 10');
    if (!$result) {
        die('error');
    }

    $table_data = '';
    $count = 1;
    while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
        $row['product_name'] = trim($row['product_name']);
        $success = ($count < 4) ? 'success' : '';
        $table_data .= <<<EOF
                  <tr class="$success">
                    <td>$count</td>
                    <td>$row[product_name]</td>
                  </tr>

EOF;
        $count++;
    }
    echo $tpl->render(array('drop_down' => $code, 'table_data' => $table_data));

