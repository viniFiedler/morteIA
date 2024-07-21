<?php
class RedisManager
{

    public $url;
    public $redis;



    function connect()
    {
        $this->url = parse_url(getenv("REDIS_TLS_URL"));
        $this->redis = new Redis();
        $this->redis->connect("tls://" . $this->url["host"], $this->url["port"], 0, NULL, 0, 0, [
            "auth" => $this->url["pass"],
            "stream" => ["verify_peer" => false, "verify_peer_name" => false],
        ]);
    }
    /**
     * Insert information on redis
     * @param hash_key 
     * @param data
     */
    function insert_redis($hash_key, $data)
    {
        try {
            if ($this->check_connection_redis()) {
                return $this->redis->hMSet($hash_key, $data);
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
        if ($this->redis->ping())
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
            $this->check_connection_redis();
            $this->redis->del($key);
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
            $this->check_connection_redis();
            $this->redis->flushAll();
        } catch (Exception $e) {
            echo 'Exceção capturada: Não foi possível deletar os dados do redis',  $e->getMessage(), "\n";
        }
    }

    function get_redis($key, $hashfield)
    {
        try {
            $this->check_connection_redis();
            return $this->redis->hGet($key, $hashfield);
        } catch (Exception $e) {
            echo 'Exceção capturada: Não foi possível deletar os dados do redis',  $e->getMessage(), "\n";
        }
    }
}

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