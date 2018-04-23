<?php

class ApplicationResponseTest extends TestCase
{
    /** @test */
    public function an_application_response_belongs_to_an_application()
    {
        $application = create('App\Application');
        $response = create(
            'App\ApplicationResponse',
            ['application_id' => $application->id]
        );

        $this->assertInstanceOf('App\Application', $response->application);
    }
}