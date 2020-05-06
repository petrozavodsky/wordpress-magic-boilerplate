<?php

namespace WordpressMagicBoilerplate\Widgets;

use WordpressMagicBoilerplate;
use WP_Widget;

class MagicWidget extends WP_Widget
{

    private $suffix = " - MagicWidget";

    function __construct()
    {

        $className = get_called_class();
        $className = str_replace("\\", '-', $className);
        parent::__construct(
            $className,
            __("My widget ", 'WordpressMagicBoilerplate') . $this->suffix,
            [
                'description' => __("My widget", 'WordpressMagicBoilerplate') . $this->suffix
            ]
        );
    }

    public function widget($args, $instance)
    {

        echo(isset($args['before_widget']) ? $args['before_widget'] : ''); ?>
        <div>
            <h1>Magic</h1>
        </div>
        <?php
        echo(isset($args['after_widget']) ? $args['after_widget'] : '');
    }


    public function form($instance)
    {
        echo '<p class="no-options-widget">' . __('There are no options for this widget.', 'WordpressMagicBoilerplate') . '</p>';

        return 'noform';
    }

    public function update($newInstance, $oldInstance)
    {
        return $newInstance;
    }

}
