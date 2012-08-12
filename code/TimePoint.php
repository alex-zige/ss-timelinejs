<?php

/**
* Single TimePoint objects that contains the specified data for mapping.
*
* Example and Instanciation:
* <code>
* </code>
*
* @author alex li, (<firstname>@novainspire.com)
* @package ss-timelinejs
*/

class TimePoint extends DataObject{

	//database fields for timepoint	
	//Note : Meida could be different type, image or video
	//Note : EndDate is optional, if there is a value it will draw the duration out of it.

	public static $db = array(
		'StartDate'=>'Date',
		'EndDate'=>'Date',
		'Headline'=>'Varchar(255)',
		'Text'=>'HTMLText',
		'MediaUrl'=>'HTMLText',
		'MediaCredit'=>'Varchar(255)',
		'MediaCaption'=>'Varchar(255)'
	);

	//allow user to upload their onsite image
	public static $has_one = array(
		'TimelinePage'=>'TimelinePage',
		'MeidaImage'=>'Image'
	);

	//Summary fields can be used to show a quick overview of the data for a specific DataObject record. 
	//It indicate the data column
	public static $summary_fields = array(
       'Headline',
       'StartDate'

     );
	//define CMS fileds
	public function getCMSFields() {

		//defien the image uploader and extension
		$imageField = new UploadField('MeidaImage', 'Meida Image');

		$imageField->allowedExtensions = array('jpg', 'gif', 'png');

		//define the dropdown datepicker;
		$start_date = new DateField('StartDate', 'Start Date');
		$start_date->setconfig('showcalendar',true);
		$start_date->setconfig('dateformat','mm,dd,yyyy');
	

		$end_date = new DateField('EndDate', 'End Date (optional)');
		$end_date->setconfig('showcalendar',true);


		return new FieldList(
			new TextField('Headline', 'Headline'),
			$start_date,
			$end_date,
			new HTMLEditorField('Text', 'Content for the TimePoint'),
			new TextField('MediaUrl', "Media Url"),
			new TextField('MediaCredit', "Media Credit"),
			new TextField('MediaCaption', "Media Caption"),
			$imageField
		);


	}

	//define the dateconvert from 2012-12-12 to 12,12,13
	public function getNiceDate($date = null){

	return ($date != null) ?  date("m,d,Y", strtotime($this->StartDate)) : null ; 

	}

} 
	

