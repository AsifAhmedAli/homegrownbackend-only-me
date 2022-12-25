<?php
  
  
  namespace App\Repositories\Hydro;
  
  use App\Utils\Helpers\Helper;
  use Exception;
  use App\Hydro\HydroCategory;
  use App\Hydro\HydroProduct;
  use App\Hydro\HydroProductAttribute;
  use App\Hydro\HydroProductBarCode;
  use App\Hydro\HydroProductDimension;
  use App\Hydro\HydroProductDocument;
  use App\Hydro\HydroProductFamily;
  use App\Hydro\HydroProductFamilyItem;
  use App\Hydro\HydroProductImage;
  use App\Hydro\HydroProductInventory;
  use App\Hydro\HydroProductPrice;
  use App\Hydro\HydroProductPriceWholeSalePrice;
  use App\Hydro\HydroProductRelated;
  use App\Hydro\HydroProductRestriction;
  use App\Hydro\HydroProductUomConversion;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Query\Builder;

  class HydroProductRepository extends HydroBaseRepository
  {
    private const API_URL = '/products/getproducts';
    private const MAX_PRODUCTS_PER_CALL = 150;
    private $syncProduct = false;
    private $syncFamily = true;
  
    /**
     * HydroProductRepository constructor.
     */
    public function __construct()
    {
      parent::__construct(self::API_URL, 'post');
    }
    
    public function setSync(bool $sync)
    {
      $this->syncProduct = $sync;
    }
  
    /**
     * @param callable $imported
     * @throws Exception
     */
    public function import(callable $imported)
    {
      $categories = HydroCategoryRepository::get(false);
      foreach ($categories as $key => $category) {
        $this->importViaCategory($category, $imported);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param string $sku
     * @param bool $sync
     * @throws Exception
     */
    private function importProduct(HydroProduct $hydroProduct, string $sku, bool $sync = false)
    {
      if(!Helper::empty($sku)) {
        if($sku != $hydroProduct->sku) {
          if(!$this->skuProductExists($sku) || $sync) {
            $currentApiUrl = $this->getApiUrl();
            $currentPostFields = $this->getFields();
            $this->setApiUrl(self::API_URL);
            $this->setFields([
              'keyword' => $sku,
              'includeProductVariants' => 'true'
            ]);
            $products = $this->process();
            $this->setApiUrl($currentApiUrl, false);
            $this->setFields($currentPostFields);
            $product = Helper::arrayIndex($products, 0, null);
            if($product) {
              $this->save($hydroProduct->category, $product);
            }
          }
        }
      }
    }
  
    /**
     * @param string $sku
     * @return bool
     */
    private function skuProductExists(string $sku): bool
    {
      return HydroProduct::whereSku($sku)->exists();
    }
  
    /**
     * @param HydroCategory $category
     * @param callable $imported
     * @param int $page
     * @param bool $importChildren
     * @throws Exception
     */
    public function importViaCategory(HydroCategory $category, callable $imported, int $page = 0, bool $importChildren = true)
    {
      $this->renewApiUrl(self::API_URL, [
        'pageSize' => self::MAX_PRODUCTS_PER_CALL,
        'pageNo' => $page + 1
      ]);
      $this->setFields([
        'Categories' => (string)$category->hydro_id
      ]);
      $products = $this->process();
      if(is_array($products)) {
        foreach ($products as $product) {
          $this->save($category, $product);
        }
        if(count($products) == self::MAX_PRODUCTS_PER_CALL) {
          $this->importViaCategory($category, $imported, $page + 1);
        } else {
          $imported($category);
        }
        if($importChildren && $category->children->count()) {
          foreach ($category->children as $child) {
            $this->importViaCategory($child, $imported);
          }
        }
      } else {
        $this->importViaCategory($category, $imported, $page);
      }
    }
  
    /**
     * @param HydroCategory $hydroCategory
     * @param $product
     * @return bool
     * @throws Exception
     */
    private function save(HydroCategory $hydroCategory, $product)
    {
      $hydroProduct = new HydroProduct;
      $hydroProduct->recid = $product->recid;
      if(!Helper::unique($hydroProduct)) {
        if(!$this->syncProduct) {
          return false;
        }
        $hydroProduct = Helper::getUnique($hydroProduct);
      }
      $hydroProduct->hydro_category_id = $hydroCategory->id;
      $this->saveProduct($hydroProduct, $product);
      return true;
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveProduct(HydroProduct $hydroProduct, $product)
    {
      $hydroProduct = $this->saveDynamic($hydroProduct, $product);
      $this->saveAttributes($hydroProduct, $product);
      $this->saveRelated($hydroProduct, $product);
      $this->saveRestrictions($hydroProduct, $product);
      $this->saveImages($hydroProduct, $product);
      $this->saveDocuments($hydroProduct, $product);
      $this->savePrice($hydroProduct, $product);
      $this->saveBarCodes($hydroProduct, $product);
      $this->saveDimensions($hydroProduct, $product);
      $this->saveUomConversions($hydroProduct, $product);
      $this->saveInventories($hydroProduct, $product);
      $this->saveFamily($hydroProduct, $product);
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveAttributes(HydroProduct $hydroProduct, $product)
    {
      $this->deleteAttributes($hydroProduct);
      foreach ($product->attributes ?? [] as $attribute) {
        $hydroAttribute = new HydroProductAttribute;
        $this->saveRelation($hydroProduct, $hydroAttribute, $attribute);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteAttributes(HydroProduct $hydroProduct)
    {
      HydroProductAttribute::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveRelated(HydroProduct $hydroProduct, $product)
    {
      $this->deleteRelated($hydroProduct);
      foreach ($product->related ?? [] as $related) {
        $hydroProductRelated = new HydroProductRelated;
        $hydroProductRelated = $this->saveRelation($hydroProduct, $hydroProductRelated, $related);
        $this->importProduct($hydroProductRelated->product, $hydroProductRelated->sku);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteRelated(HydroProduct $hydroProduct)
    {
      HydroProductRelated::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveRestrictions(HydroProduct $hydroProduct, $product)
    {
      $this->deleteRestrictions($hydroProduct);
      foreach ($product->restrictions ?? [] as $restriction) {
        $hydroProductRestriction = new HydroProductRestriction;
        $this->saveRelation($hydroProduct, $hydroProductRestriction, $restriction);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteRestrictions(HydroProduct $hydroProduct)
    {
      HydroProductRestriction::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveImages(HydroProduct $hydroProduct, $product)
    {
      $this->deleteImages($hydroProduct);
      foreach ($product->images ?? [] as $image) {
        $hydroProductImage = new HydroProductImage;
        $this->saveRelation($hydroProduct, $hydroProductImage, $image);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteImages(HydroProduct $hydroProduct)
    {
      HydroProductImage::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveDocuments(HydroProduct $hydroProduct, $product)
    {
      $this->deleteDocuments($hydroProduct);
      foreach ($product->documents ?? [] as $document) {
        $hydroProductDocument = new HydroProductDocument;
        $this->saveRelation($hydroProduct, $hydroProductDocument, $document);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteDocuments(HydroProduct $hydroProduct)
    {
      HydroProductDocument::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveBarCodes(HydroProduct $hydroProduct, $product)
    {
      $this->deleteBarCodes($hydroProduct);
      foreach ($product->barcodes ?? [] as $barcode) {
        $hydroProductBarCode = new HydroProductBarCode;
        $this->saveRelation($hydroProduct, $hydroProductBarCode, $barcode);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteBarCodes(HydroProduct $hydroProduct)
    {
      HydroProductBarCode::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveDimensions(HydroProduct $hydroProduct, $product)
    {
      $this->deleteDimensions($hydroProduct);
      foreach ($product->dimensions ?? [] as $dimension) {
        $hydroProductDimension = new HydroProductDimension;
        $this->saveRelation($hydroProduct, $hydroProductDimension, $dimension);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteDimensions(HydroProduct $hydroProduct)
    {
      HydroProductDimension::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveUomConversions(HydroProduct $hydroProduct, $product)
    {
      $this->deleteUomConversions($hydroProduct);
      foreach ($product->uomconversions ?? [] as $uomconversion) {
        $hydroProductUomConversion = new HydroProductUomConversion;
        $this->saveRelation($hydroProduct, $hydroProductUomConversion, $uomconversion);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteUomConversions(HydroProduct $hydroProduct)
    {
      HydroProductUomConversion::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveInventories(HydroProduct $hydroProduct, $product)
    {
      $this->deleteInventories($hydroProduct);
      foreach ($product->inventories ?? [] as $inventory) {
        $hydroProductInventory = new HydroProductInventory;
        $this->saveRelation($hydroProduct, $hydroProductInventory, $inventory);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    private function deleteInventories(HydroProduct $hydroProduct)
    {
      HydroProductInventory::whereHydroProductId($hydroProduct->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function savePrice(HydroProduct $hydroProduct, $product)
    {
      if(!Helper::empty($product->price)) {
        $price = new HydroProductPrice;
        $price->hydro_product_id = $hydroProduct->id;
        $price->product_recid = $hydroProduct->recid;
        if(!Helper::unique($price)) {
          $price = Helper::getUnique($price);
        }
  
        $price->retailPrice = optional($product->price)->retailPrice;
        $price->save();
        $this->saveWholeSalePrice($price, $product);
      }
    }
  
    /**
     * @param HydroProductPrice $hydroProductPrice
     * @param $product
     * @throws Exception
     */
    private function saveWholeSalePrice(HydroProductPrice $hydroProductPrice, $product)
    {
      $this->deleteWholeSalePrices($hydroProductPrice);
      foreach (optional($product->price)->wholesalePrice ?? [] as $wholeSale) {
        $hydroProductPriceWholeSale = new HydroProductPriceWholeSalePrice;
        $hydroProductPriceWholeSale->hydro_product_price_id = $hydroProductPrice->id;
        $this->saveDynamic($hydroProductPriceWholeSale, $wholeSale);
      }
    }
  
    /**
     * @param HydroProductPrice $hydroProductPrice
     * @throws Exception
     */
    private function deleteWholeSalePrices(HydroProductPrice $hydroProductPrice)
    {
      HydroProductPriceWholeSalePrice::whereHydroProductPriceId($hydroProductPrice->id)->delete();
    }
    
    /**
     * @param HydroProduct $hydroProduct
     * @param $product
     * @throws Exception
     */
    private function saveFamily(HydroProduct $hydroProduct, $product)
    {
      if(!Helper::empty($product->family)) {
        $family = new HydroProductFamily;
        $family->hydro_product_id = $hydroProduct->id;
        $family->product_recid = $hydroProduct->recid;
        if(!Helper::unique($family)) {
          $family = Helper::getUnique($family);
        }
  
        $family->name = optional($product->family)->name;
        $family->save();
        $this->saveFamilyItems($family, $product);
      }
    }
  
    /**
     * @param HydroProductFamily $hydroProductFamily
     * @param $product
     * @throws Exception
     */
    private function saveFamilyItems(HydroProductFamily $hydroProductFamily, $product)
    {
      $this->deleteFamilyItems($hydroProductFamily);
      foreach (optional($product->family)->items ?? [] as $item) {
        $familyItem = new HydroProductFamilyItem;
        $familyItem->hydro_product_family_id = $hydroProductFamily->id;
        $familyItem = $this->saveDynamic($familyItem, $item);
        if($this->syncFamily) {
          $this->importProduct($hydroProductFamily->product, $familyItem->sku);
        }
      }
    }
  
    /**
     * @param HydroProductFamily $hydroProductFamily
     * @throws Exception
     */
    private function deleteFamilyItems(HydroProductFamily $hydroProductFamily)
    {
      HydroProductFamilyItem::whereHydroProductFamilyId($hydroProductFamily->id)->delete();
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @param HydroProductAttribute|HydroProductRestriction|HydroProductRelated|HydroProductImage|HydroProductDocument|HydroProductBarCode|HydroProductDimension|HydroProductUomConversion|HydroProductInventory $relation
     * @param $data
     * @return HydroProduct|HydroProductAttribute|HydroProductDocument|HydroProductImage|HydroProductRelated|HydroProductRestriction|HydroProductPriceWholeSalePrice|HydroProductBarCode|HydroProductDimension|HydroProductUomConversion|HydroProductInventory
     */
    private function saveRelation(HydroProduct $hydroProduct, $relation, $data)
    {
      $relation->hydro_product_id = $hydroProduct->id;
      $relation->product_recid = $hydroProduct->recid;
      return $this->saveDynamic($relation, $data);
    }
  
    /**
     * @param HydroProduct[] $hydroProducts
     * @throws Exception
     */
    public function syncFamilyMembers($hydroProducts)
    {
      $this->syncFamily = false;
      $this->syncProduct = true;
      foreach ($hydroProducts as $hydroProduct) {
        $this->importHydroProduct($hydroProduct);
      }
    }
  
    /**
     * @param HydroProduct $hydroProduct
     * @throws Exception
     */
    public function importHydroProduct(HydroProduct $hydroProduct)
    {
      $this->setFields([
        'keyword' => $hydroProduct->sku,
        'includeProductVariants' => 'true'
      ]);
      $products = $this->process();
      $product = Helper::arrayIndex($products, 0, null);
      if($product) {
        $this->save($hydroProduct->category, $product);
      }
    }
  }
