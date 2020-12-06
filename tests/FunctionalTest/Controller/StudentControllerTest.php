<?php

namespace Tests\FunctionalTest\App\Controller;

use App\DataFixtures\AverageNoteByStudentFixtures;
use App\Entity\Student;
use App\Repository\StudentRepository;
use JMS\Serializer\Serializer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class StudentControllerTest extends WebTestCase
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

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->serializer = self::$container->get('jms_serializer');
        $this->studentRepository = self::$container->get(StudentRepository::class);
    }

    public function testAddStudent(): void
    {
        $student = (new Student())
            ->setLastName('Dupont')
            ->setFirstName('Xavier')
            ->setBirthDate(new \DateTime('1978-02-02'))
        ;
        $jsonStudent = $this->serializer->serialize($student, 'json');

        $this->client->request('POST', '/student', [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudent);

        static::assertEquals(
            Response::HTTP_CREATED,
            $this->client->getResponse()->getStatusCode()
        );

        $studentAdded = \json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsInt($studentAdded['id']);
        $this->assertSame('Dupont', $studentAdded['last_name']);
        $this->assertSame('Xavier', $studentAdded['first_name']);
        $this->assertSame('1978-02-02', $studentAdded['birth_date']);
    }

    public function testEditStudent(): void
    {
        $student = (new Student())
            ->setLastName('Jean')
            ->setFirstName('Pascal')
            ->setBirthDate(new \DateTime('1980-04-07'))
        ;
        $jsonStudent = $this->serializer->serialize($student, 'json');

        $this->client->request('POST', '/student', [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudent);
        $studentAdded = \json_decode($this->client->getResponse()->getContent(), true);
        $studentIdToEdit = (int) $studentAdded['id'];

        $studentInfoForEdition = (new Student())
            ->setLastName('Jean_edited')
            ->setFirstName('Pascal_edited')
            ->setBirthDate(new \DateTime('1982-05-17'))
        ;
        $jsonStudentInfoForEdition = $this->serializer->serialize($studentInfoForEdition, 'json');

        $this->client->request('PUT', "/student/$studentIdToEdit", [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudentInfoForEdition);

        /** @var Student $studentEdited */
        $studentEdited = $this->studentRepository->find($studentIdToEdit);

        $this->assertSame($studentIdToEdit, $studentEdited->getId());
        $this->assertSame('Jean_edited', $studentEdited->getLastName());
        $this->assertSame('Pascal_edited', $studentEdited->getFirstName());
        $this->assertSame('1982-05-17', $studentEdited->getBirthDate()->format('Y-m-d'));
    }

    public function testDeleteStudent(): void
    {
        $student = (new Student())
            ->setLastName('Jean')
            ->setFirstName('Pascal')
            ->setBirthDate(new \DateTime('1980-04-07'))
        ;
        $jsonStudent = $this->serializer->serialize($student, 'json');

        $this->client->request('POST', '/student', [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudent);
        $studentAdded = \json_decode($this->client->getResponse()->getContent(), true);
        $studentIdAdded = (int) $studentAdded['id'];

        $studentAdded = $this->studentRepository->find($studentIdAdded);
        $this->assertInstanceOf(Student::class, $studentAdded);

        $this->client->request('DELETE', "/student/$studentIdAdded", [], [], ['CONTENT_TYPE' => 'application/json'], $jsonStudent);

        $studentDeleted = $this->studentRepository->find($studentIdAdded);
        $this->assertNull($studentDeleted);
    }

    public function testAverageNote(): void
    {
        $this->loadFixtures([AverageNoteByStudentFixtures::class]);

        $this->client->request('GET', '/student/1/average-note', [], [], ['CONTENT_TYPE' => 'application/json']);

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(10, (float) $response['average']);
    }
}
