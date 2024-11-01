<?php


// Template for displaying a single proposal
add_filter( 'single_template', 'wpp_proposal_single_template') ;
function wpp_proposal_single_template($single_template) {
    global $post;
    if ($post->post_type == 'proposal')
          $single_template = dirname( __FILE__ ) . '/single-proposal.php';
    return $single_template;
}
