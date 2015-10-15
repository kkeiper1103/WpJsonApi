<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/15/2015
 * Time: 3:54 PM
 */

namespace WpJsonApi;


class Message
{
    private $type;
    private $message;

    const NOTICE = "update-nag";
    const UPDATED = "updated";
    const ERROR = "error";
    /**
     * @var bool
     */
    private $dismissable;

    /**
     * @param $type
     * @param $message
     * @param bool $dismissable
     */
    public function __construct( $type, $message, $dismissable = false ) {

        $this->type = $type;
        $this->message = $message;
        $this->dismissable = $dismissable;
    }

    /**
     * @return string
     */
    protected function getClasses() {
        $classes = ["notice"];

        $classes[] = $this->type;

        if( $this->dismissable === true )
            $classes[] = "is-dismissable";

        return implode(" ", $classes);
    }

    /**
     *
     */
    public function __toString() {
        ob_start(); ?>
        <div class="<?= $this->getClasses() ?>">
            <p><?= $this->message ?></p>
        </div>
        <?php return ob_get_clean();
    }
}