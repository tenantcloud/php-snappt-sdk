<?php

namespace TenantCloud\Snappt;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use TenantCloud\Snappt\Client\SnapptClient;
use TenantCloud\Snappt\Client\SnapptClientImpl;
use TenantCloud\Snappt\Fake\FakeSnapptClient;

class SnapptSdkServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->mergeConfigFrom(
			__DIR__ . '/../resources/config/snappt.php',
			'snappt'
		);

		$this->bindDefaultClient();
	}

	/**
	 * Binds default implementation of {@see SnapptClient}.
	 */
	private function bindDefaultClient(): void
	{
		$config = $this->app->make(Repository::class);
		$logger = $this->app->make(LoggerInterface::class);

//		if (!$config->get('snappt.fake_client')) {
//			$this->app->bind(SnapptClient::class, fn () => new SnapptClientImpl(
//				$config->get('snappt.api_key'),
//				$config->get('snappt.base_url'),
//				30,
//				$logger,
//			));
//		} else {
//			$this->app->bind(SnapptClient::class, FakeSnapptClient::class);
//		}

		$this->app->bind(SnapptClient::class, fn () => new SnapptClientImpl(
			$config->get('snappt.api_key'),
			$config->get('snappt.base_url'),
			30,
			$logger,
		));
	}
}
