<?php
unlink('./items/items_game_cdn.txt');
unlink('./items/items_game_live.txt');
unlink('./items/items_game.txt');

copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game_cdn.txt', './items/items_game_cdn.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game_live.txt', './items/items_game_live.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\items\items_game.txt', './items/items_game.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\resource\valve_english.txt', './misc/valve_english.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\resource\csgo_english.txt', './misc/csgo_english.txt');
copy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\mapautocompile.txt', './misc/mapautocompile.txt');

rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\cfg\\', './cfg/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\cfg\gamemode_*.*.cfg');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\\', './weapon/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\weapon_*.*');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\\', './sounds/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\game_sounds*.*');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\\', './sounds/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\scripts\soundscapes*.*');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\cs_*.jpg');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\cs_*.txt');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\ar_*.jpg');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\ar_*.txt');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\de_*.jpg');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\\', './maps/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\maps\de_*.txt');
rcopy('C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\\', './misc/', 'C:\Program Files (x86)\Steam\steamapps\common\Counter-Strike Global Offensive\csgo\game*.txt');

$key = file_get_contents('./key.txt');
$s = json_decode(fetch('https://api.steampowered.com/IEconItems_730/GetSchemaURL/v2/?key=' . $key . '&format=json'), true);
$u = fetch($s['result']['items_game_url']);
$myfile = fopen("./items/schema_730.txt", "w") or die("Unable to open file!");
fwrite($myfile, $u);
fclose($myfile);

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

function fetch($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function rcopy($src, $dst,$glob) {
	$files = glob($glob);
	foreach($files as $file){
		echo 'File: ' . $file . "\n";
		$file_to_go = str_replace($src,$dst,$file);
		copy($file, $file_to_go);
	}
}