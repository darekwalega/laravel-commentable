<?php

namespace Abix\Commentable;

use Abix\Commentable\HasComments;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasComments;
}
