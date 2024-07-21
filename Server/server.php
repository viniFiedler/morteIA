<?php

$url = parse_url(getenv("REDIS_TLS_URL"));
$redis = new Redis();
$redis->connect("tls://".$url["host"], $url["port"], 0, NULL, 0, 0, [
  "auth" => $url["pass"],
  "stream" => ["verify_peer" => false, "verify_peer_name" => false],
]);

$teste = $redis->ping('hello');

echo $teste;
