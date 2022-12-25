<?php
  
  
  namespace App\Utils\Traits;
  
  
  use App\Hydro\HydroProduct;

  trait CommonHydro
  {
    public function product()
    {
      return $this->belongsTo(HydroProduct::class, 'product_recid', 'recid');
    }
  }
