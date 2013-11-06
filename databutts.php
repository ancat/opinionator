<?PHP
$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!");
$result = pg_prepare($pg, "query", 'INSERT INTO products (product_name, product_image) VALUES ($1, $2)');
$result = pg_execute($pg, "query", array("Bread Is A Losers", "http://i.imgur.com/Ojzw8r9.jpg"));
?>

create table votes (
    vote_id serial primary key not null,
    showdown_id int not null,
    ip_address char(15) not null,
    timestamp int not null
);

create index showdown_id on votes (showdown_id);

create table showdowns (
    showdown_id serial primary key not null,
    product_id_1 int not null,
    product_id_2 int not null
);

create index product_id_1 on showdowns (product_id_1);
create index product_id_2 on showdowns (product_id_2);

create table products (
    product_id serial primary key not null,
    product_name char(255) not null,
    product_image char(512) not null
);

create table urls (
    url_id serial primary key not null,
    url_unique_string char(255) not null,
    url_active int not null,
    showdown_id int not null
);

create index url_active on urls (url_active);
create index showdown_id on urls (showdown_id);
