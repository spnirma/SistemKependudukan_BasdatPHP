<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

function generateSearchQuery(array $searchArray = [])
{
    $searchArray = generateSearchArray($searchArray);

    // REMOVE LIMIT RESTRICTION
    // if (isset($searchArray['limit'])) {
    //     unset($searchArray['limit']);
    // }

    // Default limit
    if (!isset($searchArray['limit'])) {
        $searchArray['limit'] = 20;
    }

    return http_build_query($searchArray);
}

function generateSearchArray(array $searchArray = [])
{
    $defaultSearchArray = [
        'channel'  => null,
        'query'    => '',
        'category' => null,
        'price'    => null,
        'location' => null,
        'sort'     => 4,
        'page'     => 1,
        'limit'    => 20
    ];

    foreach ($defaultSearchArray as $key => $value) {
        if (isset($searchArray[$key])) {
            continue;
        } elseif (isset($_POST[$key])) {
            $searchArray[$key] = $_POST[$key];
        } elseif (isset($_GET[$key])) {
            $searchArray[$key] = $_GET[$key];
        } else {
            $searchArray[$key] = $value;
        }
    }

    foreach ($searchArray as $key => $value) {
        if (!array_key_exists($key, $defaultSearchArray)) {
            unset($searchArray[$key]);
        }
    }

    if (empty($searchArray['category']) && isset($_GET['cat'])) {
        $searchArray['category'] = $_GET['cat'];
    }

    // reset page on new search post
    if (isset($_POST['header_search'])) {
        $searchArray['page'] = 1;
    }

    return $searchArray;
}
