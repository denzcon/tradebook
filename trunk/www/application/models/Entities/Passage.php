<?php
namespace models;

/**
 * @Entity
 * @Table(name="passage") 
 */
class Passage
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 *@Column(type="string", length=128, nullable=true)
	 */
	protected $title;
	
	/**
	 *@Column(type="string", length=512, nullable=true)
 	 */
	protected $content;
	
	/**
	 *@Column(type="integer", nullable=false)
 	 */
	protected $author_id;
	
	/**
	 *@Column(type="string", length=24, nullable=true)
 	 */
	protected $submit_date;
	
	/**
	 *@OneToMany(targetEntity="User", mappedBy="id")
	 * @JoinColumn(name="id", referencedColumnName="author_id")
	 */
//	protected $user;
	
	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}	
	
	public function setAuthorId($author_id)
	{
		$this->author_id = $author_id;
	}
	
	public function getAuthorId()
	{
		return $this->author_id;
	}
	
	public function getUser()
	{
		return $this->user;
	}
}