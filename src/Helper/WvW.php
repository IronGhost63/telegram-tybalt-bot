<?php
namespace TybaltBot\Helper\WvW;

use GW2Treasures\GW2Api\GW2Api;

function PPT_count($match){
	$score = ['Red' => 0, 'Green' => 0, 'Blue' => 0];

	foreach($match->maps as $map){
		foreach($map->objectives as $objective){
			$score[$objective->owner] += $objective->points_tick;
		}
	}

	return $score;
}

/**
* @param string 	$map	Center|RedHome|BlueHome|GreenHome  
*/
function PPT_count_map($match, $zone){
	$score = ['Red' => 0, 'Green' => 0, 'Blue' => 0];

	if(!in_array($zone, ['Center', 'RedHome', 'GreenHome', 'BlueHome'])){
		return PPT_count($match);
	}

	foreach($match->maps as $map){
		if($map->type == $zone){
			foreach($map->objectives as $objective){
				$score[$objective->owner] += $objective->points_tick;
			}
		}
	}

	return $score;
}

function get_match_score($map = 'all', $home = 1018){
	try{
		$api = new \GW2Treasures\GW2Api\GW2Api();
		$match = $api->wvw()->matches()->world($home);
		$worlds = $api->worlds()->many([$match->worlds->red, $match->worlds->green, $match->worlds->blue]);
	
		return call_user_func(__NAMESPACE__ ."\get_match_score_".$map, $match, $worlds);
	}catch(\GW2Treasures\GW2Api\Exception\ApiException $e){
		return "Error: " . $e->getMessage();
	}
}

function get_match_score_all($match, $worlds){
	$red_kills = $match->kills->red;
	$red_deaths = $match->deaths->red;
	$red_kdr = round($red_kills/$red_deaths, 2);

	$green_kills = $match->kills->green;
	$green_deaths = $match->deaths->green;
	$green_kdr = round($green_kills/$green_deaths, 2);

	$blue_kills = $match->kills->blue;
	$blue_deaths = $match->deaths->blue;
	$blue_kdr = round($blue_kills/$blue_deaths, 2);

	$PPT = PPT_count($match);

	$response = "WvW score for current match" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[0]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Red'] . PHP_EOL;
	$response .= "Victory Points: " . $match->victory_points->red . PHP_EOL;
	$response .= "Current Warscore: " . end($match->skirmishes)->scores->red . PHP_EOL;
	$response .= "KDR: " . $red_kills . "/" . $red_deaths . " (_" . $red_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[1]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Green'] . PHP_EOL;
	$response .= "Victory Points: " . $match->victory_points->green . PHP_EOL;
	$response .= "Current Warscore: " . end($match->skirmishes)->scores->green . PHP_EOL;
	$response .= "KDR: " . $green_kills . "/" . $green_deaths . " (_" . $green_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[2]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Blue'] . PHP_EOL;
	$response .= "Victory Points: " . $match->victory_points->blue . PHP_EOL;
	$response .= "Current Warscore: " . end($match->skirmishes)->scores->blue . PHP_EOL;
	$response .= "KDR: " . $blue_kills . "/" . $blue_deaths . " (_" . $blue_kdr . "_)" . PHP_EOL . PHP_EOL;

	return $response;
}

function get_match_score_ebg($match, $worlds){
	foreach($match->maps as $map){
		if($map->type == "Center"){
			$red_kills = $map->kills->red;
			$red_deaths = $map->deaths->red;
			$red_kdr = round($red_kills/$red_deaths, 2);

			$green_kills = $map->kills->green;
			$green_deaths = $map->deaths->green;
			$green_kdr = round($green_kills/$green_deaths, 2);

			$blue_kills = $map->kills->blue;
			$blue_deaths = $map->deaths->blue;
			$blue_kdr = round($blue_kills/$blue_deaths, 2);
		}
	}

	$PPT = PPT_count_map($match, 'Center');

	$response = "WvW score for current match - Eternal Battlegrounds" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[0]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Red'] . PHP_EOL;
	$response .= "KDR: " . $red_kills . "/" . $red_deaths . " (_" . $red_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[1]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Green'] . PHP_EOL;
	$response .= "KDR: " . $green_kills . "/" . $green_deaths . " (_" . $green_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[2]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Blue'] . PHP_EOL;
	$response .= "KDR: " . $blue_kills . "/" . $blue_deaths . " (_" . $blue_kdr . "_)" . PHP_EOL . PHP_EOL;

	return $response;
}

function get_match_score_red($match, $worlds){
	foreach($match->maps as $map){
		if($map->type == "RedHome"){
			$red_kills = $map->kills->red;
			$red_deaths = $map->deaths->red;
			$red_kdr = round($red_kills/$red_deaths, 2);

			$green_kills = $map->kills->green;
			$green_deaths = $map->deaths->green;
			$green_kdr = round($green_kills/$green_deaths, 2);

			$blue_kills = $map->kills->blue;
			$blue_deaths = $map->deaths->blue;
			$blue_kdr = round($blue_kills/$blue_deaths, 2);
		}
	}

	$PPT = PPT_count_map($match, 'RedHome');

	$response = "WvW score for current match - Red Desert Borderlands" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[0]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Red'] . PHP_EOL;
	$response .= "KDR: " . $red_kills . "/" . $red_deaths . " (_" . $red_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[1]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Green'] . PHP_EOL;
	$response .= "KDR: " . $green_kills . "/" . $green_deaths . " (_" . $green_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[2]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Blue'] . PHP_EOL;
	$response .= "KDR: " . $blue_kills . "/" . $blue_deaths . " (_" . $blue_kdr . "_)" . PHP_EOL . PHP_EOL;

	return $response;
}

function get_match_score_green($match, $worlds){
	foreach($match->maps as $map){
		if($map->type == "GreenHome"){
			$red_kills = $map->kills->red;
			$red_deaths = $map->deaths->red;
			$red_kdr = round($red_kills/$red_deaths, 2);

			$green_kills = $map->kills->green;
			$green_deaths = $map->deaths->green;
			$green_kdr = round($green_kills/$green_deaths, 2);

			$blue_kills = $map->kills->blue;
			$blue_deaths = $map->deaths->blue;
			$blue_kdr = round($blue_kills/$blue_deaths, 2);
		}
	}

	$PPT = PPT_count_map($match, 'GreenHome');

	$response = "WvW score for current match - Green Alpine Borderlands" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[0]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Red'] . PHP_EOL;
	$response .= "KDR: " . $red_kills . "/" . $red_deaths . " (_" . $red_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[1]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Green'] . PHP_EOL;
	$response .= "KDR: " . $green_kills . "/" . $green_deaths . " (_" . $green_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[2]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Blue'] . PHP_EOL;
	$response .= "KDR: " . $blue_kills . "/" . $blue_deaths . " (_" . $blue_kdr . "_)" . PHP_EOL . PHP_EOL;

	return $response;
}

function get_match_score_blue($match, $worlds){
	foreach($match->maps as $map){
		if($map->type == "BlueHome"){
			$red_kills = $map->kills->red;
			$red_deaths = $map->deaths->red;
			$red_kdr = round($red_kills/$red_deaths, 2);

			$green_kills = $map->kills->green;
			$green_deaths = $map->deaths->green;
			$green_kdr = round($green_kills/$green_deaths, 2);

			$blue_kills = $map->kills->blue;
			$blue_deaths = $map->deaths->blue;
			$blue_kdr = round($blue_kills/$blue_deaths, 2);
		}
	}

	$PPT = PPT_count_map($match, 'BlueHome');

	$response = "WvW score for current match - Blue Alpine Borderlands" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[0]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Red'] . PHP_EOL;
	$response .= "KDR: " . $red_kills . "/" . $red_deaths . " (_" . $red_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[1]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Green'] . PHP_EOL;
	$response .= "KDR: " . $green_kills . "/" . $green_deaths . " (_" . $green_kdr . "_)" . PHP_EOL . PHP_EOL;
	$response .= "*" . $worlds[2]->name . "*" . PHP_EOL;
	$response .= "PPT: " . $PPT['Blue'] . PHP_EOL;
	$response .= "KDR: " . $blue_kills . "/" . $blue_deaths . " (_" . $blue_kdr . "_)" . PHP_EOL . PHP_EOL;

	return $response;
}