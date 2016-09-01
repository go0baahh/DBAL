<?php
/**
 * Abstraction
 * Modular layer
 *
 */

namespace Abstraction;

class Category
{
    public $var1;
    public $var2;
    public $var3;

    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];

            $this->var1 = $data['var1'];
            $this->var2 = $data['var2'];
            $this->var3 = $data['var3'];
        }
    }

    public function GetData()
    {
        echo $this->var1;
    }
}
