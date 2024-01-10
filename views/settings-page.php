<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php
    $active_tab = $_GET['tab'] ?? 'main_options';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=borsay_slider_admin&tab=main_options"
           class="nav-tab <?php echo $active_tab =='main_options'? 'nav-tab-active' :''; ?>">Main Options</a>
        <a href="?page=borsay_slider_admin&tab=additional_options"
           class="nav-tab <?php echo $active_tab =='additional_options'? 'nav-tab-active' :''; ?>">Additional Options</a>
    </h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('borsay_slider_group');

        if($active_tab == 'main_options') {
	        do_settings_sections('borsay_slider_page1');

        }else if($active_tab =='additional_options'){
	        do_settings_sections('borsay_slider_page2');
	        submit_button('Save Settings');

        }

        ?>
    </form>
</div>