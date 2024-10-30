<?php


class Clearapp_API {

  /**
   * Handle all requests
   *
   */
  public function handler() {
    $data = $_REQUEST;
    unset($data["action"]);
    $func = "get_".$data["method"];
    if (method_exists($this, $func)) {
      echo json_encode($this->$func($data));
    } else {
      echo json_encode(array(
        "error" => "Method doesn't exist"
      ));
    }
    die();  // Required for wordpress ajax to work
  }

  /**
   * Get notifications: new comments on articles the user has commented on
   *
   */
  private function get_notifications($options) {

    // get all the posts the logged in user has commented on
    $userData = wp_get_current_user();
    $comments = get_comments(array(
      "author_email" => $userData->user_email
    ));
    $post_ids = array();
    foreach ($comments as $key => $comment) {
      $post_ids[] = $comment->comment_post_ID;
    }

    // Determine last check date
    if ($options["lastCheck"]) {
      $lastCheck = gmdate("Y-m-d H:i:s", (int) $options["lastCheck"]);
    }

    global $wpdb;
    $query = "SELECT * FROM $wpdb->comments 
        WHERE comment_post_ID IN (%s) 
        AND comment_author_email != %s";
    if (isset($lastCheck)) {
      $query .= " AND comment_date_gmt > %s";
    }

    // others comments
    $comments = $wpdb->get_results( 
      $wpdb->prepare( 
        $query,
        implode(",", $post_ids),
        $userData->user_email,
        $lastCheck
      )
    );

    // Get the posts, and re-format
    $posts = get_posts($args = array( 'post__in' => $post_ids ));

    foreach ($comments as $key => $comment) {
      foreach ($posts as $key => $post) {
        if ($comment->comment_post_ID == $post->ID) {
          $comments[$key]->post = $post;
        }
      }
    }

    return $comments;
  }

}