<?php namespace EA\tests;

class SeriesControllerTest extends TestCase
{
    public function testGetTopSeries()
    {
        $crawler = $this->client->request('GET', '/api/series/top');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        $this->assertCount(5, $data);

        $series = reset($data);
        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
    }

    public function testGetSeries()
    {
        $crawler = $this->client->request('GET', '/api/series/stargate_sg_1');
        $response = $this->client->getResponse();
        $series = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);

        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
        $this->assertObjectHasAttribute('last_seen_season', $series);
        $this->assertEquals(1, $series->last_seen_season);
    }

    public function testGetSeriesSession()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/stargate_sg_1');
        $response = $this->client->getResponse();
        $series = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);

        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
        $this->assertObjectHasAttribute('last_seen_season', $series);
        $this->assertEquals(2, $series->last_seen_season);
    }

    public function testGetByGenre()
    {
        $crawler = $this->client->request('GET', '/api/series/genre/action');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        $this->assertCount(9, $data);

        $series = reset($data);
        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
        $this->assertObjectHasAttribute('unique_name', $series);
        $this->assertEquals('arrow', $series->unique_name);
    }

    public function testGetByGenreSkip2()
    {
        $crawler = $this->client->request('GET', '/api/series/genre/action/2');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        $this->assertCount(7, $data);

        $series = reset($data);
        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
        $this->assertObjectHasAttribute('unique_name', $series);
        $this->assertEquals('vikings', $series->unique_name);
    }

    public function testSearch()
    {
        $crawler = $this->client->request('GET', '/api/series/search/st');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        $this->assertCount(3, $data);

        $series = reset($data);
        $this->assertObjectHasAttribute('id', $series);
        $this->assertObjectHasAttribute('name', $series);
        $this->assertObjectHasAttribute('unique_name', $series);
        $this->assertEquals('the_blacklist', $series->unique_name);
    }

    /**
     * @expectedException     ErrorException
     */
    public function testSearchEmpty()
    {
        $crawler = $this->client->request('GET', '/api/series/search/');
    }

    public function testGetEpisodesBySeason()
    {
        $crawler = $this->client->request('GET', '/api/series/episodesbyseason/72449/2');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertCount(22, $data);

        $episode = reset($data);
        $this->assertObjectHasAttribute('id', $episode);
        $this->assertObjectHasAttribute('series_id', $episode);
        $this->assertObjectHasAttribute('season', $episode);
        $this->assertObjectHasAttribute('episode', $episode);
        $this->assertObjectHasAttribute('airdate', $episode);
        $this->assertEquals(72449, $episode->series_id);
        $this->assertEquals(2, $episode->season);
    }

    public function testGetEpisodes()
    {
        $crawler = $this->client->request('GET', '/api/series/episodes/72449');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertCount(21, $data);

        $episode = reset($data);
        $this->assertObjectHasAttribute('id', $episode);
        $this->assertObjectHasAttribute('series_id', $episode);
        $this->assertObjectHasAttribute('season', $episode);
        $this->assertObjectHasAttribute('episode', $episode);
        $this->assertObjectHasAttribute('airdate', $episode);
        $this->assertEquals(72449, $episode->series_id);
        $this->assertEquals(1, $episode->season);
        $this->assertEquals(2, $episode->episode); // Dataset is retarded, I know
    }

    public function testGetEpisodesFollowing()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/episodes/72449');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertCount(7, $data);

        $episode = reset($data);
        $this->assertObjectHasAttribute('id', $episode);
        $this->assertObjectHasAttribute('series_id', $episode);
        $this->assertObjectHasAttribute('season', $episode);
        $this->assertObjectHasAttribute('episode', $episode);
        $this->assertObjectHasAttribute('airdate', $episode);
        $this->assertEquals(72449, $episode->series_id);
        $this->assertEquals(3, $episode->season);
        $this->assertEquals(1, $episode->episode);
    }

    public function testGetEpisodesNotFollowing()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/episodes/272128');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertCount(2, $data);

        $episode = reset($data);
        $this->assertObjectHasAttribute('id', $episode);
        $this->assertObjectHasAttribute('series_id', $episode);
        $this->assertObjectHasAttribute('season', $episode);
        $this->assertObjectHasAttribute('episode', $episode);
        $this->assertObjectHasAttribute('airdate', $episode);
        $this->assertEquals(272128, $episode->series_id);
        $this->assertEquals(1, $episode->season);
        $this->assertEquals(1, $episode->episode);
    }

    public function testEpisodeGuide()
    {

    }

    public function testSetSeenEpisodeNotLoggedIn()
    {
        $crawler = $this->client->request('POST', '/api/series/seen/85753');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testSetSeenEpisode()
    {
        $this->beAdmin();

        $crawler = $this->client->request('POST', '/api/series/seen/85753');
        $response = $this->client->getResponse();
        $data = $respones->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        //TODO: figure out a way to check database contents
    }
}
