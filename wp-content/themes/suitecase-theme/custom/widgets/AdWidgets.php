<?php

if (!defined('ABSPATH')) {
    exit;
}

class AdWidgets
{
    public const MPU = 'mpu';
    public const DOUBLE_MPU = 'double_mpu';
    public const LEADERBOARD = 'leaderboard';
    public const BILLBOARD = 'billboard';

    private const NAME = 'name';
    private const ID = 'id';
    private const FORMAT = 'format';
    private const SIZE = 'size';
    private const WIDTH = 'width';
    private const HEIGHT = 'height';
    private const HTML_CLASS = 'class';

    private const WIDGETS = [
        self::MPU => [
            self::NAME => 'MPU',
            self::ID => 'ad_mpu_300_250',
            self::HTML_CLASS => 'mpu size_300_250',
            self::FORMAT => 'mpu',
            self::SIZE => [
                self::WIDTH => 300,
                self::HEIGHT => 250,
            ],
        ],
        self::DOUBLE_MPU => [
            self::NAME => 'Double MPU',
            self::ID => 'ad_double_mpu_300_600',
            self::HTML_CLASS => 'double_mpu size_300_600',
            self::FORMAT => 'double_mpu',
            self::SIZE => [
                self::WIDTH => 300,
                self::HEIGHT => 600,
            ],
        ],
        self::LEADERBOARD => [
            self::NAME => 'Leaderboard',
            self::ID => 'ad_leaderboard_728_90',
            self::HTML_CLASS => 'leaderboard size_728_90',
            self::FORMAT => 'leaderboard',
            self::SIZE => [
                self::WIDTH => 728,
                self::HEIGHT => 90,
            ],
        ],
        self::BILLBOARD => [
            self::NAME => 'Billboard',
            self::ID => 'ad_billboard_970_250',
            self::HTML_CLASS => 'billboard size_970_250',
            self::FORMAT => 'billboard',
            self::SIZE => [
                self::WIDTH => 970,
                self::HEIGHT => 250,
            ],
        ]
    ];

    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {
        add_action('widgets_init', [$this, 'registerWidgets']);
        add_shortcode('ad', [$this, 'addShortcode']);
    }

    public function registerWidgets(): void
    {
        foreach (self::WIDGETS as $adName => $widget) {
            register_sidebar([
                'id' => $widget[self::ID],
                'name' => sprintf(
                    'Advertising area - %1$s - [ad type="%2$s"]',
                    $widget[self::NAME],
                    $widget[self::FORMAT]
                ),
                'description' => sprintf('Shortcode: [ad type="%1$s"]', $widget[self::FORMAT]),
                'class' => $widget[self::HTML_CLASS],
                'before_widget' => '<div class="ad ' . $widget[self::HTML_CLASS] . ' %2$s">',
                'after_widget' => '</div>',
                'before_title' => '',
                'after_title' => '',
                'before_sidebar' => '',
                'after_sidebar' => '',
            ]);
        }
    }

    public static function getWidgetDataByName(string $widgetName): array
    {
        return self::WIDGETS[$widgetName] ?? [
            self::NAME => 'unknown',
            self::ID => 'unknown',
            self::FORMAT => 'unknown',
            self::SIZE => [
                self::WIDTH => 0,
                self::HEIGHT => 0,
            ],
        ];
    }

    public static function getWidgetIdByName(string $widgetName): string
    {
        return self::getWidgetDataByName($widgetName)[self::ID];
    }

    public function addShortcode(array $atts): string
    {
        extract(shortcode_atts(['type' => FALSE, ], $atts));
        $type = esc_html($type);
        ob_start();
        dynamic_sidebar(self::getWidgetIdByName(strtolower($type)));

        return ob_get_clean();
    }
}