<?php 

namespace App\Tests\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testRegistration()
    {
        $client = static::createClient();
        $user = new User();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/post/hello-world');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function testPublicBlogPost()
    {
        $client = static::createClient();
        // the service container is always available via the test client
        $blogPost = $client->getContainer()->get('doctrine')->getRepository(Post::class)->find(1);
        $client->request('GET', sprintf('/en/blog/posts/%s', $blogPost->getSlug()));

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $response = $client->getResponse();
        $this->assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertSame(
            'http://localhost/',
            $response->getTargetUrl(),
            sprintf('The %s secure URL redirects to the index page.', $url)
        );
    }

    public function getPublicUrls()
    {
        yield ['/'];
    }

    public function getSecureUrls()
    {
        yield ['/mealplan'];
        yield ['/recipe'];
        yield ['/kitchen'];
        yield ['/grocerylist'];
        yield ['/profile'];
    }

}
?>
