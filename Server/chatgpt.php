<?php
define("KEY_API_CHATGPT",     getenv("CHATGPT_KEY"));

class ChatGPT
{

    private $key_api;
    public $prompt;
    public $result;
    public $prompt_final;

    function __construct($prompt)
    {
        $this->key_api = KEY_API_CHATGPT;
        $this->prompt = $prompt;
    }

    function sanitize_string()
    {
    }

    function unsanitize_string()
    {
    }

    function organize_string()
    {
    }

    function send_prompt()
    {
        $data = [
            "model" => "gpt-4o-mini",  // ou o modelo que você estiver usando
            "messages" => [
                ["role" => "system", "content" => "Você é condensador de histórias. Um cenário será fornecido a você na tag [cenario]. Para cada jogador, uma ação será fornecida na tag [Player] com um número identificador. Responda cada ação de cada jogador com até 50 palavras, descrevendo o resultado da ação. No final, forneça o resultado final de cada jogador na tag [Result] com 1 para vivo e 0 para morto, garantindo que alguns jogadores sobrevivem e outros morrem. A ação de cada jogador não impacta no cenário do outro. Acabe a frase de ações com: você sobrevive, você saiu, você morreu ou algo similar"],
                ["role" => "user", "content" => $this->prompt]
            ],
            "max_tokens" => 300  // Ajuste conforme necessário
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->key_api
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Erro:' . curl_error($ch);
        } else {
            $this->result = json_decode($response, true);
        }
        curl_close($ch);
    }

    function show_results()
    {
        if (isset($this->result['choices'][0]['message']['content'])) {
            echo $this->result['choices'][0]['message']['content'];
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
}
