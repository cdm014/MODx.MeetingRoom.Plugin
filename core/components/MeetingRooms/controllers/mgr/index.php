<?php

/*
 * Widgets are individual pieces
 * loading the widget does not render it
 *
 * Sections are the JS that actually load the widgets onto the page
 */
 
//load the js for our MeetingRooms Grid
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/MeetingRooms.grid.js');
//load the js for our Resources Grid
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/resources.grid.js');
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/requests.grid.js');
//load mgr/widgets/home.panel.js from our assets
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/home.panel.js');
//load mgr/widgets/calendar.js from our assets {this is the new calendar view}
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/calendar.js');
$modx->regClientCSS($mrManager->config['cssUrl'].'mgr/mgr.css');

$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/sections/index.js');
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/widgets/past_requests.js');
$output = '';
/*
 * We're going to load first the MeetingRooms.grid.js which is a widget that displays a 
 * grid of Meeting Rooms (mrRooms). Secondly we load the 'home' panel which is our home
 * page's main panel, which the grid will reside in. Finally, we load the index section
 * which will render the UI
 */

$output .= '<div id="MeetingRooms-panel-home-div"></div>';

return $output;