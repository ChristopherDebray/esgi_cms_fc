<?php get_header() ?>

<main class="site-content site-content--brand-background">
	<div class="container">
		<h1 class="title title--xxxl">
      404 Error.
    </h1>

    <p>
    The page you were looking for couldn't be found.<br/>
    Maybe try a search?
    </p>

    <div class="row">
      <form role="search" class="col-md-8 relative error404__search" id="searchform" method="get" action="<?php echo home_url('/'); ?>">
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Type something to search…">
        <span class="absolute right-0 bottom-1 w-auto"> <?= getIcon('search') ?> </span>
      </form>
    </div>
	</div>
</main>

<?php get_footer() ?>