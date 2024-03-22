<?php
namespace CloudsGoodsApp\Widget;

use eftec\bladeone;

class CloudsGoodsWidgetClass extends \WP_Widget
{
    protected $blade = null;
    protected $db = null;

    protected function getApiKey()
    {
        $result = $this->db->get_row( "SELECT * FROM {$this->table} where optionid = 'api_key'");
        if ($result){
            $data = json_decode($result->data);
            $this->apiKey = $data->token ?? null;
        }

    }

    public function __construct()
    {
        parent::__construct(
            'cgsrv_custom_widget',
            __( 'CloudsGoods Widget', 'text_domain' ),
            [
                'panels_icon'   => 'dashicons dashicons-wordpress',
                'customize_selective_refresh' => true,
            ]
        );
        global $wpdb;
        global $baseDir;
        $views = $baseDir.'/views';
        $compiled = $baseDir.'/compiled';
        $this->blade=new bladeone\BladeOne($views,$compiled);
        $this->db = $wpdb;
        $this->table = $this->db->prefix.'cloudsgoods_data';
        $this->getApiKey();
        add_action('vc_before_init', [&$this, 'cgRegisterWidget']);
        add_shortcode('cg_shortcode_widget',[&$this, 'cgAddWidget']);
    }

    public function cgAddWidget($params){
        if (!is_array($params)){
            $data = [];
        } else {
            $data = $params;
        }
        $link = $data['cg_widget_link'] ?? null;
        //$data['cg_widget_bg'] = $this->getIntegratedBackgroung($link);
        if (($data['cg_widget_bg'] ?? null) && $data['cg_widget_bg'] > 0){
            $img = wp_get_attachment_image_src($data['cg_widget_bg']);
            if (is_array($img)){
                $data['cg_widget_bg'] = $img[0];
            }
        }

        echo $this->blade->run("widget/display.blade.php", $data);
    }

    public function cgRegisterWidget(){
        vc_map(
            [
                'name' => __('CloudsGoods', 'cg_widget_id'),
                'base' => 'cg_shortcode_widget',
                'description' => __('CloudsGoods Branded Games', 'cg_widget_id'),
                'category' =>__('CloudsGoods', 'cg_widget_id'),
                'params'=>[
                    [
                        'type'   => 'dropdown',
                        'holder' => 'div',
                        'heading'=> esc_html__('Choose the format of how to open the game on the site', 'cg_widget_id'),
                        'param_name' => 'cg_widget_target',
                        'value'      => [
                            'Display the game in a banner'  => 0,
                            'Display the game immediately.' => 1,
                        ],
                        'std'   => 'Display the game in a banner',
                        'description'=> esc_html__('', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'textfield',
                        'holder' => 'div',
                        'heading'=> esc_html__('Game URL', 'cg_widget_id'),
                        'param_name' => 'cg_widget_link',
                        'value'      => '',
                        'description'=> esc_html__('', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'attach_image',
                        'holder' => 'div',
                        'heading'=> esc_html__('Banner background', 'cg_widget_id'),
                        'param_name' => 'cg_widget_bg',
                        'value'      => '',
                        'description'=> esc_html__('Select banner background', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'dropdown',
                        'holder' => 'div',
                        'heading'=> esc_html__('How to open the game when clicking on the banner?', 'cg_widget_id'),
                        'param_name' => 'cg_widget_display',
                        'value'      => [
                            'Display game in a new page'    => 0,
                            'Display game in a popup'       => 1,
                            'Use banner area'               => 2,
                        ],
                        'std'   => 'Display game in a new page',
                        'description'=> esc_html__('', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'textfield',
                        'holder' => 'div',
                        'heading'=> esc_html__('Width', 'cg_widget_id'),
                        'param_name' => 'cg_widget_width',
                        'value'      => '200',
                        'description'=> esc_html__('', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'textfield',
                        'holder' => 'div',
                        'heading'=> esc_html__('Height', 'cg_widget_id'),
                        'param_name' => 'cg_widget_height',
                        'value'      => '200',
                        'description'=> esc_html__('', 'cg_widget_id'),
                    ],
                    [
                        'type'   => 'textfield',
                        'holder' => 'div',
                        'heading'=> esc_html__('Enter the text that we will display along with the game. For example, “Play and get a prize with a 30% discount”', 'cg_widget_id'),
                        'param_name' => 'cg_widget_desc',
                        'value'      => '',
                        'description'=> esc_html__('maximum 60 characters', 'cg_widget_id'),
                    ],
              ],

            ]
        );
    }


    // The widget form (for the backend)
    public function form( $instance) {
        $params = [
            'cg_widget_link'    => [
                'id'    => $this->get_field_id( 'cg_widget_link' ),
                'name'  => $this->get_field_name( 'cg_widget_link' ),
                'value' => $instance['cg_widget_link'] ?? '',
            ],
            'cg_widget_display'    => [
                'id'    => $this->get_field_id( 'cg_widget_display' ),
                'name'  => $this->get_field_name( 'cg_widget_display' ),
                'value' => $instance['cg_widget_display'] ?? 0,
            ],
            'cg_widget_bg'    => [
                'id'    => $this->get_field_id( 'cg_widget_bg' ),
                'name'  => $this->get_field_name( 'cg_widget_bg' ),
                'value' => $instance['cg_widget_bg'] ?? '',
            ],
            'cg_widget_format'    => [
                'id'    => $this->get_field_id( 'cg_widget_format' ),
                'name'  => $this->get_field_name( 'cg_widget_format' ),
                'value' => $instance['cg_widget_format'] ?? 0,
            ],
            'cg_widget_width'    => [
                'id'    => $this->get_field_id( 'cg_widget_width' ),
                'name'  => $this->get_field_name( 'cg_widget_width' ),
                'value' => $instance['cg_widget_width'] ?? 200,
            ],
            'cg_widget_height'    => [
                'id'    => $this->get_field_id( 'cg_widget_height' ),
                'name'  => $this->get_field_name( 'cg_widget_height' ),
                'value' => $instance['cg_widget_height'] ?? 200,
            ],
            'cg_widget_desc'    => [
                'id'    => $this->get_field_id( 'cg_widget_desc' ),
                'name'  => $this->get_field_name( 'cg_widget_desc' ),
                'value' => $instance['cg_widget_desc'] ?? '',
            ],
        ];

        echo $this->blade->run("widget/form.blade.php", $params);
    }

    // Update widget settings
    public function update( $new_instance, $old_instance) {
        $instance = $old_instance;
        if ($new_instance['cg_widget_link'] ?? null){
            $instance['cg_widget_link'] = $new_instance['cg_widget_link'];
        }
        if ($new_instance['cg_widget_display']){
            $instance['cg_widget_display'] = $new_instance['cg_widget_display'];
        }
        if ($new_instance['cg_widget_bg']){
            $instance['cg_widget_bg'] = $new_instance['cg_widget_bg'];
        }
        if ($new_instance['cg_widget_format']){
            $instance['cg_widget_format'] = $new_instance['cg_widget_format'];
        }
        if ($new_instance['cg_widget_width']){
            $instance['cg_widget_width'] = $new_instance['cg_widget_width'];
        }
        if ($new_instance['cg_widget_height']){
            $instance['cg_widget_height'] = $new_instance['cg_widget_height'];
        }
        if ($new_instance['cg_widget_desc'] ?? null){
            $instance['cg_widget_desc'] = $new_instance['cg_widget_desc'];
        }

        return $instance;
    }
    /*
    protected function getIntegratedBackgroung($link)
    {
        if ($link){
            if (($i = strpos($link, '/game/'))){
                $id = substr($link, $i+6);
                return "https://cloudsgoods.com/storage/images/games_stocks/{$id}/landing_photo_desktop_group/0/0_img_0_0.jpg";
            }
        }

        return null;
    }
*/
    // Display the widget
    public function widget( $args, $instance) {
        $instance['before_title'] = $args['before_widget'];
        $instance['after_title'] = $args['after_title'];
        echo $args['before_widget'];
        echo $this->blade->run("widget/display.blade.php", $instance);
        echo $args['after_widget'];
    }

}
