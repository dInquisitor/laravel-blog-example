<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>A Simple Laravel Blog</title>
        <script src="<?= URL::asset('js/jquery.js'); ?>"></script>
        <link rel="stylesheet" href="<?= URL::asset('css/bootstrap.css'); ?>">
        <link rel="stylesheet" href="<?= URL::asset('css/styles.css'); ?>">
        <script src="<?= URL::asset('js/bootstrap.min.js'); ?>"></script>
    </head>
    <body>
        <div class="cb-head">
            <div>Laravel 5.7 Blog</div>
        </div><br><br>
        <div class="container"> 
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <?php
                if (count($articles) > 1) {
                    $class = "blogdesc";
                } else {
                    $class = "bdes";
                }
                foreach ($articles as $article) {
                    ?> 
                    <div> <a href="<?php echo "article/" . $article->link; ?>" class="blogtitle"><?php echo $article->title; ?></a><br>
                        <span class="blogdate"><?php echo $article->created_at->format('M j, Y, g:i A'); ?></span><br><br>
                        <div class="<?php echo $class; ?>"><?php echo $article->description; ?></div>
                    </div>
                    <?php
                }
                echo $articles->links(); ?>
            </div>              
        </div>       
    </body>
</html>
