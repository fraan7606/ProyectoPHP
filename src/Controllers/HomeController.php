<?php

namespace Controllers;

use Models\Post;

class HomeController {
    
    public static function index() {
        $postModel = new Post();
        $posts = $postModel->getAll();
        return $posts;
    }
}
