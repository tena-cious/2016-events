<?php
/*
Template name: Event Archive Template
*/

function accordion_init() { ?>
	<script>
		var $ = jQuery;

		$(function() {
			var $allPanels = $('.allevents dd').hide();

			$('dt').on('click', function(e) {
				e.preventDefault();

				if ($(this).hasClass('active')) {
					$allPanels.slideUp();
					$(this).removeClass('active');

					return false;
				} else {
					$('dt.active').removeClass('active');
					$allPanels.slideUp();

					// $(this).parent().next().show();
					$(this).addClass('active');
					$(this).next().slideDown();
					// console.log( $(this).next() );
					return false;
				}
			});

		});		
	</script>
<?php }
//add to wp_footer
add_action( 'wp_footer', 'accordion_init', 100 );

get_header(); 
get_template_part('index_header');
?>
	<?php if (has_post_thumbnail()): ?>
    <div class="masthead masthead-blog rel-1" style="display: none;">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<?php  if((get_post_meta( get_the_ID(), 'ninetheme_bobby_disable_title', true )!= true) ){ ?> 
					<h1 class="lead-heading"><?php if(get_post_meta( get_the_ID(), 'ninetheme_bobby_alt_title', true )){ 
					echo get_post_meta( get_the_ID(), 'ninetheme_bobby_alt_title', true ); 
					} else {
						echo ('Our latest news'); 
					} ?>
					</h1>
					<p class="lead text-muted blog-muted">
					<?php if(get_post_meta( get_the_ID(), 'ninetheme_bobby_subtitle', true )){ 
					echo get_post_meta( get_the_ID(), 'ninetheme_bobby_subtitle', true ); } 
					else { 
					echo ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at eros ex feugiat tristique eget a dui. '); 
					}  ?>
					</p>
				
					<?php } ?>	
					<p class="lead breadcrubms"><?php ninetheme_bobby_breadcrubms(); ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</header>

<section id="blog">
<div class="container-off has-margin-bottom">
	<div class="row-off">
		<div class="col-md-12-off has-margin-bottom">
			<?php    

				if (have_posts()) : while (have_posts()) : the_post();
					global $post;
				    the_content(); 
				endwhile; endif; 

				// insert custom tena.cious does events after main page content
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
				$posts_per_page = '6';

				$meta_query = array(
					array(
						'key' => 'date',
						'value' => date('Ymd'),
						'type' => 'DATE',
						'compare' => '<='
						)
					);

				$args = array(
					'post_type' => 'tenaciousdoes',
					'posts_per_page' => $posts_per_page,
					'order' => 'desc',
					'orderby' => 'meta_value_num',
					'meta_key' => 'date',
					'offset' => (max(1, get_query_var('paged')) - 1) * $posts_per_page,
					'meta_query' => $meta_query,
					'paged' => $paged
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) { 
					// print_r($query); ?>

					<div class="eventcalendar cf">

						<div class="vc_row wpb_row vc_row-fluid" style="padding-bottom: 40px; padding-top: 40px;">
							<div class="wpb_column vc_column_container vc_col-sm-10 vc_col-sm-offset-1">
								<div class="vc_column-inner ">
									<div class="wpb_wrapper">

										<dl class="allevents">
					
										<?php while ( $query->have_posts() ) : $query->the_post();
											global $more; 
											$more = 0;

											$eventdate = get_field('date', false, false); 
											$eventdate = new DateTime($eventdate);
											// var_dump(get_field('cta_text')); 
											?>

												<?php 
													if (has_post_thumbnail()) { 
														$bgimageurl = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
														$bgimageurl = $bgimageurl[0];
													} else { 
														$bgimageurl = get_stylesheet_directory_uri() . "/images/event_teamtenacious.png";
													} 
												?>

											<dt class="eventtitle cf" style="background-image: url(<?php echo $bgimageurl; ?>);">
													<div class="eventday"><?php echo $eventdate->format('d'); ?></div>
													<div class="eventdatedivider">
														<span class="eventmonth"><?php echo $eventdate->format('M Y'); ?></span>
														<span class="eventname">
															<?php if (get_field('display_title')) {
																	echo the_field('display_title');
																} else {
																	the_title();
																} ?>
														</span>
													</div>
												</dt>
												<dd class="eventinfo">

													<?php if (get_field('cta_text')) { ?>

													<div class="vc_row wpb_row vc_row-fluid">
														<div class="wpb_column vc_column_container vc_col-sm-9">
															<div class="vc_column-inner ">
																<div class="wpb_wrapper">
																	<?php the_content('Read more &raquo;'); ?>
																</div>
															</div>
														</div>
														<div class="wpb_column vc_column_container vc_col-sm-3">
															<div class="vc_column-inner ">
																<div class="wpb_wrapper">
																	<div class="vc_btn3-container vc_btn3-center">
																		<div class="vc_btn3-container vc_btn3-inline">
																			<a target="_blank" href="<?php echo get_field('cta_link'); ?>" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-outline vc_btn3-block vc_btn3-color-green"><?php echo get_field('cta_text'); ?></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<?php } else { ?>
														<?php the_content('Read more &raquo;'); ?>
													<?php } ?>

												</d>
						
											<?php
										endwhile; // end of the loop. ?>

										</dl>

									</div>
								</div>
							</div>
						</div>


						<!-- pagination -->
						<div class="vc_row wpb_row vc_row-fluid vc_row-has-fill" style="background-color: #363333; padding-bottom: 40px; padding-top: 40px;">
							<div class="wpb_column vc_column_container vc_col-sm-10 vc_col-sm-offset-1">
								<div class="vc_column-inner ">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element  whiteText">
											<div class="wpb_wrapper">
												<?php 
													$page_id = get_queried_object_id();
													$parent = wp_get_post_parent_id( $page_id );
													if ($parent) {
														$parentUrl = get_permalink($parent); ?>

														<p style="text-align: center;">
															» <a href="<?php echo $parentUrl ?>" style="text-transform: uppercase;">UPCOMING EVENTS</a> «
														</p>

													<?php }
												
													if ($query->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
														<p style="text-align: center;">
															<?php echo get_previous_posts_link( '» OLDER EVENTS «' ); // display all previous events link ?>
															<?php if (get_previous_posts_link() && get_next_posts_link()) { echo '&nbsp;&nbsp;&nbsp;&nbsp;'; } ?>
															<?php echo get_next_posts_link( '» MORE RECENT EVENTS «', $query->max_num_pages ); // display older posts link ?>
														</p>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				<?php wp_reset_postdata();

				} else { ?>
					<p>No events found.</p>
				<?php }

			?>
		</div>
	</div>
</div>
</section>

<?php get_footer(); ?>