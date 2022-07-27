<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category',
        'product_volume',
        'product_image',
    ];

    
    protected $category = [
        '1'   => 'One',
        '2'   => 'Two',
        '3'   => 'Three',
        '4'   => 'Four',
        '5'   => 'Five',
        '6'   => 'Six'
        
    ];

    public function getCategory(){
        return $this->category;
    }
}
