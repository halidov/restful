<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
	use SoftDeletes;
    protected $photos_path = 'photos/foods';
	protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'price', 'descr', 'weight', 'evalue', 'cooking_time', 'ingredients'];
    protected $casts = [
        'photos' => 'array',
    ];

    public function accessable(\App\Menu $menu, \App\Category $category) {
    	return $category->id == $this->category_id && $category->accessable($menu);
    }

    public function category() {
    	return $this->belongsTo('App\Category');
    }

    public function orders() {
    	return $this->hasMany('App\Order');
    }

    public function savePhotos($params = []) {

        $remove_photos = (array) $params['remove_photos'];
        $photos = $params['photos'];
        $main_photo = (int) $params['main_photo'];

        $path = $this->photos_path . '/' . $this->id;

        $id = $this->id;

        $food_photos = (array) $this->photos;

        foreach ($remove_photos as $photo) {
            \Storage::delete($path . '/' . $food_photos[$photo]);
            unset($food_photos[$photo]);
        }

        if($photos) {
            foreach ($photos as $key=>$photo) {
                $file_name = md5(str_random(30)) . '.jpg';

                \Storage::put($path . '/' . $file_name, file_get_contents($photo->getRealPath()));
                $food_photos[] = $file_name;
            }
        }

        $food_photos = array_values($food_photos);

        if($food_photos) {
            if($main_photo) {
                $this->main_photo = $food_photos[$main_photo];
            }

            if(!$this->main_photo || array_search($this->main_photo, $food_photos) === FALSE) {
                $this->main_photo = $food_photos[0];
            }
        } else {
            $this->main_photo = '';
        }

        $this->photos = $food_photos;

        $this->save();
    }
}
