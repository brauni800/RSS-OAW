<?php
require_once 'vendor/simplepie/simplepie/autoloader.php';
require_once 'db.config.php';

$url = 'http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml';
$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->set_cache_location('./cache');
$feed->init();
$itemQty = $feed->get_item_quantity();

$sql = '';
foreach($feed->get_items(3,3) as $item) {
    $sql .= 'INSERT INTO item(title, link, date, description) VALUES("'
    . $item->get_title() . '", "'
    . $item->get_link() . '", "'
    . $item->get_date('Y-m-d H:i:s') . '", "'
    . $item->get_description() . '");';
}
if($conn->multi_query($sql) === TRUE) {
    echo 'Se ha insertado correctamente';
}
else {
    echo 'Error: ' . $sql . '<br/>' . $conn->error;
}
$conn->close();