<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getAttributes()
    {
      $attributes = Attribute::select('title as text', 'id')
        ->when(request('search'), function ($q) {
          $q->where('title', 'like', '%' . request('search') . '%');
        })
        ->orderBy('title')
        ->get();
  
      return response()->json([
        'results'    => $attributes
      ]);
    }
    
    public function getAttributeValues()
    {
    
    }
}
