<?php
  namespace App;
  use App\Hydro\HydroProduct;
  use App\Utils\Traits\CommonRelations;
  use App\Utils\Traits\CommonScopes;
  use App\Utils\Traits\Search;
  use Illuminate\Database\Eloquent\Model;
  /**
   * App\HomePage
   *
   * @property int $id
   * @property string $banner_text
   * @property string $banner_products
   * @property string $featured_categories
   * @property string $promotional_banner
   * @property string $promotional_banner_cta_link
   * @property string $package_1_title
   * @property string $package_1_description
   * @property string $package_1_image
   * @property float $package_1_price
   * @property string $package_2_title
   * @property string $package_2_description
   * @property string $package_2_image
   * @property float $package_2_price
   * @property string $package_3_title
   * @property string $package_3_description
   * @property string $package_3_image
   * @property float $package_3_price
   * @property string $package_cta_title
   * @property string $package_cta_link
   * @property string $how_it_work_title
   * @property string $how_it_work_description
   * @property string $how_it_work_cta_title
   * @property string $how_it_work_cta_link
   * @property string $how_it_work_left_image
   * @property string $how_it_work_right_image
   * @property string $team_title
   * @property string $team_cta_title
   * @property string $team_cta_link
   * @property string $bottom_section_title
   * @property string $bottom_section_description
   * @property string $bottom_section_cta_title
   * @property string $bottom_section_book_title
   * @property string $bottom_section_download_book
   * @property string $bottom_section_cta_link
   * @property string $review_section_title
   * @property \Illuminate\Support\Carbon|null $created_at
   * @property \Illuminate\Support\Carbon|null $updated_at
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage active()
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage default()
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage newModelQuery()
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage newQuery()
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage ofCart($cartID)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage ofProduct($productID)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage ofUser($userID)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage query()
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBannerProducts($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBannerText($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionBookTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionCtaLink($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionCtaTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionDescription($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionDownloadBook($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereCreatedAt($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereFeaturedCategories($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkCtaLink($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkCtaTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkDescription($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkLeftImage($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkRightImage($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereHowItWorkTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereId($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage1Description($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage1Image($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage1Price($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage1Title($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage2Description($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage2Image($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage2Price($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage2Title($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage3Description($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage3Image($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage3Price($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackage3Title($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackageCtaLink($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePackageCtaTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePromotionalBanner($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage wherePromotionalBannerCtaLink($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereReviewSectionTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereTeamCtaLink($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereTeamCtaTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereTeamTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereUpdatedAt($value)
   * @mixin \Eloquent
   * @property-read HydroProduct $bannerProducts
   * @property string $slider_banner_image
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereSliderBannerImage($value)
   * @property string $bottom_center_image
   * @property string $bottom_section_book_cover_image
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomCenterImage($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereBottomSectionBookCoverImage($value)
   * @property string $featured_products_mini_title
   * @property string $featured_products_title
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereFeaturedProductsMiniTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|HomePage whereFeaturedProductsTitle($value)
   */
  class HomePage extends Model
  {
    protected $table = 'home_page';
    use CommonRelations, CommonScopes, Search;
    public function bannerProducts() {
      return $this->belongsTo(HydroProduct::class);
    }
  }
