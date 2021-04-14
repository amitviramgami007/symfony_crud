<?php

namespace App\Entity;

use App\Entity\Page;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WebsiteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=WebsiteRepository::class)
 */
class Website
{
    /**
     * @var int|null $id
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $domainName
     * @ORM\Column(type="string", length=255)
     */
    private $domainName;

    /**
     * @var string $language
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @var Host $host
     * @ORM\ManyToOne(targetEntity=Host::class, cascade={"persist"})
     * @ORM\JoinColumn(name="host_id", referencedColumnName="id")
     */
    private $host;

    /**
     * @var ArrayCollection $pages
     * @ORM\OneToMany(targetEntity=Page::class, mappedBy="website", cascade={"persist"})
     */
    private $pages;

    /**
     * Website constructor.
     */
    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomainName(): ?string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getHost(): ?Host
    {
        return $this->host;
    }

    public function setHost(?Host $host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setWebsite($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getWebsite() === $this) {
                $page->setWebsite(null);
            }
        }

        return $this;
    }
}
