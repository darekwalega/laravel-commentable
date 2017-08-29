<?php

namespace Abix\Commentable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
	use NodeTrait;

	protected $guarded = [];

	public function owner()
    {
        return $this->morphTo();
    }

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function reply(Model $owner, $comment)
    {
    	return $this->commentable->comment($owner, $comment, $this);
    }

    public function replies()
    {
    	return $this->children();
    }

    public function repliesCount()
    {
    	return $this->children()->count();
    }

    public function hasReplies()
    {
    	return (bool) $this->repliesCount() > 0;
    }

    public function isPublished()
    {
        if (! $this->published_at) {
            return false;
        }

        if (Carbon::now() < $this->published_at) {
            return false;
        }

        return true;
    }

    public function publish($date = null)
    {
    	if (! $date) {
    		$date = Carbon::now();
    	}

    	$this->published_at = Carbon::parse($date);
    	$this->save();

    	return $this;
    }

    public function unpublish()
    {
        $this->published_at = null;

        $this->save();
    }

    public function togglePublish()
    {
        ($this->isPublished()) ? $this->unpublish() : $this->publish();
    }
}
