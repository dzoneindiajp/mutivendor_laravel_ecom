<?php
namespace App\Models;

use Eloquent,File;

/**
 * Review Model
 */
class ProductImage extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product_images';

	function getImageAttribute($value = "")
	{
		if (!empty($value)) {
			return Config('constant.PRODUCT_IMAGE_URL') . $value;
		} else {
			return Config('constant.PRODUCT_IMAGE_URL') . "noimage.png";
		}
	}

} // end EmailAction class
