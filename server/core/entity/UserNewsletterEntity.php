<?php
/*************
* Třída UserNewsletterEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once(PATH_ROOT2 . 'core/entity/' . "Entity.php");
class UserNewsletterEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_user_newsletter";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_user_newsletter";
		$this->metadata["user_id"] = array("type" => "int","reference" => "User");
		$this->metadata["newsletter_id"] = array("type" => "int","reference" => "Newsletter");
	}
	#endregion

	#region Property
	// int
	protected $user_id;

	protected $user_idOriginal;
	protected $userUserEntity;

	// int
	protected $newsletter_id;

	protected $newsletter_idOriginal;
	protected $newsletterNewsletterEntity;

	#endregion

	#region Method
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
	// Setter newsletter_id
	protected function setNewsletter_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->newsletter_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->newsletterNewsletterEntity = new NewsletterEntity($value,false);
		} else {
			$this->newsletterNewsletterEntity = null;
		}
	}
	// Getter newsletter_id
	public function getNewsletter_id()
	{
		return $this->newsletter_id;
	}
	// Getter newsletter_idOriginal
	public function getNewsletter_idOriginal()
	{
		return $this->newsletter_idOriginal;
	}
	#endregion

}
