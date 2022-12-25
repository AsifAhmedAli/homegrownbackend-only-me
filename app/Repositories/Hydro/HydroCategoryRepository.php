<?php
  
  
  namespace App\Repositories\Hydro;
  
  
  use App\Utils\Helpers\Helper;
  use Exception;
  use App\Hydro\HydroCategory;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Database\Eloquent\Model;

  class HydroCategoryRepository extends HydroBaseRepository
  {
    private const API_URL = '/categories/getcategories';
    
    /**
     * HydroCategoryRepository constructor.
     */
    public function __construct()
    {
      parent::__construct(self::API_URL);
    }
  
    /**
     * @param callable $imported
     * @throws Exception
     */
    public function import(callable $imported)
    {
      $this->setFields([
        'flatStructure' => "false"
      ]);
      $categories = $this->process();
      if($categories) {
        foreach ($categories as $key => $category) {
          $this->save($category, $imported);
        }
      }
    }
  
    /**
     * @param $category
     * @param callable $imported
     * @param bool $isRoot
     */
    private function save($category, callable $imported, bool $isRoot = true)
    {
      $hydroCat = new HydroCategory;
      $hydroCat->hydro_id = $category->id;
      if(Helper::unique($hydroCat)) {
        $hydroCat->hydro_parent_id = $category->parentId;
        $hydroCat->name = $category->name;
        $hydroCat->short_name = $category->shortName;
        $hydroCat->is_root = $isRoot;
        $hydroCat->save();
        $imported($hydroCat);
      }
      if(count($category->subCategories)) {
        foreach ($category->subCategories as $subCategory) {
          $this->save($subCategory, $imported, false);
        }
      }
    }
  
    /**
     * To Get Hydro Categories from DB
     * if passing false then all categories (active/inactive) will be returned
     * @param bool $active
     * @param array $options (limit, order_by-id, direction-asc)
     * @return mixed
     */
    public static function get(bool $active = true, array $options = [])
    {
      return HydroCategory::with([
        'children' => function($q) use($active) {
          $q->when($active, function($query) {
            $query->active();
          });
        }
      ])
        ->root()->when($active, function($query) {
          $query->active();
        })
        ->when(isset($options['limit']), function ($q) use($options) {
          $q->take($options['limit']);
        })
        ->orderBy(
            Helper::arrayIndex($options, 'order_by', 'id'),
            Helper::arrayIndex($options, 'direction', 'asc')
          )
        ->get();
    }
  
    /**
     * @param int $hydroID
     * @return HydroCategory|Builder|Model
     */
    public static function find(int $hydroID)
    {
      return HydroCategory::whereHydroId($hydroID)->firstOrFail();
    }
  }
