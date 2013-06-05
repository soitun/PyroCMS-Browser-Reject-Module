PyroCMS-Browser-Reject-Module
=============================

## Description ##
This module allow you to deny the access to your site at users with specific browser.  
By default the module reject all the users with Internet Explorer < 7.  
This module is based on JQuery Browser Reject by **Steven Bower** (http://jreject.turnwheel.com/).  

## How to install ##
The installation process is very easy, just download the zip and unzip it, copy the browser_reject folder in your `addons/SITE_REF/modules/` or in `addons/shared_addons/modules/` then go in your Control Panel and click on install.

## How to use ##
The module has a simple User Interface that allow you to set the basic infos about the plugin popup such as the title, the paragraph and cookies. Plus allow you to choose which browser reject.  
To make this plugin work all you need is to place the plugin script in you theme with:  

`{{ browser_reject:show_popup }}`
