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
		'Tagline'=>'Varchar(255)',
		'Width'=>'Varchar(10)',
		'Height'=>'Varchar(10)',
		'SourceType'=>"enum('JSON,Google Docs','JSON')",
		'GoogleDocSrc'=>'Varchar(255)',
		'Fonts'=>"enum('Bevan-PotanoSans,Merriweather-NewsCycle,PoiretOne-Molengo,
						Arvo-PTSans,PTSerif-PTSans,PTSerif-PTSans,DroidSerif-DroidSans,Lekton-Molengo,NixieOne-Ledger,
						AbrilFatface-Average,PlayfairDisplay-Muli,Rancho-Gudea,BreeSerif-OpenSans,SansitaOne-Kameron,
						Pacifico-Arimo,PT','Bevan-PotanoSans')",
		'Language'=>"enum('en,fr,es,de,it,pt-br,nl,cz,dk,id,pl,ru,is,fo,kr,ja,zh-ch,zh-tw,ta','en')"

	);

	//set the default value as JSON
    static $defaults = array('SourceType' => 'JSON');

	//define relationshiop with TimePoints
	static $has_many = array(
      'TimePoints' => 'TimePoint'
   );

	//Generate the DataGrid for Timepoints
	public function getCMSFields(){

		$fields = parent::getCMSFields();

		//the Global setting
		$fields->addFieldToTab("Root.Setting", new DropdownField('Language','Select timeline language',singleton('TimelinePage')->dbObject('Language')->enumValues()));
		$fields->addFieldToTab("Root.Setting", new TextField('Tagline','Tagline'));
		$fields->addFieldToTab("Root.Setting", new TextField('Headline','Timeline Headline'),'Tagline');
		$fields->addFieldToTab("Root.Setting", new DropdownField('Fonts','Select a font family ',singleton('TimelinePage')->dbObject('Fonts')->enumValues()));
		$fields->addFieldToTab("Root.Setting", new LiteralField('Fonts-Preview',"<a href=".Director::absoluteBaseURL()."ss-timeline/images/font-options.png target='_blank'>Preview the font combinations </a>",singleton('TimelinePage')->dbObject('Fonts')->enumValues()));
		
		//setting for width and height.
		$fields->addFieldToTab("Root.Setting", new TextField('Width','Timeline Width (eg. 100% or 100, default: 940)'));

		$fields->addFieldToTab("Root.Setting", new TextField('Height','Timeline Height (eg. 100% or 100, default: 400)'));
	
		$fields->addFieldToTab("Root.Setting", new DropdownField('SourceType','Please define the source type',singleton('TimelinePage')->dbObject('SourceType')->enumValues()));

		// define the field config 

		// if the soruce is JSON

		if($this->SourceType == 'JSON'){

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

		$gridField = new GridField("TimePoints", "Time Points", $this->TimePoints(), $gridFieldConfig);

		$fields->addFieldToTab("Root.TimePoints", $gridField);

	}else{

		$fields->addFieldToTab("Root.Setting", new TextField('GoogleDocSrc','Google Document Source URL'));

	}

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
	
	return json_encode($timeline_json_array);
	}

	public function getTimePointsArray($objectset){

		//start parsing
		if($objectset)

		$timepointset = $objectset;

		$date= array();

		foreach ($timepointset as $timepoints) {

			foreach ($timepoints as $timepoint ) {

				$media_url=$this->getMediaAsset($timepoint);

				$asset=array(
					"media" => $media_url,
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

				//test if it has images,render image as a default stuff.
				array_push($date,$timepoint);
			}

	}
		return $date;

	}


	/**
	 * Generate Meida Asset url, if the user upload own image, overwrite its media url.
	 *
	 * @return media url
	 * @author alex
	 **/
	public function getMediaAsset($timepoint){

		if(isset($timepoint))

		if($timepoint->MeidaImage()->ID != 0) { // if has mediaImage use the image instead, overwirte the media url.
			return $timepoint->MeidaImage()->URL;
 		}else{
			return $timepoint->MediaUrl;
 		}

	}
} 

class TimelinePage_Controller extends Page_Controller{

	static $Timeline_Folder = 'ss-timeline';

	//init function output the JS library and relevant CSS
	public function init(){

		parent::init();

	Requirements::customScript(self::get_config(), 'timeline_config');
	
	Requirements::set_write_js_to_body(false);
	
	}

	/**
	 * Generate Configuration file for timeline
	 *
	 * @return javascript
	 * @author alex
	 **/
	public function get_config(){

	//define source type
	$source = ($this->SourceType == "JSON" ) ? $this->genreateJSON() : $this->GoogleDocSrc;

	$font = trim($this->Fonts);

	$lang = trim($this->Language);

	$width = ($this->Width) ? $this->Width : '940';

	$height = ($this->Height) ? $this->Height : '400';
	
	//output javascript
	return <<<JS
	 var timeline_config = {
					width: 	"{$width}",
					height: "{$height}",
					source: {$source},
					font: "{$font}",
					lang: "{$lang}",
					css: 	'ss-timeline/css/timeline.css',	//OPTIONAL
					js: 	'ss-timeline/js/timeline-min.js'	//OPTIONAL
				}
JS
;
	}

	}



