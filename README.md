# SS-Timelinejs
=============

a silverstripe - timeline JS intergration module 

This module based on Silverstripe and offers CMSable object for each timepoint. 

## Requirements
Silverstripe 3.0+

## Get it 
You can either git clone the repository to your root dictory or simply download and extract it.

	git clone git@github.com:alex-zige/ss-timelinejs.git ss-timeline

## Add it to your site

	run dev/build for rebuiding the database
	
## Options

###Language
`lang`
Localization
*default is en*
Languages available:
* `en` *English*
* `fr` *Français*
* `es` *Español*
* `de` *Deutsch*
* `it` *Italiano*
* `pt-br` *Português Brazil *
* `nl` *Dutch*
* `cz` *Czech*
* `dk` *Danish*
* `id` *Indonesian*
* `pl` *Polish*
* `ru` *Russian*
* `is` *Icelandic*
* `fo` *Icelandic*
* `kr` *월요일*
* `ja` *日本語*
* `zh-ch` *中文*
* `zh-tw` *Taiwanese Mandarin*
* `ta` *தமிழ் - Tamil*

###Font Options 
`font:`
* `Arvo-PTSans`
* `Merriweather-NewsCycle`
* `PoiretOne-Molengo`
* `PTSerif-PTSans`
* `DroidSerif-DroidSans`
* `Lekton-Molengo`
* `NixieOne-Ledger`
* `AbrilFatface-Average`
* `PlayfairDisplay-Muli`
* `Rancho-Gudea`
* `Bevan-PotanoSans`
* `BreeSerif-OpenSans`
* `SansitaOne-Kameron`
* `Pacifico-Arimo`
* Or make your own 

## File Formats

### JSON:

JSON is the native data format for TimelineJS. It is easy enough for “normals”
to use but powerful enough for real nerds to get excited about.

If you select JSON option, there will have timepoints DataGrid in Silverstripe CMS for you loading Timepoints.
The System take care the JSON encode work, will generate JSON for timeline.

### Google Docs:

If you don’t want to mess with JSON, fire up Google Docs and build your
timeline in a spreadsheet. It’s as simple as dropping a date, text, and links
into the appropriate columns in TimelineJS’s template.

You can find the template here: [TimelineJS Google Spreadsheet Template](https://docs.google.com/a/digitalartwork.net/previewtemplate?id=0AppSVxABhnltdEhzQjQ4MlpOaldjTmZLclQxQWFTOUE&mode=public)

There are only four things you need to know in order to create a timeline
using Google Docs:

  1. Make the spreadsheet public:   
	Google Docs are automatically set to private but the spreadsheet must be
	public.

  
	Click the blue “Share” button on the top right-hand corner. In the “Share
	settings” window, you’ll see the private setting of the spreadsheet: click
	“Change...”. In the Visibility options window, choose “Public on the Web” and
	save.

  2. Publish to the Web  
	Under the File menu, select “Publish to the Web.”

  
	In the next window, check the box next to “Automatically republish when
	changes are made.” Uncheck all other boxes. Click “start publishing.” This
	will give you the URL to embed in your HTML file.

  3. Copy/paste the Web URL into your TimelineJS HTML file  
	After you publish the spreadsheet, Google Docs will generate a link to the
	file. Copy the link for the Web Page option (as opposed to PDF, HTML, XLS,
	etc.), then paste it into the timeline’s HTML file:

  
	`timeline.init(“URL goes here”)`

  4. Designate the “start” slide  
	This indicates which event is the title slide, the one that begins the
	timeline.

  
	Only one should be labeled "start" (generally, the first one). The title slide
	must have a start date, headline and text to appear properly.
	


## Media

Offer user upload images from their local file system. If the image has been uploaded, the default media url will be overwrited.


## Contributing
Anyone and everyone is welcome to contribute. There are several ways you can help out:

    Raising issues on GitHub.
    Sending pull requests for bug fixes or new features and improvements.
    Making the docs better.


## Contact
Alex http://twitter.com/#!/Galaxy_Watcher 