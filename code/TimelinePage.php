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
		'Headline'=>'Varchar(255)'
	);

	//define relationshiop with TimePoints
	static $has_many = array(
      'TimePoints' => 'TimePoint'
   );

	//Generate the DataGrid for Timepoints
	public function getCMSFields(){

		$fields = parent::getCMSFields();

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


} 
class TimelinePage_Controller extends Page_Controller{

	//init function output the JS library and relevant CSS
	public function init(){



	}



	}



