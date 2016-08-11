<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Shop_Customizer
 * @subpackage Woocommerce_Shop_Customizer/admin
 * @author     MBJ Technolabs <info@mbjtechnolabs.com>
 */
class Woocommerce_Shop_Customizer_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Shop_Customizer_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Shop_Customizer_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-shop-customizer-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Shop_Customizer_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Shop_Customizer_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name . 'bn', plugin_dir_url(__FILE__) . 'js/woo-shop-customizer-bn.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-shop-customizer-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script('woocommerce-shop-coutomizer-accourdion', plugin_dir_url(__FILE__) . 'js/accordion.js', array('jquery'), $this->version, false);
    }

    /**
     * @since    1.0.0
     */
    public function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/woocommerce-shop-customizer-admin-display.php';
    }

    public function clivern_plugin_render_options_page() {
        add_options_page('Woo Customizer', 'Woo Customizer', 'manage_options', 'woo-shop-customizer-setting', array($this, 'my_woocommerce_shop_customizer_option_page'));
    }

    public function woo_shop_customizer_paypal_args($paypal_args) {
        $paypal_args['bn'] = 'mbjtechnolabs_SP';
        return $paypal_args;
    }

    public function woo_shop_customizer_paypal_digital_goods_nvp_args($paypal_args) {
        $paypal_args['BUTTONSOURCE'] = 'mbjtechnolabs_SP';
        return $paypal_args;
    }

    public function woo_shop_customizer_gateway_paypal_pro_payflow_request($paypal_args) {
        $paypal_args['BUTTONSOURCE'] = 'mbjtechnolabs_SP';
        return $paypal_args;
    }

    public function woo_shop_customizer_gateway_paypal_pro_request($paypal_args) {
        $paypal_args['BUTTONSOURCE'] = 'mbjtechnolabs_SP';
        return $paypal_args;
    }

    public function my_woocommerce_shop_customizer_option_page() {
        ?>
        <h3><?php _e('WooCommerce Shop Customizer Options', 'woocommerce-shop-customizer'); ?></h3>
        <div class="accordion">
            <?php
            $row_value = get_option('number_of_grid_display');
            if (isset($row_value['number_of_grid'])) {
                $row = $row_value['number_of_grid'];
            }
            $args = array(
                'post_type' => 'product'
            );
            $count = 0;
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()) : $loop->the_post();
                    $count++;
                endwhile;
            }
            if ($count > 1) {
                ?>
                <div class="accordion-section" style="    border-top: 1px solid #dfdfdf;">
                    <a class="accordion-section-title" href="#accordion-1"><?php _e('Select number of product display in one row', 'woocommerce-shop-customizer'); ?></a>
                    <div id="accordion-1" class="accordion-section-content">
                        <form style="" action="options.php" method="POST"> 
                            <?php settings_fields('myoption-group'); ?> 
                            <table>
                                <tr valign="top">
                                    <?php
                                    if ($count > 4) {
                                        $count = 4;
                                    }
                                    for ($i = 1; $i <= $count; $i++) {
                                        ?>
                                        <td style="text-align: center">
                                            <input type="radio" name="number_of_grid_display[number_of_grid]" value="<?php echo $i; ?>" <?php if ($row == $i) echo "checked = 'checked'"; ?>/>
                                            <table border="1" width="100" height="100">
                                                <th colspan="<?php echo $i; ?>"><?php _e($i, 'woocommerce-shop-customizer'); ?></th>
                                                <tr>
                                                    <?php
                                                    $str_value = "";
                                                    for ($j = 1; $j <= $i; $j++) {
                                                        $str_value.= "<td height=\"100\"></td>";
                                                    }
                                                    echo $str_value;
                                                    ?>                                                       
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } ?>
                                </tr> 
                            </table>
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row" style="width: 365px;">
                                        <label><?php _e('Show the product description underneath an image', 'woocommerce-shop-customizer'); ?></label>
                                    </th>
                                    <td>
                                        <input type="radio" name="number_of_grid_display[under_image_desription]" value="1" <?php if (isset($row_value['under_image_desription']) == '1') echo 'checked'; ?> > <?php _e('Yes', 'woocommerce-shop-customizer'); ?> 
                                        <input type="radio" name="number_of_grid_display[under_image_desription]" value="0" <?php if (isset($row_value['under_image_desription']) == '0') echo 'checked'; ?> > <?php _e('No', 'woocommerce-shop-customizer'); ?>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit">
                                <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                            </p>                            
                        </form>
                    </div><!--end .accordion-section-content-->
                </div><!--end .accordion-section-->
                <?php
            }
            if ($count > 0) {
                ?>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#accordion-2"><?php _e('Automatically add product in visit site', 'woocommerce-shop-customizer'); ?></a>
                    <div id="accordion-2" class="accordion-section-content">
                        <form action="options.php" method="POST"> 
                            <?php
                            settings_fields('defualt_cart_value_add');
                            $row = get_option('defualt_cart_value');
                            ?> 
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row">
                                <lable><?php _e('Select product name', 'woocommerce-shop-customizer'); ?></lable>
                                </th> 
                                <td>
                                    <?php
                                    $args = array('post_type' => 'product');
                                    $loop = new WP_Query($args);
                                    if ($loop->have_posts()) {
                                        ?>
                                        <select name="defualt_cart_value[defualt_cart_item]" style="min-width: 300px;"><?php while ($loop->have_posts()) : $loop->the_post(); ?>
                                                <option value="<?php echo $loop->post->ID; ?>" <?php if (isset($row['defualt_cart_item']) == $loop->post->ID) echo "selected = 'selected'"; ?> ><?php the_title(); ?></option><?php endwhile;
                                        ?>
                                        </select>
                                    </td>
                                    </tr>
                                </table><?php
                            } else {
                                echo __('No products found');
                            }
                            wp_reset_postdata();
                            ?>
                            <p class="submit">
                                <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                            </p>                            
                        </form>
                    </div><!--end .accordion-section-content-->
                </div><!--end .accordion-section-->
            <?php } ?>
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-3"><?php _e('Remove specific or All of the product tabs in single page view', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-3" class="accordion-section-content">
                    <form action="options.php" method="POST"> 
                        <?php
                        settings_fields('checkbox_check_remove_product_tab');
                        $row_value = get_option('checkbox_check_remove_tab');
                        $description = "";
                        $reviews = "";
                        $information = "";
                        if (is_array($row_value)) {
                            $description = $row_value['description'];
                            $reviews = $row_value['reviews'];
                            $information = $row_value['information'];
                        }
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                            <lable><?php _e('Remove specific tab', 'woocommerce-shop-customizer'); ?></lable>
                            </th> 
                            <td>
                                <input type="checkbox" name="checkbox_check_remove_tab[description]" value="description" <?php if ($description === 'description') echo 'checked="checked"'; ?>>  <?php _e('Description', 'woocommerce-shop-customizer'); ?><br/>
                                <input type="checkbox" name="checkbox_check_remove_tab[reviews]" value="reviews" <?php if ($reviews === 'reviews') echo 'checked="checked"'; ?>>  <?php _e('Reviews', 'woocommerce-shop-customizer'); ?><br/>
                                <input type="checkbox" name="checkbox_check_remove_tab[information]" value="information" <?php if ($information === 'information') echo 'checked="checked"'; ?>> <?php _e('Additional information', 'woocommerce-shop-customizer'); ?> <br/>
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-4"><?php _e('Single product tab settings', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-4" class="accordion-section-content">
                    <form action="options.php" method="POST"> 
                        <?php
                        settings_fields('select_priority_in_dropdown_list');
                        $row_value = get_option('select_priority_in_dropdown');
                        $row_array = array('5' => 'First',
                            '10' => 'Second');
                        if (is_array($row_value)) {
                            $description = $row_value['description'];
                            $reviews = $row_value['reviews'];
                            //$information = $row_value['information'];  
                        }
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Select reviews tab priority', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <select name="select_priority_in_dropdown[reviews]" style="min-width: 300px;">
                                        <?php foreach ($row_array as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if ($key == $reviews) echo "selected='selected'"; ?>><?php echo $value; ?></option>
                                        <?php } ?>                                
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Select discription tab priority', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <select name="select_priority_in_dropdown[description]" style="min-width: 300px;">
                                        <?php foreach ($row_array as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if ($key == $description) echo "selected='selected'"; ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Rename review tab', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="select_priority_in_dropdown[rename_reviews]" value="<?php if (isset($row_value['rename_reviews'])) echo $row_value['rename_reviews']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>                            
                            <tr valign="top"> 
                                <th scope="row">
                                    <label><?php _e('Rename discription tab', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="select_priority_in_dropdown[rename_description]" value="<?php if (isset($row_value['rename_description'])) echo $row_value['rename_description']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Add custom title', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="select_priority_in_dropdown[custom_title_tab]" value="<?php if (isset($row_value['custom_title_tab'])) echo $row_value['custom_title_tab']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Add custom description', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <textarea name="select_priority_in_dropdown[custom_descriptiom_tab]" style="min-width: 300px;"><?php if (isset($row_value['custom_descriptiom_tab'])) echo $row_value['custom_descriptiom_tab']; ?></textarea>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <h4><?php _e('Add to Cart Button Text', 'woocommerce-shop-customizer'); ?></h4>
                                </th>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('All Product Types', 'woocommerce-shop-customizer'); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="select_priority_in_dropdown[single_product_add_to_cart_text]" style="min-width: 300px;" value="<?php if (isset($row_value['single_product_add_to_cart_text'])) echo $row_value['single_product_add_to_cart_text']; ?>">
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->             
            <?php
            $args = array('taxonomy' => 'product_cat');
            $terms = get_terms('product_cat', $args);
            if (is_array($terms) && count($terms) > 0) {
                ?>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#accordion-5"><?php _e('Remove product content based on the category', 'woocommerce-shop-customizer'); ?></a>
                    <div id="accordion-5" class="accordion-section-content">
                        <form action="options.php" method="POST">     
                            <?php settings_fields('remove_selected_category_register'); ?>
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row">
                                        <label><?php _e('Select category', 'woocommerce-shop-customizer'); ?></label>
                                    </th> 
                                    <td><?php
                                        settings_fields('remove_selected_category_register');
                                        $row_value = get_option('remove_selected_category_value');
                                        $count = 0;
                                        $checked = "";
                                        foreach ($terms as $key => $value) {
                                            $count = $count + 1;
                                            $category_name = $terms[$key]->name;
                                            if (is_array($row_value)) {
                                                if (array_key_exists($category_name, $row_value)) {
                                                    if ($category_name == $row_value[$category_name]) {
                                                        $checked = "checked='checked'";
                                                        ?>
                                                        <input type="checkbox" name="remove_selected_category_value[<?php echo $terms[$key]->name; ?>]" value="<?php echo $terms[$key]->name; ?>" <?php echo $checked; ?>> <?php
                                                        echo $terms[$key]->name . "<br/>";
                                                    }
                                                } else {
                                                    $checked = "";
                                                    ?>
                                                    <input type="checkbox" name="remove_selected_category_value[<?php echo $terms[$key]->name; ?>]" value="<?php echo $terms[$key]->name; ?>" <?php echo $checked; ?>> <?php
                                                    echo $terms[$key]->name . "<br/>";
                                                }
                                            } else {
                                                $checked = "";
                                                ?>
                                                <input type="checkbox" name="remove_selected_category_value[<?php echo $terms[$key]->name; ?>]" value="<?php echo $terms[$key]->name; ?>" <?php echo $checked; ?>> <?php
                                                echo $terms[$key]->name . "<br/>";
                                            }
                                        }
                                        ?> </td>
                                </tr>
                            </table>
                            <p class="submit">
                                <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                            </p>                            
                        </form>
                    </div><!--end .accordion-section-content-->
                </div><!--end .accordion-section-->                
                <?php
            }
            $args = array('taxonomy' => 'product_cat');
            $terms = get_terms('product_cat', $args);
            if (is_array($terms) && count($terms) > 0) {
                ?>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#accordion-6"><?php _e('Don\'t Display products from a particular category on the shop page', 'woocommerce-shop-customizer'); ?></a>
                    <div id="accordion-6" class="accordion-section-content">
                        <form action="options.php" method="POST">     
                            <?php settings_fields('do_not_show_category_on_the_shop_page'); ?>
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row">
                                        <label><?php _e('Select category', 'woocommerce-shop-customizer'); ?></label>
                                    </th> 
                                    <td>
                                        <?php
                                        settings_fields('do_not_show_category_on_the_shop_page_register');
                                        $row_value = get_option('do_not_show_category_on_the_shop_page');
                                        $count = 0;
                                        $checked = "";
                                        if (is_array($row_value) && count($row_value) > 0) {
                                            foreach ($terms as $key => $value) {
                                                $count = $count + 1;
                                                $row = $row_value[$terms[$key]->name];
                                                $category_name = $terms[$key]->name;
                                                if (strlen($row) > 0) {
                                                    if ($category_name == $row) {
                                                        $checked = "checked='checked'";
                                                    } else {
                                                        $checked = "";
                                                    }
                                                } else {
                                                    $checked = "";
                                                }
                                                ?> 
                                                <input type="checkbox" name="do_not_show_category_on_the_shop_page[<?php echo $terms[$key]->name; ?>]" value="<?php echo $terms[$key]->name; ?>" <?php echo $checked; ?>> <?php
                                                echo $terms[$key]->name . "<br/>";
                                            }
                                        } else {
                                            foreach ($terms as $key => $value) {
                                                ?>
                                                <input type="checkbox" name="do_not_show_category_on_the_shop_page[<?php echo $terms[$key]->name; ?>]" value="<?php echo $terms[$key]->name; ?>" <?php echo $checked; ?>> <?php
                                                echo $terms[$key]->name . "<br/>";
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit">
                                <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                            </p>                            
                        </form>
                    </div><!--end .accordion-section-content-->
                </div><!--end .accordion-section-->
            <?php } ?>
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-7"><?php _e('Add a checkbox field to checkout with a simple snippet', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-7" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('check_box_tital_text_chekout_page_register');
                        $row_option_value = get_option('check_box_tital_text_chekout_page');
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Display terms & conditions', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="radio" name="check_box_tital_text_chekout_page[radio_button_check_display]" value="1" <?php if (isset($row_option_value['radio_button_check_display']) == '1') echo 'checked'; ?>> <?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                    <input type="radio" name="check_box_tital_text_chekout_page[radio_button_check_display]" value="0" <?php if (isset($row_option_value['radio_button_check_display']) == '0') echo 'checked'; ?>> <?php _e('No', 'woocommerce-shop-customizer'); ?>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Checkbox tital', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="check_box_tital_text_chekout_page[check_box_tital_display]" value="<?php if (isset($row_option_value['check_box_tital_display'])) echo $row_option_value['check_box_tital_display']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Checkbox text', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="check_box_tital_text_chekout_page[check_box_text_display]" value="<?php if (isset($row_option_value['check_box_text_display'])) echo $row_option_value['check_box_text_display']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-8"><?php _e('Want to alter the default state and country at the checkout', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-8" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('defualt_set_code_country_and_state_register');
                        $row_option_value = get_option('defualt_set_code_country_and_state');
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Enter your defualt country code', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="defualt_set_code_country_and_state[country]" value="<?php if (strlen($row_option_value['country']) > 0) echo $row_option_value['country']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Enter your defualt state code', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="defualt_set_code_country_and_state[state]" value="<?php if (strlen($row_option_value['state']) > 0) echo $row_option_value['state']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>                            
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-9"><?php _e('Register or Login on your site by adding a message', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-9" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('ragister_login_additing_message_register');
                        $row_option_value = get_option('ragister_login_additing_message');
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Message 1', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="ragister_login_additing_message[message_1]" value="<?php if (strlen($row_option_value['message_1']) > 0) echo $row_option_value['message_1']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Message 2', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="ragister_login_additing_message[message_2]" value="<?php if (strlen($row_option_value['message_2']) > 0) echo $row_option_value['message_2']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Message 3', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="ragister_login_additing_message[message_3]" value="<?php if (strlen($row_option_value['message_3']) > 0) echo $row_option_value['message_3']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Message 4', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="ragister_login_additing_message[message_4]" value="<?php if (strlen($row_option_value['message_4']) > 0) echo $row_option_value['message_4']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section--> 
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-10"><?php _e('Breadcrumbs setting in home', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-10" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('change_breadcum_in_home_register');
                        $row_option_value = get_option('change_breadcum_in_home');
                        $breadcrumbs_value = "";
                        if (isset($row_option_value['rid_of_all_the_breadcrumbs'])) {
                            $breadcrumbs_value = $row_option_value['rid_of_all_the_breadcrumbs'];
                        }
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Change breadcrumbs in home', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="change_breadcum_in_home[breadcum_home_name]" value="<?php if (isset($row_option_value['breadcum_home_name'])) echo $row_option_value['breadcum_home_name']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Change breadcrumbs in home url', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="change_breadcum_in_home[breadcum_home_name_url]" value="<?php if (isset($row_option_value['breadcum_home_name_url'])) echo $row_option_value['breadcum_home_name_url']; ?>" style="min-width: 300px;">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Get rid of all the breadcrumbs', 'woocommerce-shop-customizer'); ?></label> 
                                </th> 
                                <td>
                                    <input type="radio" name="change_breadcum_in_home[rid_of_all_the_breadcrumbs]" value="yes" <?php if ($breadcrumbs_value == 'yes') echo 'checked'; ?> ><?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                    <input type="radio" name="change_breadcum_in_home[rid_of_all_the_breadcrumbs]" value="no" <?php if ($breadcrumbs_value == 'no') echo 'checked'; ?> ><?php _e('No', 'woocommerce-shop-customizer'); ?>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section--> 
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-11"><?php _e('Replace the old page navigation with fancier pagination links', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-11" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('remove_woocommerce_pagination_register');
                        $row_option_value = get_option('remove_woocommerce_pagination');
                        $pagination_value = "";
                        if (strlen($row_option_value['remove_pagination'])) {
                            $pagination_value = $row_option_value['remove_pagination'];
                        }
                        ?> 
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row" style="width: 365px;">
                                    <label><?php _e('Replace the old page navigation with fancier pagination links', 'woocommerce-shop-customizer'); ?></label> 
                                </th> 
                                <td>
                                    <input type="radio" name="remove_woocommerce_pagination[remove_pagination]" value="yes" <?php if ($pagination_value == 'yes') echo 'checked'; ?> ><?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                    <input type="radio" name="remove_woocommerce_pagination[remove_pagination]" value="no" <?php if ($pagination_value == 'no') echo 'checked'; ?> ><?php _e('No', 'woocommerce-shop-customizer'); ?>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-12"><?php _e('Display category image on category archive', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-12" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_display_category_image_on_category_archive_name');
                        $display_value = get_option('mfwp_display_category_image_on_category_archive_value');
                        $category_archive_value = "";
                        if (isset($display_value['category_display_image_value'])) {
                            $category_archive_value = $display_value['category_display_image_value'];
                        }
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Display category image on category archive', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td>
                                    <input type="radio" name="mfwp_display_category_image_on_category_archive_value[category_display_image_value]" value="yes" <?php if ($category_archive_value == "yes") echo 'checked'; ?> ><?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                    <input type="radio" name="mfwp_display_category_image_on_category_archive_value[category_display_image_value]" value="no" <?php if ($category_archive_value == "no") echo 'checked'; ?> ><?php _e('No', 'woocommerce-shop-customizer'); ?>
                                </td>
                            </tr>                            
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-13"><?php _e('Hide all other shipping methods when free shipping is available', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-13" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_hide_shipping_method_name');
                        $shipping_value = get_option('mfwp_hide_shipping_method_value');
                        $shipping_method_value = "";
                        if (isset($shipping_value['shipping_method'])) {
                            $shipping_method_value = $shipping_value['shipping_method'];
                        }
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row" style="width: 365px;">
                                    <label><?php _e('Hide all other shipping methods when free shipping is available', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td>
                                    <input type="radio" name="mfwp_hide_shipping_method_value[shipping_method]" value="yes" <?php if ($shipping_method_value == 'yes') echo 'checked'; ?> ><?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                    <input type="radio" name="mfwp_hide_shipping_method_value[shipping_method]" value="no" <?php if ($shipping_method_value == 'no') echo 'checked'; ?> ><?php _e('No', 'woocommerce-shop-customizer'); ?>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>"/>
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-14"><?php _e('This trick will allow you to order by price, date or title on your shop page', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-14" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_sort_shop_page_name');
                        $sort_value = get_option('mfwp_sort_shop_page_value');
                        $sort_shop_page_value = "";
                        if (isset($sort_value['sort_shop_page']) && strlen($sort_value['sort_shop_page']) > 0) {
                            $sort_shop_page_value = $sort_value['sort_shop_page'];
                        }
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                                    <label><?php _e('Select order by', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td>
                                    <?php
                                    $sort_arr = array('date' => 'Date',
                                        'title ' => 'Title ',
                                        'price ' => 'Price ',
                                    );
                                    ?>
                                    <select name="mfwp_sort_shop_page_value[sort_shop_page]" style="min-width: 300px;">
                                        <?php foreach ($sort_arr as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if ($key == $sort_shop_page_value) echo "selected = 'selected'"; ?>><?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>     
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section"> 
                <a class="accordion-section-title" href="#accordion-15"><?php _e('Edit the ‘out of stock’ with any text you prefer', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-15" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_edit_out_of_text_name');
                        $text_value = get_option('mfwp_edit_out_of_text_value');
                        $edit_stock_value = "";
                        if (isset($text_value['edit_text_value']) && strlen($text_value['edit_text_value']) > 0) {
                            $edit_stock_value = $text_value['edit_text_value'];
                        }
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                                    <label><?php _e('Edit the ‘out of stock’ with any text you prefer', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td>
                                    <input type="text" name="mfwp_edit_out_of_text_value[edit_text_value]" value="<?php echo $edit_stock_value; ?>" style="min-width: 300px;"/>
                                </td>
                            </tr>                             
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-16"><?php _e('Change the look of your product gallery by customising the number of thumbnails per row', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-16" class="accordion-section-content">
                    <form action="options.php" method="post">
                        <?php
                        settings_fields('mfwp_product_gallery_thumbnails_per_row_name');
                        $text_value = get_option('mfwp_product_gallery_thumbnails_per_row_value');
                        if (isset($text_value['thumbnails_per_row']) && strlen($text_value['thumbnails_per_row']) > 0) {
                            $row_value = $text_value['thumbnails_per_row'];
                        }
                        ?>
                        <table>
                            <tr>
                                <td style="text-align: center">
                                    <input type="radio" name="mfwp_product_gallery_thumbnails_per_row_value[thumbnails_per_row]" value="1" <?php if ($row_value == '1') echo "checked = 'checked'"; ?> />
                                    <table border="1" width="100" height="100">
                                        <th colspan="1"><?php _e('One', 'woocommerce-shop-customizer'); ?></th>
                                        <tr><td height="100"></td></tr>
                                    </table>
                                </td>
                                <td style="text-align: center">
                                    <input type="radio" name="mfwp_product_gallery_thumbnails_per_row_value[thumbnails_per_row]" value="2" <?php if ($row_value == '2') echo "checked = 'checked'"; ?> />
                                    <table border="1" width="100" height="100">
                                        <th colspan="2"><?php _e('Two', 'woocommerce-shop-customizer'); ?></th>
                                        <tr><td height="100"></td><td height="100"></td></tr>
                                    </table>
                                </td>
                                <td style="text-align: center">
                                    <input type="radio" name="mfwp_product_gallery_thumbnails_per_row_value[thumbnails_per_row]" value="3" <?php if ($row_value == '3') echo "checked = 'checked'"; ?> />
                                    <table border="1" width="100" height="100">
                                        <th colspan="3"><?php _e('Three', 'woocommerce-shop-customizer'); ?></th>
                                        <tr><td height="100"></td><td height="100"></td><td height="100"></td></tr>
                                    </table>
                                </td>
                                <td style="text-align: center">
                                    <input type="radio" name="mfwp_product_gallery_thumbnails_per_row_value[thumbnails_per_row]" value="4" <?php if ($row_value == '4') echo "checked = 'checked'"; ?> />
                                    <table border="1" width="100" height="100">
                                        <th colspan="4"><?php _e('Four', 'woocommerce-shop-customizer'); ?></th>
                                        <tr><td height="100"></td><td height="100"></td><td height="100"></td><td height="100"></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-17"><?php _e('Customise a URL to direct customers to from ‘add to cart’', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-17" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_customise_url_direct_customer_add_to_cart_value_name');
                        $url_value = get_option('mfwp_customise_url_direct_customer_add_to_cart_value');
                        $page_set = "";
                        if (isset($url_value['customise_url']) && strlen($url_value['customise_url']) > 0) {
                            $page_set = $url_value['customise_url'];
                        }
                        ?>
                        <p style="color: yellow; background: black"><?php _e('Notice : If you wont to Redirect to the cart page after successful addition Disable the  Enable AJAX add to cart buttons on archives checkbox in Woocommerce->Settings->Products->Display', 'woocommerce-shop-customizer'); ?></p>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                                    <label><?php _e('Choose page to redirect', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td><?php
                                    $pages = get_pages();
                                    ?>
                                    <select name="mfwp_customise_url_direct_customer_add_to_cart_value[customise_url]" style="min-width: 300px;">
                                        <?php foreach ($pages as $page) { ?>
                                            <option value="<?php echo $page->ID; ?>"  <?php if ($page->ID == $page_set) echo "selected = 'selected'"; ?> ><?php echo $page->post_title; ?> </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>                             
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-18"><?php _e('Customise the serach result', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-18" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('serach_value_post_type_register');
                        $row_option_value = get_option('serach_value_post_type');
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                                    <label><?php _e('Customise search results', 'woocommerce-shop-customizer'); ?></label> 
                                </th>
                                <td>
                                    <input type="checkbox" name="serach_value_post_type[serach_products]" value="product" <?php
                                    if (is_array($row_option_value)) {
                                        if (strlen($row_option_value['serach_products']))
                                            echo "checked='checked'";
                                    }
                                    ?> > <?php _e('Products', 'woocommerce-shop-customizer'); ?><br/>
                                    <input type="checkbox" name="serach_value_post_type[serach_posts]" value="post" <?php
                                    if (is_array($row_option_value)) {
                                        if (strlen($row_option_value['serach_posts']))
                                            echo "checked='checked'";
                                    }
                                    ?> ><?php _e('Posts (blog articles)', 'woocommerce-shop-customizer'); ?><br/>
                                    <input type="checkbox" name="serach_value_post_type[serach_pages]" value="page" <?php
                                    if (is_array($row_option_value)) {
                                        if (strlen($row_option_value['serach_pages']))
                                            echo "checked='checked'";
                                    }
                                    ?> ><?php _e('Static pages', 'woocommerce-shop-customizer'); ?><br/>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section--> 
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-19"><?php _e('Want to customise the currency or symbol', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-19" class="accordion-section-content">
                    <form action="options.php" method="POST">   
                        <?php
                        settings_fields('currency_name_symbol_register');
                        $row_option_value = get_option('currency_name_symbol');
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                            <lable><?php _e('Currency name', 'woocommerce-shop-customizer'); ?></lable>
                            </th>
                            <td>
                                <input type="text" name="currency_name_symbol[currency_name]" value="<?php if (strlen($row_option_value['currency_name']) > 0) echo $row_option_value['currency_name']; ?>" placeholder="<?php _e('Rupee', 'woocommerce-shop-customizer'); ?>" style="min-width: 300px;">
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row">
                            <lable><?php _e('Currency code', 'woocommerce-shop-customizer'); ?></lable>
                            </th>
                            <td>
                                <input type="text" name="currency_name_symbol[currency_code]" value="<?php if (strlen($row_option_value['currency_code']) > 0) echo $row_option_value['currency_code']; ?>" placeholder="<?php _e('INR', 'woocommerce-shop-customizer'); ?>" style="min-width: 300px;">
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row">
                            <lable><?php _e('Currency symbol', 'woocommerce-shop-customizer'); ?></lable>
                            </th>
                            <td>
                                <input type="text" name="currency_name_symbol[currency_symbol]" value="<?php if (strlen($row_option_value['currency_symbol']) > 0) echo $row_option_value['currency_symbol']; ?>" placeholder="<?php _e('Rs', 'woocommerce-shop-customizer'); ?>" style="min-width: 300px;">
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>">
                        </p>                        
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-20"><?php _e('Get rid of, or simply unhook eooCommerce emails', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-20" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_unhook_wooCommerce_emails_name');
                        $unhook_email_value = get_option('mfwp_unhook_wooCommerce_emails_value');
                        $displayvalue = "";
                        if (isset($unhook_email_value['unhook_email']) && strlen($unhook_email_value['unhook_email']) > 0) {
                            $displayvalue = $unhook_email_value['unhook_email'];
                        }
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                            <lable><?php _e('Unhook emails', 'woocommerce-shop-customizer'); ?></lable>
                            </th>
                            <td>
                                <input type="radio" name="mfwp_unhook_wooCommerce_emails_value[unhook_email]" value="yes" <?php if ($displayvalue == "yes") echo 'checked'; ?> ><?php _e('Yes', 'woocommerce-shop-customizer'); ?>
                                <input type="radio" name="mfwp_unhook_wooCommerce_emails_value[unhook_email]" value="no" <?php if ($displayvalue == "no") echo 'checked'; ?> ><?php _e('No', 'woocommerce-shop-customizer'); ?>
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form>
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-21"><?php _e('How to add any custom field to your order emails by hooking in and specifying the name of the custom field', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-21" class="accordion-section-content">
                    <form id="featured_upload" method="post" action="options.php" >
                        <?php
                        settings_fields('mfwp_add_custome_field_order_email_name');
                        $custome_field_order_email_value = get_option('mfwp_add_custome_field_order_email_value');
                        $order_email_custome_field_label = "";
                        $order_email_custome_field_value = "";
                        if (isset($custome_field_order_email_value['custome_label_order']) && strlen($custome_field_order_email_value['custome_label_order']) > 0) {
                            $order_email_custome_field_label = $custome_field_order_email_value['custome_label_order'];
                        }
                        if (isset($custome_field_order_email_value['custome_value_order']) && strlen($custome_field_order_email_value['custome_value_order']) > 0) {
                            $order_email_custome_field_value = $custome_field_order_email_value['custome_value_order'];
                        }
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row">
                            <lable><?php _e('Order email custome field label', 'woocommerce-shop-customizer'); ?></lable>
                            </th>
                            <td>
                                <input type="text" name="mfwp_add_custome_field_order_email_value[custome_label_order]" value="<?php echo $order_email_custome_field_label; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Order email custome field value', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="mfwp_add_custome_field_order_email_value[custome_value_order]" value="<?php echo $order_email_custome_field_value; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form> 
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-22"><?php _e('Customize Shop loop ', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-22" class="accordion-section-content">
                    <form method="post" action="options.php" >
                        <?php
                        settings_fields('customize_shop_loop_page_register');
                        $customize_shop_loop_page_value = get_option('customize_shop_loop_page_value');
                        
                        $simple_product_add_to_cart_text = "";
                        $variable_product_add_to_cart_text = "";
                        $grouped_product_add_to_cart_text = "";
                        $external_product_add_to_cart_text = "";
                        $out_of_stock_product_add_to_cart_text = "";
                        $product_columns_displayed_per_page = "";
                        
                        if (isset($customize_shop_loop_page_value['simple_product_add_to_cart_text']) && strlen($customize_shop_loop_page_value['simple_product_add_to_cart_text']) > 0) {
                            $simple_product_add_to_cart_text = $customize_shop_loop_page_value['simple_product_add_to_cart_text'];
                        }
                        if (isset($customize_shop_loop_page_value['variable_product_add_to_cart_text']) && strlen($customize_shop_loop_page_value['variable_product_add_to_cart_text']) > 0) {
                            $variable_product_add_to_cart_text = $customize_shop_loop_page_value['variable_product_add_to_cart_text'];
                        }
                        if (isset($customize_shop_loop_page_value['grouped_product_add_to_cart_text']) && strlen($customize_shop_loop_page_value['grouped_product_add_to_cart_text']) > 0) {
                            $grouped_product_add_to_cart_text = $customize_shop_loop_page_value['grouped_product_add_to_cart_text'];
                        }
                        if (isset($customize_shop_loop_page_value['external_product_add_to_cart_text']) && strlen($customize_shop_loop_page_value['external_product_add_to_cart_text']) > 0) {
                            $external_product_add_to_cart_text = $customize_shop_loop_page_value['external_product_add_to_cart_text'];
                        }
                        if (isset($customize_shop_loop_page_value['out_of_stock_product_add_to_cart_text']) && strlen($customize_shop_loop_page_value['out_of_stock_product_add_to_cart_text']) > 0) {
                            $out_of_stock_product_add_to_cart_text = $customize_shop_loop_page_value['out_of_stock_product_add_to_cart_text'];
                        }
                        if (isset($customize_shop_loop_page_value['product_columns_displayed_per_page']) && strlen($customize_shop_loop_page_value['product_columns_displayed_per_page']) > 0) {
                            $product_columns_displayed_per_page = $customize_shop_loop_page_value['product_columns_displayed_per_page'];
                        }
                        ?>
                        <h3><?php _e('Add to Cart Button Text', 'woocommerce-shop-customizer'); ?></h3>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Simple Product', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[simple_product_add_to_cart_text]" value="<?php echo $simple_product_add_to_cart_text; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Variable Product', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[variable_product_add_to_cart_text]" value="<?php echo $variable_product_add_to_cart_text; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Grouped Product', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[grouped_product_add_to_cart_text]" value="<?php echo $grouped_product_add_to_cart_text; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                            <tr  valign="top"><th scope="row"><lable><?php _e('External Product', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[external_product_add_to_cart_text]" value="<?php echo $external_product_add_to_cart_text; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Out of Stock Product', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[out_of_stock_product_add_to_cart_text]" value="<?php echo $out_of_stock_product_add_to_cart_text; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                        </table>
                        <h3><?php _e('Layout', 'woocommerce-shop-customizer'); ?></h3>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Product columns displayed per page', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_shop_loop_page_value[product_columns_displayed_per_page]" value="<?php echo $product_columns_displayed_per_page; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form> 
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-23"><?php _e('Customize checkout page', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-23" class="accordion-section-content">
                    <form method="post" action="options.php" >
                        <?php
                        settings_fields('customize_checkout_page_register');
                        $customize_checkout_page_value = get_option('customize_checkout_page_value');
                        
                        $checkout_must_be_logged_in_message = "";
                        $checkout_coupon_message = "";
                        $checkout_login_message = "";
                        $order_button_text = "";
                        $create_account_default_checked_value = "";
                        
                        if (isset($customize_checkout_page_value['checkout_must_be_logged_in_message']) && strlen($customize_checkout_page_value['checkout_must_be_logged_in_message']) > 0) {
                            $checkout_must_be_logged_in_message = $customize_checkout_page_value['checkout_must_be_logged_in_message'];
                        }
                        if (isset($customize_checkout_page_value['checkout_coupon_message']) && strlen($customize_checkout_page_value['checkout_coupon_message']) > 0) {
                            $checkout_coupon_message = $customize_checkout_page_value['checkout_coupon_message'];
                        }
                        if (isset($customize_checkout_page_value['checkout_login_message']) && strlen($customize_checkout_page_value['checkout_login_message']) > 0) {
                            $checkout_login_message = $customize_checkout_page_value['checkout_login_message'];
                        }
                        if (isset($customize_checkout_page_value['order_button_text']) && strlen($customize_checkout_page_value['order_button_text']) > 0) {
                            $order_button_text = $customize_checkout_page_value['order_button_text'];
                        }
                        if (isset($customize_checkout_page_value['create_account_default_checked']) && strlen($customize_checkout_page_value['create_account_default_checked']) > 0) {
                            $create_account_default_checked_value = $customize_checkout_page_value['create_account_default_checked'];
                        }
                        $create_account_default_checked = array('Checked' => 'customizer_true', 'Unchecked' => 'customizer_false')
                        ?>
                        <h3><?php _e('Messages', 'woocommerce-shop-customizer'); ?></h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label><?php _e('Display coupon', 'woocommerce-shop-customizer'); ?></label>
                                </th> 
                                <td>
                                    <input type="radio" name="customize_checkout_page_value[display_coupon]" value="true" <?php if ($customize_checkout_page_value['display_coupon'] == 'true') echo 'checked'; ?> > Yes
                                    <input type="radio" name="customize_checkout_page_value[display_coupon]" value="false" <?php if ($customize_checkout_page_value['display_coupon'] == 'false') echo 'checked'; ?>> No
                                </td>
                            </tr>
        <!--                            <tr valign="top">
                                <th scope="row">
                                    <label><?php //_e('Rename coupon button', 'woocommerce-shop-customizer');    ?></label>
                                </th> 
                                <td>
                                    <input type="text" name="customize_checkout_page_value[rename_coupon_name]" value="<?php //if (strlen($customize_checkout_page_value['rename_coupon_name']) > 0) echo $customize_checkout_page_value['rename_coupon_name'];    ?>" style="min-width: 300px;">
                                </td>
                            </tr>-->
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Must be logged in text', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_checkout_page_value[checkout_must_be_logged_in_message]" value="<?php echo $checkout_must_be_logged_in_message; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Coupon text', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_checkout_page_value[checkout_coupon_message]" value="<?php echo $checkout_coupon_message; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Login text', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_checkout_page_value[checkout_login_message]" value="<?php echo $checkout_login_message; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>                            
                        </table>
                        <h3><?php _e('Misc', 'woocommerce-shop-customizer'); ?></h3>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Create Account checkbox default', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <select name="customize_checkout_page_value[create_account_default_checked]" style="min-width: 300px;">
                                    <?php foreach ($create_account_default_checked as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>" <?php if ($value == $create_account_default_checked_value) echo "selected='selected'"; ?>><?php echo $key; ?></option>
                                    <?php } ?>                                
                                </select>
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Submit Order button', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_checkout_page_value[order_button_text]" value="<?php echo $order_button_text; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form> 
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
            <div class="accordion-section">
                <a class="accordion-section-title" href="#accordion-24"><?php _e('Customize tax or vat lable ', 'woocommerce-shop-customizer'); ?></a>
                <div id="accordion-24" class="accordion-section-content">

                    <form method="post" action="options.php" >
                        <?php
                        settings_fields('customize_tax_lable_register');
                        $customize_tax_lable_value = get_option('customize_tax_lable_value');
                        $countries_tax_or_vat = "";
                        $countries_including_tax_or_vat = "";
                        $countries_excluding_tax_or_vat = "";
                        if (isset($customize_tax_lable_value['countries_tax_or_vat']) && strlen($customize_tax_lable_value['countries_tax_or_vat']) > 0) {
                            $countries_tax_or_vat = $customize_tax_lable_value['countries_tax_or_vat'];
                        }
                        if (isset($customize_tax_lable_value['countries_including_tax_or_vat']) && strlen($customize_tax_lable_value['countries_including_tax_or_vat']) > 0) {
                            $countries_including_tax_or_vat = $customize_tax_lable_value['countries_including_tax_or_vat'];
                        }
                        if (isset($customize_tax_lable_value['countries_excluding_tax_or_vat']) && strlen($customize_tax_lable_value['countries_excluding_tax_or_vat']) > 0) {
                            $countries_excluding_tax_or_vat = $customize_tax_lable_value['countries_excluding_tax_or_vat'];
                        }
                        ?>
                        <table class="form-table">
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Tax Label', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_tax_lable_value[countries_tax_or_vat]" value="<?php echo $countries_tax_or_vat; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Including Tax Label', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_tax_lable_value[countries_including_tax_or_vat]" value="<?php echo $countries_including_tax_or_vat; ?> " style="min-width: 300px;"/> 
                            </td>
                            </tr>
                            <tr  valign="top">
                                <th scope="row"><lable><?php _e('Excluding Tax Label', 'woocommerce-shop-customizer'); ?></lable></th>
                            <td>
                                <input type="text" name="customize_tax_lable_value[countries_excluding_tax_or_vat]" value="<?php echo $countries_excluding_tax_or_vat; ?> " style="min-width: 300px;"/>  
                            </td>
                            </tr>                            
                        </table>                        
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Save Changes', 'woocommerce-shop-customizer'); ?>" />
                        </p>
                    </form> 
                </div><!--end .accordion-section-content-->
            </div><!--end .accordion-section-->
        </div><!--end .accordion-->
        <?php
    }

    /*
     * @since    1.0.0
     * Register Option Table add option table data
     */

    public function register_myoptions() {
        register_setting('myoption-group', 'number_of_grid_display');
        register_setting('defualt_cart_value_add', 'defualt_cart_value');
        register_setting('checkbox_check_remove_product_tab', 'checkbox_check_remove_tab');
        register_setting('select_priority_in_dropdown_list', 'select_priority_in_dropdown');
        register_setting('remove_selected_category_register', 'remove_selected_category_value');
        register_setting('do_not_show_category_on_the_shop_page_register', 'do_not_show_category_on_the_shop_page');
        register_setting('check_box_tital_text_chekout_page_register', 'check_box_tital_text_chekout_page');
        register_setting('defualt_set_code_country_and_state_register', 'defualt_set_code_country_and_state');
        register_setting('ragister_login_additing_message_register', 'ragister_login_additing_message');
        register_setting('change_breadcum_in_home_register', 'change_breadcum_in_home');
        register_setting('remove_woocommerce_pagination_register', 'remove_woocommerce_pagination');
        register_setting('serach_value_post_type_register', 'serach_value_post_type');
        register_setting('mfwp_display_category_image_on_category_archive_name', 'mfwp_display_category_image_on_category_archive_value');
        register_setting('mfwp_hide_shipping_method_name', 'mfwp_hide_shipping_method_value');
        register_setting('mfwp_sort_shop_page_name', 'mfwp_sort_shop_page_value');
        register_setting('mfwp_edit_out_of_text_name', 'mfwp_edit_out_of_text_value');
        register_setting('mfwp_product_gallery_thumbnails_per_row_name', 'mfwp_product_gallery_thumbnails_per_row_value');
        register_setting('mfwp_customise_url_direct_customer_add_to_cart_value_name', 'mfwp_customise_url_direct_customer_add_to_cart_value');
        register_setting('mfwp_unhook_wooCommerce_emails_name', 'mfwp_unhook_wooCommerce_emails_value');
        register_setting('mfwp_add_custome_field_order_email_name', 'mfwp_add_custome_field_order_email_value');
        register_setting('currency_name_symbol_register', 'currency_name_symbol');
        register_setting('customize_shop_loop_page_register', 'customize_shop_loop_page_value');
        register_setting('customize_checkout_page_register', 'customize_checkout_page_value');
        register_setting('customize_tax_lable_register', 'customize_tax_lable_value');
    }

    /*
     * @since    1.0.0
     * Store column count for displaying the grid
     */

    public function loop_shop_columns_own($var) {
        $no_row = get_option('number_of_grid_display');
        if (isset($no_row ['number_of_grid'])) {
            return $no_row ['number_of_grid'];
        }
        return $var;
    }

    /*
     * @since    1.0.0
     * Automatic add product in cart on visit
     */

    public function add_product_to_cart() {
        $remove_product_id_arr = get_transient('is_product_id_removed');
        $row_product_id = get_option('defualt_cart_value');
        if (isset($row_product_id['defualt_cart_item'])) {
            $product_id = $row_product_id['defualt_cart_item'];
            if ($remove_product_id_arr != $product_id || $remove_product_id_arr == false) {
                if (!is_admin()) {
                    $found = false;
                    if (sizeof(WC()->cart->get_cart()) > 0) {
                        foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                            $_product = $values['data'];
                            if ($_product->id == $product_id)
                                $found = true;
                        }
                        if (!$found)
                            WC()->cart->add_to_cart($product_id);
                    } else {
                        WC()->cart->add_to_cart($product_id);
                    }
                }
            }
        }
    }

    /*
     * Set transient remove product from cart
     */

    public function set_transient_remove_product_from_cart($cart_item_key) {
        global $woocommerce;
        $row_product_id = get_option('defualt_cart_value');
        $product_id = $row_product_id['defualt_cart_item'];
        foreach ($woocommerce->cart->removed_cart_contents as $cart_item_key_loop => $cart_item) {
            if ($cart_item_key_loop == $cart_item_key) {
                if ($cart_item['product_id'] == $product_id) {
                    set_transient('is_product_id_removed', $product_id, 12 * HOUR_IN_SECONDS);
                    return false;
                }
            }
        }
    }

    /*
     * @since    1.0.0
     * Remove Product tab in single page product desplay
     */

    public function woo_remove_product_tabs($tabs) {
        $row_value = get_option('checkbox_check_remove_tab');
        if (is_array($row_value)) {
            foreach ($row_value as $key => $value) {
                unset($tabs[$value]); // Remove the tab
            }
        }
        return $tabs;
    }

    /*
     * @since    1.0.0
     * Want to re-order the product tabs
     */

    public function woo_reorder_tabs($tabs) {
        $row_value = get_option('select_priority_in_dropdown');
        if (is_array($row_value)) {
            foreach ($tabs as $tab_key => $tab_value) {
                foreach ($row_value as $key => $value) {
                    if ($key == $tab_key) {
                        $tabs[$key]['priority'] = $value;
                    }
                }
            }
        }
        return $tabs;
    }

    /*
     * @since    1.0.0
     * Rename Single Product Tab
     */

    public function woo_rename_tab($tabs) {
        $row_value = get_option('select_priority_in_dropdown');
        if (is_array($row_value)) {
            foreach ($tabs as $tab_key => $tab_value) {
                $title = $tab_value['title'];
                preg_match('/[^\s]+/', $title, $matches);
                $title = strtolower('rename_' . $matches[0]);
                foreach ($row_value as $key => $value) {
                    if ($title == $key && strlen($value) > 0) {
                        $tabs['reviews']['title'] = $value;
                    }
                }
            }
        }
        return $tabs;
    }

    /*
     * @since    1.0.0
     * Personalise a product tab Custom Description Tab
     */

    public function woo_custom_description_tab($tabs) {
        $row_value = get_option('select_priority_in_dropdown');
        if (is_array($row_value)) {
            $custom_title = $row_value['custom_title_tab'];
            $custom_description = $row_value['custom_descriptiom_tab'];
            if (strlen($custom_title) > 0 || strlen($custom_description) > 0) {
                $tabs['description']['callback'] = array($this, 'woo_custom_description_tab_content'); // Custom description callback
                return $tabs;
            }
        }
        return $tabs;
    }

    /*
     * @since    1.0.0
     */

    public function woo_custom_description_tab_content($custom_title, $custom_description) {
        $row_value = get_option('select_priority_in_dropdown');
        $custom_title = $row_value['custom_title_tab'];
        $custom_description = $row_value['custom_descriptiom_tab'];
        echo '<h2>' . $custom_title . '</h2>';
        echo '<p>' . $custom_description . '</p>';
    }

    /*
     * @since    1.0.0
     * Adding category, excerpt, and SKU to shop page 
     */

    public function prima_custom_shop_item() {
        global $post, $product;
        $row_value = get_option('number_of_grid_display');
        if (isset($row_value['under_image_desription'])) {
            $row = $row_value['under_image_desription'];
            if ($row == '1') {
                $size = sizeof(get_the_terms($post->ID, 'product_cat'));
                echo $product->get_categories(', ', '<p>' . _n('Category:', 'Categories:', $size, 'woocommerce') . ' ', '.</p>');
                if ($post->post_excerpt) {
                    echo apply_filters('woocommerce_short_description', $post->post_excerpt);
                }
                echo '<p>SKU: ' . $product->get_sku() . '</p>';
            }
        }
    }

    /*
     * @since    1.0.0
     * Remove product content based on the category
     */

    public function remove_product_content() {
        $row_value = get_option('remove_selected_category_value');
        if (is_array($row_value)) {
            foreach ($row_value as $key => $value) {
                if (is_product() && has_term($value, 'product_cat')) {
                    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
                }
            }
        }
    }

    /*
     * @since    1.0.0
     * Don’t want products from a particular category to show on the shop page
     */

    public function custom_pre_get_posts_query($q) {
        $row_value = get_option('do_not_show_category_on_the_shop_page');
        if (!$q->is_main_query())
            return;
        if (!$q->is_post_type_archive())
            return;
        if (!is_admin()) {
            $q->set('tax_query', array(array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $row_value,
                    'operator' => 'NOT IN'
            )));
        }
        remove_action('pre_get_posts', 'custom_pre_get_posts_query');
    }

    /**
     * @since    1.0.0
     * Add checkbox field to the checkout
     * */
    public function my_custom_checkout_field($checkout) {
        global $display_terms_condition;
        $display_terms_condition = 'no';
        $row_option_value = get_option('check_box_tital_text_chekout_page');
        if (isset($row_option_value['radio_button_check_display'])) {
            $display_terms_condition = $row_option_value['radio_button_check_display'];
            if ($display_terms_condition == '1') {
                $tital = $row_option_value['check_box_tital_display'];
                $text = $row_option_value['check_box_text_display'];
                echo '<div id="my-new-field"><h3>' . __($tital) . '</h3>';
                woocommerce_form_field('my_checkbox', array(
                    'type' => 'checkbox',
                    'class' => array('input-checkbox'),
                    'label' => __($text),
                    'required' => true,
                        ), $checkout->get_value('my_checkbox'));
                echo '</div>';
            }
        }
    }

    /**
     * @since    1.0.0
     * Process the checkout
     * */
    public function my_custom_checkout_field_process() {
        if ($display_terms_condition == '1') {
            global $woocommerce;
            if (!$_POST['my_checkbox'])
                $this->add_error(__('Please agree to my checkbox.'));
        }
    }

    /**
     * @since    1.0.0
     * Update the order meta with field value
     * */
    public function my_custom_checkout_field_update_order_meta($order_id) {
        if ($_POST['my_checkbox'])
            update_post_meta($order_id, 'My Checkbox', esc_attr($_POST['my_checkbox']));
    }

    /**
     * @since    1.0.0
     * Manipulate default state and countries
     */
    public function change_default_checkout_country() {
        $row_option_value = get_option('defualt_set_code_country_and_state');
        return $row_option_value['country']; // country code
    }

    /*
     * @since    1.0.0
     */

    public function change_default_checkout_state() {
        $row_option_value = get_option('defualt_set_code_country_and_state');
        return $row_option_value['state']; // state code
    }

    /**
     * @since    1.0.0
     * Customise ‘add to cart’ text on single product pages
     */
    public function woo_custom_cart_button_text($button_text) {
        $customize_shop_loop_page_value = get_option('select_priority_in_dropdown');
        if (is_array($customize_shop_loop_page_value)) {
            if (strlen($customize_shop_loop_page_value['single_product_add_to_cart_text']) > 0) {
                $button_text = $customize_shop_loop_page_value['single_product_add_to_cart_text'];
            }
        }
        return $button_text;
    }

    /**
     * @since    1.0.0
     * Change the ‘add to cart’ text on product archives
     */
    public function woo_custom_cart_button_text_archive($button_text, $product) {
        $customize_shop_loop_page_value = get_option('customize_shop_loop_page_value');
        if (is_array($customize_shop_loop_page_value)) {
            if (isset($customize_shop_loop_page_value['out_of_stock_product_add_to_cart_text']) && !$product->is_in_stock()) {
                return $customize_shop_loop_page_value['out_of_stock_product_add_to_cart_text'];
            }
            if (strlen($customize_shop_loop_page_value['simple_product_add_to_cart_text']) > 0 && $product->is_type('simple')) {
                return $customize_shop_loop_page_value['simple_product_add_to_cart_text'];
            } elseif (strlen($customize_shop_loop_page_value['variable_product_add_to_cart_text']) > 0 && $product->is_type('variable')) {
                return $customize_shop_loop_page_value['variable_product_add_to_cart_text'];
            } elseif (strlen($customize_shop_loop_page_value['grouped_product_add_to_cart_text']) > 0 && $product->is_type('grouped')) {
                return $customize_shop_loop_page_value['grouped_product_add_to_cart_text'];
            } elseif (isset($customize_shop_loop_page_value['external_product_add_to_cart_text']) && $product->is_type('external')) {
                return $customize_shop_loop_page_value['external_product_add_to_cart_text'];
            }
        }
        return __($button_text, 'woocommerce');
    }

    /**
     * @since    1.0.0
     * 
     */
    public function woo_loop_shop_per_page() {
        $customize_shop_loop_page_value = get_option('customize_shop_loop_page_value');
        if (isset($customize_shop_loop_page_value['product_columns_displayed_per_page'])) {
            return $customize_shop_loop_page_value['product_columns_displayed_per_page'];
        }
    }

    /**
     * @since    1.0.0
     * Alternatively, to rename it you simply change the text inside the single quotes to whatever you’d like the “Apply Coupon�? button to say when using this code:
     */
    public function woocommerce_rename_coupon_field_on_cart($translated_text, $text, $text_domain) {
        $row_option_value = get_option('customize_checkout_page_value');
        if (strlen($row_option_value['rename_coupon_name']) > 0) {
            $coupon_name = $row_option_value['rename_coupon_name'];
        }
        if (is_admin() || 'woocommerce' !== $text_domain) {
            return $translated_text;
        }
        if ('Apply Coupon' === $text) {
            $translated_text = $coupon_name;
        }
        return $translated_text;
    }

    /**
     * @since    1.0.0
     * Encourage people to register on your site by adding a message above the login/registration form
     */
    public function jk_login_message() {
        $row_option_value = get_option('ragister_login_additing_message');
        if (get_option('woocommerce_enable_myaccount_registration') == 'yes') {
            ?>
            <div class="woocommerce-info">
                <p><?php _e('Returning customers login. New users register for next time so you can:'); ?></p>
                <ul>
                    <?php
                    foreach ($row_option_value as $key => $value) {
                        if (isset($value) && !empty($value)) {
                            echo "<li>$value</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
    }

    /**
     * @since    1.0.0
     * Change the breadcrumb home text from 'Home' to 'Appartment'
     */
    public function jk_change_breadcrumb_home_text($defaults) {
        $row_option_value = get_option('change_breadcum_in_home');
        if (isset($row_option_value['breadcum_home_name']) && strlen($row_option_value['breadcum_home_name']) > 0) {
            $default = $row_option_value['breadcum_home_name'];
            $defaults['home'] = $default;
            return $defaults;
        }
        return $defaults;
    }

    /**
     * @since    1.0.0
     * Change the Home link to a different URL
     */
    public function woo_custom_breadrumb_home_url($breacum_url) {
        $row_option_value = get_option('change_breadcum_in_home');
        if (isset($row_option_value['breadcum_home_name_url']) && strlen($row_option_value['breadcum_home_name_url']) > 0) {
            $breacum_url = $row_option_value['breadcum_home_name_url'];
        }
        return $breacum_url;
    }

    /**
     * @since    1.0.0
     * Get rid of all the breadcrumbs
     */
    public function jk_remove_wc_breadcrumbs() {
        $row_option_value = get_option('change_breadcum_in_home');
        if (isset($row_option_value['rid_of_all_the_breadcrumbs'])) {
            if ($row_option_value['rid_of_all_the_breadcrumbs'] == "yes") {
                remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
            }
        }
    }

    /**
     * @since    1.0.0
     * Replace WooCommerce Default Pagination with WP-PageNavi Pagination
     */
    public function woocommerce_pagination() {
        $row_option_value = get_option('remove_woocommerce_pagination');
        if ($row_option_value['remove_pagination'] == "yes") {
            remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
            wp_pagenavi();
        }
    }

    /*
     * @since    1.0.0
     */

    public function searchfilter($query) {
        $row_option_value = get_option('serach_value_post_type');
        if (!is_array($row_option_value)) {
            $row_option_value = array('post');
        }
        if (!is_admin()) {
            if ($query->is_search && !is_admin()) {
                $query->set('post_type', $row_option_value);
            }
            return $query;
        }
    }

    /**
     * @since    1.0.0
     * Display category image on category archive
     */
    public function woocommerce_category_image() {
        $display_value = get_option('mfwp_display_category_image_on_category_archive_value');
        $displayvalue = $display_value['category_display_image_value'];
        if ($displayvalue == "yes") {
            if (is_product_category()) {
                global $wp_query;
                $cat = $wp_query->get_queried_object();
                $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                if ($image) {
                    echo '<img src="' . $image . '" alt="" />';
                }
            }
        }
    }

    /**
     * @since    1.0.0
     * Hide shipping rates when free shipping is available
     *
     * @param array $rates Array of rates found for the package
     * @param array $package The package array/object being shipped
     * @return array of modified rates
     */
    public function hide_shipping_when_free_is_available($rates, $package) {
        $shipping_value = get_option('mfwp_hide_shipping_method_value');
        if (isset($shipping_value['shipping_method']) && strlen($shipping_value['shipping_method']) > 0) {
            $displayvalue = $shipping_value['shipping_method'];
            if ($displayvalue == "yes") {
                if (isset($rates['free_shipping'])) {
                    unset($rates['flat_rate']);
                    $free_shipping = $rates['free_shipping'];
                    $rates = array();
                    $rates['free_shipping'] = $free_shipping;
                }
            }
        }
        return $rates;
    }

    /**
     * @since    1.0.0
     * This trick will allow you to order by price, date or title on your shop page
     */
    public function custom_default_catalog_orderby() {
        $sort_value = get_option('mfwp_sort_shop_page_value');
        if (isset($sort_value['sort_shop_page']) && strlen($sort_value['sort_shop_page']) > 0) {
            $displayvalue = $sort_value['sort_shop_page'];
            return $displayvalue; // Can also use title and price
        }
    }

    /**
     * @since    1.0.0
     * Edit the ‘out of stock’ with any text you prefer
     */
    public function availability_filter_function($availability) {
        $text_value = get_option('mfwp_edit_out_of_text_value');
        if (isset($text_value['edit_text_value']) && strlen($text_value['edit_text_value']) > 0) {
            $change_value = $text_value['edit_text_value'];
            $availability['availability'] = str_ireplace('Out of stock', $change_value, $availability['availability']);
        }
        return $availability;
    }

    /**
     * @since    1.0.0
     * Change the look of your product gallery by customising the number of thumbnails per row
     */
    public function product_gallery_thumb_cols($row) {
        $text_value = get_option('mfwp_product_gallery_thumbnails_per_row_value');
        if (is_array($text_value)) {
            $row_value = $text_value['thumbnails_per_row'];
            if (isset($row_value) && strlen($row_value) > 0) {
                return $row_value; // .last class applied to every 4th thumbnail
            }
        }
        return $row;
    }

    /**
     * @since    1.0.0
     * Customise a URL to direct customers to from ‘add to cart’
     */
    public function custom_add_to_cart_redirect($url) {
        $url_value = get_option('mfwp_customise_url_direct_customer_add_to_cart_value');
        if (is_array($url_value)) {
            $page_set = $url_value['customise_url'];
            if (strlen($page_set) > 0) {
                return get_permalink($page_set); // Replace with the url of your choosing
            }
        }
        return $url;
    }

    /**
     * @since    1.0.0
     * Hooks for sending emails during store events
     * */
    public function unhook_those_pesky_emails($email_class) {
        $unhook_email_value = get_option('mfwp_unhook_wooCommerce_emails_value');
        if (isset($unhook_email_value['unhook_email']) && strlen($unhook_email_value['unhook_email']) > 0) {
            $displayvalue = $unhook_email_value['unhook_email'];
            if ($displayvalue == "yes") {
                remove_action('woocommerce_low_stock_notification', array($email_class, 'low_stock'));
                remove_action('woocommerce_no_stock_notification', array($email_class, 'no_stock'));
                remove_action('woocommerce_product_on_backorder_notification', array($email_class, 'backorder'));
                remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_pending_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_failed_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_failed_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_failed_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
                remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
                remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
                remove_action('woocommerce_order_status_completed_notification', array($email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger'));
                remove_action('woocommerce_new_customer_note_notification', array($email_class->emails['WC_Email_Customer_Note'], 'trigger'));
            }
        }
    }

    /**
     * @since    1.0.0
     * Add the field to order emails
     * */
    public function my_woocommerce_email_order_meta_keys($keys) {
        $custome_field_order_email_value = get_option('mfwp_add_custome_field_order_email_value');
        if (is_array($custome_field_order_email_value)) {
            $order_email_custome_field_label = $custome_field_order_email_value['custome_label_order'];
            $order_email_custome_field_value = $custome_field_order_email_value['custome_value_order'];
            $keys[$order_email_custome_field_label] = $order_email_custome_field_value;
        }
        return $keys;
    }

    /**
     * @since    1.0.0
     * Want to customise the currency or symbol?
     */
    public function add_my_currency($currencies) {

        $row_option_value = get_option('currency_name_symbol');
        $currencies_name = '';
        $currencies_code = 'ABC';
        if (strlen($row_option_value['currency_name']) > 0) {
            $currencies_name = $row_option_value['currency_name'];
        }
        if (strlen($row_option_value['currency_code']) > 0) {
            $currencies_code = strtoupper($row_option_value['currency_code']);
        }
        $currencies[$currencies_code] = __($currencies_name, 'woocommerce');
        return $currencies;
    }

    /*
     * @since    1.0.0
     * Add currency symbol
     */

    public function add_my_currency_symbol($currency_symbol, $currency) {
        $row_option_value = get_option('currency_name_symbol');
        $currencies_symbol = '';
        $currencies_code = 'ABC';
        if (strlen($row_option_value['currency_symbol']) > 0) {
            $currencies_symbol = $row_option_value['currency_symbol'];
        }
        if (strlen($row_option_value['currency_code']) > 0) {
            $currencies_code = strtoupper($row_option_value['currency_code']);
        }
        switch ($currency) {
            case $currencies_code: $currency_symbol = $currencies_symbol;
                break;
        }
        return $currency_symbol;
    }

    /**
     * @since    1.0.0
     * Hide the coupon form on the cart or checkout page to encourage a steamlined order process
     */
    public function hide_coupon_field($enabled) {
        $row_option_value = get_option('customize_checkout_page_value');
        if ($row_option_value['display_coupon'] == 'false') {
            if (is_cart() || is_checkout()) {
                $enabled = false;
            }
        } else {
            if (is_cart() || is_checkout()) {
                $enabled = true;
            }
        }
        return $enabled;
    }

    /*
     * @since    1.0.0
     */

    public function woo_create_account_default_checked_checkout_page($text) {
        $customize_checkout_page_value = get_option('customize_checkout_page_value');
        if ('customizer_true' === $customize_checkout_page_value['create_account_default_checked'] || 'customizer_true' === $customize_checkout_page_value['create_account_default_checked']) {
            return 'customizer_true' === $customize_checkout_page_value['create_account_default_checked'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_order_button_text_checkout_page($text) {
        $customize_checkout_page_value = get_option('customize_checkout_page_value');
        if (strlen(trim($customize_checkout_page_value['order_button_text'])) > 0 && isset($customize_checkout_page_value['order_button_text'])) {
            return $customize_checkout_page_value['order_button_text'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_checkout_must_be_logged_in_message_checkout_page($text) {
        $customize_checkout_page_value = get_option('customize_checkout_page_value');
        if (strlen(trim($customize_checkout_page_value['checkout_must_be_logged_in_message'])) > 0 && isset($customize_checkout_page_value['checkout_must_be_logged_in_message'])) {
            return $customize_checkout_page_value['checkout_must_be_logged_in_message'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_checkout_coupon_message_checkout_page($text) {
        $customize_checkout_page_value = get_option('customize_checkout_page_value');
        if (strlen(trim($customize_checkout_page_value['checkout_coupon_message'])) > 0 && isset($customize_checkout_page_value['checkout_coupon_message'])) {
            return $customize_checkout_page_value['checkout_coupon_message'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_checkout_login_message_checkout_page($text) {
        $customize_checkout_page_value = get_option('customize_checkout_page_value');
        if (strlen(trim($customize_checkout_page_value['checkout_login_message'])) > 0 && isset($customize_checkout_page_value['checkout_login_message'])) {
            return $customize_checkout_page_value['checkout_login_message'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_countries_tax_or_vat($text) {
        $customize_tax_lable_value = get_option('customize_tax_lable_value');
        if (strlen(trim($customize_tax_lable_value['countries_tax_or_vat'])) > 0 && isset($customize_tax_lable_value['countries_tax_or_vat'])) {
            return $customize_tax_lable_value['countries_tax_or_vat'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_countries_inc_tax_or_vat($text) {
        $customize_tax_lable_value = get_option('customize_tax_lable_value');
        if (strlen(trim($customize_tax_lable_value['countries_including_tax_or_vat'])) > 0 && isset($customize_tax_lable_value['countries_including_tax_or_vat'])) {
            return $customize_tax_lable_value['countries_including_tax_or_vat'];
        }
        return $text;
    }

    /*
     * @since    1.0.0
     */

    public function woo_countries_ex_tax_or_vat($text) {
        $customize_tax_lable_value = get_option('customize_tax_lable_value');
        if (strlen(trim($customize_tax_lable_value['countries_excluding_tax_or_vat'])) > 0 && isset($customize_tax_lable_value['countries_excluding_tax_or_vat'])) {
            return $customize_tax_lable_value['countries_excluding_tax_or_vat'];
        }
        return $text;
    }

}