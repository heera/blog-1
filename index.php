<?php require 'header.php' ?>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 posts">

            </div>
        </div>

    <script>
        var params = {
            'address': "wss://socketize.dev:8080",
            'public_key': 'OXkZMQ_test-public-key'
        };
        var blogPosts;
        var socketize = new Socketize.client(params);

        $(document).ready(function () {
            getAllPosts(function () {
                getContent();
            });

            window.addEventListener("hashchange", function (e) {
                getContent();
            });
        });

        function getAllPosts(callback) {
            socketize.getListItems('public/blog_posts').then(function (posts) {
                blogPosts = posts;
                callback();
            });
        }

        function getContent() {
            var path = window.location.hash;
            if (path == '') {
                buildHomePage();
                return;
            }

            var segments = path.split('/');
            var postSlug = segments[segments.length - 1];
            console.log(postSlug);
            var post = blogPosts.filter(function (post) {
                return post.slug == postSlug;
            })[0];
            var formattedContent = '<h2 class="post-title">' + post.title + '</h2>' + '<p>' + post.content + '</p>';
            $('.posts').html(formattedContent);
        }

        function buildHomePage() {
            var i = 0;
            $('.posts').html('');
            $.each(blogPosts, function (index, post) {
                var postHtml = '<div class="post-preview"> ' +
                    '<a class="post-link" data-post-id="' + post.slug + '" href=#' + '/posts/' + post.slug + '>' +
                    '<h2 class="post-title">' +
                    post.title +
                    '</h2>' +
                    '</a>' +
                    '</div>' +
                    '<hr>';
                $('.posts').append(postHtml);
            });
        }

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