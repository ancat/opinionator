<?PHP
$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!");

$data = array(
	array('product_name' => 'Samsung Rugby III', 'product_image' => 'http://i.imgur.com/ugnKGWw.png'),
	array('product_name' => 'LG Optimus F3', 'product_image' => 'http://i.imgur.com/jvi7azp.jpg'),
	array('product_name' => 'Samsung Galaxy S III', 'product_image' => 'http://i.imgur.com/wPP1T90.jpg'),
	array('product_name' => 'Samsung Galaxy S 4', 'product_image' => 'http://i.imgur.com/nYkQofel.jpg'),
	array('product_name' => 'Samsung Galaxy Note II', 'product_image' => 'http://i.imgur.com/kPRmmCB.jpg'),
	array('product_name' => 'Microsoft Xbox', 'product_image' => 'http://i.imgur.com/BFIj14Jl.jpg'),
	array('product_name' => 'Nokia Lumia 520', 'product_image' => 'http://i.imgur.com/qbZ0YGZl.jpg'),
	array('product_name' => 'Nexus 4', 'product_image' => 'http://i.imgur.com/PQ3bLnj.png'),
	array('product_name' => 'Nexus 5', 'product_image' => 'http://i.imgur.com/YNjKRu2.png'),
	array('product_name' => 'iPhone 5', 'product_image' => 'http://i.imgur.com/oRywV8c.jpg'),
	array('product_name' => 'iPhone 5s', 'product_image' => 'http://i.imgur.com/K0x6Lfzl.jpg'),
	array('product_name' => 'iPhone 5c', 'product_image' => 'http://i.imgur.com/PfrA7Brl.jpg'),
	array('product_name' => 'Leapfrog Chat and Count Phone', 'product_image' => 'http://i.imgur.com/FfC41Qu.jpg'),
	array('product_name' => 'Burger Phone', 'product_image' => 'http://i.imgur.com/fKo0Gix.jpg'),
	// array('product_name' => '', 'product_image' => ''),
);

$result = pg_prepare($pg, "query", 'INSERT INTO products (product_name, product_image) VALUES ($1, $2)');
foreach ($data as $datum) {
	$result = pg_execute($pg, "query", array($datum["product_name"], $datum["product_image"]));
}
?>
