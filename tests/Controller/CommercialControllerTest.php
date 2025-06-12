<?php

namespace App\Test\Controller;

use App\Entity\Commercial;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommercialControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/commercial/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Commercial::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commercial index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'commercial[codeCommercial]' => 'Testing',
            'commercial[nomCommercial]' => 'Testing',
            'commercial[prenomCommercial]' => 'Testing',
            'commercial[telCommercial]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commercial();
        $fixture->setCodeCommercial('My Title');
        $fixture->setNomCommercial('My Title');
        $fixture->setPrenomCommercial('My Title');
        $fixture->setTelCommercial('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commercial');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commercial();
        $fixture->setCodeCommercial('Value');
        $fixture->setNomCommercial('Value');
        $fixture->setPrenomCommercial('Value');
        $fixture->setTelCommercial('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'commercial[codeCommercial]' => 'Something New',
            'commercial[nomCommercial]' => 'Something New',
            'commercial[prenomCommercial]' => 'Something New',
            'commercial[telCommercial]' => 'Something New',
        ]);

        self::assertResponseRedirects('/commercial/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCodeCommercial());
        self::assertSame('Something New', $fixture[0]->getNomCommercial());
        self::assertSame('Something New', $fixture[0]->getPrenomCommercial());
        self::assertSame('Something New', $fixture[0]->getTelCommercial());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commercial();
        $fixture->setCodeCommercial('Value');
        $fixture->setNomCommercial('Value');
        $fixture->setPrenomCommercial('Value');
        $fixture->setTelCommercial('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/commercial/');
        self::assertSame(0, $this->repository->count([]));
    }
}
