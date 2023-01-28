<?php

namespace app\components;

use yii\base\Component;
use Aws\Sdk;
use Aws\S3\S3Client;

class AWS extends Component
{
	public $key;
	public $secret;
	public $region;

	protected $_client;

	public function client()
	{
		if (isset($this->_client))
			return $this->_client;
		return $this->_client = new Sdk([
			'region' => $this->region,
			'version' => 'latest',
			'credentials' => [
				'key' => $this->key,
				'secret' => $this->secret,
			],
		]);
	}

	public function getFilePath($id,$filename)
	{
		return Yii::getAlias("@s3/{$id}/{$filename}");
	}
}
