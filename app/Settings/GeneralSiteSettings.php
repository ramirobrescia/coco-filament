<?php

use Spatie\LaravelSettings\Settings;

class GeneralSiteSettings extends Settings
{

	public ?string $name = 'Mi sitio web';

	public ?string $description = '';

	public ?string $keywords = '';

	public static function group(): string
	{
		return 'site';
	}
}
