<?php
unlink('./items/items_game_cdn.txt');
unlink('./items/items_game_live.txt');
unlink('./items/items_game.txt');

copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game_cdn.txt', './items/items_game_cdn.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game_live.txt', './items/items_game_live.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game.txt', './items/items_game.txt');

$file = file_get_contents('./items/items_game_cdn.txt');
$preg = preg_match_all("/weapon_(.*?)=(.*?).png/", $file, $matches);

for ($i = 0; $i < count($matches[2]); $i++) {
    $ch = curl_init($matches[2][$i] . '.png');
    $fp = fopen('./skins/' . $matches[1][$i] . '.png', 'w+');
    echo $matches[1][$i] . "\n";
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
