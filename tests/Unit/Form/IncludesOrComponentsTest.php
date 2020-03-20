<?php

namespace Kompo\Tests\Unit\Form;

use Kompo\Tests\EnvironmentBoot;

class IncludesOrComponentsTest extends EnvironmentBoot
{
	/** @test */
	public function load_components_method_by_default()
	{
		$form = new _IncludesOrComponentsForm();

		$this->assertEquals('title', $form->components[0]->name);
	}

	/** @test */
	public function load_other_method_if_header_includes_is_present()
	{
		\Route::kompo('some-route', _IncludesOrComponentsForm::class);

		$this->withHeaders([ 'X-Kompo-Includes' => 'newkompos' ])->get('some-route')
			->assertJson([
				'components' => [
					0 => [
						'name' => 'content'
					]
				]
			]);
	}


}