<?php

use Spatie\LaravelSettings\Settings;

class BlogSettings extends Settings
{

	public ?int $postPerPage = 10;

	public ?int $pageOnEachSide = 2;

	public static function group(): string
	{
		return 'blog';
	}
}
