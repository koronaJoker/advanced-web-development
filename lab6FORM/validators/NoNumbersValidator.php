<?php
require_once 'ValidatorInterface.php';

class NoNumbersValidator implements ValidatorInterface {
    private $error = '';
    private $fieldName;

    public function __construct($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function validate($value): bool {
        if (preg_match('/\d/', $value)) {
            $this->error = "{$this->fieldName} must not contain numbers";
            return false;
        }
        return true;
    }

    public function getError(): string {
        return $this->error;
    }
}