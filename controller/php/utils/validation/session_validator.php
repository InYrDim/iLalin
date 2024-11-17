<?php

include('credential_check.php');

$validator = new CredentialValidator();

if(!$validator->validAll()) {
    var_dump($validator->getValidValidators());
    exit;
}