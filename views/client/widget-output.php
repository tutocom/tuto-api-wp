<?php
defined('ABSPATH') or die('No direct load !');

if($use_default == 1) {
    //default output
    $output = '<span class="taw-tutorials"><a title="' . esc_attr__('See all tutorials',
                    TAW_TEXTDOMAIN) . '" href="' . esc_url(sprintf('http://fr.tuto.com/formateur/%s.htm',
                            $apilogin)) . '">' . __('tutorials : ',
                    TAW_TEXTDOMAIN) . $stat['tutorials'] . '</a></span>';
    $output .= '<span class="taw-customers">' . __('customers : ',
                    TAW_TEXTDOMAIN) . $stat['customers'] . '</span>';
    $output .= '<span class="taw-sales">' . __('sales : ', TAW_TEXTDOMAIN) . $stat['sales'] . '</span>';
    $output .= '<span class="taw-rating">' . sprintf(__('average rating : ',
                            TAW_TEXTDOMAIN) . '%d / 5',
                    round($stat['rating'], 1)) . '</span>';
} else {
    $output = wp_kses_post($custom_code);
    $output = str_replace('%CUSTOMERS_COUNT%', $stat['customers'], $output);
    $output = str_replace('%SALES_COUNT%', $stat['sales'], $output);
    $output = str_replace('%AVERAGE_RATING%', round($stat['rating'], 1), $output);
    $output = str_replace('%TUTORIALS_COUNT%', $stat['tutorials'], $output);
}
