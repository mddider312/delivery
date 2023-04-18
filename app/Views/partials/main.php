<!doctype html>
<html lang="<?php
    $session = \Config\Services::session();
    $lang = $session->get('lang');
    echo $lang;
?>">