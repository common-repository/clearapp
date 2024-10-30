<?php




class Clearapp_Helpers {

  /**
   * Generates a wrapper div based on the attributes passed.
   *
   */
  public function generate_wrapper_div($attributes) {
    if ($attributes["app"] === "pre-content") {
        $html = "\n<!-- Clearapp pre-content wrapper -->\n";
    } else if ($attributes["app"] === "post-content") {
        $html = "\n<!-- Clearapp post-content wrapper -->\n";
    } else {
        if (!$attributes["app"]) return;
        $html = "\n<!-- Clearapp wrapper for app: \"".$attributes["app"]."\" -->\n";
    }
    $html .= '<div class="clearapp-wrapper" ';
    foreach ($attributes as $key => $value) {
        $html .= 'data-'.$key.'="'.$value.'" ';
    }
    $html .= '></div>';
    $html .= "\n\n";
    return $html;
  }

}
