<?php
function connect_redis(){
    $url = parse_url(getenv("REDIS_TLS_URL"));
    $redis = new Redis();
    $redis->connect("tls://".$url["host"], $url["port"], 0, NULL, 0, 0, [
    "auth" => $url["pass"],
    "stream" => ["verify_peer" => false, "verify_peer_name" => false],
        ])
}


$teste = $redis->ping('hello');

echo $teste;



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