<?php

if (isset($_GET['rq'])){
    require_once "INC/request.inc.php";
    die(gereRequete($_GET['rq']));
}

require_once "INC/layout.html.inc.php";
