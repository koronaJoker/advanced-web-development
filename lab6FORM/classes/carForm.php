<?php
require_once __DIR__ . '/../validators/RequiredValidator.php';
require_once __DIR__ . '/../validators/NoNumbersValidator.php';

class CarForm {
    private $data = [];
    private $errors = [];
    private $validators = [];

    public function __construct($postData) {
        $this->data = $postData;
        $this->setupValidators();
    }

    private function setupValidators() {
        $this->validators = [
            'car-model' => [new RequiredValidator("Model"), new NoNumbersValidator("Model")],
            'car-brand' => [new RequiredValidator("Brand")],
            'car-data' => [new RequiredValidator("Release Date")],
            'car-color' => [new RequiredValidator("Color")],
            'car-fuel' => [new RequiredValidator("Fuel")],
            'car-description' => [new RequiredValidator("Description")]
        ];
    }

    public function validate(): bool {
        $valid = true;

        foreach ($this->validators as $field => $validators) {
            foreach ($validators as $validator) {
                if (!$validator->validate($this->data[$field] ?? '')) {
                    $this->errors[$field] = $validator->getError();
                    $valid = false;
                    break;
                }
            }
        }

        return $valid;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function save($filename = __DIR__ . '/../storage/data.json') {
        $existing = [];

        if (file_exists($filename)) {
            $existing = json_decode(file_get_contents($filename), true) ?: [];
        }

        $existing[] = [
            'id' => uniqid(),
            'model' => $this->data['car-model'],
            'brand' => $this->data['car-brand'],
            'release_date' => $this->data['car-data'],
            'color' => $this->data['car-color'],
            'fuel' => $this->data['car-fuel'],
            'description' => $this->data['car-description'],
            'created_at' => date("Y-m-d")
        ];

        file_put_contents($filename, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}