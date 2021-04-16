<?php

namespace App\Entity;

use App\Entity\Employee;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dept_name;

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="dept")
     */
    private $dept_id;

    public function __construct()
    {
        $this->dept_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeptName(): ?string
    {
        return $this->dept_name;
    }

    public function setDeptName(string $dept_name): self
    {
        $this->dept_name = $dept_name;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getDeptId(): Collection
    {
        return $this->dept_id;
    }

    public function addDeptId(Employee $deptId): self
    {
        if (!$this->dept_id->contains($deptId)) {
            $this->dept_id[] = $deptId;
            $deptId->setDept($this);
        }

        return $this;
    }

    public function removeDeptId(Employee $deptId): self
    {
        if ($this->dept_id->removeElement($deptId)) {
            // set the owning side to null (unless already changed)
            if ($deptId->getDept() === $this) {
                $deptId->setDept(null);
            }
        }

        return $this;
    }
}
