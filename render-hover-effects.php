<?php

	if (isset($saved_captions['posts'])) { ?>
		<div class="grid grid-pad">
		<?php foreach ($saved_captions['posts'] as $key => $data) { ?>
			<?php  foreach ($data['allcapImages'] as $key => $data2) {  ?>
				<?php  if ($atts['id']== $data2['shortcode']) {
					wp_enqueue_style( 'hover-css', plugins_url( 'css/hover-advance.css',__FILE__ )); 
					wp_enqueue_style( 'grid-css', plugins_url( 'css/simplegrid.css',__FILE__ )); ?>
				    <div class="<?php echo $data2['cap_grid']; ?>">
				       <div class="hover-content">
				           <figure class="<?php echo $data2['cap_effect']; ?>">
							    <img src="<?php echo ($data2['cap_img']!='' ? $data2['cap_img'] : 'http://www.gemologyproject.com/wiki/images/5/5f/Placeholder.jpg' ); ?>" style="height:<?php echo ($data2['cap_resp_option'] == 'no' ? $data2['cap_thumbheight'] : '100%' ); ?>px;">
							    <figcaption>
							        <h3><?php echo $data2['cap_head']; ?></h3>
							        <p>
      									<?php $content= stripslashes($data2['cap_desc']); echo $content; ?>
    								</p>
							    </figcaption>
							    <?php if ($data2['cap_link']!='') { ?>
							    	<a href="<?php echo $data2['cap_link']; ?>"></a>
							    <?php } ?>
							</figure>
				       </div>
				    </div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		</div>
	<?php
	}
 ?>