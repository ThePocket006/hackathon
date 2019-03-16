<?php
class Forum_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getForumAndCat(){
        return $this->db->query("
            SELECT f.id AS forId, f.name as forName, c.id as catId, c.name AS catName, c.post_nbr
            FROM forum f
            LEFT JOIN category c ON c.forum = f.id");
    }
    public function getCategoryInfo($permalink){
        return $this
            ->db->select('*')
            ->from('category')
            ->where('permalink',$permalink)
            ->get();
    }
    public function getPostInfo($postId){
        return $this
            ->db->query("SELECT p.*, u.firstname, u.lastname,u.id as userId
            FROM post p
            LEFT JOIN user u ON u.id = p.user
            WHERE p.id = ? AND p.visible=? ORDER BY p.post_date DESC",array($postId,'1'));
    }

    public function getPostsOfCat($catId){
        return $this
            ->db->query("
            SELECT p.*, u.firstname, u.lastname,u.id as userId
            FROM post p
            LEFT JOIN user u ON u.id = p.user
            WHERE p.category = ? AND p.visible=? ORDER BY p.post_date DESC",array($catId,'1'));
    }
    public function getCommentsOfPost($postId){
        return $this
            ->db->query("
            SELECT c.*, u.firstname, u.lastname, u.avatar,u.id as userId
            FROM comment c
            LEFT JOIN user u ON u.id = c.user
            WHERE c.post = ? AND c.visible=? ORDER BY c.post_date DESC",array($postId,'1'));
    }

    public function solve($postId){
        return $this->db->query("UPDATE post set solved='1' WHERE id = ?",array($postId));
    }

    public function addPost($post){
        return $this->db->set($post)->insert('post');
    }

    public function updPostNbr($catId){
        return $this->db->query('UPDATE category set post_nbr = post_nbr+1 WHERE id = ?',$catId);
    }

    public function addComment($comment){
        return $this->db->set($comment)->insert('comment');
    }

    public function updCommentNbr($postId){
        return $this->db->query('UPDATE post set comment_nbr = comment_nbr+1 WHERE id = ?',$postId);
    }
    
     public function getLastPost($user=null){
        if($user == null)
        {
            $select = 'p.*, u.avatar, u.number_id matricule, u.firstname, u.lastname';
            return $this->db->select($select)
                ->from('post p')
                ->join('user u', 'p.user = u.id')
                ->order_by('p.id', 'DESC')
                ->limit(1)
                ->get()->result();
        }
        $select = 'p.*, u.avatar, u.number_id matricule, u.firstname, u.lastname';
        return $this->db->select($select)
            ->join('user u', 'p.user = u.id')
            ->where('u.id', $user)
            ->order_by('p.id', 'DESC')
            ->limit(1)
            ->get()->result();
    }
    public function getLastComment($user=null,$post=null){
        if($user == null or $post == null)
        {
            $select = 'c.*, u.avatar, u.number_id matricule, u.firstname, u.lastname';
            return $this->db->select($select)
                ->from('comment c')
                ->join('user u', 'c.user = u.id')
                ->order_by('c.id', 'DESC')
                ->limit(1)
                ->get()->result();
        }

        $select = 'c.*, u.avatar, u.number_id matricule, u.firstname, u.lastname';
        return $this->db->select($select)
            ->from('comment c')
            ->join('user u', 'c.user = u.id')
            ->where('c.post',$post)
            ->order_by('c.id', 'DESC')
            ->limit(1)
            ->get()->result();
    }
    
}