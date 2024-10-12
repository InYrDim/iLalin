<?php

class FormValidator {
    private $data;
    private $requiredFields = [];
    public function __construct($postData) {
        $this->data = $postData;

    }

    public function validate() {
        // Common validation rules
        $this->validateRequiredFields();
        $this->validateEmailFormat();

        // Add more validation methods as needed
    }

    private function validateRequiredFields() {
        // Check if required fields are present
        foreach ($this->requiredFields as $field) {
            if (empty($this->data[$field])) {
                throw new Exception("{$field} is required.");
            }
        }
    }

    private function validateEmailFormat() {
        // Check if email field is in a valid format
        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
    }

    
}



?>