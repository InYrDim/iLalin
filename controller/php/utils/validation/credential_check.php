<?php

class CredentialValidator {
    
    private static $messages;
    private static $isSuccessful;
    private static $invalidValidators = [];
    private static $validValidators = [];
    
    /**
     * Returns the validation messages
     * 
     * @return array
     */
    public static function getMessages() {
        return self::$messages;
    }

    /**
     * Returns whether the validation was successful
     * 
     * @return boolean
     */
    public static function isSuccessful() {
        return self::$isSuccessful;
    }
    
    /**
     * Returns the list of invalid validators
     * 
     * @return array
     */
    public static function getInvalidValidators() {
        return self::$invalidValidators;
    }
    
    /**
     * Returns the list of valid validators
     * 
     * @return array
     */
    public static function getValidValidators() {
        return self::$validValidators;
    }
    
    /**
     * Checks if the user is logged in
     * 
     * @return boolean
     */
    public static function isLoggedIn() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            self::$messages = 'not logged in';
            self::$isSuccessful = false;
            self::$invalidValidators[] = 'isLoggedIn';
            return false;
        }
        self::$messages = 'logged in';
        self::$isSuccessful = true;
        self::$validValidators[] = 'isLoggedIn';
        return true;
    }
    
    /**
     * Checks if the user has a valid email
     * 
     * @return boolean
     */
    public static function validEmail() {
        if (empty($_SESSION['email'])) {
            self::$messages = 'invalid email in session';
            self::$isSuccessful = false;
            self::$invalidValidators[] = 'validEmail';
            return false;
        }
        self::$messages = 'valid email in session';
        self::$isSuccessful = true;
        self::$validValidators[] = 'validEmail';
        return true;
    }
    
    /**
     * Checks all validations
     * 
     * @return boolean
     */
    public static function validAll() {
        self::$validValidators = []; // Reset valid validators
        return self::isLoggedIn() && self::validEmail();
    }
    
    /**
     * Example usage
     */
    public static function exampleUsage() {
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = 'john.doe@example.com';
        
        if (CredentialValidator::validAll()) {
            echo 'valid credentials';
        } else {
            echo 'invalid credentials';
            var_dump(CredentialValidator::getMessages());
            var_dump(CredentialValidator::getInvalidValidators());
            var_dump(CredentialValidator::getValidValidators());
        }
    }
}