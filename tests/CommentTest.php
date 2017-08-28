<?php

class CommentTest extends TestCase
{
	/** @test */
    public function it_can_be_replied()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $comment = $this->makeComment($entity);

        $commentBody = 'Lorem ipsum';

        $comment->reply($user, $commentBody);

        $this->assertTrue($comment->hasReplies());
        $this->assertInstanceOf('Kalnoy\Nestedset\Collection', $comment->replies);
        $this->assertEquals(1, $comment->repliesCount());
    }

    /** @test */
    public function it_should_not_be_published_after_create_as_default()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $commentBody = 'Lorem ipsum';

        $entity->comment($user, $commentBody);

        $this->assertFalse($entity->comments->first()->isPublished());
    }

    /** @test */
    public function it_can_be_publish()
    {
    	$user = $this->makeUser();

        $entity = $this->makeEntity();

        $commentBody = 'Lorem ipsum';

        $entity->comment($user, $commentBody);

        $entity->comments->first()->publish();

        $this->assertTrue($entity->comments->first()->isPublished());
    }
}
