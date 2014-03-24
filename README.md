weather class
=============

PHP Weather class
Weather class: is a powerful,easy and expendable PHP class !

It's very easy to configure , and it comes with Multi themes !
Also it contains forecast for next three days just click icon next to city name.
=======================
		$weather->set_cache(60*60);
	    $weather->set_city('cairo');
	    $weather->set_theme('darkred');
	    echo $weather->get_weather(); 
		
Weather widget: has a Powerful caching system !

=========================================
For Online demo please visit <a href="http://deploy2cloud.com/demo/weather/">Weather class Demo</a>

Default temperature measurement is Celsius, You can change it to Fahrenheit very easy !

	$weather->set_temp_metrics('f');

Weather widget: support many languages and yet can be extended to support more easily !
Currently supported language by widget and weather API are :(English,Italian,Russian and French)
And API Support:

We support the following languages that you can use with the corresponded lang values: English - en, Russian - ru, Italian - it, Spanish - sp, Ukrainian - ua, German - de, Portuguese - pt, Romanian - ro, Polish - pl, Finnish - fi, Dutch - nl, French - fr, Bulgarian - bg, Swedish - se, Chinese Traditional - zh_tw, Chinese Simplified - zh_cn, Turkish - tr

Weather widget: can select city by name ie (Alexandria,EG) or id ie (3645532) or Longitude and Latitude ie(28.666668,77.216667)!

	 $weather->set_lang('fr');

Also you can control it's dimension !
	 $weather->set_dimention(550,248);
	 
This features is not enough ? Wait , do you know that you can get all of this info as a row PHP array !
And it's ready to be used with CodeIgniter as a library !