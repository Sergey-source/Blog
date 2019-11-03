<?php
namespace App\Models;

use App\Models\BaseModel;
use Core\DB;

class ArticleModel extends BaseModel
{
    protected $table = 'articles';

    public function getAllArticles()
    {
        $articles = $this->db->select($this->table);
        return $articles;
    }

    public function getArticle($id)
    {
        $sql = "SELECT articles.id, articles.title, articles.body, COUNT(likes.id) AS likes_count FROM articles 
                JOIN likes ON likes.article_id=$id WHERE articles.id=$id";
        
        $params = [
            'id' => $id
        ];
        
        return ($article = $this->db->select_with_sql($this->table, $sql, $params, DB::FETCH_ONE)) ? $article : false;
    }

    public function create($title, $body)
    {
        $params = [
            'title' => $title,
            'body' => $body,
        ];

        $this->db->insert($this->table, $params);
    }

    public function update($title, $body, $id)
    {
        $params = [
            'title' => $title,
            'body' => $body,
        ];

        $this->db->update($this->table, $params, ['id' => $id]);
    }

    /**
     * Проверяет, поставил ли пользователь лайк
     * 
     * @return boolean
     */
    public function userLiked($article_id, $user_id)
    {
        $params = [
            'article_id' => $article_id,
            'user_id' => $user_id
        ];

        return ($this->db->select('likes', $params, DB::FETCH_ONE)) ? true : false;
    }
    
    public function addLike($article_id, $user_id)
    {
        $params = [
            'article_id' => $article_id,
            'user_id' => $user_id
        ];

        $this->db->insert('likes', $params);
    }

    public function deleteLike($article_id, $user_id)
    {
        $params = [
            'article_id' => $article_id,
            'user_id' => $user_id
        ];

        $this->db->delete('likes', $params);
    }

}
