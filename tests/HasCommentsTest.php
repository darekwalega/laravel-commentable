<?php

class HasCommentsTest extends TestCase
{
	/** @test */
    public function it_can_be_commented_by_user()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $commentBody = 'Lorem ipsum';

        $entity->comment($user, $commentBody);

        $this->assertCount(1, $entity->comments);
        $this->assertEquals($user->id, $entity->comments->first()->owner->id);
        $this->assertEquals($commentBody, $entity->comments->first()->body);
    }

    /** @test */
    public function it_can_has_multiple_comments()
    {
        $user = $this->makeUser();

        $entity = $this->makeEntity();

        $commentBody = 'Lorem ipsum';

        $entity->comment($user, $commentBody);
        $entity->comment($user, $commentBody);
        $entity->comment($user, $commentBody);

        $this->assertCount(3, $entity->comments);
    }
}
