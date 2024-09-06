<?php

require get_theme_file_path( '/inc/search-route.php' );
require get_theme_file_path( '/inc/like-route.php' );

function university_custom_rest() {
   register_rest_field( 'post', 'authorName', array(
     'get_callback' => function() {return get_the_author();}
   ));
   register_rest_field( 'note', 'userNoteCount', array(
     'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
   ));
   
}
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL) {
  if (!isset($args['title'])) {
     $args['title'] = get_the_title();
  }

  if (!isset($args['subtitle'])) {
     $args['subtitle'] = get_field('page_banner_subtitle');
  }

  if (!isset($args['photo'])) {
     if (get_field('page_banner_background') AND !is_archive() AND !is_home() ) {
        $args['photo'] = get_field('page_banner_background')['sizes']['pageBanner'];
     } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
     }
  }

  ?>

  <div class="page-banner">
           <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)">
              
            </div>
           <div class="page-banner__content container container--narrow">
             <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
             <div class="page-banner__intro">
               <p><?php echo $args['subtitle'] ?></p>
             </div>
            </div>
        </div>

<?php }

function university_files() {
    wp_enqueue_script( 'googleMap', '//maps.googleapis.com/maps/api/js?key=YOUR-API-KEY', NULL, '1.0' , true);
    wp_enqueue_script( 'main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'),'1.0' , true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
       'root_url' => get_site_url(),
       'nonce' => wp_create_nonce('wp_rest')
    ));

}
 
add_action('wp_enqueue_scripts','university_files');

function university_features(){

    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size( 'professorLandscape', 400, 260, true );
    add_image_size( 'professorPortrait', 480, 650, true );
    add_image_size( 'pageBanner', 1500, 350, true );
    add_theme_support('editor-styles');
    add_editor_style(array('https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', 'build/style-index.css', 'build/index.css'));
}

add_action('after_setup_theme','university_features');

function university_adjust_queries($query) {
  
  if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
     $query->set('posts_per_page', -1 );
  }

  if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
     $query->set('orderby', 'title');
     $query->set('order', 'ASC');
     $query->set('posts_per_page', -1 );
  }

  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
      ));
  }
}
add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {
  $api['key'] = 'YOUR-API-KEY';
  return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');

//Redirect subscriber  accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontEnd');

function redirectSubsToFrontEnd() {
   $ourCurrentUser = wp_get_current_user();

   if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber' ) {
     wp_redirect(site_url('/'));
     exit;
   }
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
   $ourCurrentUser = wp_get_current_user();

   if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber' ) {
     show_admin_bar(false);
   }
}

//Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
   return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
   wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
   wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
   wp_enqueue_style('university_main_style', get_theme_file_uri('/build/style-index.css'));
   wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

}

add_filter('login_headertext', 'ourLoginTitle');

function ourLoginTitle() 
{
   return get_bloginfo('name');
}

//Force Notes Posts To Be Private

add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2 );

function makeNotePrivate($data, $postarr) {
   if($data['post_type'] == 'note') {
      if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
         die("You have reached your note limit");
      }

      $data['post_content'] = sanitize_textarea_field( $data['post_content'] );
      $data['post_title'] = sanitize_text_field( $data['post_title'] );
   }
   if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
      $data['post_status'] = "private";
   }
   return $data;
 
}


class JSXBlock {
   function __construct($name, $renderCallback = null, $data = null) {
      $this->name = $name;
      $this->data = $data;
      $this->renderCallback = $renderCallback;
      add_action('init', [$this, 'onInit']);
   }

   function ourRenderCallback($attributes, $content) {
       ob_start();
       require get_theme_file_path("/our-blocks/{$this->name}.php");
       return ob_get_clean();
   }

   function onInit() {
      wp_register_script($this->name, get_stylesheet_directory_uri() . "/build/{$this->name}.js", array('wp-blocks', 'wp-editor'));
      
      if($this->data) {
         wp_localize_script($this->name, $this->name, $this->data);
      }

      $ourArgs = array(
         'editor_script' => $this->name
      );
      if ($this->renderCallback) {
         $ourArgs['render_callback'] = [$this, 'ourRenderCallback'];
      }
      register_block_type("ourblocktheme/{$this->name}", $ourArgs);
   }

}

new JSXBlock('banner', true, ['fallbackimage' => get_theme_file_uri('/images/library-hero.jpg')]);
new JSXBlock('genericheading');
new JSXBlock('genericbutton');