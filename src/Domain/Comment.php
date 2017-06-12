<?php

namespace cmsBk1\Domain;

class Comment 
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment author.
     *
     * @var string
     */
    private $author;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Associated article.
     *
     * @var \cmsBk1\Domain\Article
     */
    private $article;
	
	/**
	* Comment parent
	* @var integer
	*/
	private $parentId;
	
	private $childrenComments;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }
	public function getParentId() {
        return $this->parentId;
    }
	public function setParentId($parentId) {
        $this->parentId = $parentId;
        return $this;
    }
	
	public function getChildrenComments() {
        return $this->childrenComments;
    }
	public function setChildrenComments($childrenComments) {
        $this->childrenComments = $childrenComments;
        return $this;
    }
	
	
}