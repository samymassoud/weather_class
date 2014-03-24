<?php

/**
 * Weather widget class
 * All Documentation included in this document.
 * For further developer note please see the Weather.php class
 * 
 * @version 1.0.0
 * @author Samy Massoud <samymassoud@gmail.com>
 * @link  www.egyspac.com/codecanyon/weather/demo.php
 * 
 * @tutorial 
 * This class main functionality is to provide weather wedget to use it easily and smoothly.
 * You can use this class with almost zero configuration , or configure it as far as you need !
 * 
 * When i started to write this class i put in mind to make it easy,clean and professional as much as i can.
 * 
 * To start using this class just do the following
 *  1- include attached weather.css file in your page.
 *  2- Make sure that you have embedded jquery version greater than 1.6 
 *  3- Include this class in your page and Make object from this class with required city
 *     $weather = new weather ("Cairo,EG");
 *     echo $weather->get_weather ();
 * And you will get a copy from this widget with cairo weather !
 * 
 * To start using this class as codeigniter library
 *  1- include attached weather.css file in your page.
 *  2- Make sure that you have embedded jquery version greater than 1.6 
 *  3- Move weather.php to application/libraries folder
 *     and you can load library by adding it to autoload.php or use
 *     $this->load->library ('weather');
 *     and at any place in your application (Controller or view)
 *     $this->weather->set_city ('Cairo,EG');
 *     echo $this->weather->get_weather ();
 * And you will get a copy from this widget with cairo weather !
 * 
 * 
 */
class weather {

    /**
     * Available themes for weather class
     * @var array 
     */
    private $themes = array(
	'blue' => 'theme-blue',
	'darkblue' => 'theme-darkblue',
	'green' => 'theme-green',
	'black' => 'theme-black',
	'darkred' => 'theme-darkred'
    );

    /**
     * Default theme , or user selected theme
     * @var string 
     */
    private $theme = "theme-darkblue";

    /**
     * Weather api link and weather forecast link
     * @var string 
     */
    private $weather_api = "http://api.openweathermap.org/data/2.5/weather?units=metric&";
    private $forecast_api = "http://api.openweathermap.org/data/2.5/forecast/daily/?cnt=4&units=metric&mode=json&";

    /**
     * City identifires , used to select city by name,id or lat. and lon.
     * @var string
     */
    private $city = "";
    private $city_id = "";
    private $city_lat = "";
    private $city_lon = "";

    /**
     * Selected temperature measurement
     * @var string 
     */
    private $temp_metric = "c";

    /**
     * Output type it can be empty or row for php array
     * @var string 
     */
    private $output = "";

    /**
     * Cache folder , this is the dfault folder , user can change it using configuration
     * @var string 
     */
    private $cache_folder = "./cache/";

    /**
     * Enable or disable cache
     * @var bool 
     */
    private $cache = false;

    /**
     * cache lifetime (By seconds)
     * @var integer 
     */
    private $cache_time = 600;

    /**
     * Widget dimention this is default values 
     * @var integer 
     */
    private $width = 270;
    private $height = 248;

    /**
     * weather info after processing it
     * @var array
     */
    private $weather_info = array();

    /**
     * Widget  languages,it can be extended by coping
     * for example 'En' array and translate it to any other language
     * @var array 
     */
    private $languages = array(
	'en' => array(
	    'cannot_access' => "Can't Access Weather API",
	    'invalid_city_info' => "Please select valid city information",
	    'show_next_days' => "Show weather next three days",
	    'back_to_weather' => "Back to current weather details",
	    'weather' => 'Weather',
	    'weather_desc' => "Weather description",
	    'wind' => 'Wind',
	    'wind_degree' => 'Wind degree',
	    'humidity' => 'Humidity',
	    'pressure' => 'Pressure',
	    'hi' => 'HI',
	    'lo' => 'LO'
	),
	'it' => array(
	    'cannot_access' => "Impossibile accedere Meteo",
	    'invalid_city_info' => "Si prega di selezionare le informazioni città valida",
	    'show_next_days' => "Mostra previsioni prossimi tre giorni",
	    'back_to_weather' => "Torna a correnti dettagli meteo",
	    'weather' => 'Meteo',
	    'weather_desc' => "descrizione Meteo",
	    'wind' => 'vento',
	    'wind_degree' => 'grado Vento',
	    'humidity' => 'umidità',
	    'pressure' => 'pressione',
	    'hi' => 'alto',
	    'lo' => 'basso'
	),
	'ru' => array(
	    'cannot_access' => "?? ??????? ???????? ?????? ?????? API",
	    'invalid_city_info' => "??????????, ???????? ?????????? ?????????? ?????",
	    'show_next_days' => "???????? ?????? ????????? ??? ???",
	    'back_to_weather' => "????????? ? ??????? ??????? ????????",
	    'weather' => '??????',
	    'weather_desc' => "???????? ??????",
	    'wind' => '?????',
	    'wind_degree' => '??????? ?????',
	    'humidity' => '?????????',
	    'pressure' => '????????',
	    'hi' => '???????',
	    'lo' => '??????'
	),
	'fr' => array(
	    'cannot_access' => "Impossible d'accéder à l'API Météo",
	    'invalid_city_info' => "S'il vous plaît sélectionner l'information de la ville valide",
	    'show_next_days' => "Montrez temps trois prochains jours",
	    'back_to_weather' => "Retour aux détails météorologiques actuelles",
	    'weather' => 'météo',
	    'weather_desc' => "Description météo",
	    'wind' => 'vent',
	    'wind_degree' => 'Degré de Vent',
	    'humidity' => 'humidité',
	    'pressure' => 'pression',
	    'hi' => 'haut',
	    'lo' => 'faible'
	)
    );
    //Available API Languages ' don't modify
    private $api_lang = array('en', 'it', 'ru', 'fr', 'ua', 'de', 'pt', 'ro', 'pl', 'fi', 'nl', 'sp', 'bg', 'se', 'zh_tw', 'zh_cn', 'tr');

    /**
     * Selected language for api and widget
     * @var string
     */
    private $lang = 'en';
    private $lang_api = 'en';

    /**
     * Construct weather widget you can provide any configration you want 
     * Click right # to see more
     * @example  $config = array ('theme' => 'blue',
     * 			'city' => 'cairo,eg',
     * 			'temp_metrics' => 'f');
     * $weather = new weather ($config);
     * 
     * @param type array
     */
    public function __construct($config = null) {
	if (is_array($config)) {
	    foreach ($config as $key => $value) {
		//Set Theme
		if ($key == "theme" && isset($this->themes[$value])) {
		    $this->theme = $this->themes[$value];
		}

		//Set City Name
		if ($key == 'city') {
		    $this->city = $value;
		}
		if ($key == 'city_id') {
		    $this->city_id = $value;
		}
		if ($key == 'city_lat') {
		    $this->city_lat = $value;
		}
		if ($key == 'city_lon') {
		    $this->city_lon = $value;
		}

		//Set Tempereature Metrics
		if ($key == 'temp_metrics' && ($value == "c" || $value == 'f')) {
		    $this->temp_metric = $value;
		}

		if ($key == "lang" && (isset($this->languages[$value]) || in_array($value, $this->api_lang))) {
		    if (isset($this->languages[$value])) {
			$this->lang = $value;
		    }

		    if (in_array($value, $this->api_lang)) {
			$this->lang_api = $value;
		    }
		}
		//Set Output
		if ($key == "output" && ($value == "row")) {
		    $this->output = "row";
		}
	    }
	} else {
	    $this->city = $config; //City Name
	}
    }

    // Start Setter Functions

    /**
     * set city by it's name or id or lat. and lon.
     * @param type string
     * @param type integer
     * @param type decimal
     * @param type decimal
     */
    public function set_city($name = null, $id = null, $lat = null, $lon = null) {
	if ($name) {
	    $this->city = $name;
	    $this->city_id = null;
	    $this->city_lat = null;
	    $this->city_lon = null;
	}

	if ($id) {
	    $this->city_id = $id;
	    $this->city = null;
	    $this->city_lat = null;
	    $this->city_lon = null;
	}

	if ($lat) {
	    $this->city_lat = $lat;
	    $this->city_id = null;
	    $this->city = null;
	}

	if ($lon)
	    $this->city_lon = $lon;
    }

    /**
     * Set Theme
     * 
     * @param type string
     */
    public function set_theme($theme) {
	if (isset($this->themes[$theme])) {
	    $this->theme = $this->themes[$theme];
	}
    }

    /**
     * Set temp. metrics
     * @param type char
     */
    public function set_temp_metrics($metrics = 'c') {
	if ($metrics == 'c' || $metrics == 'f')
	    $this->temp_metric = $metrics;
    }

    /**
     * Set language
     * @param type string
     */
    public function set_lang($lang) {
	if (isset($this->languages[$lang])) {
	    $this->lang = $lang;
	}

	if (in_array($lang, $this->api_lang)) {
	    $this->lang_api = $lang;
	}
    }

    /**
     * Set widget dimention
     * @param type integer
     * @param type integer
     */
    public function set_dimention($width, $height) {
	if ($width > 270)
	    $this->width = $width;
	if ($height > 248)
	    $this->height = $height;
    }

    /**
     * Set output type accept empty string or word 'row'
     * @param type string
     */
    public function set_output($out = "") {
	if ($out == "row") {
	    $this->output = "row";
	}
    }

    /**
     * set cache time and folder and this will enable cache
     * you have to provide cache time greater than 0 second
     * and cache folder name is optional , if you didn't provide it 
     * it will use default cache folder
     * @param type integer
     * @param type string
     */
    public function set_cache($cache_time, $cache_folder = false) {
	if ($cache_time > 0) {
	    $this->cache = TRUE;
	    $this->cache_time = $cache_time;
	    if ($cache_folder)
		$this->cache_folder = $cache_folder;
	}
    }

    /**
     * Stop caching
     */
    public function disable_cache() {
	$this->cache = FALSE;
    }

    /**
     * get weather widget or row array according to your config
     * @return type
     */
    public function get_weather() {
	if (!$this->city && !$this->city_id && (!$this->city_lat && !$this->city_lon))
	    return $this->languages[$this->lang]['invalid_city_info'];
	//City Detrmine method
	$search_q = "";
	if ($this->city) {
	    $search_q = "q=" . $this->city;
	} elseif ($this->city_id) {
	    $search_q = "id=" . $this->city_id;
	} else {
	    $search_q = "lat=" . $this->city_lat . "&lon=" . $this->city_lon;
	}

	$read_cache = $this->read_wether();

	if ($read_cache) {
	    $weather = true;
	} else {
	    $weather = @file_get_contents($this->weather_api . $search_q . '&lang=' . $this->lang_api);
	}

	if ($weather) {
	    if (!$read_cache) {
		$weather_forecast = @file_get_contents($this->forecast_api . $search_q . '&lang=' . $this->lang_api);
		$weather = json_decode($weather);
		$weather_forecast = json_decode($weather_forecast);
		//print_r($weather_forecast);

		if (isset($weather->message))
		    return ($weather->message);
		//Extract Weather
		$this->extract_weather($weather, $weather_forecast);
	    }

	    if ($this->output == "row") {
		return $this->weather_info;
	    }
	    //Else return markup
	    return $this->markup();
	} else {
	    return $this->languages[$this->lang]['cannot_access'];
	}
    }

    //Private Methods
    /**
     * extract weather to weather info
     * @param type object
     * @param type object
     */
    private function extract_weather($weather, $weather_forecast) {
	//Normal Weather data
	$this->weather_info['place'] = $weather->name . (($weather->name) ? ',' : '' ) . $weather->sys->country;
	$this->weather_info['icon'] = $weather->weather[0]->icon;
	$this->weather_info['weather_main'] = $weather->weather[0]->main;
	$this->weather_info['weather_description'] = $weather->weather[0]->description;
	$this->weather_info['temp_c'] = round($weather->main->temp, 1);
	$this->weather_info['temp_c_accurate'] = ($weather->main->temp);
	$this->weather_info['temp_f'] = round((9 / 5) * $weather->main->temp, 1) + 32;
	$this->weather_info['temp_f_accurate'] = ((9 / 5) * $weather->main->temp) + 32;
	$this->weather_info['temp'] = (($this->temp_metric == 'c') ? $this->weather_info['temp_c'] : $this->weather_info['temp_f']);
	$this->weather_info['symbol'] = (($this->temp_metric == 'c') ? 'C' : 'F');
	$this->weather_info['humidity'] = $weather->main->humidity;
	$this->weather_info['wind_speed'] = $weather->wind->speed;
	//Aditinal info
	$this->weather_info['wind_degree'] = $weather->wind->deg;
	$this->weather_info['pressure'] = $weather->main->pressure;
	$this->weather_info['lat'] = $weather->coord->lat;
	$this->weather_info['lon'] = $weather->coord->lon;

	//Forecast Data For Next Three days
	$forecaster = array();
	for ($i = 1; $i <= 3; $i++) {
	    $forecaster[$i]['day'] = date('D', $weather_forecast->list[$i]->dt);
	    $forecaster[$i]['month'] = date('M d', $weather_forecast->list[$i]->dt);
	    $forecaster[$i]['min_temp_c'] = round($weather_forecast->list[$i]->temp->min, 1);
	    $forecaster[$i]['min_temp_f'] = round((9 / 5) * $weather_forecast->list[$i]->temp->min, 1) + 32;
	    $forecaster[$i]['max_temp_c'] = round($weather_forecast->list[$i]->temp->max, 1);
	    $forecaster[$i]['max_temp_f'] = round((9 / 5) * $weather_forecast->list[$i]->temp->max, 1) + 32;
	    $forecaster[$i]['temp_max'] = (($this->temp_metric == 'c') ? $forecaster[$i]['max_temp_c'] : $forecaster[$i]['max_temp_f']);
	    $forecaster[$i]['temp_min'] = (($this->temp_metric == 'c') ? $forecaster[$i]['min_temp_c'] : $forecaster[$i]['min_temp_f']);
	    $forecaster[$i]['symbol'] = (($this->temp_metric == 'c') ? 'C' : 'F');
	    $forecaster[$i]['weather_main'] = $weather_forecast->list[$i]->weather[0]->main;
	    $forecaster[$i]['icon'] = $weather_forecast->list[$i]->weather[0]->icon;
	}
	//Append To weather info 
	$this->weather_info['forecast'] = $forecaster;

	//IF Cache enabled,save data to file
	if ($this->cache) {
	    $this->save_weather($this->weather_info);
	}
    }

    /**
     * save weather to cache
     * @param type array
     */
    private function save_weather($weather) {
	$weather_json = json_encode($weather);
	$file = $this->cache_folder . $this->city . '.txt';
	$handle = @fopen($file, 'w');
	if ($handle) {
	    fwrite($handle, $weather_json);
	    fclose($handle);
	}
    }

    /**
     * load weather from cache
     * @return boolean
     */
    private function read_wether() {
	$file = $this->cache_folder . $this->city . '.txt';
	if (file_exists($file)) {
	    if (((time() - $this->cache_time) > filemtime($file)) || !$this->cache)
		return false; //This file is not fresh or cache disabled
	    $handle = @fopen($file, 'r');
	    if ($handle) {
		$json_weather = fread($handle, filesize($file));
		$this->weather_info = json_decode($json_weather, true);
		/** CHECK FOR METRICS AND FIX IT * */
		if ($this->temp_metric == "c") {
		    $this->weather_info['temp'] = $this->weather_info['temp_c'];
		    $this->weather_info['symbol'] = 'C';

		    for ($i = 1; $i <= 3; $i++) {
			$this->weather_info['forecast'][$i]['temp_min'] = $this->weather_info['forecast'][$i]['min_temp_c'];
			$this->weather_info['forecast'][$i]['temp_max'] = $this->weather_info['forecast'][$i]['max_temp_c'];
			$this->weather_info['forecast'][$i]['symbol'] = 'C';
		    }
		} else {
		    $this->weather_info['temp'] = $this->weather_info['temp_f'];
		    $this->weather_info['symbol'] = 'F';
		    for ($i = 1; $i <= 3; $i++) {
			$this->weather_info['forecast'][$i]['temp_min'] = $this->weather_info['forecast'][$i]['min_temp_f'];
			$this->weather_info['forecast'][$i]['temp_max'] = $this->weather_info['forecast'][$i]['max_temp_f'];
			$this->weather_info['forecast'][$i]['symbol'] = 'F';
		    }
		}

		fclose($handle);
		return true;
	    }
	}

	return false;
    }

    /**
     * Get weather markup(Widget)
     * @return string
     */
    private function markup() {
	$next_weather = $this->languages[$this->lang]['show_next_days'];
	$back_weather = $this->languages[$this->lang]['back_to_weather'];

	$markup = '<div class="widget" style="width:' . $this->width . 'px;height:' . $this->height . 'px"> 
		   <div class="upper">
		   <div class="degree-box">
		   <div class="temp">
		   <h2 class="title"><span class="update">' . $this->weather_info['temp'] . '<sup>o</sup>' . $this->weather_info['symbol'] . '</span></h2></div>
		   <div class="place update ' . $this->theme . '-place">' . $this->weather_info['place'] . '</div></div>
		   <div id="change-weather" onclick="change_weather($(this))" show-ul="weather-forecast"  class="change-weather next-icon" title="' . $next_weather . '"></div>
		   </div>
		   <div class="clear"></div>
		   <div class="lower ' . $this->theme . '-lower">
		    
		   <ul id="weather-info" class="infos-w">
		   <li class="info-w weather"><h2 class="title"><span class="weather-bg" title="' . $this->languages[$this->lang]['weather'] . '"></span></h2>
		    <span class="update">' . $this->weather_info['weather_main'] . '</span>
		   <h2 class="title"><span><img title="' . $this->languages[$this->lang]['weather_desc'] . '" src="http://openweathermap.org/img/w/' . $this->weather_info['icon'] . '.png" /></span></h2>
		       <span class="update">' . $this->weather_info['weather_description'] . '</span></li>
		   <li class="info-w wind"><h2 class="title"><span class="wind-bg" title="' . $this->languages[$this->lang]['wind'] . '"></span></h2>
		       <span class="update">' . $this->weather_info['wind_speed'] . 'm/s</span>
		   <h2><span class="wind-degree" title="' . $this->languages[$this->lang]['wind_degree'] . '"></span></h2><p class="update">' . $this->weather_info['wind_degree'] . '<sup>o</sup></p></li>
		   <li class="info-w"><h2 class="title"><span class="humidity" title="' . $this->languages[$this->lang]['humidity'] . '"></span></h2>
		   <p class="update">' . $this->weather_info['humidity'] . '%</p>
		   <h2><span class="pressure" title="' . $this->languages[$this->lang]['pressure'] . '"></span> </h2><p class="update">' . $this->weather_info['pressure'] . ' hPa</p></li></ul>';


	$inner_li = "";
	foreach ($this->weather_info['forecast'] as $weather) {
	    $inner_li .= '<li class="info-w"><h2 class="title">' . $weather['day'] . '</h2><h3>' . $weather['month'] . '</h3>
		   <span class="main update">
		   <img title="' . $weather['weather_main'] . '" src="http://openweathermap.org/img/w/' . $weather['icon'] . '" /></span>
		   <br/><span class="des update">' . $this->languages[$this->lang]['hi'] . ': ' . $weather['temp_max'] . '<sup>o</sup>' . $weather['symbol'] . '<br/>
		    ' . $this->languages[$this->lang]['lo'] . ': ' . $weather['temp_min'] . '<sup>o</sup>' . $weather['symbol'] . '</span></li>';
	}

	$markup .= '<ul style="display:none"  id="weather-forecast" class="infos-w">' . $inner_li . '</ul></div></div>';

	//JAVASCRIPT
	$markup .= '<script type="text/javascript">
	    function change_weather (sender){
		var elm = sender.attr("show-ul");
		var next_elm = "";
		
		if(elm == "weather-forecast"){
		    next_elm = "weather-info";
		    sender.removeClass("next-icon");
		    sender.addClass("back-icon");
		    sender.prop("title","' . $back_weather . '");
		}
		else {
		    next_elm = "weather-forecast";
		    sender.removeClass("back-icon");
		    sender.addClass("next-icon");
		    sender.prop("title","' . $next_weather . '");
		}
		
		//Set element next item
		sender.attr("show-ul",next_elm);
		sender.parent().parent().find("#"+next_elm).slideUp("slow");
		sender.parent().parent().find("#"+elm).slideDown("slow");
	    }
	</script>';
	return $markup;
    }

}