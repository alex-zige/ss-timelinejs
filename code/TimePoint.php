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
		'MediaUrl'=>'Varchar(255)',
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
       'StartDate',
       'Headline'
     );
	//define CMS fileds
	public function getCMSFields() {

		//defien the image uploader and extension
		$imageField = new UploadField('MeidaImage', 'Meida Image');
		$imageField->allowedExtensions = array('jpg', 'gif', 'png');

		return new FieldList(
			new TextField('Headline', 'Headline'),
			new DateField('StartDate', 'Start Date'),
			new DateField('EndDate', 'End Date (optional)'),
			new HTMLEditorField('Text', 'Content for the TimePoint'),
			new TextField('MediaUrl', "Media Url"),
			new TextField('MediaCredit', "Media Credit"),
			new TextField('MediaCaption', "Media Caption"),
			$imageField
		);

	}

} 
	

