<?php 
namespace App\Models; 
use Eloquent;
use DB;
/**
 * Review Model
 */
class ProductVariantCombination extends Eloquent {

	
/**
 * The database table used by the model.
 *
 * @var string
 */
	protected $table = 'product_variant_combinations';

	function fetchProductDetailsByProductId($productId){
		$returnData = [];
		$productDetails = ProductVariantCombination::where('product_variant_combinations.id', $productId ?? 0)->leftJoin('products', 'products.id', 'product_variant_combinations.product_id')->select('product_variant_combinations.*', 'products.name','products.category_id','products.sub_category_id','products.child_category_id',DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant1_value_id ) as variant_value1_name'),DB::raw('(SELECT name from variant_values WHERE id = product_variant_combinations.variant2_value_id ) as variant_value2_name'))->first();
        $returnData['product_name'] = $productDetails->name ?? '';
        $returnData['category_id'] = $productDetails->category_id ?? '';
        $returnData['sub_category_id'] = $productDetails->sub_category_id ?? '';
        $returnData['child_category_id'] = $productDetails->child_category_id ?? '';
        $returnData['variant_value1_name'] = $productDetails->variant_value1_name ?? '';
        $returnData['variant_value2_name'] = $productDetails->variant_value2_name ?? '';
        $returnData['product_price'] = getDropPrices($productDetails->id,['category_id' => $productDetails->category_id, 'sub_category_id' => $productDetails->sub_category_id, 'child_category_id' => $productDetails->child_category_id,'selling_price' => $productDetails->selling_price,'product_id' => $productDetails->product_id],'selling') ;
        $productImage = ProductVariantCombinationImage::where('product_variant_combination_images.product_variant_combination_id', $productDetails->id)->leftJoin('product_images', 'product_images.id', 'product_variant_combination_images.product_image_id')->value('product_images.image');
        $returnData['product_image'] = (!empty($productImage)) ? Config('constant.PRODUCT_IMAGE_URL') . $productImage : Config('constant.IMAGE_URL') . "noimage.png";
		return $returnData;

	}


}// end EmailAction class
