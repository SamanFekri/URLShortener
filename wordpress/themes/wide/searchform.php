<form method="get"  class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

    <div class="input-group">
        <label class="screen-reader-text"><?php echo esc_attr__( 'Search for:','wide' ); ?></label>
        <input type="text" class="form-control" placeholder="<?php echo esc_attr__( 'Search ... ','wide' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <span class="input-group-btn">
            <button class="btn btn-primary"><i class="ti-search"></i></button>
        </span>
    </div>

</form>