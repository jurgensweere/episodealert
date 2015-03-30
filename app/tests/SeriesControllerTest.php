<?php namespace EA\tests;

class SeriesControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetTopSeries()
    {
        $crawler = $this->client->request('GET', '/api/series/top');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        $this->assertCount(5, $data);
    }
}
