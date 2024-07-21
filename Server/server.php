<?php
$url = parse_url(getenv("REDIS_TLS_URL"));
$redis = new Redis();
$redis->connect("tls://" . $url["host"], $url["port"], 0, NULL, 0, 0, [
    "auth" => $url["pass"],
    "stream" => ["verify_peer" => false, "verify_peer_name" => false],
]);

/**
 * Insert information on redis
 * @param hash_key 
 * @param data
 */
function insert_redis($hash_key, $data)
{
    try {
        if (check_connection_redis()) {
            return $redis->hMSet($hash_key, $data);
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: Não foi possivel inserir os dados no redis',  $e->getMessage(), "\n";
    }
    return -1;
}

/**
 * Check if there is a connection to redis
 */
function check_connection_redis()
{
    if ($redis->ping())
        return true;
    else {
        throw new Exception('Not able to connect to redis');
        return false;
    }
}

/**
 * Remove information of this key type of redis
 * @param key
 */
function remove_redis($key)
{
    try {
        check_connection_redis();
        $redis->del($key);
    } catch (Exception $e) {
        echo 'Exceção capturada: Não foi possível remover o dado do redis',  $e->getMessage(), "\n";
    }
}


/**
 * Clear all the data from redis
 */
function clear_all_redis()
{
    try {
        check_connection_redis();
        $redis->flushAll();
    } catch (Exception $e) {
        echo 'Exceção capturada: Não foi possível deletar os dados do redis',  $e->getMessage(), "\n";
    }
}

function get_redis($key, $hashfield)
{
    try {
        check_connection_redis();
        return $redis->hGet($key, $hashfield);
    } catch (Exception $e) {
        echo 'Exceção capturada: Não foi possível deletar os dados do redis',  $e->getMessage(), "\n";
    }
}



insert_redis('id', array(
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 36,
));

get_redis('id', 'name');

/*

"""
{
id : 'Idunico sala',
number_users : numero_de_jogadores,
game_information : [
    game_phase : 'situacao blablabla'
    game_prompt : 'prompt'
]
players_information: [
    {
        name : nome_do_player
        input : player_input
        return_message : 
    },
    {
        name : nome_do_player
        input : player_input
    }
]
}
"""

*/