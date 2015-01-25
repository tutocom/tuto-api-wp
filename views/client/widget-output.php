<?php
defined('ABSPATH') or die('No direct load !');

if( 1 === (int) $use_default) {
    //default output
    $output  = '<div class="taw-container">';
    $output .= '<div class="taw taw-avatar"><img src="' . esc_url( $info['avatar']) . '"  height="100" width="100" alt=""/></div>';
    $output .= '<div class="taw taw-tutorials"><span class="big-number-statistics">' . $stat['tutorials'] . '</span> <span class="sentence-under-number-statistics">'  . __( 'tutorials', TAW_TEXTDOMAIN ) . '</span></div>';
    $output .= '<div class="taw taw-customers"><span class="big-number-statistics">' . $stat['customers'] . '</span> <span class="sentence-under-number-statistics">'  . __( 'customers',TAW_TEXTDOMAIN ) . '</span></div>';
    $output .= '<div class="taw taw-sales"><span class="big-number-statistics">' . $stat['sales'] . '</span> <span class="sentence-under-number-statistics">'  . __( 'sales', TAW_TEXTDOMAIN ) . '</span></div>';
    $output .= '<div class="taw taw-rating"><span class="big-number-statistics">' . round($stat['rating'], 1) . '</span> <span class="sentence-under-number-statistics">'  . __( 'average rating out of 5', TAW_TEXTDOMAIN ) . '</span></div>';
    $output .= '</div>';
    $output .= '<a class="taw-link" title="' . esc_attr__( 'See all tutorials',TAW_TEXTDOMAIN ) . '" href="' . esc_url( $info['profile']) . '">' . __( 'See all tutorials',TAW_TEXTDOMAIN ) .'</a>';
} else {
    $output = wp_kses_post($custom_code);
    $output = str_replace('%AVATAR%', $info['avatar'], $output);
    $output = str_replace('%CUSTOMERS_COUNT%', $stat['customers'], $output);
    $output = str_replace('%SALES_COUNT%', $stat['sales'], $output);
    $output = str_replace('%AVERAGE_RATING%', round($stat['rating'], 1), $output);
    $output = str_replace('%TUTORIALS_COUNT%', $stat['tutorials'], $output);
    $output = str_replace('%PROFILE_LINK%', $info['profile'], $output);
}
