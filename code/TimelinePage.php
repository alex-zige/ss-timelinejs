<?php

/**
* Provides an system level integration between silverstripe objects and timelinejs.
*
* Features:
* - Bundled with timelinejs automatically generate JSON object for each Timepoints 
* - return JSON obejct for data mapping.
*
* Example and Instanciation:
* <code>
* </code>
*
* @author alex li, (<firstname>@novainspire.com)
* @package ss-timelinejs
*/

class TimelinePage extends Page {

	public static $icon="";

	public static $description="The Timeline Page Type allow you create different Time Point";

	public static $db = array(
		'Headline'=>'Varchar(255)',
		'Tagline'=>'Varchar(255)'
	);

	//define relationshiop with TimePoints
	static $has_many = array(
      'TimePoints' => 'TimePoint'
   );

	//Generate the DataGrid for Timepoints
	public function getCMSFields(){

		$fields = parent::getCMSFields();


		//the Global Headline

		$fields->addFieldToTab("Root.Main", new TextField('Tagline','Tagline'),'Content');
		$fields->addFieldToTab("Root.Main", new TextField('Headline','The Timeline Headline'),'Tagline');

		// define the field config 
		$gridFieldConfig = GridFieldConfig::create()->addComponents(
    		new GridFieldFilterHeader(),
            new GridFieldToolbarHeader(),
            new GridFieldAddNewButton('toolbar-header-right'),
            new GridFieldSortableHeader(),
            new GridFieldDataColumns(),
            new GridFieldPaginator(10),
            new GridFieldEditButton(),
            new GridFieldDeleteAction(),
            new GridFieldDetailForm()
		);

	//	Debug::show($this->TimePoints());
	$gridField = new GridField("TimePoints", "Time Points", $this->TimePoints(), $gridFieldConfig);

	$fields->addFieldToTab("Root.TimePoints", $gridField);

	return $fields;

	}



	/**
	 * Generate json object based on the current timepoints
	 *
	 * @return json
	 * @author alex
	 **/
	public function genreateJSON(){

	//get those time-ponits.
	$dataset = $this->Timepoints();

	$date_array = $this->getTimePointsArray($dataset);

	$timeline_json_array=array(

		'timeline'=>array(
			'headline'=>$this->Headline,
			 "type"=>"default",
			 "text"=>$this->Tagline,
			 'date'=>$date_array 
			)

		);

//	Debug::Show(json_encode($timeline_json_array));
return json_encode($timeline_json_array);


/*
Final output that we want to have:

{
    "timeline":
    {
        "headline":"Sh*t People Say",
        "type":"default",
		"text":"People say stuff",
        "date": [
            <% loop TimePoints %>
			{
                "startDate":"2012,1,21",
                "headline":"Sh*t Cyclists Say",
                "text":"",
                "asset":
                {
                    "media":"http://youtu.be/GMCkuqL9IcM",
                    "credit":"",
                    "caption":"Video script, production, and editing by Allen Krughoff of Hardcastle Photography"
                }
            },
            <% end_loop %>
      
        ]
    }
}
*/
	}

	public function getTimePointsArray($objectset){

		//start parsing
		if($objectset)

		$timepointset = $objectset;

		$date= array();

		foreach ($timepointset as $timepoints) {

			foreach ($timepoints as $timepoint ) {

				$asset=array(
					"media" => $timepoint->MediaUrl,
                    "credit" => $timepoint->MediaCredit,
                    "caption" => $timepoint->MediaCaption
					);

				//date need to be conver to MM,DD,YY formate "12,30,2012",
				$timepoint=array(
					'startDate' => $timepoint->getNiceDate($timepoint->StartDate),
					'endDate' => $timepoint->getNiceDate($timepoint->EndDate),
					'headline' => $timepoint->Headline,
					'text' => $timepoint->Text,
					"asset"=> $asset,
				 );

				array_push($date,$timepoint);
			}

	}
		return $date;

	}

	public function getAsset(){


	}

	public function getreserverString($str=null){

	if(is_string($str)){
	
	$tmp_str = $str;

	//start split 
	//split string to array
	$tmp_str = str_split($tmp_str);

	//reverse the the array;
	$new_array = array_reverse($tmp_str);

	//glu the array into a string for outputting
	$new_str = implode('', $new_array);

	return $new_str;

	}


	}
} 
class TimelinePage_Controller extends Page_Controller{


	public static $Timeline_Folder = 'ss-timeline';

	//init function output the JS library and relevant CSS
	public function init(){

		parent::init();

		//Debug::show('sdas');

	Debug::show($this->getreserverString('this is my string!'));
	$this->genreateJSON();

	Requirements::customScript(self::get_config(), 'timeline_config');
	
	Requirements::set_write_js_to_body(false);
	
	}

	//global configuration scripts
	public function get_config(){

	$json = $this->genreateJSON();
	
	return <<<JS
	 var timeline_config = {
					width: 	"100%",
					height: "100%",
					source: {$json},
					css: 	'ss-timeline/css/timeline.css',	//OPTIONAL
					js: 	'ss-timeline/js/timeline-min.js'	//OPTIONAL
				}
JS
;
	}


	}



