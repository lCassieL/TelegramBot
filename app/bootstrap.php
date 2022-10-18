<?php
include_once 'config.php';
include_once 'core/Controller.php';
include_once 'core/View.php';
include_once 'core/Model.php';
include_once 'core/Router.php';
include_once 'helpers/GenerateHeader.php';
session_start();
router::init();