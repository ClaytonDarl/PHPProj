<?php
class Comment extends DbObject {

    protected static $db_table = 'comments';
    protected static $db_table_fields = ['photoId', 'author', 'body'];

        public $id;
        public $photoId;
        public $author;
        public $body;


        public static function createComment($photoId, $author, $body) {

            if (!empty($photoId) && !empty($author) && !empty($body)) {
                $comment = new Comment();
                $comment->photoId = (int)$photoId;
                $comment->author = $author;
                $comment->body = $body;
                return $comment;
            } else {
                return false;
            }
        }

        public static function findComments($photoId) {
            global $database;
            $query = "SELECT * FROM ". self::$db_table ." WHERE photoId= " . $database->escapeString($photoId) . " ORDER BY photoId ASC";

            return self::findQuery($query);
        }
}
?>