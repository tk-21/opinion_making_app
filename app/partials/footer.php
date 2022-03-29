<?php

namespace partials;

function footer()
{
?>

    </main>

    <footer class="footer">
        <div class="inner">
            <p class="footer-txt">© 2022 TAKUYA OKUBO</p>
        </div>
    </footer>
    </div>

    <!-- jQuery本体 -->
    <script src="../public/js/jquery-3.6.0.min.js"></script>
    <!-- jQueryプラグイン -->
    <!-- js -->
    <script src="../public/js/main.js"></script>
    <script src="../public/js/form-validate.js"></script>
    <!-- フォント -->
    <script>
        (function(d) {
            var config = {
                    kitId: 'qdb8tth',
                    scriptTimeout: 3000,
                    async: true
                },
                h = d.documentElement,
                t = setTimeout(function() {
                    h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
                }, config.scriptTimeout),
                tk = d.createElement("script"),
                f = false,
                s = d.getElementsByTagName("script")[0],
                a;
            h.className += " wf-loading";
            tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
            tk.async = true;
            tk.onload = tk.onreadystatechange = function() {
                a = this.readyState;
                if (f || a && a != "complete" && a != "loaded") return;
                f = true;
                clearTimeout(t);
                try {
                    Typekit.load(config)
                } catch (e) {}
            };
            s.parentNode.insertBefore(tk, s)
        })(document);
    </script>
    </body>

    </html>

<?php
}
?>
