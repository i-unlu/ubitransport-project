<?php

namespace Tests\FunctionalTest\App\Controller;

use App\DataFixtures\AverageNoteFixtures;
use App\Entity\Student;
use App\Model\SubjectNoteModel;
use JMS\Serializer\Serializer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubjectNoteControllerTest extends WebTestCase
{
    Use FixturesTrait;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;

    /**
     * @var Serializer
     */
    private $serializer;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->serializer = self::$container->get('jms_serializer');
    }

    public function testAddSubjectNote(): void
    {
        $student = (new Student())
            ->setLastName('Delamontagne')
            ->setFirstName('Marie')
            ->setBirthDate(new \DateTime('1982-08-19'))
        ;
        $jsonStudent = $this->serializer->serialize($student, 'json');

        $this->client->request('POST', '/student', [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudent);
        $studentAdded = \json_decode($this->client->getResponse()->getContent(), true);
        $studentIdAdded = (int) $studentAdded['id'];

        $subjectNoteModel = new SubjectNoteModel('Maths', 18.0, $studentIdAdded);
        $jsonSubjectNote = $this->serializer->serialize($subjectNoteModel, 'json');

        $this->client->request('POST', '/subject-note', [], [], ['CONTENT_TYPE' => 'application/json'], $jsonSubjectNote);
        $subjectNoteAdded = \json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsInt($subjectNoteAdded['id']);
        $this->assertSame('Maths', $subjectNoteAdded['subject']);
        $this->assertSame(18.0, $subjectNoteAdded['note']);
        $this->assertSame($studentIdAdded, (int) $subjectNoteAdded['student']['id']);
        $this->assertSame('Delamontagne', $subjectNoteAdded['student']['last_name']);
        $this->assertSame('Marie', $subjectNoteAdded['student']['first_name']);
        $this->assertSame('1982-08-19', $subjectNoteAdded['student']['birth_date']);
    }

    public function testAverageNote(): void
    {
        $this->loadFixtures([AverageNoteFixtures::class]);

        $this->client->request('GET', '/subject-note/average-note');

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $response = \json_decode($this->client->getResponse()->getContent(), true)[0];
        $this->assertEquals(11.5, (float) $response['average']);
    }
}
