<?php

namespace Jasny;

/**
 * Validation result
 */
class ValidationResult
{
    /**
     * @var array
     */
    protected $errors = [];
    
    /**
     * Add an error
     * 
     * @param string $message
     */
    public function addError($message)
    {
        $this->errors[] = $message;
    }
    
    /**
     * Add errors from a validation object
     * 
     * @param Validation $validation
     * @param string     $prefix
     */
    public function add(Validation $validation, $prefix = '')
    {
        foreach ($validation->getErrors() as $err) {
            $this->errors[] = $prefix . $err; 
        }
    }
    
    
    /**
     * Check if there are no validation errors
     * 
     * @return boolean
     */
    public function succeeded()
    {
        return empty($this->errors);
    }
    
    /**
     * Alias of succeeded()
     * 
     * @return boolean
     */
    final public function isSuccess()
    {
        return $this->succeeded();
    }
    
    /**
     * Check if there are validation errors
     * 
     * @return boolean
     */
    public function failed()
    {
        return !empty($this->errors);
    }
    
    
    /**
     * Get the (first) validation error
     * 
     * @return string|null
     */
    public function getError()
    {
        if (count($this->errors) > 1) trigger_error("There are multiple errors", E_USER_WARNING);
        
        return reset($this->errors) ?: null;
    }
    
    /**
     * Get the validation errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    

    /**
     * Factory method for successfull validation
     * 
     * @return static
     */
    public static function success()
    {
        return new static();
    }
    
    /**
     * Factory method for failed validation
     * 
     * @param string $message
     * @return static
     */
    public static function error($message)
    {
        $validation = new static();
        $validation->addError($message);
        
        return $validation;
    }
}