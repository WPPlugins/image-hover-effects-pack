<?php 
	/**
	* Plugin Main Class
	*/
	class LA_Hover_Pack { 
		
		function __construct()  
		{
			add_action( "admin_menu", array($this,'advance_hover_admin_options'));
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_options_page_scripts' ) );
			add_action('wp_ajax_la_save_hover_effects_pack', array($this, 'save_caption_options'));
			add_shortcode( 'hover-effects-pack', array($this,'render_caption_hovers') );
		}

		// Admin Options Page
		function admin_options_page_scripts($slug){
			if($slug=='toplevel_page_hover_effects_pack'){
				wp_enqueue_media();
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'admin-js', plugins_url( 'admin/admin.js', __FILE__ ), array('jquery', 'jquery-ui-accordion','wp-color-picker','jquery-ui-sortable'));
				wp_enqueue_style( 'ui-css', plugins_url( 'admin/jquery-ui.min.css', __FILE__ ));
				wp_enqueue_script( 'spectrum-js', plugins_url( 'admin/spectrum.js', __FILE__ ),array('jquery'));
				wp_enqueue_style( 'spectrum-css', plugins_url( 'admin/spectrum.css', __FILE__ ));
				wp_enqueue_style( 'style-css', plugins_url( 'admin/style.css', __FILE__ ));
				wp_localize_script( 'admin-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' )));
			}
		}

		function advance_hover_admin_options(){
			add_menu_page( 'Hover Effects Pack', 'Hover Effects Pack', 'manage_options', 'hover_effects_pack', array($this,'render_menu_page'), 'dashicons-format-image' );
		}

		function save_caption_options(){
			print_r($_REQUEST);
			if (isset($_REQUEST)) {
				update_option( 'la_hover_effects_pack', $_REQUEST );
			}
		}

		function render_menu_page(){
			$saved_captions = get_option( 'la_hover_effects_pack' ); 

			?>
			<div class="wrapper" id="caption">
				<h2>Hover Effects Collection</h2>
				<a style="text-decoration:none;"  href="http://webdevocean.com/product/hover-effects-pack/" target="_blank"><h4 style="padding: 10px;background: #31b999;color: #fff;margin-bottom: 0px;text-align:center;font-size:24px;">Get Pro Version</h4></a><br>
				<hr>
				<div id="faqs-container" class="accordian">
				<?php if (isset($saved_captions['posts'])) { ?>
				<?php foreach ($saved_captions['posts'] as $key => $data) { 
					?>
					
				    <h3><span class="dashicons dashicons-category"></span> <a href="#"><?php if ($data['cat_name'] !== '') {
				    	echo $data['cat_name']; 
				    } else {
				    	echo "Image Hover Advance";
				    }
				    ?></a></h3>
				     
				     
				   <div class="accordian content">
					
				<?php foreach ($data['allcapImages'] as $key => $data2) { ?>   
				
				        <h3><span class="dashicons dashicons-format-image"></span> <a class=href="#"><?php if ($data2['img_name']!=='') {
				        	echo $data2['img_name'];
				        } else {
				        	echo "image";
				        }
				         ?></a></h3>
				        <div>
				        	<table class="form-table">
				        		<tr>
				        			<td style="width:20%">
				        				<strong><?php _e( 'Category Name', 'la-hover-advance' ); ?></strong>
				        			</td>

				        			<td style="width:30%">
				        				<input type="text" class="catname widefat form-control" value="<?php echo $data['cat_name']; ?>">
				        			</td>

				        			<td style="width:50%">
				        				<p class="description"><?php _e( 'Name the category for images.Category name should be same for everyimage', 'la-hover-advance' ); ?></p>
				        			</td>
				        		</tr>
				        		<tr>
				        			<td >
				        				<strong><?php _e( 'Image Name', 'la-hover-advance' ); ?></strong>
				        			</td>

				        			<td >
				        				<input type="text" class="imgname widefat form-control" value="<?php echo $data2['img_name']; ?>">
				        			</td>

				        			<td>
				        				<p class="description"><?php _e( 'Name the image.It will be for your reference', 'la-hover-advance' ); ?></p>
				        			</td>
				        		</tr>
				        	</table>
				        	<button class="addimage button"><?php _e( 'Upload Image', 'la-hover-advance' ); ?></button>
				        	<span class="image">
				        		<?php if ($data2['cap_img']!='') {
				        		
				        			echo '<span><img src="'.$data2['cap_img'].'"><span class="dashicons dashicons-dismiss"></span></span>'; } ?>
				        		
				        	</span><br>
				        	<h4><?php _e( 'Caption Settings', 'la-hover-advance' ); ?></h4>
				        	<hr>
							<table class="form-table">
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Caption Heading', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="text" class="widefat capheading form-control" value="<?php $heading= stripslashes($data2['cap_head']);
								                        	echo $heading; ?>">
									</td>	
									<td style="width:50%">
										<p class="description"><?php _e( 'Type Caption heading', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Heading Animation (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<select disabled class="headinganim form-control">
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade' ) echo 'selected="selected"'; ?> value="ih-fade"><?php _e( 'Fade', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-up' ) echo 'selected="selected"'; ?> value="ih-fade-up"><?php _e( 'Fade Up', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-down' ) echo 'selected="selected"'; ?> value="ih-fade-down"><?php _e( 'Fade Down', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-left' ) echo 'selected="selected"'; ?> value="ih-fade-left"><?php _e( 'Fade Left', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-right' ) echo 'selected="selected"'; ?> value="ih-fade-right"><?php _e( 'Fade Right', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-up-big' ) echo 'selected="selected"'; ?> value="ih-fade-up-big"><?php _e( 'Fade Up Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-down-big' ) echo 'selected="selected"'; ?> value="ih-fade-down-big"><?php _e( 'Fade Down Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-left-big' ) echo 'selected="selected"'; ?> value="ih-fade-left-big"><?php _e( 'Fade Left Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-fade-right-big' ) echo 'selected="selected"'; ?> value="ih-fade-right-big"><?php _e( 'Fade Right Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-zoom-in' ) echo 'selected="selected"'; ?> value="ih-zoom-in"><?php _e( 'Zoom In', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-zoom-out' ) echo 'selected="selected"'; ?> value="ih-zoom-out"><?php _e( 'Zoom Out', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-flip-x' ) echo 'selected="selected"'; ?> value="ih-flip-x"><?php _e( 'Flip X', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_head_animation'] == 'ih-flip-y' ) echo 'selected="selected"'; ?> value="ih-flip-y"><?php _e( 'Flip Y', 'la-hover-advance' ); ?></option>
										</select>
									</td>	
									<td style="width:50%">
										<p class="description"><?php _e( 'Select Animation For the Heading.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Description', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<textarea class="widefat capdesc form-control" id="" cols="30" rows="10"><?php $content= stripslashes($data2['cap_desc']);
								                        	echo $content; ?></textarea>
									</td>
									<td>
										<p class="description"><?php _e( 'Give description for the caption', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Animation (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
								        <select disabled class="capanim form-control">
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade' ) echo 'selected="selected"'; ?> value="ih-fade"><?php _e( 'Fade', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-up' ) echo 'selected="selected"'; ?> value="ih-fade-up"><?php _e( 'Fade Up', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-down' ) echo 'selected="selected"'; ?> value="ih-fade-down"><?php _e( 'Fade Down', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-left' ) echo 'selected="selected"'; ?> value="ih-fade-left"><?php _e( 'Fade Left', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-right' ) echo 'selected="selected"'; ?> value="ih-fade-right"><?php _e( 'Fade Right', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-up-big' ) echo 'selected="selected"'; ?> value="ih-fade-up-big"><?php _e( 'Fade Up Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-down-big' ) echo 'selected="selected"'; ?> value="ih-fade-down-big"><?php _e( 'Fade Down Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-left-big' ) echo 'selected="selected"'; ?> value="ih-fade-left-big"><?php _e( 'Fade Left Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-fade-right-big' ) echo 'selected="selected"'; ?> value="ih-fade-right-big"><?php _e( 'Fade Right Big', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-zoom-in' ) echo 'selected="selected"'; ?> value="ih-zoom-in"><?php _e( 'Zoom In', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-zoom-out' ) echo 'selected="selected"'; ?> value="ih-zoom-out"><?php _e( 'Zoom Out', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-flip-x' ) echo 'selected="selected"'; ?> value="ih-flip-x"><?php _e( 'Flip X', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_desc_animation'] == 'ih-flip-y' ) echo 'selected="selected"'; ?> value="ih-flip-y"><?php _e( 'Flip Y', 'la-hover-advance' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select Animation For the Caption.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								
								<tr>
									<td>
										<strong><?php _e( 'Caption Link', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="text" class="widefat caplink form-control" value="<?php echo $data2['cap_link'] ?>">
									</td>
									<td>
										<p class="description"><?php _e( 'Give link to caption', 'la-hover-advance' ); ?></p>
									</td>
								</tr> 

								<tr>
									<td>
										<strong><?php _e( 'Open Link in New Tab (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select disabled class="capnewtab form-control">
											<option <?php if ( $data2['cap_newtab'] == 'yes' ) echo 'selected="selected"'; ?> value="yes"><?php _e( 'Yes', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_newtab'] == 'no' ) echo 'selected="selected"'; ?> value="no"><?php _e( 'No', 'la-hover-advance' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose want to open link in new tab or not.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Heading Font Size (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" disabled class="headfontsize form-control" value="<?php echo $data2['cap_headsize']; ?>">
									</td>
									<td>
										<p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Heading.(Default 22)', 'la_caption_hover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Description Font Size (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" disabled class="descfontsize form-control" value="<?php echo $data2['cap_descsize']; ?>">
									</td>
									<td>
										<p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Description.(Default 12)', 'la_caption_hover' ); ?></p>
									</td>
								</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Heading Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
				  					</td>
				  					<td>
				  						<input type='text' class="custom head-color" value="<?php echo $data2['cap_headcolor']; ?>" />
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption heading', 'la-hover-advance' ); ?>.</p>
				  					</td>
			  					</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Description Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="desc-color" value="<?php echo $data2['cap_desccolor']; ?>">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption description', 'la-hover-advance' ); ?>.</p>
				  					</td>
			  					</tr>
							</table>
							<h4><?php _e( 'Hover Settings', 'la-hover-advance' ); ?></h4>
							<hr>
							<table class="form-table">
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Responsive Width & Height', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<select class="respimages form-control">
											<option <?php if ( $data2['cap_resp_option'] == 'yes' ) echo 'selected="selected"'; ?> value="yes"><?php _e( 'Yes', 'la-hover-advance' ); ?></option>
											<option <?php if ( $data2['cap_resp_option'] == 'no' ) echo 'selected="selected"'; ?> value="no"><?php _e( 'No', 'la-hover-advance' ); ?></option>
										</select>
									</td>
									<td style="width:50%">
										<p class="description"><?php _e( 'If set yes the images will get width of griding else you can set custom width and height.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr class="customwidth">
									<td style="width:20%">
										<strong><?php _e( 'Thumbnail Width (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="number" class="form-control thumbwidth" value="<?php echo $data2['cap_thumbwidth']; ?>">
									</td>
									<td style="width:50%">
										<p class="description"><?php _e( 'Give thumbnail width (keep width and height same for circle style) for the thumbnail.Default(220)', 'la-hover-advance' ); ?></p>
									</td>
								</tr>

								<tr class="customheight">
									<td>
										<strong><?php _e( 'Thumbnail Height (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" class="form-control thumbheight" value="<?php echo $data2['cap_thumbheight']; ?>">
									</td>
									<td>
										<p class="description"><?php _e( 'Give thumbnail height (keep width and height same for circle style) for the thumbnail.Default(220)', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Select Hover Effect', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="effectopt form-control widefat">
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-push-up' ) echo 'selected="selected"'; ?> value="imghvr-push-up">Push Up</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-push-down' ) echo 'selected="selected"'; ?> value="imghvr-push-down">Push Down</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-push-left' ) echo 'selected="selected"'; ?> value="imghvr-push-left">Push Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-push-right' ) echo 'selected="selected"'; ?> value="imghvr-push-right">Push Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-up' ) echo 'selected="selected"'; ?> value="imghvr-slide-up">Slide Up</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-down' ) echo 'selected="selected"'; ?> value="imghvr-slide-down">Slide Down</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-left' ) echo 'selected="selected"'; ?> value="imghvr-slide-left">Slide Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-right' ) echo 'selected="selected"'; ?> value="imghvr-slide-right">Slide Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-top-left' ) echo 'selected="selected"'; ?> value="imghvr-slide-top-left">Slide Top Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-top-right' ) echo 'selected="selected"'; ?> value="imghvr-slide-top-right">Slide Top Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-bottom-left' ) echo 'selected="selected"'; ?> value="imghvr-slide-bottom-left">Slide Bottom Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-slide-bottom-right' ) echo 'selected="selected"'; ?> value="imghvr-slide-bottom-right">Slide Bottom Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-up' ) echo 'selected="selected"'; ?> value="imghvr-reveal-up">Reveal Up</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-down' ) echo 'selected="selected"'; ?> value="imghvr-reveal-down">Reveal Down</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-left' ) echo 'selected="selected"'; ?> value="imghvr-reveal-left">Reveal Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-right' ) echo 'selected="selected"'; ?> value="imghvr-reveal-right">Reveal Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-top-left' ) echo 'selected="selected"'; ?> value="imghvr-reveal-top-left">Reveal Top Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-top-right' ) echo 'selected="selected"'; ?> value="imghvr-reveal-top-right">Reveal Top Right</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-bottom-left' ) echo 'selected="selected"'; ?> value="imghvr-reveal-bottom-left">Reveal Bottom Left</option>
										  <option <?php if ( $data2['cap_effect'] == 'imghvr-reveal-bottom-right' ) echo 'selected="selected"'; ?> value="imghvr-reveal-bottom-right">Reveal Bottom Right</option>
										  		
										   
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select caption hover effects', 'la-hover-advance' ); ?></p>
									</td>
								</tr>

								<tr>
									<td>
										<strong><?php _e( 'Images Per Row', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="capgrid form-control widefat">
										  <option <?php if ( $data2['cap_grid'] == 'col-1-1' ) echo 'selected="selected"'; ?> value="col-1-1">1</option>
										  <option <?php if ( $data2['cap_grid'] == 'col-1-2' ) echo 'selected="selected"'; ?> value="col-1-2">2</option>
										  <option <?php if ( $data2['cap_grid'] == 'col-1-3' ) echo 'selected="selected"'; ?> value="col-1-3">3</option>
										  <option <?php if ( $data2['cap_grid'] == 'col-1-4' ) echo 'selected="selected"'; ?> value="col-1-4">4</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-5' ) echo 'selected="selected"'; ?> disabled value="col-1-5">5 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-6' ) echo 'selected="selected"'; ?> disabled value="col-1-6">6 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-7' ) echo 'selected="selected"'; ?> disabled value="col-1-7">7 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-8' ) echo 'selected="selected"'; ?> disabled value="col-1-8">8 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-9' ) echo 'selected="selected"'; ?> disabled value="col-1-9">9 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-10' ) echo 'selected="selected"'; ?> disabled value="col-1-10">10 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-11' ) echo 'selected="selected"'; ?> disabled value="col-1-11">11 (Pro)</option>  
										  <option <?php if ( $data2['cap_grid'] == 'col-1-12' ) echo 'selected="selected"'; ?> disabled value="col-1-12">12 (Pro)</option>  
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select how many images show in one row.Keep it same for every Image', 'la-hover-advance' ); ?></p>
									</td>
								</tr> 

								<tr> 
									<td>
										<strong><?php _e( 'Caption Background Type (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="capbgtype form-control widefat">
										  <option value="color" <?php if ( $data2['capbgtype'] == 'color' ) echo 'selected="selected"'; ?>>color</option>
										  <option value="image" <?php if ( $data2['capbgtype'] == 'image' ) echo 'selected="selected"'; ?>>image</option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose background type.It can be image or color.', 'la-hover-advance' ); ?></p>
									</td>
								</tr> 

								<tr class="bgcolorrow"> 
									<td>
										<strong><?php _e( 'Caption Background Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input disabled type="text" class="form-control custom capbgcolor" value="<?php echo $data2['cap_bgcolor']; ?>" />
				  						
				  					</td>
									<td><p class="description"><?php _e( 'Choose background color for the caption.(Default #333)', 'la-hover-advance' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
									<td>
										<strong><?php _e( 'Choose Background Image (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
				  						<button disabled class="bgimage button"><?php _e( 'Upload Image', 'la-hover-advance' ); ?></button>
				  						<span class="backgroundimage">
				        					<?php if ($data2['cap_bg_img']!='') {
				        		
				        						echo '<span><img style="max-width: 135px;max-height: 135px;" src="'.$data2['cap_bg_img'].'"><span class="dashicons dashicons-dismiss"></span></span>'; } ?>
				        				</span>

				  					</td>
									<td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-hover-advance' ); ?></p></td>
								</tr>

							</table> <br> <hr>
							<button class="button removeitem"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Remove Image', 'la-hover-advance' ); ?></button> 
							

				       	<span class="moreimages">
				    		<button class="button moreimg"><b title="Add New" class="dashicons dashicons-plus-alt"></b> <?php _e( 'Add Image', 'la-hover-advance' ); ?></button>
							<button class="button-primary addcat"><?php _e( 'Add Category', 'la-hover-advance' ); ?></button>
							<button class="button-primary fullshortcode pull-right" id="<?php echo $data2['shortcode']; ?>"><?php _e( 'Get Shortcode', 'la-hover-advance' ); ?></button>
							<button class="button removecat pull-right"><?php _e( 'Remove Category', 'la-hover-advance' ); ?></button>
				    	</span>

				        </div> 
				        <?php } ?>
				   </div>
				   <?php }  ?>
				   <?php } else { ?>

				    <h3><a href="#">Category Name</a></h3>
				   	  
				   <div class="accordian content">
					
				        <h3><a class=href="#">Image</a></h3>
				        <div>
				        	<table class="form-table">
				        		<tr>
				        			<td style="width:20%">
				        				<strong><?php _e( 'Category Name', 'la-hover-advance' ); ?></strong>
				        			</td>

				        			<td style="width:30%">
				        				<input type="text" class="catname widefat form-control"> 
				        			</td>

				        			<td style="width:50%">
				        				<p class="description"><?php _e( 'Name the category for images.Category name should be same for everyimage', 'la-hover-advance' ); ?></p>
				        			</td>
				        		</tr>
				        		<tr>
				        			<td >
				        				<strong><?php _e( 'Image Name', 'la-hover-advance' ); ?></strong>
				        			</td>

				        			<td >
				        				<input type="text" class="imgname widefat form-control" value="">
				        			</td>

				        			<td>
				        				<p class="description"><?php _e( 'Name the image.It will be for your reference', 'la-hover-advance' ); ?></p>
				        			</td>
				        		</tr>
				        	</table>
				        	<button class="addimage button"><?php _e( 'Upload Image', 'la-hover-advance' ); ?></button>
				        	<span class="image">
				        		
				        	</span><br>
				        	<h4><?php _e( 'Caption Settings', 'la-hover-advance' ); ?></h4>
				        	<hr>
							<table class="form-table">

								<tr style="width:20%">
									<td>
										<strong><?php _e( 'Caption Heading', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="text" class="widefat capheading form-control">
									</td>
									<td style="width:50%">
										<p class="description"><?php _e( 'Type Caption heading', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								
								<tr>
									<td>
										<strong><?php _e( 'Caption Description', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<textarea class="widefat capdesc form-control" cols="30" rows="10"></textarea>
									</td>
									<td>
										<p class="description"><?php _e( 'Give description for the caption.You can use HTML here.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Link', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="text" class="widefat caplink form-control">
									</td>
									<td>
										<p class="description"><?php _e( 'Give link to caption', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Heading Animation (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<select disabled class="headinganim form-control">
											<option  value="ih-fade"><?php _e( 'Fade', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-up"><?php _e( 'Fade Up', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-down"><?php _e( 'Fade Down', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-left"><?php _e( 'Fade Left', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-right"><?php _e( 'Fade Right', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-up-big"><?php _e( 'Fade Up Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-down-big"><?php _e( 'Fade Down Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-left-big"><?php _e( 'Fade Left Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-right-big"><?php _e( 'Fade Right Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-zoom-in"><?php _e( 'Zoom In', 'la-hover-advance' ); ?></option>
											<option  value="ih-zoom-out"><?php _e( 'Zoom Out', 'la-hover-advance' ); ?></option>
											<option  value="ih-flip-x"><?php _e( 'Flip X', 'la-hover-advance' ); ?></option>
											<option  value="ih-flip-y"><?php _e( 'Flip Y', 'la-hover-advance' ); ?></option>
										</select>
									</td>	
									<td style="width:50%">
										<p class="description"><?php _e( 'Select Animation For the Heading', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Caption Animation (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<select disabled class="capanim form-control">
											<option  value="ih-fade"><?php _e( 'Fade', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-up"><?php _e( 'Fade Up', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-down"><?php _e( 'Fade Down', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-left"><?php _e( 'Fade Left', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-right"><?php _e( 'Fade Right', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-up-big"><?php _e( 'Fade Up Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-down-big"><?php _e( 'Fade Down Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-left-big"><?php _e( 'Fade Left Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-fade-right-big"><?php _e( 'Fade Right Big', 'la-hover-advance' ); ?></option>
											<option  value="ih-zoom-in"><?php _e( 'Zoom In', 'la-hover-advance' ); ?></option>
											<option  value="ih-zoom-out"><?php _e( 'Zoom Out', 'la-hover-advance' ); ?></option>
											<option  value="ih-flip-x"><?php _e( 'Flip X', 'la-hover-advance' ); ?></option>
											<option  value="ih-flip-y"><?php _e( 'Flip Y', 'la-hover-advance' ); ?></option>
										</select>
									</td>	
									<td style="width:50%">
										<p class="description"><?php _e( 'Select Animation For the Caption', 'la-hover-advance' ); ?></p>
									</td>
								</tr>

								
								<tr>
									<td>
										<strong><?php _e( 'Open Link in New Tab (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select disabled class="capnewtab form-control">
											<option value="yes"><?php _e( 'Yes', 'la-hover-advance' ); ?></option>
											<option value="no"><?php _e( 'No', 'la-hover-advance' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose want to open link in new tab or not.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Heading Font Size (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" disabled class="headfontsize form-control">
									</td>
									<td>
										<p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Heading.(Default 22)', 'la_caption_hover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Description Font Size (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" disabled class="descfontsize form-control">
									</td>
									<td>
										<p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Description.(Default 12)', 'la_caption_hover' ); ?></p>
									</td>
								</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Heading Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="head-color" disabled value="#fff">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption heading', 'la-hover-advance' ); ?>.</p>
				  					</td>
			  					</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Description Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="desc-color" disabled value="#fff">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption description', 'la-hover-advance' ); ?>.</p>
				  					</td>
			  					</tr>
							</table>
							<h4><?php _e( 'Hover Settings', 'la-hover-advance' ); ?></h4>
							<hr>
							<table class="form-table">
								<tr>
									<td style="width:20%">
										<strong><?php _e( 'Responsive Width & Height', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<select class="respimages form-control">
											<option value="yes"><?php _e( 'Yes', 'la-hover-advance' ); ?></option>
											<option value="no"><?php _e( 'No', 'la-hover-advance' ); ?></option>
										</select>
									</td>
									<td style="width:50%">
										<p class="description"><?php _e( 'If set yes the images will get width of griding else you can set custom width and height.', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr class="customwidth">
									<td style="width:20%">
										<strong><?php _e( 'Thumbnail Width (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="number" class="form-control thumbwidth">
									</td>
									<td style="width:50%">
										<p class="description"><?php _e( 'Give thumbnail width (keep width and height same for circle style) for the thumbnail.Default(220)', 'la-hover-advance' ); ?></p>
									</td>
								</tr>

								<tr class="customheight">
									<td>
										<strong><?php _e( 'Thumbnail Height (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<input type="number" class="form-control thumbheight">
									</td>
									<td>
										<p class="description"><?php _e( 'Give thumbnail height (keep width and height same for circle style) for the thumbnail.Default(220)', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Select Hover Effect', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="effectopt form-control widefat">
										  <option value="imghvr-push-up">Push Up</option>
										  <option value="imghvr-push-down">Push Down</option>
										  <option value="imghvr-push-left">Push Left</option>
										  <option value="imghvr-push-right">Push Right</option>
										  <option value="imghvr-slide-up">Slide Up</option>
										  <option value="imghvr-slide-down">Slide Down</option>
										  <option value="imghvr-slide-left">Slide Left</option>
										  <option value="imghvr-slide-right">Slide Right</option>
										  <option value="imghvr-slide-top-left">Slide Top Left</option>
										  <option value="imghvr-slide-top-right">Slide Top Right</option>
										  <option value="imghvr-slide-bottom-left">Slide Bottom Left</option>
										  <option value="imghvr-slide-bottom-right">Slide Bottom Right</option>
										  <option value="imghvr-reveal-up">Reveal Up</option>
										  <option value="imghvr-reveal-down">Reveal Down</option>
										  <option value="imghvr-reveal-left">Reveal Left</option>
										  <option value="imghvr-reveal-right">Reveal Right</option>
										  <option value="imghvr-reveal-top-left">Reveal Top Left</option>
										  <option value="imghvr-reveal-top-right">Reveal Top Right</option>
										  <option value="imghvr-reveal-bottom-left">Reveal Bottom Left</option>
										  <option value="imghvr-reveal-bottom-right">Reveal Bottom Right</option>
										  
										   
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select caption hover effects', 'la-hover-advance' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Images Per Row', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="capgrid form-control widefat">
										  <option value="col-1-1">1</option>
										  <option value="col-1-2">2</option>
										  <option value="col-1-3">3</option>
										  <option value="col-1-4">4</option>  
										  <option disabled value="col-1-5">5 (Pro)</option>  
										  <option disabled value="col-1-6">6 (Pro)</option>  
										  <option disabled value="col-1-7">7 (Pro)</option>  
										  <option disabled value="col-1-8">8 (Pro)</option>  
										  <option disabled value="col-1-9">9 (Pro)</option>  
										  <option disabled value="col-1-10">10 (Pro)</option>  
										  <option disabled value="col-1-11">11 (Pro)</option>  
										  <option disabled value="col-1-12">12 (Pro)</option>  
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select how many images show in one row.Keep it same for every Image', 'la-hover-advance' ); ?></p>
									</td>
								</tr>

								<tr>
									<td>
										<strong><?php _e( 'Caption Background Type (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
										<select class="capbgtype form-control widefat">
										  <option value="color" >color</option>
										  <option value="image" >image</option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose background type.It can be image or color.', 'la-hover-advance' ); ?></p>
									</td>
								</tr> 

								<tr class="bgcolorrow"> 
									<td>
										<strong><?php _e( 'Caption Background Color (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
				  						<input type="text" class="form-control custom capbgcolor" disabled value="#fff" />
				  					</td>
									<td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-hover-advance' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
									<td>
										<strong><?php _e( 'Choose Background Image (Available In Pro)', 'la-hover-advance' ); ?></strong>
									</td>
									<td>
				  						<button disabled class="bgimage button"><?php _e( 'Upload Image', 'la-hover-advance' ); ?></button>
				  						<span class="backgroundimage">
				        		
				        				</span>
				  					</td>
									<td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-hover-advance' ); ?></p></td>
								</tr>

							</table> <br> <hr>
							<button class="button removeitem"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Remove Image', 'la-hover-advance' ); ?></button> 
								
				       	<span class="moreimages">
				    		<button class="button moreimg"><b title="Add New" class="dashicons dashicons-plus-alt"></b><?php _e( 'Add Image', 'la-hover-advance' ); ?></button>
							<button class="button-primary addcat"><?php _e( 'Add Category', 'la-hover-advance' ); ?></button>
							<button class="button-primary fullshortcode pull-right" id="1"><?php _e( 'Get Shortcode', 'la-hover-advance' ); ?></button>
							<button class="button removecat pull-right"><?php _e( 'Remove Category', 'la-hover-advance' ); ?></button>
				    	</span>
				        </div>

				   </div>
				<?php } ?>
				</div>
					<hr>
					<button class="button-primary save-meta pull-right"><?php _e( 'Save Data', 'la-hover-advance' ); ?></button>
					<span id="la-loader" class="pull-right"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader.gif"></span>
					<span id="la-saved"><strong><?php _e( 'Changes Saved!', 'la-portfolio' ); ?></strong></span>
			</div>
		<?php
		}

		function render_caption_hovers($atts){
			$saved_captions = get_option( 'la_hover_effects_pack' );
			include 'render-hover-effects.php';
			
		}
}		
 ?>