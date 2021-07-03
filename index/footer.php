                    <!-- 底部引入页面 -->
					</div> <!-- container -->
                </div> <!-- content -->
                <!-- 页脚 -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo stripslashes(SYSTEM_COPYRIGHT);?>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
									<?php echo stripslashes(SYSTEM_FRIENDS);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- 页脚 -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Matomo -->
        <script type="text/javascript">
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//matomo.fatda.cn/";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '3']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>
        <!-- End Matomo Code -->
        
        <script type="text/javascript" src="../assets/js/jquery.min.js" ></script>
        <script type="text/javascript" src="../assets/js/dianzan.js" ></script>
        <script type="text/javascript" src="../assets/javascript/app.min.js"></script>
    </body>
</html>