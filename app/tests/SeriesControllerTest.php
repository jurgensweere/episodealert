<?php namespace EA\tests;

use Route;
use EA\models\Seen;

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
        Route::enableFilters();

        $crawler = $this->client->request('POST', '/api/series/seen/85753');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testSetSeenEpisode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/seen/85753');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount + 1, Seen::all()->count());
    }

    public function testSetSeenEpisodeSeasonMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/seen/85753', array('mode' => Seen::MODE_SEASON));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount + 21, Seen::all()->count());
    }

    public function testSetSeenEpisodeUntilMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/seen/85753', array('mode' => Seen::MODE_UNTIL));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount + 3, Seen::all()->count());
    }

    public function testSetSeenEpisodeUnknownMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/seen/85753', array('mode' => 'worstenbrood'));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertFalse($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount, Seen::all()->count());
    }

    public function testSetUneenEpisodeNotLoggedIn()
    {
        Route::enableFilters();

        $crawler = $this->client->request('POST', '/api/series/unseen/85775');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testSetUnseenEpisode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/unseen/85775');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount - 1, Seen::all()->count());
    }

    public function testSetUnseenEpisodeSeasonMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/unseen/85775', array('mode' => Seen::MODE_SEASON));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount - 4, Seen::all()->count());
    }

    public function testSetUnseenEpisodeUntilMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/unseen/85775', array('mode' => Seen::MODE_UNTIL));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount - 3, Seen::all()->count());
    }

    public function testSetUnseenEpisodeUnknownMode()
    {
        $this->beAdmin();

        $initialSeenCount = Seen::all()->count();

        $crawler = $this->client->request('POST', '/api/series/unseen/85775', array('mode' => 'worstenbrood'));
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertFalse($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        // One extra seen record created
        $this->assertEquals($initialSeenCount, Seen::all()->count());
    }

    public function testGetUnseenEpisodesNotLoggedIn()
    {
        Route::enableFilters();

        $crawler = $this->client->request('GET', '/api/series/unseenamount');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testGetUnseenEpisodes()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/unseenamount');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertObjectHasAttribute('unseenepisodes', $data);
        $this->assertEquals(46, $data->unseenepisodes); // (53 - 3 not following - 4 seen)
    }

    public function testGetUnseenEpisodesPerSeasonNotLoggedIn()
    {
        Route::enableFilters();

        $crawler = $this->client->request('GET', '/api/series/unseenamountbyseason/72449/2');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testGetUnseenEpisodesPerSeason()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/unseenamountbyseason/72449/2');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertObjectHasAttribute('unseenepisodes', $data);
        $this->assertEquals(18, $data->unseenepisodes); // (22 - 4 seen)
    }

    public function testGetUnseenEpisodesPerSeriesNotLoggedIn()
    {
        Route::enableFilters();

        $crawler = $this->client->request('GET', '/api/series/unseenamountbyseries/72449/3');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    public function testGetUnseenEpisodesPerSeries()
    {
        $this->beAdmin();

        $crawler = $this->client->request('GET', '/api/series/unseenamountbyseries/72449/3');
        $response = $this->client->getResponse();
        $data = $response->getData();

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
        $this->assertCount(3, $data);
        $this->assertEquals(21, $data[0]);
        $this->assertEquals(18, $data[1]);
        $this->assertEquals(7, $data[2]);
    }

    // TODO: FIX THIS FUNCTION
    public function testGetEpisodesForUserPerDateNotLoggedIn()
    {
        Route::enableFilters();

        $crawler = $this->client->request('GET', '/api/series/episodesperdate/1999-07-24');
        $response = $this->client->getResponse();

        $this->assertFalse($response->isOk());
    }

    // public function testGetEpisodesForUserPerDate()
    // {
    //     $this->beAdmin();

    //     $crawler = $this->client->request('GET', '/api/series/episodesperdate/1999-07-23');
    //     $response = $this->client->getResponse();
    //     $data = $response->getData();

    //     $this->assertTrue($response->isOk());
    //     $this->assertInstanceOf('\Illuminate\Http\JsonResponse', $response);
        
    //     $this->assertCount(1, $data);
    // }
}
