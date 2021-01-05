 
<?php

require_once 'Facebook/autoload.php';

if (!session_id())
{
    session_start();
}

// Call Facebook API

$facebook = new \Facebook\Facebook([
  'app_id'      => '726258211341741',
  'app_secret'     => 'eeb23f3b208c891fe88cb1818ee7ccaf',
  'default_graph_version'  => 'v2.10'
]);

?>