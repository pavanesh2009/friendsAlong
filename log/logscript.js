/**
 * Created by Pavanesh on 5/1/14.
 */

//<![CDATA[
// Create the logger
var log = log4javascript.getLogger();

// Create a PopUpAppender with default options
var popUpAppender = new log4javascript.PopUpAppender();

// Change the desired configuration options
popUpAppender.setFocusPopUp(true);
popUpAppender.setNewestMessageAtTop(true);

// Add the appender to the logger
log.addAppender(popUpAppender);

// Test the logger
log.debug("Hello world!");
/*
 ]]>

/* Sending log messages to the server
 Constructor AjaxAppender(String url) : Parameters:
 url : The URL to which log messages should be sent. Note that this is subject to the usual Ajax restrictions: the URL should be in the same domain as that of the page making the request.
*/
    var ajaxAppender = new log4javascript.AjaxAppender(URL);
    log.addAppender(ajaxAppender);