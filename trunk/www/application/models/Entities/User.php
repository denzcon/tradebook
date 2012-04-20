<?php
namespace models\Entities;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{

	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @Column(type="string", length=32, unique=true, nullable=true)
	 */
	private $username;

	/**
	 * @Column(type="string", length=64, nullable=true)
	 */
	private $password;

	/**
	 * @Column(type="string", length=64, nullable=true)
	 */
	private $first_name;
	
	/**
	 * @Column(type="string", length=64, nullable=true)
	 */
	private $last_name;

	/**
	 * @Column(type="string", length=64, nullable=true)
	 */
	private $email_address;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function setFirstName($first_name)
	{
		$this->first_name = $first_name;
	}
	
	public function setLastName($last_name)
	{
		$this->last_name = $last_name;
	}

	public function setEmailAddress($email_address)
	{
		$this->email_address = $email_address;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}

}
