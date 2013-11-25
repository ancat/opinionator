<?PHP
    require_once 'includes/include_all.php';

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        show_error('Please go back and submit the form.');
        die();
    }

    $product_one = (int) $_POST['product_one'];
    $product_two = (int) $_POST['product_two'];

    if ($product_one == $product_two) {
        show_error('You can\'t compare a product to itself! That boy ain\'t right.');
        die();
    }

    $products = pg_prepare($postgres, 'query', 'SELECT * FROM products WHERE product_id in ($1, $2)');
    $result = pg_execute($postgres, 'query', array($product_one, $product_two));
    if (pg_num_rows($result) != 2) {
        show_error('At least one of the products you chose is invalid.');
        die();
    }

    // basic errors out of teh way now...
    $query = pg_prepare($postgres, 'create_showdown', 'INSERT INTO showdowns (product_id_1, product_id_2) VALUES ($1, $2) RETURNING showdown_id');
    $result = pg_execute($postgres, 'create_showdown', array($product_one, $product_two));
    $showdown_id = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    $showdown_id = $showdown_id['showdown_id'];
    if (!$showdown_id) {
        show_error('Something went wrong with the sql. ');
        die();
    }

    $random_url = substr(md5(rand()*rand()), 0, 16);
    $sekure_hmac = hash_hmac('md5', $random_url, 'why cant this semester be over already');
    $query = pg_prepare($postgres, 'create_url', 'INSERT INTO urls (url_unique_string, url_active, showdown_id) VALUES ($1, $2, $3)');
    $result = pg_execute($postgres, 'create_url', array($random_url, 1, $showdown_id));
    if (!$result) {
        show_error('Failed to create you a unique url...  ' . pg_last_error() );
        die();
    }

    $tpl = $mustache->loadTemplate('make_showdown');
    echo $tpl->render(array('product_url'=>$random_url, 'sekure_hmac'=>$sekure_hmac, 'host'=>$_SERVER['HTTP_HOST']));


