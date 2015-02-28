</div>

<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted">Copyright &copy; Your Website 2015</p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/clean-blog.min.js"></script>
<script src="http://letrol.dev/js/inject.min.js"></script>

<script>
    var params = {
        'address': "ws://pizzazz.letrol.com:8080",
        'publicKey': 'test-public-key'
    };

    var siteUrl = '<?php echo $siteUrl ?>';
    var blogPosts;

    var l = new letrol(params);
    l.onSuccess(function() {
        l.ping(function (data) {
            console.log(data.message);
        });

        l.getPublicData('blog_posts:developer', function(response) {
            blogPosts = $.parseJSON(response.message);
            getContent();
        });

    });

    $(document).ready(function() {
        window.addEventListener("hashchange", function(e) {
            getContent();
        });

        $(document).on('click', 'a', function(e) {
            e.preventDefault();
            var href = $(this).attr('href').trim();
            if (href == '#' || href == '') return;
            var path = href.replace(siteUrl, '');
            window.location.hash = path;
            //$(document).scrollTop(0);
        });
    });

    function getContent() {
        var path = window.location.hash;
        if (path == '') {
            buildHomePage();
            return;
        }

        path = path.replace(/^#?\//, '');
        console.log(path);
        var postKey = path.replace('/', ':');

        l.getPublicData(postKey, function(response) {
            $('.posts').html(response.message);
        });
    }

    function buildHomePage() {
        var i = 0;
        $('.posts').html('');
        l.getPublicData('posts_titles', function (response) {
            var postTitles = $.parseJSON(response.message);
            $.each(postTitles, function(key, value) {
                var postHtml = '<div class="post-preview"> ' +
                    '<a class="post-link" data-post-id="' + key + '" href="' + siteUrl + '/posts/' + key + '">' +
                    '<h2 class="post-title">' +
                    value +
                    '</h2>' +
                    '</a>' +
                    '</div>' +
                    '<hr>';
                $('.posts').append(postHtml);
            });
        });
        /*blogPosts.forEach(function(blogPost) {
            var postHtml = '<div class="post-preview"> ' +
                '<a class="post-link" data-post-id="' + i + '" href="' + siteUrl + '/posts/' + i + '">' +
                '<h2 class="post-title">' +
                blogPost.title +
                '</h2>' +
                '</a>' +
                '</div>' +
                '<hr>';
            $('.posts').append(postHtml);
            i++;
        });*/
    }

    function login(email, password) {
        var params = {
            'publicKey': 'test-public-key',
            'auth_type': 'password',
            'auth_params': {
                'email': email,
                //'payload': '{{ hash_hmac('sha256', 'sylhet123@gmail.com', 'test-private-key') }}'
                'password': password
            }
        };

        l.authenticate(params, function(response) {
            console.log(response);
        });
    }

    function post(key, value) {
        l.setPublicData(key, value, function(response) {
            console.log(response);
        });
    }
</script>

</body>

</html>
