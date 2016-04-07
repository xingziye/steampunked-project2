<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Steampunked\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('santor10@cse.msu.edu');
    $site->setRoot('/~santor10/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=santor10',
        'santor10',       // Database user
        '4772016',     // Database password
        'project2_');            // Table prefix
};