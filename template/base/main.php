<?php declare(strict_types=1);

use adRespect\Rules\RouterRules;
use adRespect\View\View;

$viewData = View::data();

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Zadanie | <?= $viewData['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= $viewData['url'] ?>">
    <meta name="description" content="Zadanie rekrutacyjne adRespect">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $viewData['url'] ?>public/style/style.css" type="text/css" media="all">

</head>

<body data-action="<?= $viewData['action'] ?>" data-content="<?= $viewData['content'] ?? '' ?>">

<section class="page-container">
    <nav class="base-nav">
        <ul data-page="nav_ul">
            <li class="<?= ($viewData['action'] === 'home' ? 'active_page' : '') ?>">
                <a rel="home start" href="<?= RouterRules::viewLink('page', 'home') ?>"><i class="fa-solid fa-calculator"></i></a>
            </li>
            <li class="<?= ($viewData['action'] === 'updateCurses' ? 'active_page' : '') ?>">
                <a rel="list section" href="<?= RouterRules::viewLink('page', 'updateCurses') ?>"><i class="fa-solid fa-download"></i></a>
            </li>
        </ul>
    </nav>


