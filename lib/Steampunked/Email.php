<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 4/7/16
 * Time: 4:59 PM
 */

namespace Steampunked;


class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }

}