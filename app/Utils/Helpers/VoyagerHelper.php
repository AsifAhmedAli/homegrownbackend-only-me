<?php

  use TCG\Voyager\Models\Setting;

    function getSiteSettings() {
      return Setting::where('group','Site')->pluck('value','key');
    }

    function getGXSiteSettings() {
      return Setting::where('group','GX')->pluck('value','key');
    }

    function getAdminEmail() {
      return setting('admin.admin_email');
    }

    function getProducts() {
        return \App\Hydro\HydroProduct::active()->pluck('sku', 'id');
    }

    function getKitProducts($order_id, $kit_id) {
        return \App\Models\OrderKitProduct::where(['order_id' => $order_id, 'kit_id' => $kit_id])->get();
    }
