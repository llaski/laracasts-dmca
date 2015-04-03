<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Provider;

class ProvidersSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$providers = [
			['name' => 'YouTube', 'copyright_email' => 'larry.laski@gmail.com']
		];

		foreach($providers as $provider)
		{
			Provider::create($provider);
		}

	}

}
