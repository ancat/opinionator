<?PHP
    require_once 'includes/include_all.php';

    $showdown_url = $_GET['id'];
    $admin_url = isset($_GET['admin']) ? $_GET['admin'] : '';

    // echo "hash_hmac('md5', '$showdown_url', '" . HMAC_KEY . "');";
    // die();
    $admin_mode = false;
    if ($admin_url) {
        if ($admin_url != hash_hmac('md5', $showdown_url, HMAC_KEY)) {
            show_error('Please check your privileges.');
            die();
        } else {
            $admin_mode = true;
        }
    }

    if (!$admin_mode) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = (int) $_POST['product_id'];
            $devices = pg_prepare($postgres, 'products', 'SELECT * FROM showdowns WHERE showdown_id = (SELECT showdown_id FROM urls WHERE url_unique_string = $1 LIMIT 1)');
            $result = pg_execute($postgres, 'products', array($_GET['id']));
            if (!$result) {
                die('query failurez ' . pg_last_error($postgres));
            }

            $result = pg_fetch_array($result, NULL, PGSQL_ASSOC);
            $product_one = $result['product_id_1'];
            $product_two = $result['product_id_2'];
            $showdown_id = $result['showdown_id'];

            if ($product_one != $product_id) {
                $product_id = $product_two;
            }

/****** 

INSERT ELO STUFF HERE
I REPEAT
INSERT ELO STUFF HERE
AND THEN WE'RE DONE PROBABLY****/
            $insert_vote = pg_prepare($postgres, 'insert_vote', 'INSERT INTO votes (showdown_id, ip_address, timestamp, product_id) VALUES ($1, $2, $3, $4)');
            $result = pg_execute($postgres, 'insert_vote', array($showdown_id, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_TIME'], $product_id));
            if (!$result) {
                show_error(pg_last_error($postgres));
                die();
            } else {
                die('er ware good');
            }
        }
    }

    $devices = pg_prepare($postgres, 'products', 'SELECT * FROM showdowns WHERE showdown_id = (SELECT showdown_id FROM urls WHERE url_unique_string = $1 LIMIT 1)');
echo pg_last_error($postgres);
    $result = pg_execute($postgres, 'products', array($_GET['id']));
    if (!$result) {
        die('query failurez ' . pg_last_error($postgres));
    }

    $result = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $product_one = $result['product_id_1'];
    $product_two = $result['product_id_2'];

    $device_infos = pg_prepare($postgres, 'product_info', 'SELECT * FROM products WHERE product_id = $1');
    $product_one = pg_execute($postgres, 'product_info', array($product_one));
    $product_one = pg_fetch_array($product_one, NULL, PGSQL_ASSOC);
    $product_two = pg_execute($postgres, 'product_info', array($product_two));
    $product_two = pg_fetch_array($product_two, NULL, PGSQL_ASSOC);

    if ($admin_mode) {
        $tpl = $mustache->loadTemplate('admin_showdown');
        echo $tpl->render(array('product_one'=>$product_one, 'product_two'=>$product_two));
        die();
    }

    // show the voting form

    $tpl = $mustache->loadTemplate('vote_showdown');
    echo $tpl->render(array('product_one'=>$product_one, 'product_two'=>$product_two));


