<?php include 'bbcode_function.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="<?= URL::asset('js/jquery.js'); ?>"></script>
        <link rel="stylesheet" href="<?= URL::asset('css/bootstrap.css'); ?>">
        <link rel="stylesheet" href="<?= URL::asset('css/styles.css'); ?>">
        <script src="<?= URL::asset('js/bootstrap.min.js'); ?>"></script>
        <script src="<?= URL::asset('js/functions.js'); ?>"></script>
    </head>
    <body>
        <div class="cc-head">
            <span><?= $article->title; ?></span><br><span class="blogdate"><?= $article->created_at->format('M j, Y, g:i A'); ?></span>

        </div><br><br>
    <center>
        <div class="row" style="width: 100%">
            <div align="left">
                <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12 col-md-offset-1 col-lg-offset-1 container">
                    <?= $article->body; ?>
                    <div class="page-header">
                        <h2>About the author</h2>
                    </div>

                    <table>
                        <tr><td class="t-ful">  <img align="left" src="<?= URL::asset('images/' . $article->author_image); ?>" class="c-img img-circle img-responsive" alt="Display image"></td>
                            <td class="abt-body"><?= $article->about_author; ?></td>
                        </tr></table>
                </div>
                <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
                    <hr class="hidden-lg hidden-md">
                    <div class="sid"><div class="mr-head">Most viewed articles</div>
                        <div class="cm">
                            <?php
                            foreach ($most_viewed_articles as $most_viewed_article) {
                                ?>
                                &gt;&gt; <a href="<?= $most_viewed_article->link; ?>"><?= $most_viewed_article->title; ?></a><br>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <hr><div class="container">

        <?php
        if ($article->comments()->first() != null) {
            ?>
            <div class="page-header">
                <h1>Comments</h1>
            </div>
            <?php
            foreach ($article->comments()->orderBy('created_at', 'desc')->get() as $comment) {
                ?>
                <div align="left"><table>
                        <tr><td>  <img align="left" src="<?php $img = $comment->image != "" ? 'images/' . $comment->image : 'images/image.png';
        echo URL::asset($img); ?>" class="c-img img-circle img-responsive" alt="Display image"></td><td>
                                <div align="left" style="margin-left: 40px"><span class="cua"><?= $comment->name; ?></span><br> <span class="blogdate"><?= $comment->created_at->format('M j, Y, g:i A') ?></span></div></td></table></div>
                <br>
                <div align="left"><div class="co-body"> <?= bbcode_to_html($comment->comment); ?><!--
                        --><br><a class="rplnk" onclick="slider(repl<?= $comment->id; ?>)">Reply</a>
                        <form style="display: none" id="repl<?= $comment->id; ?>" action="../subcomment/<?= $comment->id; ?>/<?= $article->id; ?>" method="post">
                            <br>
                            <div class="form-group">
                                <input type="text" name="name" required class="form-control" placeholder="Your name"><br>
                                <textarea rows="7" name="comment" class="form-control" placeholder="Enter reply" required></textarea><br>
                                <input type="submit" name="submit" value="Reply" class="m-btn form-control">
                            </div>
        <?= csrf_field(); ?>
                        </form><br><br>
                        <div class="crep">
                            <?php
                            foreach ($comment->subcomments()->orderBy('created_at', 'desc')->get() as $subcomment) {
                                ?>
                                <div><?= nl2br($subcomment->body); ?><br><span class="cred">By <?= $subcomment->name; ?> <?= $subcomment->created_at->format('M j, Y, g:i A'); ?></span></div><br>
                                <?php }
                                ?></div>
                    </div>

                </div><hr>
                <?php
            }
        }
        ?>
        <br><br>
        <div class="page-header">
            <h1>Speak your mind</h1>
        </div><br><br>
        <form action="../comment/<?= $article->id; ?>" method="post"  enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Your name</label>
                <input id="name" type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="comment">Your comment</label><br>
                <input class="mkr" type="button" value="Bold" onclick="javascript:insert('[b]', '[/b]', 'comment');"><!--
                --><input class="mkr" type="button" value="Italic" onclick="javascript:insert('[i]', '[/i]', 'comment');"><!--
                --><input class="mkr" type="button" value="Underline" onclick="javascript:insert('[u]', '[/u]', 'comment');"><!--
                --><input class="mkr" type="button" value="Srtikethrough" onclick="javascript:insert('[s]', '[/s]', 'comment');"><!--
                --><input class="mkr" type="button" value="Image" onclick="javascript:insert('[img]', '[/img]', 'comment');"><!--
                --><input class="mkr" type="button" value="Link" onclick="javascript:insert('[url=', ']Input text to be clicked[/url]', 'comment');"><!--
                --><input class="mkr" type="button" value="Left" onclick="javascript:insert('[left]', '[/left]', 'comment');"><!--
                --><input class="mkr" type="button" value="Center" onclick="javascript:insert('[center]', '[/center]', 'comment');"><!--
                --><input class="mkr" type="button" value="Right" onclick="javascript:insert('[right]', '[/right]', 'comment');"><!--
                --><input class="mkr" type="button" value="Horizontal" onclick="javascript:insert('[hr]', '', 'comment');">
                <textarea rows="8" class="form-control myt" name="comment" id="comment"></textarea>
            </div>
<?= csrf_field(); ?>
            <div class="form-group">
                <label for="avatar">Choose picture</label> <span class="form-control-static">(optional)</span>
                <input id="avatar" type="file" name='avatar' accept="image/gif, image/jpeg, image/x-ms-bmp, image/x-png" class="form-control">
            </div>
            <input type="submit" class="btn btn-default form-control" value="Submit comment">
        </form><br>
        <div class="sid hidden-lg hidden-md"><hr><br><div class="mr-head">Most viewed articles</div>
            <div class="cm">
                <?php
                foreach ($most_viewed_articles as $most_viewed_article) {
                    ?>
                    &gt;&gt; <a href="<?= $most_viewed_article->link; ?>"><?= $most_viewed_article->title; ?></a><br>
<?php } ?>   
            </div>
        </div>
    </div><br><br><br>
    <script> function slider(elm) {
            $(elm).slideToggle();
        }</script>
</body>
</html>
