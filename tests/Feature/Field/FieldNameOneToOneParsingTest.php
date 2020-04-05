<?php

namespace Kompo\Tests\Feature\Field;

use Kompo\Tests\EnvironmentBoot;
use Kompo\Tests\Models\Obj;
use Kompo\Tests\Models\Post;

class FieldNameOneToOneParsingTest extends EnvironmentBoot
{
	/** @test */
	public function nested_has_one_handled_from_parent_model_form()
	{
		$postTitle = 'post-title';
		$objTitle = 'obj-title';
		$objTag = 'obj-tag';
		$postTagTitle = 'postTag-title';

		$this->submit_status_and_json_assertions(new _FieldNameOneToOneParsingForm(), 201, $postTitle, $objTitle, $objTag, $postTagTitle);

		$this->database_and_form_reloading_assertions($postTitle, $objTitle, $objTag, $postTagTitle);

		$postTitle = 'post-title2';
		$objTitle = 'obj-title2';
		$objTag = null;
		$postTagTitle = 'postTag-title2';

		$this->submit_status_and_json_assertions(new _FieldNameOneToOneParsingForm(1), 200, $postTitle, $objTitle, $objTag, $postTagTitle);

		$this->database_and_form_reloading_assertions($postTitle, $objTitle, $objTag, $postTagTitle);
	}


	/** ------------------ PRIVATE --------------------------- */  

	private function submit_status_and_json_assertions($form, $status, $postTitle, $objTitle, $objTag, $postTagTitle)
	{
		$this->submit($form, [
			'title' => $postTitle,
			'obj.title' => $objTitle,
			'obj.tag' => $objTag,
			'postTag.title' => $postTagTitle
		])->assertStatus($status)
		->assertJson([
			'id' => 1,
			'title' => $postTitle,
			'obj' => [
				'title' => $objTitle,
				'tag' => $objTag
			],
			'post_tag' => [
				'title' => $postTagTitle
			]
		]);
	}

	private function database_and_form_reloading_assertions($postTitle, $objTitle, $objTag, $postTagTitle)
	{
		$this->assertEquals(1, \DB::table('posts')->count());
		$this->assertDatabaseHas('posts', ['id' => 1,'title' => $postTitle]);
		$this->assertEquals(1, \DB::table('objs')->count());
		$this->assertDatabaseHas('objs', ['id' => 1,'title' => $objTitle, 'tag' => $objTag]);
		$this->assertEquals(1, \DB::table('post_tag')->count());
		$this->assertDatabaseHas('post_tag', ['id' => 1,'title' => $postTagTitle]);

		$form = new _FieldNameOneToOneParsingForm(1);

		$this->assertEquals($objTitle, $form->components[1]->value);
		$this->assertEquals($objTag, $form->components[2]->value);
		$this->assertEquals($postTagTitle, $form->components[3]->value);
	}
	
}