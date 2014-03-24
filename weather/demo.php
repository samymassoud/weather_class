<?php

include 'weathercore.php';
$weather = new weather(array('city'=>'alexandria','temp_metrics'=>'c'));


?>

<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8" />
	<title>Weather widget Demo</title>
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<script type="text/javascript" src="jquery-1.10.2.min.js" ></script>
	<style>
	    .weather_box{float:left;margin-left: 30px;}
	    .step{width:100%;margin: 10px;}
	    .hint{width: 100%;background-color: #f9ecbf;color: #6D6969;border: 1px solid #f4cf89;}
	    .clear{clear:both;}
	</style>
    </head> 
    <body>
	<div style="width:900px;margin: 0 auto;color:#747171;margin-top: 30px;font-family: 'Montserrat'; ">
	    <div style="width:100%;text-align: center"><h2>Weather widget demo</h2></div>
	    <div class='step'>
		<br/>
		<p><strong>Weather widget:</strong> is a powerful,easy and extendable PHP class !
		</p>
		<br/>
		<p>It's very easy to configure , and it comes with  <strong>Multi themes !</strong><br/><br/>
		    
		<p class='hint'>It includes <strong>blue,darkblue,green,black and darkred</strong> themes.
		<br/>
		</p>
		
		<br/><br/>
		<p>
		    Also it contains forecast for next three days just click icon next to city name.
		</p>
	    </div>
	    
	    
	    <div class='weather_box'>
		<?php echo $weather->get_weather(); ?>
		
	    </div>
	    <div class="weather_box">
	    <?php 
	    $weather->set_cache(60*60);
	    $weather->set_city('cairo');
	    $weather->set_theme('darkred');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    <div class="weather_box">
	    <?php 
	    $weather->set_city('istanbul');
	    $weather->set_theme('black');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    <div class='clear'></div>
	    <br/>
	    <div class='step'>
		<br/><br/>
		<p><strong>Weather widget:</strong> has a Powerful caching system !
		</p>
		<br/>
		<p>All data on this page except first widget are cached for one Hour !
		    
		<br/><br/>
		<p>
		    Default temperature measurement is celsius, You can change it to fahrenheit very easy !
		</p>
	    </div>
	    
	    
	    <div class='weather_box'>
		<?php 
		$weather->set_temp_metrics('f');
		$weather->set_theme('blue');
		echo $weather->get_weather(); ?>
		
	    </div>
	    <div class="weather_box">
	    <?php 
	    $weather->set_city('lublin');
	    $weather->set_theme('green');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    <div class="weather_box">
	    <?php 
	    $weather->set_city('istanbul');
	    $weather->set_theme('black');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	
	    
	    
	    
	    
	    <div class='clear'></div>
	    <br/>
	    <div class='step'>
		<br/>
		<p><strong>Weather widget:</strong> support many languages and yet can be extended to support more easily !
		</p>
		<br/>
		<p>Currently supported language by widget and weather API are :(English,Italian,Russian and French)<br/>
		 And API Support:
		<blockquote class='hint'>
		    We support the following languages that you can use with the corresponded lang values: English - en, Russian - ru, Italian - it, Spanish - sp, Ukrainian - ua, German - de, Portuguese - pt, Romanian - ro, Polish - pl, Finnish - fi, Dutch - nl, French - fr, Bulgarian - bg, Swedish - se, Chinese Traditional - zh_tw, Chinese Simplified - zh_cn, Turkish - tr 
		</blockquote>
		    
		
	    </div>
	    
	    
	    <div class='weather_box'>
		<?php 
		$weather->set_lang('it');
		$weather->set_temp_metrics('c');
		$weather->set_theme('blue');
		echo $weather->get_weather(); ?>
		
	    </div>
	    <div class="weather_box">
	    <?php 
	    $weather->set_city('lublin');
	    $weather->set_lang('ru');
	    $weather->set_theme('darkred');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    <div class="weather_box">
	    <?php 
	    $weather->set_city('maldives');
	    $weather->set_theme('black');
	    $weather->set_lang('fr');
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    
	    
	    <div class='clear'></div>
	    <br/>
	    <div class='step'>
		<br/>
		<p><strong>Weather widget:</strong> can select city by name ie (Alexandria,EG) or id ie (3645532) or Longitude and Latitude ie(28.666668,77.216667)!
		</p>
		<br/>
		<p>Also you can control it's dimension !
		<blockquote class='hint'>
		    This features is not enough ?
		    Wait , do you know that you can get all of this info as a row PHP array !<br/>
		    And it's ready to be used with <strong>CodeIgniter</strong> as a library !
		</blockquote>
		    
		
	    </div>
	    
	    
	    <div class='weather_box'>
		<?php 
		$weather->set_lang('en');
		$weather->set_city(null, '3645532');
		echo $weather->get_weather(); ?>
		
	    </div>
	    
	    
	    <div class="weather_box">
	    <?php 
	    $weather->set_lang('en');
	    $weather->set_city('maldives');
	    $weather->set_dimention(550,248);
	    echo $weather->get_weather(); 
	    
	    ?></div>
	    
	    <div class='clear'></div>
	    <br/><br/><br/>
	    <div class='hint' style='text-align: center'>All right reserved, This class uses OpenWeatherMap.org</div>
	    
	</div>
	
    </body>
    
</html>