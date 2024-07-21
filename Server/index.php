<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Render the prompt view
 *
 * @param string $prompt
 * @param string $playerName
 * @param string|false $input
 * @return void
 */
function render($prompt, $playerName = "", $input = "") {
    require "../Client/prompt-view.php";
}

require "server.php";
