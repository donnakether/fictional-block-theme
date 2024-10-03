<?php 
   pageBanner(array(
    'title' => 'All Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
   ));
 ?>
   <div class="container container--narrow page-section">

<div class="acf-map">
 <?php
   while(have_posts()) {
     the_post(); 
     $mapLocation = get_field('map_location');
     ?>
      
      <div class="marker" data-lng="<?php echo $mapLocation['lng']?>" 
      data-lat="<?php echo $mapLocation['lat']?>">
      <h3> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
      <?php echo $mapLocation['address'];?>
    </div>
      
     
   <?php } ?>
   
</div>

</div>     
