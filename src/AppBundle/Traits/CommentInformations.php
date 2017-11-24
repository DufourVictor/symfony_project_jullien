<?php
namespace AppBundle\Traits;
/**
 * Class CommentInformations
 */
trait CommentInformations
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->firstName .' '. $this->getLastName();
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
