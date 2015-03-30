<?php

class SeriesControllerTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testGetTopSeries()
	{
		$crawler = $this->client->request('GET', '/api/series/top');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
