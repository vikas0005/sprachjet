<?php

/*----------------------------
Social Link
----------------------------*/

 Kirki::add_section( 'edubin_social_link_section', array(
    'title'    =>  esc_html__( 'Social Links', 'edubin' ),
    'panel' =>  'edubin_general_panel'
) );

// enable disable social handle
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'toggle',
    'settings'    => 'enable_social_handle',
    'label'       => esc_html__( 'Enable Social Links?', 'edubin' ),
    'section'     => 'edubin_social_link_section',
    'default'     => false,
] );

// Header Page Title Align
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'radio-buttonset',
    'settings'    => 'social_alignment',
    'label'       => esc_html__( 'Alignment', 'edubin' ),
    'section'     => 'edubin_social_link_section',
    'default'     => 'alignright',
    'choices'     => [
        'alignleft'   => esc_html__( 'Left', 'edubin' ),
        'alignright'   => esc_html__( 'Right', 'edubin' ),
    ],
    'active_callback'   =>  [
        [
            'setting'   =>  'enable_social_handle',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
    ],
] );

// Enable Follow Us
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'toggle',
    'settings'    => 'follow_us_show',
    'label'       => esc_html__( 'Enable Follow Us?', 'edubin' ),
    'section'     => 'edubin_social_link_section',
    'default'     => '1',
    'active_callback'   =>  [
        [
            'setting'   =>  'enable_social_handle',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
    ],
] );

// Custom Follow Us Text
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'text',
    'label'       => esc_html__('Custom Follow Us Text', 'edubin'),
    'settings'    => 'follow_us_text',
    'section'     => 'edubin_social_link_section',
    'default'     => '',
    'active_callback'   =>  [
        [
            'setting'   =>  'enable_social_handle',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
        [
            'setting'   =>  'follow_us_show',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
    ],
] );

// Open in new browser tab
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'toggle',
    'settings'    => 'social_newtab',
    'label'       => esc_html__( 'Open in new browser tab?', 'edubin' ),
    'section'     => 'edubin_social_link_section',
    'default'     => '1',
    'active_callback'   =>  [
        [
            'setting'   =>  'enable_social_handle',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
    ],
] );

// Social links repeater
Kirki::add_field( 'edubin_theme_config', [
    'type'        => 'repeater',
    'label'       => esc_html__( 'Social Links', 'edubin' ),
    'section'     => 'edubin_social_link_section',
    'settings'     => 'edubin_social_links',
    'row_label' => [
        'type'  => 'text',
        'value' => esc_html__( 'Social Link', 'edubin' ),
    ],
    'button_label' => esc_html__('Add new social handle', 'edubin' ),
    'fields' => [
        'header_icon_icons' => [
            'type'        => 'select',
            'label'       => esc_html__( 'Select an Icon', 'edubin' ),
            'placeholder' => esc_html__( 'Select an icon...', 'edubin' ),
            'choices'     => [
                'flaticon-facebook' => esc_html__( 'Facebook', 'edubin' ),
                'flaticon-youtube-logotype' => esc_html__( 'Youtube', 'edubin' ),
                'flaticon-instagram-1' => esc_html__( 'Instagram', 'edubin' ),
                'flaticon-twitter' => esc_html__( 'Twitter', 'edubin' ),
                'flaticon-linkedin' => esc_html__( 'LinkedIn', 'edubin' ),
                'flaticon-behance-logo' => esc_html__( 'Behance', 'edubin' ),
                'flaticon-dribbble-logo' => esc_html__( 'Dribble', 'edubin' ),
                'flaticon-logo' => esc_html__( 'Google Plus', 'edubin' ),
                'flaticon-flickr-website-logo-silhouette' => esc_html__( 'Flickr', 'edubin' ),
                'flaticon-github-character' => esc_html__( 'GitHub', 'edubin' ),
                'flaticon-send' => esc_html__( 'Telegram', 'edubin' ),
                'flaticon-medium-size' => esc_html__( 'Medium', 'edubin' ),
                'flaticon-bitbucket-logo' => esc_html__( 'Bitbucket', 'edubin' ),
                'flaticon-pinterest' => esc_html__( 'Pinterest', 'edubin' ),
                'fa-slack' => esc_html__( 'Slack', 'edubin' ),
                'flaticon-snapchat' => esc_html__( 'Snapchat', 'edubin' ),
                'flaticon-soundclou' => esc_html__( 'Soundclou', 'edubin' ),
                'flaticon-overflowing-stacked-papers-tray' => esc_html__( 'StackOverflow', 'edubin' ),
                'flaticon-tumblr-logo' => esc_html__( 'Tumblr', 'edubin' ),
                'flaticon-vimeo-logo' => esc_html__( 'Vimeo', 'edubin' ),
                'flaticon-whatsapp' => esc_html__( 'Whatsapp', 'edubin' ),
                'flaticon-skype' => esc_html__( 'Skype', 'edubin' ),
                'flaticon-vk' => esc_html__( 'VK', 'edubin' ),
            ],
            'default'     => 'flaticon-facebook',
        ],
        'header_icons_color'  => [
            'type'        => 'color',
            'label'       => esc_html__( 'Icon Color', 'edubin' ),
            'default'     => '',
        ],
        'header_icon_title'  => [
            'type'        => 'text',
            'label'       => esc_html__( 'Title', 'edubin' ),
            'default'     => 'Facebook',
        ],
        'header_icon_link'  => [
            'type'        => 'link',
            'label'       => esc_html__( 'Social Link', 'edubin' ),
            'default'     => esc_url_raw( 'https://facebook.com' ),
        ],
    ],
    // 'choices'   => [
    //     'limit' => 4,
    // ],
    'active_callback'   =>  [
        [
            'setting'   =>  'enable_social_handle',
            'operator'  =>  '===',
            'value'     =>  true,
        ],
    ],
] );

