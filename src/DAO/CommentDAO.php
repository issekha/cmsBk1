<?php

namespace cmsBk1\DAO;

use cmsBk1\Domain\Comment;

class CommentDAO extends DAO 
{
    /**
     * @var \cmsBk1\DAO\ArticleDAO
     */
    private $articleDAO;

    public function setArticleDAO(ArticleDAO $articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    /**
     * Return a list of all comments for an article.
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId) {
        // The associated article is retrieved only once
        $article = $this->articleDAO->find($articleId);

        // art_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, com_author, parent_id from t_comment where art_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $allComments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
			$comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setArticle($article);
            $allComments[$comId] = $comment;
        }
		
		$parentComments = array_filter($allComments, function($comment) {
			return $comment->getParentId() === NULL;
		});
		
		foreach ($parentComments as $key => $parentComment) {
			$this->setChildrenComments($allComments, $parentComment);
		}
		
		
		
		
	
        return $parentComments;
    }
	
	function setChildrenComments($allComments, $parentComment) {
		$childrenComments = array_filter($allComments, function($comment) use ($parentComment) {
			return $comment->getParentId() === $parentComment->getId();
		});

		$parentComment->setChildrenComments($childrenComments);

		foreach ($childrenComments as $key => $childComment) {
			$this->setChildrenComments($allComments, $childComment);
		}
	} 

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \cmsBk1\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setAuthor($row['com_author']);
		$comment->setParentId($row['parent_id']);

        if (array_key_exists('art_id', $row)) {
            // Find and set the associated article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        
        return $comment;
    }
}
