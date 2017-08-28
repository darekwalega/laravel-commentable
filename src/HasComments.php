<?php

namespace Abix\Commentable;

use Illuminate\Database\Eloquent\Model;

trait HasComments
{
    public function commentModel()
    {
        return 'Abix\Commentable\Comment';
    }

	public function comments()
	{
		return $this->morphMany($this->commentModel(), 'commentable');
	}

    public function comment(Model $owner, $comment, $parent = null)
    {
    	$attributes = [
            'owner_id' => $owner->id,
            'owner_type' => get_class($owner),
        ];

        if (is_string($comment)) {
        	$attributes['body'] = $comment;
        } elseif (is_array($comment)) {
        	$attributes = array_merge($attributes, $comment);
        }

        if ($parent) {
        	$attributes['parent_id'] = $parent->id;
        }

        $this->comments()->create($attributes);

        return $this;
    }
}
