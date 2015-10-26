<?php require 'header.php' ?>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <form action="" id="post-form">
                <div class="form-group">
                    <input type="text" name="title" placeholder="Post Title" class="form-control">
                </div>

                <div class="form-group">
                    <input type="text" name="slug" placeholder="Slug" class="form-control">
                </div>

                <div class="form-group">
                    <textarea name="content" placeholder="Content" rows="10" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Post</button>
            </form>
        </div>
    </div>

    <script>
        var params = {
            'address': "wss://socketize.dev:8080",
            'public_key': 'OXkZMQ_test-public-key'
        };
        var socketize = new Socketize.client(params);

        $(document).ready(function () {

        });

        function savePost(slug, title, content) {
            socketize.pushOnList('public/blog_posts', {
                slug: slug,
                title: title,
                content: content
            }).then(function () {
                    alert('Posted!');
                },
                function (error) {
                    alert(error.message);
                }
            );
        }
    </script>

<?php require 'footer.php' ?>