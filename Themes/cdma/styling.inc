<?php

// $Id: styling.inc 1305 2010-03-17 09:27:24Z cimorrison $

// CDMA THEME

// Style guide colors
$cdma_teal                      = "#6CCACD";
$cdma_orange                    = "#FAA21B";
$cdma_yellow                    = "#FFEF00";
$cdma_black                     = "#000";


// ***** COLOURS ************************
// Colours used in CDMA.    All the colours are defined here as PHP variables

$body_background_color          = "#e7ebee";    // background colour for the main body
$standard_font_color            = $cdma_black;    // default font color
$header_font_color              = "#ffffff";    // font color for text in headers
$highlight_font_color           = $cdma_orange;    // used for highlighting text (eg links, errors)
$colour_key_font_color          = $standard_font_color;    // used in the colour key table
$error_font_color				= "#FF0000";	// used to display error messages

$banner_back_color              = $cdma_teal;    // background colour for banner
$banner_border_color            = $body_background_color;    // border colour for banner
$banner_font_color              = $header_font_color;       // font colour for banner

$header_back_color              = $banner_back_color;  // background colour for headers

$admin_table_header_back_color  = $header_back_color;     // background colour for header and also border colour for table cells
$admin_table_header_sep_color   = $body_background_color; // vertical separator colour in header
$admin_table_header_font_color  = $header_font_color;     // font colour for header
$admin_table_border_color       = "#C3CCD3";

$main_table_border_color        = $body_background_color; // border colour for day/week/month tables - outside
$main_table_header_border_color = $body_background_color; // border colour for day/week/month tables - header
$main_table_body_h_border_color = "#ffffff";              // border colour for day/week/month tables - body, horizontal
$main_table_body_v_border_color = $body_background_color; // border colour for day/week/month tables - body, vertical
$main_table_month_color         = "#ffffff";    // background colour for days in the month view
$main_table_month_invalid_color = "#d1d9de";    // background colour for invalid days in the month view
$main_table_labels_back_color   = $header_back_color;     // background colour for the row labels column

$available_background_color     = "#CCFAC3";
$booked_background_color        = "#F7B0A8";

// border colours for the main table when it is printed.     These are used by cdma-print.css.php
$main_table_border_color_print        = "#879AA8";    // border colour for the main table (print view)
$main_table_header_border_color_print = "#879AA8";    // border colour for day/week/month tables - header (print view)
$main_table_body_h_border_color_print = "#879AA8";    // border colour for day/week/month tables - body, horizontal (print view)
$main_table_body_v_border_color_print = "#879AA8";    // border colour for day/week/month tables - body, vertical (print view)

$report_table_border_color      = $standard_font_color;
$report_h2_border_color         = $banner_back_color;     // border colour for <h2> in report.php
$report_h3_border_color         = "#879AA8";              // border colour for <h2> in report.php
$report_entry_border_color      = "#C3CCD3";              // used to separate individual bookings in report.php
$report_table_background_color  = "#FFFFFF";              // background color of entry table

$search_table_border_color      = $standard_font_color;

$site_faq_entry_border_color    = $report_entry_border_color;    // used to separate individual FAQ's in help.php

$trailer_border_color           = $standard_font_color;

$anchor_link_color              = $standard_font_color;        // link color
$anchor_visited_color           = $anchor_link_color;          // link color (visited)
$anchor_hover_color             = $highlight_font_color;       // link color (hover)

$anchor_link_color_banner       = $header_font_color;          // link color
$anchor_visited_color_banner    = $anchor_link_color_banner;   // link color (visited)
$anchor_hover_color_banner      = $anchor_link_color_banner;   // link color (hover)

$anchor_link_color_header       = $header_font_color;          // link color
$anchor_visited_color_header    = $anchor_link_color_header;   // link color (visited)
$anchor_hover_color_header      = $anchor_link_color_header;   // link color (hover)

$cell_hover_color               = "#FAC3C9";   // highlight a cell in main table when hovering over it
$report_hover_color             = $cell_hover_color; // highlight a row in the report when hovering over it.

$column_hidden_color            = $main_table_month_invalid_color;    // hidden days in the week and month views
$calendar_hidden_color          = "#dae0e4";                          // hidden days in the mini-cals
$row_even_color                 = "#ffffff";        // even rows in the day and week views
$row_odd_color                  = "#f2f4f6";        // even rows in the day and week views
$row_highlight_color            = "#ffc0da";        // used for highlighting a row
                                                    // NOTE: this colour is also used in xbLib.js (in more than one place)and 
                                                    // if you change it here you will also need to change it there.

$help_highlight_color           = "#ffe6f0";        // highlighting text on the help page

$multiple_control_color         = "#ffff22";        // background colour for the multiple booking controls

// These are the colours used for distinguishing between the dfferent types of bookings in the main
// displays in the day, week and month views
$color_types = array(
    'A' => "#ffff99",
    'B' => "#99cccc",
    'C' => "#ffffcd",
    'D' => "#cde6e6",
    'E' => "#6dd9c4",
    'F' => "#82adad",
    'G' => "#ccffcc",
    'H' => "#d9d982",
    'I' => "#99cc66",
    'O' => "#e6ffe6"); 

// colours used for pending.php and provisional bookings
$outstanding_color         = "#FFF36C"; // font colour for the outstanding reservations message in the header
$pending_header_back_color = $header_back_color;; // background colour for series headers
$series_entry_back_color   = "#FFFCDA"; // background colour for entries in a series
$pending_control_color     = "#FFF36C"; // background colour for the series +/- controls in pending.php

// colours used for day selector
$day_selector_selected_fg_color = $standard_font_color;
$day_selector_selected_bg_color = $cdma_yellow;
$day_selector_unselected_fg_color = "#FFFFFF";
$day_selector_unselected_bg_color = $cdma_teal;
$day_selector_hover_bg_color      = $cdma_orange;
    
// ***** DIMENSIONS *******************
$banner_border_width          = '0';  // (px)  border width for the outside of the banner
$banner_border_cell_width     = '1';  // (px)  border width for the cells of the banner
$main_table_border_width      = '0';  // (px)  border width for the outside of the main day/week/month tables    
$main_table_cell_border_width = '1';  // (px)  border width for the cells of the main day/week/month tables
$main_cell_height             = '17'; // (px)  height of the cells in the main day/week tables
         
    
// ***** FONTS ************************    
$standard_font_family  = 'Arial, Verdana, sans-serif';

?>
