<?php

include('credential_check.php');

$validator = new CredentialValidator();

if(!$validator->validAll()) {
    
    include_once(__DIR__ . '/../alertUtils.php');
    $alertUtils = new AlertUtils();

    $alertUtils->showAlertPage('You credential is not valid.', 'Please login again.');
    $alertUtils->renderRedirectScript(1000, '../../../../auth/login.php');

    exit;
}