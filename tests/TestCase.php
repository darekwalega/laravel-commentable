<?php

use Abix\Commentable\Comment;
use Illuminate\Database\Capsule\Manager as DB;
use Kalnoy\Nestedset\NestedSet;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        $this->setUpDatabase();
        $this->migrateTables();
    }

    protected function setUpDatabase()
    {
        $database = new DB;
        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    protected function migrateTables()
    {
        DB::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();  
        });

        DB::schema()->create('entities', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();  
        });

        DB::schema()->create('comments', function ($table) {
            $table->increments('id');
            NestedSet::columns($table);
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->string('body');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->index(['commentable_id', 'commentable_type'], 'commentable');
        });
    }

    protected function makeUser()
    {
        $user = new User;
        
        $user->name = 'Some name';
        $user->save();
        
        return $user; 
    }

    protected function makeEntity()
    {
        $entity = new Entity;
        
        $entity->title = 'Some title';
        $entity->save();
        
        return $entity; 
    }

    protected function makeComment($entity = null)
    {
        $user = $this->makeUser();

        if (! $entity) {
            $entity = $this->makeEntity();
        }

        $comment = Comment::create([
            'body' => 'Some comment',
            'commentable_id' => $entity->id,
            'commentable_type' => get_class($entity),
            'owner_id' => $user->id,
            'owner_type' => get_class($user),
        ]);

        Comment::fixTree();

        return $comment->fresh();
    }
}

class Entity extends \Illuminate\Database\Eloquent\Model
{
    use Abix\Commentable\HasComments;
}

class User extends \Illuminate\Database\Eloquent\Model
{
    // ...
}
