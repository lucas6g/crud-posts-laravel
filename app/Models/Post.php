<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    private $title;
    /**
     * @var mixed
     */
    private $content;
    /**
     * @var mixed
     */
    private $img_url;
    /**
     * @var mixed
     */
    private $user_id;
    /**
     * @var User|mixed
     */
    private $user;
    /**
     * @var mixed
     */
    private $id;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

}
