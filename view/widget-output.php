<?php
defined( 'ABSPATH' ) or die ('No direct load !');

$output = '<ul class="taw-stats">';

    foreach ( $stats as $stat ) {
        $output .= '<li class="taw-tutorials">' . __( 'tutorials : ', TAW_TEXTDOMAIN ) . $stat['tutorials'] .  '</li>';
        $output .= '<li class="taw-customers">' . __( 'customers : ', TAW_TEXTDOMAIN  ) . $stat['customers'] . '</li>';
        $output .= '<li class="taw-sales">' . __( 'sales : ', TAW_TEXTDOMAIN ) . $stat['sales']  . '</li>';
        $output .= '<li class="taw-rating">' . __( 'average rating : ', TAW_TEXTDOMAIN ) . $stat['rating'] . '</li>';
    }

$output .= '</ul>';