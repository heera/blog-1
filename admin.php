<?php require 'header.php' ?>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <button id="login-btn" class="btn btn-default">Login</button>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <h3>Add a new post</h3>
            <form action="" id="post-form">
                <div class="form-group">
                    <input type="text" id="title" name="title" placeholder="Post Title" class="form-control" required>
                </div>

                <div class="form-group">
                    <input type="text" id="slug" name="slug" placeholder="Slug" class="form-control" required>
                </div>

                <div class="form-group">
                    <textarea name="content" id="content" placeholder="Content" rows="10" class="form-control" required></textarea>
                </div>

                <button type="submit" id="post-btn" class="btn btn-primary pull-right">Post</button>
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
            $('#login-btn').click(function () {
                socketize.showLoginModal();
            });

            $('#post-form').submit(function (e) {
                e.preventDefault();
                savePost($('#slug').val(), $('#title').val(), $('#content').val()).then(function () {
                    alert('Posted!');
                    $('#post-form input[type=text], #post-form textarea').val('');
                });
            });

            $('#title').blur(function () {
                var $slug = $('#slug');
                var slug = $(this).val().toLowerCase().replace(/\s/g, '-');
                $slug.val(slug);
            });
        });

        socketize.on('login', function () {
            $('#login-btn').hide();
        });

        function savePost(slug, title, content) {
            var promise = socketize.pushOnList('public/blog_posts', {
                slug: slug,
                title: title,
                content: content
            });

            promise.catch(function (error) {
                alert(error.message);
            });

            return promise;
        }
    </script>

<?php require 'footer.php' ?>