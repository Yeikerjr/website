<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Website
 * @package App\Models
 * @version January 23, 2021, 6:12 am UTC
 *
 * @property string $name
 * @property integer $domain_authority
 * @property integer $page_authority
 * @property number $price
 * @property integer $link_type_id
 * @property integer $post_content_id
 */
class Website extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'websites';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'domain_authority',
        'page_authority',
        'price',
        'link_type_id',
        'post_content_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'domain_authority' => 'integer',
        'page_authority' => 'integer',
        'price' => 'double',
        'link_type_id' => 'integer',
        'post_content_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'domain_authority' => 'required|numeric',
        'page_authority' => 'required|numeric',
        'price' => 'required|numeric',
        'link_type_id' => 'required|numeric',
        'post_content_id' => 'required|numeric'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function linkType() {
        return $this->hasOne(LinkType::class, 'link_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function postContent() {
        return $this->hasOne(PostContent::class, 'post_content_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    
}
