<?php
if(! class_exists('Borsay_Slider_Settings')) {
    class Borsay_Slider_Settings {
        public static $options;

        public function __construct(){
            self::$options = get_option('borsay_slider_options');
            add_action( 'admin_init', array($this, 'admin_init'));
        }

        public function admin_init(): void {
            register_setting(
                'borsay_slider_group',
                'borsay_slider_options',
                array( $this, 'borsay_slider_validate')
            );

            add_settings_section(
                'borsay_slider_main_section',
                'How does it work',
                null,
                'borsay_slider_page1'
            );
            add_settings_section(
                'borsay_slider_second_section',
                'Other Plugin Options',
                null,
                'borsay_slider_page2'
            );

            add_settings_field(
                'borsay_slider_shortcode',
                'Shortcode',
                array($this, 'borsay_slider_shortcode_callback'),
                'borsay_slider_page1',
                'borsay_slider_main_section'
            );

            add_settings_field(
                'borsay_slider_title',
                'Slider Title',
                array($this, 'borsay_slider_title_callback'),
                'borsay_slider_page2',
                'borsay_slider_second_section',
                array(
                        'label_for'=>'borsay_slider_title'
                )
            );

            add_settings_field(
                'borsay_slider_bullets',
                'Display Bullets',
                array($this, 'borsay_slider_bullets_callback'),
                'borsay_slider_page2',
                'borsay_slider_second_section',
                array(
                        'label_for'=>'borsay_slider_bullets'
                )
            );

            add_settings_field(
                'borsay_slider_style',
                'Slider Style',
                array($this, 'borsay_slider_style_callback'),
                'borsay_slider_page2',
                'borsay_slider_second_section',
                array(
                        'items' => array(
                                'style-1',
                                'style-2'
                        ),
                        'label_for'=> 'borsay_slider_style'
                )
            );
        }

        public function borsay_slider_shortcode_callback(){
            ?>
            <span>Use the short code [borsay_slider] to display the slider in any page/post/widget</span>
            <?php
        }

        public function borsay_slider_title_callback(){
            ?>
            <input
                type="text"
                name="borsay_slider_options[borsay_slider_title]"
                id="borsay_slider_title"
                value="<?php echo isset( self::$options['borsay_slider_title']) ? esc_attr(self::$options['borsay_slider_title']) : ''; ?>"
            <?php
        }

        /**
         * @return void
         */
        public function borsay_slider_bullets_callback(): void{
            ?>
            <input
                type="checkbox"
                name="borsay_slider_options[borsay_slider_bullets]"
                id="borsay_slider_bullets"
                value="1"
                <?php
                if(isset(self::$options['borsay_slider_bullets'])) {
                    checked( "1", self::$options['borsay_slider_bullets'] );
                }
                ?>
                />
                <label for="borsay_slider_bullets"> Whether to display bullets of not
            <?php
        }

        public function borsay_slider_style_callback($args): void{ ?>
            <select
                id="borsay_slider_style"
                name="borsay_slider_options[borsay_slider_style]">
                <?php
                foreach ($args['items'] as $item):
                ?>

                <option value="<?php echo esc_attr($item); ?>"
                    <?php if(isset(self::$options['borsay_slider_style']) ){
                        selected($item, self::$options['borsay_slider_style']);
                    } ?>><?php echo esc_html(ucfirst($item)); ?></option>
                    <?php endforeach; ?>

            </select>
           <?php
        }

        public function borsay_slider_validate($input):array{
            $new_input =array();
            foreach( $input as $key => $value){
                switch ($key){
                    case 'borsay_slider_title':
                        if( empty($value)){
                        add_settings_error('borsay_slider_options','borsay_slider_message','The title field cannot be left empty!');

                        }
                        $new_input[$key] = sanitize_text_field($value);
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                    break;
                }
            }
            return $new_input;
        }
    }
}