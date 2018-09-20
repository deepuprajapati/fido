<?php
/**
 * Template Name: Overview
 *
 * @package WordPress
 * @subpackage Packer_movers
 * @since Packer Movers 1.0
 */

get_header(); ?>


<div class="page-title" style="background-image: url('<?php bloginfo('template_url'); ?>/images/title/bg01.jpg')">
  <div class="container">
    <h1 class="entry-title">About Us - Basic</h1>
    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li class="active">About Us - Basic</li>
    </ol>
  </div>
</div>

<section class="our-company">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="custom-heading part-heading three-slashes">
          <h2>ABOUT US</h2>
        </div>
        <div class="description">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id nisl neque. Proin tincidunt porttitor vestibulum. Ut dictum vel tellus ac semper. In leo lectus, malesuada sed feugiat quis, placerat et mauris.</p>

          <p>Nam non nisl fermentum, fringilla orci sit amet, ullamcorper urna. Aenean viverra pellentesque luctus. Donec a aliquam libero. Curabitur eu felis arcu. Pellentesque sed leo in turpis volutpat laoreet at id sapien. Phasellus ac euismod orci, in tristique dolor. Nam non nisl fermentum, fringilla orci sit amet, ullamcorper urna. Aenean viverra pellentesque luctus. Donec a aliquam libero. Curabitur eu felis arcu. Pellentesque sed leo in turpis volutpat laoreet at id sapien. Phasellus ac euismod orci, in tristique dolor.</p>

			<p>Nam non nisl fermentum, fringilla orci sit amet, ullamcorper urna. Aenean viverra pellentesque luctus. Donec a aliquam libero. Curabitur eu felis arcu. Pellentesque sed leo in turpis volutpat laoreet at id sapien. Phasellus ac euismod orci, in tristique dolor.</p>

			<p>Nam non nisl fermentum, fringilla orci sit amet, ullamcorper urna. Aenean viverra pellentesque luctus. Donec a aliquam libero. Curabitur eu felis arcu. Pellentesque sed leo in turpis volutpat laoreet at id sapien. Phasellus ac euismod orci, in tristique dolor.</p>

          <p>Curabitur eu felis arcu. Pellentesque sed leo in turpis volutpat laoreet at id sapien. Phasellus ac euismod orci, in tristique dolor. </p>

        </div>
      </div>
      <div class="col-lg-4">
		<img class="imgBlck" src="<?php bloginfo('template_url'); ?>/images/banner6.png">
      </div>
    </div>
  </div>
</section>



	  
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>    
		<?php if( have_rows('home_history') ): ?>
		<section class="about-img-list">
			<div class="container">
				<div class="row">
					<div class="col-lg-112">
						<div class="custom-heading part-heading three-slashes">
						<h2>THE HISTORY</h2>
						</div>
						<div class="row">
							<ul class="slides">
								<?php while( have_rows('home_history') ): the_row(); 
								// vars
								$historyimage = get_sub_field('history_image');
								$historyyear = get_sub_field('history_year');
								$historytitle = get_sub_field('history_title');
								?>
								<div class="col-lg-3">
									<article class="post history-post has-post-thumbnail hentry">
										<div class="post-image">
											  <div class="dates">
												<span class="year"><?php echo $historyyear; ?></span>
											  </div><?php if( $historyimage ): ?>
											<?php endif; ?>
												  <img class="img-fluid" src="<?php echo $historyimage['url']; ?>" alt="<?php echo $historyimage['alt'] ?>">
											<?php if( $historyimage ): ?>
											<?php endif; ?>
										</div>
										<!-- post-image -->

										<header class="entry-header">
										  <h3 class="entry-title"><?php echo $historytitle; ?></h3>
										</header>
										<!-- .entry-header -->
									</article>
								</div>
								<?php endwhile; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>
<?php endif; ?>
	

<?php get_footer(); ?>