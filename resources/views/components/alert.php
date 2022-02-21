<?php

use App\Utils\SessionFlash;

if (SessionFlash::isExist(ALERT_ERROR)) {
    $alert = SessionFlash::get(ALERT_ERROR);
    echo '<div class="alert alert-danger" role="alert">' . $alert['message'] . '</div>';
}

if (SessionFlash::isExist(ALERT_INFO)) {
    $alert = SessionFlash::get(ALERT_INFO);
    echo '<div class="alert alert-info" role="alert">' . $alert['message'] . '</div>';
}

if (SessionFlash::isExist(ALERT_WARNING)) {
    $alert = SessionFlash::get(ALERT_WARNING);
    echo '<div class="alert alert-warning" role="alert">' . $alert['message'] . '</div>';
}

if (SessionFlash::isExist(ALERT_SUCCESS)) {
    $alert = SessionFlash::get(ALERT_SUCCESS);
    echo '<div class="alert alert-success" role="alert">' . $alert['message'] . '</div>';
}
